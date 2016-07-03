<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_coupon extends MJ_Controller {

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('help_category_model','help_category');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
    }

    public function index()
    {
        $where['uid'] = $this->uid;
        if ($this->input->get('status')) $where['status'] = $this->input->get('status');
        $data['user_coupon'] = $this->user_coupon_get->getWhere($where)->result();
        $data['coupon_status'] = array('1'=>'未使用', '2'=>'已使用', '3'=>'过期');
        $data['user_info'] = unserialize(base64_decode(get_cookie('frontUserInfo')));
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('foot_recommend_img','foot_speed_key'));
        $data['category'] = $this->help_category->getResultByFlag($flag=1);//左边栏显示
        $this->load->view('user_coupon/user_coupon', $data);
    }
    
}
