<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enshrine extends MJ_Controller {

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('mall_goods_base_model', 'mall_goods_base');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('help_category_model','help_category');
    }

    public function index()
    {
        $data['user_info'] = unserialize(base64_decode(get_cookie('frontUserInfo')));
        $enshrine = $this->mall_enshrine->findById(array('uid'=>$data['user_info']->uid))->result();
        $goods_ids = array();
        foreach ($enshrine as $e) {
            $goods_ids[] = $e->goods_id;
        }
        $data['goods'] = $this->mall_goods_base->getWhereIn($goods_ids);
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('foot_recommend_img','foot_speed_key'));
        $data['category'] = $this->help_category->getResultByFlag($flag=1);//左边栏显示
        $this->load->view('enshrine/enshrine', $data);
    }
    
}
