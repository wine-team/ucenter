<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ucenter extends CS_Controller {

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('advert_model','advert');
        $this->load->model('mall_cart_goods_model', 'mall_cart_goods');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_order_product_model', 'mall_order_product');
        $this->load->model('mall_goods_base_model', 'mall_goods_base');
        $this->load->model('mall_goods_related_model', 'mall_goods_related');
        $this->load->model('mall_order_reviews_model', 'mall_order_reviews');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
        $this->load->model('account_log_model', 'account_log');
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
        $data['order'] = $this->mall_order_base->findByStatus($this->uid, $this->input->get('status'))->result();
        $orderid_arr = array();
        foreach ($data['order'] as $order) {
            $orderid_arr[] = $order->order_id;
        }
        $data['order_product'] = $this->mall_order_product->getWhereIn($orderid_arr);
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 5; 
        $this->load->view('order/all_order', $data);
    }
    
    public function user_reviews()
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
        $data['user_reviews'] = $this->mall_order_reviews->getByUid($this->uid)->result();
        $data['reviews_status'] = array('1'=>'待审核', '2'=>'通过', '3'=>'未通过审核');
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $this->load->view('order/user_reviews', $data);
    }
    
    public function order_detail($order_id)
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
        $data['status_arr'] = array('1'=>'取消订单', '2'=>'未付款', '3'=>'已付款', '4'=>'已发货', '5'=>'已收货', '6'=>'已评价');
        $data['order'] = $this->mall_order_base->findById($order_id)->row();
        $data['order_product'] = $this->mall_order_product->findByOrderId($order_id)->result();
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $this->load->view('order/order_detail', $data);
    }
    
    public function get_maybe_like()
    {set_cookie('history', base64_encode(serialize(array())), 60);
        $goods_ids = array();
        $history = unserialize(base64_decode(get_cookie('history')));
        if ($history) {
            foreach ($history as $h) {
                $goods_ids[] = $h->goods_id;
            }
            $related_goods_ids = array();
            $related = $this->mall_goods_related->getWhereIn($goods_ids);
            foreach ($related as $r) {
                $related_goods_ids[] = $r->related_goods_id;
            }
            $goods = $this->mall_goods_base->getWhereIn($goods_ids);
            echo json_encode($goods);
        } else {
            echo json_encode(false);
        }
    }
    
    public function user_info()
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
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $this->load->view('order/user_info', $data);
    }
    
    public function edit_photo()
    {
        $postData = $this->input->post();
        $frontUserInfo = $this->get_user_info();
        $old_photo = '';
        if (!in_array($frontUserInfo->photo, user_photo())) {
            $old_photo = $frontUserInfo->photo;
        }
        $upload = $this->dealWithImages('photo', $old_photo);
        $photo = isset($upload['file_name']) ? $upload['file_name'] : $postData['user_photo'];
        $res = $this->user->updatePhoto($this->uid, $photo);
        if ($res) {
            $frontUserInfo->photo = $photo;
            $this->cache->memcached->save('frontUserInfo',$frontUserInfo);
        }
        redirectAction('Ucenter/user_info');
    }
    
    public function edit_user_info()
    {
        $postData = $this->input->post();
        $res = $this->user->update($this->uid, $postData);
        if ($res) {
            $frontUserInfo = $this->get_user_info();
            $frontUserInfo->alias_name = $postData['alias_name'];
            $frontUserInfo->birthday = $postData['birthday'];
            $frontUserInfo->sex = $postData['sex'];
            $frontUserInfo->email = $postData['email'];
            $frontUserInfo->phone = $postData['phone'];
            $this->cache->memcached->save('frontUserInfo',$frontUserInfo);
            echo json_encode(array('status'=>true, 'messages'=>base_url('Ucenter/edit_ok')));
        } else {
            echo json_encode(array('status'=>false, 'messages'=>'修改失败！'));
        }
    }
    
    public function edit_ok()
    {
        $this->load->view('order/edit_ok');
    }
    
    public function reset_password()
    {
        $res = $this->user->updatePwd($this->uid, $this->input->post('new_password'));
        if ($res) {
            $this->cache->memcached->delete('frontUserInfo');
            echo json_encode(array('status'=>true, 'messages'=>$this->config->passport_url.'Login/logout'));
        } else {
            echo json_encode(array('status'=>false, 'messages'=>'修改失败！'));
        }
    }
    
    public function pay_points()
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
        $data['points_num'] = $this->account_log->total(array('uid'=>$this->uid, 'account_type'=>2));
        $data['points_list'] = $this->account_log->getByAccountType($this->uid, 2)->result();
        $data['user_info'] = $this->get_user_info();
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $this->load->view('order/pay_points', $data);
    }
    
}
