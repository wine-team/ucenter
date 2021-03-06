<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_coupon extends CS_Controller {

    public function _init()
    {
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
    }
    
     /**
     *首页
     */
    public function index() {
    	
        $data['head_menu'] = 'on';
        $data['user_coupon'] = $this->user_coupon_get->findByStatus($this->uid, $this->input->get('status'))->result();
        $data['coupon_status'] = array('1'=>'未使用', '2'=>'已使用', '3'=>'过期');
        $data['user_info'] = $this->get_user_info();
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('user_coupon/user_coupon', $data);
    }
    
}
