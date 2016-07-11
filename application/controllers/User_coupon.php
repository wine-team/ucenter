<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_coupon extends CS_Controller {

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('advert_model','advert');
        $this->load->model('mall_brand_model','mall_brand');
        $this->load->model('mall_cart_goods_model', 'mall_cart_goods');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
    }
    
    public function get_user_info()
    {
        $frontUserInfo = $this->user->findByid($this->uid)->row();
        $order_num = $this->mall_order_base->total($this->uid);
        $enshrine_num = $this->mall_enshrine->total(array('uid'=>$this->uid));
        $coupon_num = $this->user_coupon_get->total(array('uid'=>$this->uid));
        $frontUserInfo->num_list = array('order_num'=>$order_num, 'enshrine_num'=>$enshrine_num, 'coupon_num'=>$coupon_num, 'pay_points_num'=>$frontUserInfo->pay_points);
        return $frontUserInfo;
    }

    public function index()
    {
        if (!$this->cache->memcached->get('hostHomePageCache')) {
            $data = array(
				'advert' => $this->advert->findBySourceState($source_state=1)->result_array(),
			    'cms_block' => $this->cms_block->findByBlockIds(array('home_keyword','head_right_advert','head_today_recommend','head_recommend_down','head_hot_keyword')),
			    'brand' => $this->mall_brand->findBrand($limit=6)->result_array()
			);
            $this->cache->memcached->save('hostHomePageCache',$data);
        } else {
            $data = $this->cache->memcached->get('hostHomePageCache');
        }
        $data['user_coupon'] = $this->user_coupon_get->findByStatus($this->uid, $this->input->get('status'))->result();
        $data['coupon_status'] = array('1'=>'未使用', '2'=>'已使用', '3'=>'过期');
        $data['user_info'] = $this->get_user_info();
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $this->load->view('user_coupon/user_coupon', $data);
    }
    
}
