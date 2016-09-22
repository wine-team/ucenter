<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CS_Controller {

    public function _init()
    {
        $this->load->library('pagination');
//         $this->load->library('chinapay/chinapay', null, 'chinapay');
        $this->load->library('alipay/alipaypc', null, 'alipaypc');
        $this->load->library('qrcode',null,'QRcode');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('mall_order_product_model', 'mall_order_product');
        $this->load->model('mall_goods_base_model', 'mall_goods_base');
        $this->load->model('mall_goods_related_model', 'mall_goods_related');
        $this->load->model('deliver_order_model', 'deliver_order');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
        $this->load->model('mall_order_reviews_model', 'mall_order_reviews');
    }
    
    public function index($num = 0) {
    	
        $perpage = 10;
        $page = $num/$perpage;
        $data['sum'] = $this->mall_order_base->total($this->uid, $this->input->get('order_status'));
        $config['base_url'] = base_url('order/index');
        $config['total_rows'] = $data['sum'];
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $data['order'] = $this->mall_order_base->mallOrderList($page, $perpage, $this->uid, $this->input->get('order_status'))->result();
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
        $order = $this->mall_order_base->findById((int)$order_id);
        if ($order->num_rows() == 0) {
            $this->alertJumpPre('订单信息出错');
        }
        if ($order->row()->payer_uid != $this->uid) {
            $this->alertJumpPre('订单信息出错');
        }
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['pay_method'] = array('1'=>'支付宝','2'=>'微信','3'=>'银联');      
        $data['order'] = $order->row();
        $data['order_product'] = $this->mall_order_product->findByOrderId($order_id)->result();
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/order_detail', $data);
    }
    
    /**
     * 查看物流
     * */
    public function check_deliver($order_id=0)
    {
        $order = $this->mall_order_base->findById((int)$order_id);
        if ($order->num_rows() == 0) {
            $this->alertJumpPre('订单信息出错');
        }
        if ($order->row()->payer_uid != $this->uid) {
            $this->alertJumpPre('订单信息出错');
        }
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $data['pay_id'] = $this->input->get('pay_id');
        $data['order_id'] = $order_id;
        $deliver_order = $this->deliver_order->findByOrderId($order_id);
        $data['deliver_order'] = $deliver_order->num_rows()>0 ? $deliver_order->row() : '';
        $this->load->view('order/check_deliver', $data);
    }
    
    /**
     * 评价
     * */
    public function order_reviews($order_id)
    {
        $order = $this->mall_order_base->findById((int)$order_id);
        if ($order->num_rows() == 0) {
            $this->alertJumpPre('订单信息出错');
        }
        if ($order->row()->payer_uid != $this->uid) {
            $this->alertJumpPre('订单信息出错');
        }
        $product = $this->mall_order_product->findByOrderId($order_id);
        if ($product->num_rows() == 0) {
            $this->alertJumpPre('订单信息出错');
        }
        $data['product'] = $product->row()->goods_name.'['.$product->row()->attr_value.'] '.'（共'.$product->num_rows().'件）';
        foreach ($product->result() as $p) {
            if ($p->goods_id == $this->input->get('goods_id')) {
                $data['product'] = $p->goods_name.'['.$p->attr_value.']';
            }
        }
        $data['order_id'] = $order_id;
        $data['goods_id'] = $this->input->get('goods_id');
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/order_reviews', $data);
    }
    
    public function reviews_add()
    { 
        $postData = $this->input->post();
        $img = array();
        for ($i=1;$i<=5;$i++) {
            $input = 'slide_show'.$i;
            if (!empty($_FILES[$input]['name'])) {
                $file = $this->dealWithImages($input, '', 'reviews');
                $img[] = $file['file_name'];
            }
        }
        $where['order_id'] = $postData['order_id'];
        if (!empty($postData['goods_id'])) {
            $where['goods_id'] = $postData['goods_id'];
        }
        $product = $this->mall_order_product->getWhere($where)->result();
        $i = 0;
        foreach ($product as $p) {
            $data[$i]['order_product_id'] = $p->order_product_id;
            $data[$i]['order_id']   = $p->order_id;
            $data[$i]['goods_id']   = $p->goods_id;
            $data[$i]['goods_name'] = $p->goods_name;
            $data[$i]['goods_attr'] = $p->attr_value;
            $data[$i]['score']      = $postData['score'];
            $data[$i]['content']    = $postData['content'];
            $data[$i]['slide_show'] = implode('|',$img);
            $data[$i]['created_at'] = date('Y-m-d H:i:s');
            $data[$i]['user_name']  = $this->userName;
            $data[$i]['uid']        = $this->uid;
            $i ++;
        }
        
        $this->db->trans_start();
        $this->mall_order_reviews->insertArray($data);
        $this->mall_order_base->updateOrderStatus($postData['order_id'], 0, 6);
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            $this->redirect('order/order_detail/'.$postData['order_id']);
        }
        $this->alertJumpPre('操作失败，请再试一次');
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
     * 微信二维码的生产
     * @param unknown $order_id
     */
    public function productEwm(){
        $order_id = $this->input->post('order_id');
        $url = $this->config->m_url.'pay/wxPay?order_id='.base64_encode($order_id).'.html';
        $name = 'pay-order_id-'.$order_id.'.png';
        $path = $this->config->upload_image_path('common/ewm').$name;
        $this->QRcode->png($url,$path,4,10);
        echo json_encode($this->config->show_image_url('common/ewm', $name));
    }
 
    /**
     * 获取订单是否支付
     */
    public function get_order_status() {
    
        $order_id = $this->input->post('order_id');
        if (empty($order_id)) {
            $this->jsonMessage('非法参数');
        }
        $order_base = $this->mall_order_base->findById((int)$order_id);
        if ($order_base->num_rows()<=0) {
            $this->jsonMessage('订单不存在');
        }
        $mainOrder = $order_base->row(0);
        if ($mainOrder->order_status==2) {
            $this->jsonMessage('', base_url('order/order_detail/'.$order_id));
        }
        $this->jsonMessage('该订单没有支付');
    }
    
    /**
     * 网银去支付方法。
     */
    public function pay_by_orderid()
    {
        $order_id = $this->input->post('order_id');
        $pay_bank = $this->input->post('pay_bank');
        $order = $this->mall_order_base->findById((int)$order_id);
        if ($order->num_rows() == 0) {
            $this->alertJumpPre('订单信息出错');
        }
        $orderInfo = $order->row();
        if ($pay_bank == 1) {
            //支付宝支付
            $alipayParameter = $this->alipayParameter($pay_bank, $orderInfo, $orderInfo->actual_price);
            $this->alipaypc->callAlipayApi($alipayParameter);
        } else {
            //银联支付
            $BgRetUrl = site_url('paycallback/chinapayReturn');
            $PageRetUrl = site_url('paycallback/chinapayReturn');
            $objPay = $this->chinapay->callChinapayApi($order_id, $orderInfo->actual_price, 'notcart', $BgRetUrl, $PageRetUrl);
        }
    }
    
    
    /**
     * 获取支付宝需要参数。
     * @param paybank $bank_id
     * @param object $orderInfo
     * @param object $orderProductInfo    ---主订单号的
     * @return array
     */
    private function alipayParameter($pay_bank, $order_id,$actual_price)
    {
        $parameter = array(
            'out_trade_no' => $order_id,
            'subject'      => $order_id,
            'total_fee'    => $actual_price,
            'body'         => $order_id,
            'show_url'     => base_url(),
            'notify_url'   => base_url('paycallback/alipayNotify'),
            'return_url'   => base_url('payt/alipayReturn'),
            'pay_method'   => $pay_bank,
            'defaultbank'  => 'alipay'
        );
        return $parameter;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * @微信支付二维码
     * */
    public function get_wxpay_code()
    {
        $postData = $this->input->post();
        $order = $this->mall_order_base->findById($postData['out_trade_no'])->row();
//         if ($order->status != 2) {
//             echo json_encode(array('status'=>false, 'msg'=>'订单状态已改变', 'data'=>base_url('order/index')));exit;
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
                echo json_encode(array('status'=>true, 'msg'=>'支付成功', 'data'=>base_url('order/index')));
            } else {
                echo json_encode(array('status'=>false));
            }
        } else {
            echo json_encode(array('status'=>false));
        }
    }
}
