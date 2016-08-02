<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enshrine extends CS_Controller {

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('mall_cart_goods_model', 'mall_cart_goods');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
        $this->load->model('mall_goods_base_model', 'mall_goods_base');
    }
    
    public function index($num = 0)
    {
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        
        $perpage = 10;
        $page = $num/$perpage;
        $data['sum'] = $data['user_info']->num_list['enshrine_num'];
        $config['base_url'] = base_url('Enshrine/index');
        $config['total_rows'] = $data['sum'];
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $data['goods'] = $this->mall_enshrine->enshrineList($page, $perpage, $this->uid)->result();
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword','head_right_advert','head_today_recommend','head_recommend_down','head_hot_keyword'));
        $this->load->view('enshrine/enshrine', $data);
    }
    
    public function delete()
    {
        $res = $this->mall_enshrine->delete(array('uid'=>$this->uid, 'goods_id'=>$this->input->get('goods_id')));
        if ($res) {
            $this->success('Enshrine/index', '', '删除成功！');
        } else {
            $this->error('Enshrine/index', '', '删除失败！');
        }
    }
    
    
}
