<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ucenter extends CS_Controller {

    public function _init()
    {
    	$this->load->helper('validation');
        $this->load->library('pagination');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('mall_cart_goods_model', 'mall_cart_goods');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_order_product_model', 'mall_order_product');
        $this->load->model('mall_goods_base_model', 'mall_goods_base');
        $this->load->model('mall_goods_related_model', 'mall_goods_related');
        $this->load->model('mall_order_reviews_model', 'mall_order_reviews');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
        $this->load->model('account_log_model', 'account_log');
        $this->load->model('deliver_order_model', 'deliver_order');
    }
    
    public function index($num = 0) {
    	
        $perpage = 10;
        $page = $num/$perpage;
        $data['sum'] = $this->mall_order_base->total($this->uid, $this->input->get('status'));
        $config['base_url'] = base_url('ucenter/index');
        $config['total_rows'] = $data['sum'];
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $data['order'] = $this->mall_order_base->mallOrderList($page, $perpage, $this->uid, $this->input->get('status'))->result();
        $orderid_arr = array();
        foreach ($data['order'] as $order) {
            $orderid_arr[] = $order->order_id;
        }
        $data['order_product'] = $this->mall_order_product->getWhereIn($orderid_arr);
        $data['user_info'] = $this->get_user_info();
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $data['like'] = $this->get_maybe_like();
        $data['head_menu'] = 'on';
        $this->load->view('order/all_order', $data);
    }
    
    public function user_reviews()
    {
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['user_reviews'] = $this->mall_order_reviews->getByUid($this->uid)->result();
        $data['reviews_status'] = array('1'=>'待审核', '2'=>'通过', '3'=>'未通过审核');
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/user_reviews', $data);
    }
    
    /**
     * 订单详情
     * */
    public function order_detail($order_id)
    {
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['order'] = $this->mall_order_base->findById((int)$order_id)->row();
        $data['order_product'] = $this->mall_order_product->findByOrderId($order_id)->result();
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/order_detail', $data);
    }
    
    /**
     * 查看物流
     * */
    public function check_deliver($order_id=0)
    {
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $data['order_main_sn'] = $this->input->get('order_main_sn');
        $data['order_id'] = $order_id;
        $deliver_order = $this->deliver_order->findByOrderId($order_id);
        $data['deliver_order'] = $deliver_order->num_rows()>0 ? $deliver_order->row() : '';
        $this->load->view('order/check_deliver', $data);
    }
    
     /**
     * 猜测你喜欢
     * @return unknown|boolean
     */
    public function get_maybe_like()
    {
        $goods_ids = array();
        $history = unserialize(base64_decode(get_cookie('history')));
        if ($history) {
            foreach ($history as $h) {
                $goods_ids[] = $h->goods_id;
            }
            $related_goods_ids = array();
            $related = $this->mall_goods_related->getWhereIn($goods_ids);
            foreach ($related->result() as $r) {
                $related_goods_ids[] = $r->related_goods_id;
            }
            $goods = $this->mall_goods_base->getWhereIn($related_goods_ids);
            return $goods;
        } 
        return false;
    }
    
     /**
     *商户的用户信息
     */
    public function user_info()
    {
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/user_info', $data);
    }
    
     /**
     *更改图片
     */
    public function edit_photo()
    {
    	$postData = $this->input->post();
    	$frontUserInfo = $this->get_user_info();
    	$old_photo = in_array($frontUserInfo->photo, user_photo()) ? '' : $frontUserInfo->photo;
        if (!empty($_FILES['photo']['name'])) {
        	$imageData = $this->dealWithImages('photo', $old_photo,'common/touxiang');
        }
        $photo = isset($imageData['file_name']) ? $imageData['file_name'] : $postData['user_photo'];
        $res = $this->user->updatePhoto($this->uid, $photo);
        $this->redirect('ucenter/user_info');
    }
    
    public function edit_user_info()
    {
        $postData = $this->input->post();
        if (mb_strlen($postData['alias_name']) < 2){
        	$this->jsonMessage('用户名不得少于2个字！');
        }
        if (empty($postData['birthday'])){
        	$this->jsonMessage('生日不能为空！');
        }
        if (!validEmail($postData['email'])){
        	$this->jsonMessage('请填写正确的邮箱！');
        }
        if (!validateMobilePhone($postData['phone'])){
        	$this->jsonMessage('请填写正确的手机号码！');
        }
        $res = $this->user->update($this->uid, $postData);
        if ($res) {
            $this->jsonMessage('', site_url('ucenter/user_info'));
        } 
        $this->jsonMessage('修改失败！');
    }
    
    public function edit_ok()
    {
        $data['head_menu'] = 'on';
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/edit_ok', $data);
    }
    
    public function reset_password()
    {
        if ($this->input->post('old_password') == $this->input->post('new_password')) {
            $this->jsonMessage('新密码与原密码相同');
        } 
        $pass = $this->user->findById($this->uid)->row()->password;
        if ($pass == sha1(base64_encode($this->input->post('old_password')))) {
           $res = $this->user->updatePwd($this->uid, $this->input->post('new_password'));
           if ($res) {
              $this->jsonMessage('', $this->config->passport_url.'login/logout');
           } 
           $this->jsonMessage('修改失败');
        } 
        $this->jsonMessage('原密码错误');
    }
    
    public function pay_points()
    {
        $data['head_menu'] = 'on';
        $data['points_num'] = $this->account_log->total(array('uid'=>$this->uid, 'account_type'=>2));
        $data['points_list'] = $this->account_log->getByAccountType($this->uid, 2);
        $data['user_info'] = $this->get_user_info();
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/pay_points', $data);
    }
    
    /**
     * @微信支付二维码
     * */
    public function get_wxpay_code()
    {
        $postData = $this->input->post();
        $order = $this->mall_order_base->findById($postData['out_trade_no'])->row();
//         if ($order->status != 2) {
//             echo json_encode(array('status'=>false, 'msg'=>'订单状态已改变', 'data'=>base_url('ucenter/index')));exit;
//         }
        //测试数据
        $postData['total_fee']=1;
        $postData['out_trade_no'] = 1;
        
        /**时间加订单号*/
        $time_orderid = date('YmdHis').'_'.$postData['out_trade_no'];
        /**扫码支付*/
        include_once("./WxpayAPI/wxpay/WxPay.NativePay.php");
        $nativePay = new NativePay();
        $input = new WxPayUnifiedOrder();
        //商品描述---需要参数传递/统一信息
        $input->SetBody($postData['body']);
        //商户订单号
        $input->SetOut_trade_no($time_orderid);
        //总金额
        $input->SetTotal_fee((int)$postData['total_fee']);
        //交易类型
        $input->SetTrade_type("NATIVE");
        $input->GetTrade_type("NATIVE");
        //商品id
        $input->SetProduct_id($time_orderid);
        
        $res = $nativePay->GetPayUrl($input);
        if ($res['return_code']=='SUCCESS' && $res['result_code']=='SUCCESS') {
            /**支付链接*/
            $code_url = $res['code_url'];
            
            /**生成二维码*/
            $this->load->library('Productewm');
            $code_img_url = '/wx_ewm/'.$time_orderid.'.png';
            $getData = array(
                'value'=>$code_url,
                'errorCorrectionLevel'=>'H',
                'matrixPointSize'=>4,
                'QR'=>dirname(FCPATH).'/images'.$code_img_url,
                'logo'=>false,
                'output'=>false
            );
            $this->productewm->product($getData);
            echo json_encode(array('status'=>true, 'code_img_url'=>$this->config->images_url.$code_img_url, 'data'=>$time_orderid));
        } else{
            echo json_encode(array('status'=>false, 'msg'=>'微信支付二维码生成失败，请刷新页面'));
        }
    }
    
    /**
     * @获取扫码支付结果
     * */
    public function get_trade_state()
    {
        $out_trade_no = $this->input->post('out_trade_no');
        include_once("./WxpayAPI/lib/WxPay.Api.php");
        $wxPay = new WxPayApi();
        $input = new WxPayUnifiedOrder();
        $input->SetOut_trade_no($out_trade_no);
        $res = $wxPay->orderQuery($input);
        if ($res['return_code']=='SUCCESS' && $res['result_code']=='SUCCESS') {
            if ($res['trade_state']=='SUCCESS') {
                /**支付成功，更新订单状态*/
                $order_no = explode('_',$out_trade_no);
                $this->mall_order_base->updateOrderStatus($order_no[1], 2, 3);
                echo json_encode(array('status'=>true, 'msg'=>'支付成功', 'data'=>base_url('ucenter/index')));
            } else {
                echo json_encode(array('status'=>false));
            }
        } else {
            echo json_encode(array('status'=>false));
        }
    }
}
