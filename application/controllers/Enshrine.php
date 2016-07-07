<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enshrine extends CS_Controller {

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('advert_model','advert');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
        $this->load->model('mall_goods_base_model', 'mall_goods_base');
    }
    
    public function get_user_info()
    {
        if (!$this->cache->memcached->get('frontUserInfo')) {
            $frontUserInfo = $this->user->findByid($this->uid)->row();
            $order_num = $this->mall_order_base->total(array('payer_uid'=>$this->uid));
            $enshrine_num = $this->mall_enshrine->total(array('uid'=>$this->uid));
            $coupon_num = $this->user_coupon_get->total(array('uid'=>$this->uid));
            $frontUserInfo->num_list = array('order_num'=>$order_num, 'enshrine_num'=>$enshrine_num, 'coupon_num'=>$coupon_num, 'pay_points_num'=>$frontUserInfo->pay_points);
            $this->cache->memcached->save('frontUserInfo',$frontUserInfo);
        } else {
            $frontUserInfo = $this->cache->memcached->get('frontUserInfo');
        }
        return $frontUserInfo;
    }

    public function index()
    {
        if (!$this->cache->memcached->get('hostHomePageCache')) {
            $data = array(
                'advert' => $this->advert->findBySourceState($source_state=1)->result_array(),
                'cms_block' => $this->cms_block->findByBlockIds(array('home_keyword','head_right_advert','head_today_recommend','head_recommend_down','head_hot_keyword')),
            );
            $this->cache->memcached->save('hostHomePageCache',$data);
        } else {
            $data = $this->cache->memcached->get('hostHomePageCache');
        }
        $data['user_info'] = $this->get_user_info();
        $enshrine = $this->mall_enshrine->getByUid($this->uid)->result();
        $goods_ids = array();
        foreach ($enshrine as $e) {
            $goods_ids[] = $e->goods_id;
        }
        $data['goods'] = $this->mall_goods_base->getWhereIn($goods_ids);
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
