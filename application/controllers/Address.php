<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Address extends CS_Controller {

    public function _init()
    {
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('mall_cart_goods_model', 'mall_cart_goods');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
        $this->load->model('mall_address_model', 'mall_address');
        $this->load->model('region_model', 'region');
    }
    
    public function index()
    {
        $address = $this->mall_address->findById((int)$this->input->get('address_id'));
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
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword','head_right_advert','head_today_recommend','head_recommend_down','head_hot_keyword'));
        $data['head_menu'] = 'on';
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
                $this->jsonMessage('', base_url('Address/index'));
            } else {
                $this->jsonMessage('操作失败');
            }
        } else {
            $this->jsonMessage('最多可以添加5个收货地址');
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
