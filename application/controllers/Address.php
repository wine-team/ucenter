<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Address extends CS_Controller {

    public function _init()
    {
    	$this->load->helper('validation');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
        $this->load->model('mall_address_model', 'mall_address');
        $this->load->model('region_model', 'region');
    }
    
    public function index()
    {
        $address = $this->mall_address->findById($this->input->get('address_id'));
        $data['res'] = null;
        if ($address->num_rows() > 0) {
            $data['res'] = $address->row();
            $data['province_id'] = $address->row()->province_id;
            $data['city_id'] = $address->row()->city_id;
            $data['district_id'] = $address->row()->district_id;
        } 
        $data['user_info'] = $this->get_user_info();
        $data['address'] = $this->mall_address->findByUid($this->uid);
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $data['head_menu'] = 'on';
        $this->load->view('address/address', $data);
    }
    
    /**
     *添加
     */
    public function addPost()
    {
        $postData = $this->input->post();
        $this->validate($postData);
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
        if ($res && $this->db->trans_status()===TRUE) {
            $this->jsonMessage('', base_url('Address/index'));
        } 
        $this->jsonMessage('操作失败');
    }
    
     /**
     * 验证
     * @param unknown $param
     */
    public function validate($param) {
    	
    	if (empty($param['receiver_name']) || mb_strlen($param['receiver_name'])<2) {
    		$this->jsonMessage('收货人姓名不得少于2个字！');
    	}
    	if (empty($param['province_id']) || empty($param['city_id']) || empty($param['district_id'])) {
    		$this->jsonMessage('省市区不能为空！');
    	}
    	if (empty($param['detailed']) || mb_strlen($param['detailed'])<4 || mb_strlen($param['detailed'])>50){
    		$this->jsonMessage('请填写收货地址4-50个字！');
    	}
    	if (empty($param['tel']) || !validateMobilePhone($param['tel'])){
    		$this->jsonMessage('请填写正确的手机号码！');
    	}
    	if ( !empty($param['code']) ){
    		if (!validateZipCode($param['code'])) {
    			$this->jsonMessage('请填写正确的邮编！');
    		}
    	}
    }
    
     /**
     * 设为默认
     */
    public function setDefault()
    {
        $this->db->trans_start();
        $this->mall_address->setNotDefault($this->uid);
        $this->mall_address->setDefault($this->input->get('address_id'));
        $this->db->trans_complete();
        if ($this->db->trans_status()===TRUE) {
            $this->success('Address/index', '', '设置成功！');
	    }
	    $this->error('Address/index', '', '设置失败！');
	    
    }
    
    /**
     *删除
     */
    public function delete()
    {
        $res = $this->mall_address->delete($this->input->get('address_id'));
        if ($res) {
            $this->success('Address/index', '', '删除成功！');
        } 
        $this->error('Address/index', '', '删除失败！');
    }
}
