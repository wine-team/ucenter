<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CS_Controller {

    public function _init()
    { 
        $this->load->library('pagination');
//         $this->load->library('chinapay/chinapay', null, 'chinapay');
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
        $this->load->model('mall_order_refund_model', 'mall_order_refund');
        $this->load->model('mall_order_history_model', 'mall_order_history');
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
        $data['had_refund'] = $this->mall_order_refund->findByOrderId($order_id);
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['pay_method'] = array('1'=>'支付宝','2'=>'微信','3'=>'银联');      
        $data['order'] = $order->row();
        $data['order_product'] = $this->mall_order_product->findByOrderId($order_id)->result();
        $order_review = $this->mall_order_reviews->getByOrderid($order_id)->result();
        $order_product_review = array();
        foreach ($order_review as $review) {
            $order_product_review[] = $review->goods_id;
        }
        $data['order_product_review'] = $order_product_review; 
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/order_detail', $data);
    }
    
    /**
     * 取消订单
     * */
    public function order_cancel($order_id = 0)
    {
        $order = $this->mall_order_base->findById((int)$order_id);
        if ($order->num_rows() == 0) {
            $this->alertJumpPre('订单信息出错');
        }
        if ($order->row()->payer_uid != $this->uid) {
            $this->alertJumpPre('订单信息出错');
        }
        $this->db->trans_start();
        $res = $this->mall_order_base->updateOrderStatus($order_id, 0, 1); //更新订单状态
        $this->order_history($order_id, 6, '取消订单'); //订单状态记录
        $this->order_product_back($order_id, $order->row()->coupon_code);
        $this->db->trans_complete();
        if ($res && $this->db->trans_status()) {
            $this->redirect('order/index');
        } 
        $this->alertJumpPre('操作失败，请再试一次');
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
     * @退款
     * */
    public function order_refund($order_id = 0)
    {
        $refund = $this->mall_order_refund->findByOrderId($order_id);
        if ($refund->num_rows() > 0) {
            $this->alertJumpPre('您已经申请退款，正在加急处理中...');
        } else {
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
            $this->db->trans_start();
            $i = 0;
            foreach ($product->result() as $p) {
                $data[$i]['order_product_id']   = $p->order_product_id;
                $data[$i]['order_id']           = $p->order_id;
                $data[$i]['goods_id']           = $p->goods_id;
                $data[$i]['existing']           = $p->number;
                $data[$i]['number']             = $p->refund_num;
                $data[$i]['seller_uid']         = $order->row()->seller_uid;
                $data[$i]['uid']                = $this->uid;
                $data[$i]['user_name']          = $this->aliasName;
                $data[$i]['cellphone']          = $this->userPhone;
                $data[$i]['counter_fee']        = 0;
                $data[$i]['status']             = 1;
                $data[$i]['deliver_order_id']   = 0;
                $data[$i]['images']             = '';
                $data[$i]['refund_content']     = '';
                $data[$i]['reject_content']     = '';
                $data[$i]['created_at']         = date('Y-m-d H:i:s');
                $i ++;
                $this->mall_order_product->update(array('refund_num'=>0),$p->order_product_id);
            }
            $res = $this->mall_order_refund->insertArray($data);
            $this->order_history($order_id, 7, '申请退货');
            $this->db->trans_complete();
            if ($res && $this->db->trans_status()) {
                $this->alertJumpPre('申请退款成功，稍后客服会联系您...');
            } else {
                $this->alertJumpPre('申请退款失败，请再次申请');
            }
        }
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
            $data[$i]['user_name']  = $this->aliasName;
            $data[$i]['uid']        = $this->uid;
            $i ++;
        }
        
        $this->db->trans_start();
        $this->mall_order_reviews->insertArray($data);
        $this->mall_order_base->updateOrderStatus($postData['order_id'], 4, 6);
        $this->order_history($postData['order_id'], 5, '评价');
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            $this->redirect('order/order_detail/'.$postData['order_id']);
        }
        $this->alertJumpPre('操作失败，请再试一次');
    }
    
    /**
     * 订单状态记录
     * */
    public function order_history($order_id, $operate_type, $comment)
    {
        $history['order_id']      = $order_id;
        $history['operate_time']  = date('Y-m-d H:i:s');
        $history['uid']           = $this->uid;
        $history['operate_type']  = $operate_type;
        $history['comment']       = $comment;
        $this->mall_order_history->insert($history);
    }
    
    /**
     * 取消订单后处理订单里产品
     * */
    public function order_product_back($order_id, $coupon_code)
    { 
        $product = $this->mall_order_product->findByOrderId($order_id)->result();
        $integral = 0;
        foreach ($product as $p) {
            $integral += $p->integral;
            $goods[$p->goods_id] = $p->number;
        }
        //退还优惠券，退还积分，退还数量
        $this->user_coupon_get->updateStatus($coupon_code);
        $this->user->updatePoints($this->uid, $integral);
        foreach ($goods as $goods_id=>$in_stock) {
            $this->mall_goods_base->updateStock($goods_id, $in_stock);
        }
        //更新订单产品操作时间
        $this->mall_order_product->update_at($order_id);
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
        $payid = $this->input->post('pay_id');
        $url = $this->config->m_url.'pay/wxPay?order_id='.$payid.'.html';
        $name = 'pay-'.$payid.'.png';
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
    
    
}
