<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Address extends CS_Controller {

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
        $this->load->model('mall_address_model', 'mall_address');
        $this->load->model('region_model', 'region');
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
        $address = $this->mall_address->findById($this->input->get('address_id'));
        $data['res'] = (object)null;
        if ($address->num_rows() > 0) {
            $data['res'] = $address->row();
            $data['province_id'] = $address->row()->province_id;
            $data['city_id'] = $address->row()->city_id;
            $data['district_id'] = $address->row()->district_id;
        } 
        $data['user_info'] = $this->get_user_info();
        $data['address'] = $this->mall_address->findByUid($this->uid)->result();
        $data['cart_num'] = ($this->uid) ? $this->mall_cart_goods->getCartGoodsByUid($this->uid)->num_rows() : 0;
        $this->load->view('address/address', $data);
    }
    
    public function addPost()
    {
        $postData = $this->input->post();
        $address_num = $this->mall_address->total(array('uid'=>$this->uid));
        if ($address_num < 5) {
            
            $this->db->trans_start();
            if (isset($postData['is_default']) && $postData['is_default']==2) {
                $this->mall_address->setNotDefault($this->uid);
            }
            if ($postData['address_id']) {
                $res = $this->mall_address->update($postData['address_id'], $postData);
            } else {
                $res = $this->mall_address->insert($postData);
            }
            $this->db->trans_complete();
            if ($res>0 && $this->db->trans_status()) {
                echo json_encode(array('status'=>true, 'messages'=>base_url('Address/index')));
            } else {
                echo json_encode(array('status'=>false ,'messages'=>'操作失败'));
            }
        } else {
            echo json_encode(array('status'=>false ,'messages'=>'最多可以添加5个收货地址'));
        }
    }
    
    public function setDefault()
    {
        $this->db->trans_start();
        $this->mall_address->setNotDefault($this->uid);
        $this->mall_address->setDefault($this->input->get('address_id'));
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            $this->success('Address/index', '', '设置成功！');
	    } else {
	        $this->error('Address/index', '', '设置失败！');
	    }
    }
    
    public function delete()
    {
        $res = $this->mall_address->delete($this->input->get('address_id'));
        if ($res) {
            $this->success('Address/index', '', '删除成功！');
        } else {
            $this->error('Address/index', '', '删除失败！');
        }
    }
    
}
