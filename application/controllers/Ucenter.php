<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ucenter extends MJ_Controller {

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('help_category_model','help_category');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_order_product_model', 'mall_order_product');
        $this->load->model('mall_order_reviews_model', 'mall_order_reviews');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
        $this->load->model('account_log_model', 'account_log');
    }

    public function index()
    {
        $frontUserInfo = unserialize(base64_decode(get_cookie('frontUserInfo')));  
        if (!$frontUserInfo) {
            $frontUserInfo = $this->user->findByid($this->uid)->row();
            $order_num = $this->mall_order_base->total(array('payer_uid'=>$this->uid));
            $enshrine_num = $this->mall_enshrine->total(array('uid'=>$this->uid));
            $coupon_num = $this->user_coupon_get->total(array('uid'=>$this->uid));
            $frontUserInfo->num_list = array('order_num'=>$order_num, 'enshrine_num'=>$enshrine_num, 'coupon_num'=>$coupon_num, 'pay_points_num'=>$frontUserInfo->pay_points);
            set_cookie('frontUserInfo', base64_encode(serialize($frontUserInfo)), 435200);
        }
        $where['payer_uid'] = $this->uid;
        if ($this->input->get('status')) $where['status'] = $this->input->get('status');
        $data['user_info'] = $frontUserInfo;
        $data['order'] = $this->mall_order_base->getWhere($where)->result();
        $orderid_arr = array();
        foreach ($data['order'] as $order) {
            $orderid_arr[] = $order->order_id;
        }
        $data['order_product'] = $this->mall_order_product->getWhereIn($orderid_arr);
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('foot_recommend_img','foot_speed_key'));
        $data['category'] = $this->help_category->getResultByFlag($flag=1);//左边栏显示
        $this->load->view('order/all_order', $data);
    }
    
    public function user_reviews()
    {
        $data['user_info'] = unserialize(base64_decode(get_cookie('frontUserInfo')));
        $data['user_reviews'] = $this->mall_order_reviews->getWhere(array('uid'=>$this->uid))->result();
        $data['reviews_status'] = array('1'=>'待审核', '2'=>'通过', '3'=>'未通过审核');
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('foot_recommend_img','foot_speed_key'));
        $data['category'] = $this->help_category->getResultByFlag($flag=1);//左边栏显示
        $this->load->view('order/user_reviews', $data);
    }
    
    public function order_detail($order_id)
    {
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['order'] = $this->mall_order_base->getWhere(array('order_id'=>$order_id))->row();
        $data['order_product'] = $this->mall_order_product->findById($order_id)->result();
        $data['user_info'] = unserialize(base64_decode(get_cookie('frontUserInfo')));
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('foot_recommend_img','foot_speed_key'));
        $data['category'] = $this->help_category->getResultByFlag($flag=1);//左边栏显示
        $this->load->view('order/order_detail', $data);
    }
    
    public function user_info()
    {
        $frontUserInfo = unserialize(base64_decode(get_cookie('frontUserInfo')));
        $data['user_info'] = $frontUserInfo;
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('foot_recommend_img','foot_speed_key'));
        $data['category'] = $this->help_category->getResultByFlag($flag=1);//左边栏显示
        $this->load->view('order/user_info', $data);
    }
    
    public function edit_photo()
    {
        $postData = $this->input->post();
        $frontUserInfo = unserialize(base64_decode(get_cookie('frontUserInfo')));
        $old_photo = '';
        if (!in_array($frontUserInfo->photo, user_photo())) {
            $old_photo = $frontUserInfo->photo;
        }
        $upload = $this->dealWithImages('photo', $old_photo);
        $data['photo'] = isset($upload['file_name']) ? $upload['file_name'] : $postData['user_photo'];
        $res = $this->user->update(array('uid'=>$this->uid), $data);
        if ($res) {
            $frontUserInfo->photo = $data['photo'];
            set_cookie('frontUserInfo', base64_encode(serialize($frontUserInfo)), 435200);
        }
        redirectAction('Ucenter/user_info');
    }
    
    public function edit_user_info()
    {
        $postData = $this->input->post();
        $data['alias_name'] = $postData['alias_name'];
        $data['birthday'] = $postData['birthday'];
        $data['sex'] = $postData['sex'];
        $data['email'] = $postData['email'];
        $data['phone'] = $postData['phone'];
        $res = $this->user->update(array('uid'=>$this->uid), $data);
        if ($res) {
            $frontUserInfo = unserialize(base64_decode(get_cookie('frontUserInfo')));
            $frontUserInfo->alias_name = $postData['alias_name'];
            $frontUserInfo->birthday = $postData['birthday'];
            $frontUserInfo->sex = $postData['sex'];
            $frontUserInfo->email = $postData['email'];
            $frontUserInfo->phone = $postData['phone'];
            set_cookie('frontUserInfo', base64_encode(serialize($frontUserInfo)), 7200);
            echo json_encode(array('status'=>true, 'messages'=>base_url('Ucenter/user_info')));
        } else {
            echo json_encode(array('status'=>false, 'messages'=>'修改失败！'));
        }
    }
    
    public function reset_password()
    {
        $data['password'] = sha1(base64_encode($this->input->post('new_password')));
        $res = $this->user->update(array('uid'=>$this->uid), $data);
        if ($res) {
            delete_cookie('frontUserInfo');
            echo json_encode(array('status'=>true, 'messages'=>$this->config->passport_url.'Login/logout'));
        } else {
            echo json_encode(array('status'=>false, 'messages'=>'修改失败！'));
        }
    }
    
    public function pay_points()
    {
        $data['points_num'] = $this->account_log->total(array('uid'=>$this->uid, 'account_type'=>2));
        $data['points_list'] = $this->account_log->getWhere(array('uid'=>$this->uid, 'account_type'=>2))->result();
        $frontUserInfo = unserialize(base64_decode(get_cookie('frontUserInfo')));
        $data['user_info'] = $frontUserInfo;
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('foot_recommend_img','foot_speed_key'));
        $data['category'] = $this->help_category->getResultByFlag($flag=1);//左边栏显示
        $this->load->view('order/pay_points', $data);
    }
    
}
