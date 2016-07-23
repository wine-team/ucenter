<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ucenter extends CS_Controller {

    public function _init()
    {
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
    }
    
    public function index($num = 0)
    {
        $perpage = 10;
        $page = $num/$perpage;
        $data['sum'] = $this->mall_order_base->total($this->uid, $this->input->get('status'));
        $config['base_url'] = base_url('Ucenter/index');
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
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 5; 
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword','head_right_advert','head_today_recommend','head_recommend_down','head_hot_keyword'));
        $this->load->view('order/all_order', $data);
    }
    
    public function user_reviews()
    {
        $data['user_info'] = $this->get_user_info();
        $data['user_reviews'] = $this->mall_order_reviews->getByUid($this->uid)->result();
        $data['reviews_status'] = array('1'=>'待审核', '2'=>'通过', '3'=>'未通过审核');
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword','head_right_advert','head_today_recommend','head_recommend_down','head_hot_keyword'));
        $this->load->view('order/user_reviews', $data);
    }
    
    public function order_detail($order_id)
    {
        $data['user_info'] = $this->get_user_info();
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['order'] = $this->mall_order_base->findById((int)$order_id)->row();
        $data['order_product'] = $this->mall_order_product->findByOrderId($order_id)->result();
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword','head_right_advert','head_today_recommend','head_recommend_down','head_hot_keyword'));
        $this->load->view('order/order_detail', $data);
    }
    
    public function get_maybe_like()
    {set_cookie('history', base64_encode(serialize(array())), 60);
        $goods_ids = array();
        $history = unserialize(base64_decode(get_cookie('history')));
        if ($history) {
            foreach ($history as $h) {
                $goods_ids[] = $h->goods_id;
            }
            $related_goods_ids = array();
            $related = $this->mall_goods_related->getWhereIn($goods_ids);
            foreach ($related as $r) {
                $related_goods_ids[] = $r->related_goods_id;
            }
            $goods = $this->mall_goods_base->getWhereIn($goods_ids);
            echo json_encode($goods);
        } else {
            echo json_encode(false);
        }
    }
    
    public function user_info()
    {
        $data['user_info'] = $this->get_user_info();
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword','head_right_advert','head_today_recommend','head_recommend_down','head_hot_keyword'));
        $this->load->view('order/user_info', $data);
    }
    
    public function edit_photo()
    {
        $postData = $this->input->post();
        $frontUserInfo = $this->get_user_info();
        $old_photo = '';
        if (!in_array($frontUserInfo->photo, user_photo())) {
            $old_photo = $frontUserInfo->photo;
        }
        $upload = $this->dealWithImages('photo', $old_photo);
        $photo = isset($upload['file_name']) ? $upload['file_name'] : $postData['user_photo'];
        $res = $this->user->updatePhoto($this->uid, $photo);
        redirectAction('Ucenter/user_info');
    }
    
    public function edit_user_info()
    {
        $postData = $this->input->post();
        $res = $this->user->update($this->uid, $postData);
        if ($res) {
            $this->jsonMessage('', base_url('Ucenter/edit_ok'));
        } else {
            $this->jsonMessage('修改失败');
        }
    }
    
    public function edit_ok()
    {
        $this->load->view('order/edit_ok');
    }
    
    public function reset_password()
    {
        if ($this->input->post('old_password') == $this->input->post('new_password')) {
            $this->jsonMessage('新密码与原密码相同');
        } else {
            $pass = $this->user->findById($this->uid)->row()->password;
            if ($pass == sha1(base64_encode($this->input->post('old_password')))) {
                $res = $this->user->updatePwd($this->uid, $this->input->post('new_password'));
                if ($res) {
                    $this->jsonMessage('', $this->config->passport_url.'Login/logout');
                } else {
                    $this->jsonMessage('修改失败');
                }
            } else { 
                $this->jsonMessage('原密码错误');
            }
        }
    }
    
    public function pay_points()
    {
        $data['points_num'] = $this->account_log->total(array('uid'=>$this->uid, 'account_type'=>2));
        $data['points_list'] = $this->account_log->getByAccountType($this->uid, 2)->result();
        $data['user_info'] = $this->get_user_info();
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword','head_right_advert','head_today_recommend','head_recommend_down','head_hot_keyword'));
        $this->load->view('order/pay_points', $data);
    }
    
    /**
     * @微信支付二维码
     * */
    public function get_wxpay_code()
    {
        $postData = $this->input->post();
        
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
            echo json_encode(array('status'=>true, 'code_img_url'=>$this->config->images_url.$code_img_url));
        } else{
            echo json_encode(array('status'=>false, 'msg'=>'微信支付二维码生成失败，请刷新页面'));
        }
    }
    
    
    
}
