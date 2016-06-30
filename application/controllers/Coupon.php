<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Coupon extends MJ_Controller {

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('help_category_model','help_category');
    }

    public function index()
    {
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('foot_recommend_img','foot_speed_key'));
        $data['category'] = $this->help_category->getResultByFlag($flag=1);//左边栏显示
        $this->load->view('coupon/coupon', $data);
    }
    
}
