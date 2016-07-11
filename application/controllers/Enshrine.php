<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enshrine extends CS_Controller {

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
        $this->load->model('mall_goods_base_model', 'mall_goods_base');
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

    public function index($num = 0)
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
        $data['user_info'] = $this->get_user_info();
        
        $perpage = 10;
        $page = $num/$perpage;
        $data['sum'] = $data['user_info']->num_list['enshrine_num'];
        $config['base_url'] = base_url('Enshrine/index');
        $config['total_rows'] = $data['sum'];
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $enshrine = $this->mall_enshrine->enshrineList($page, $perpage, $this->uid)->result();
        $goods_ids = array();
        foreach ($enshrine as $e) {
            $goods_ids[] = $e->goods_id;
        }
        $data['goods'] = $this->mall_goods_base->getWhereIn($goods_ids);
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
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
