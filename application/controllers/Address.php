<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Address extends MJ_Controller {

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('help_category_model','help_category');
        $this->load->model('mall_address_model', 'mall_address');
        $this->load->model('region_model', 'region');
    }

    public function index()
    {
        $data['user_info'] = unserialize(base64_decode(get_cookie('frontUserInfo')));
        $data['address'] = $this->mall_address->findById(array('uid'=>$data['user_info']->uid))->result();
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('foot_recommend_img','foot_speed_key'));
        $data['category'] = $this->help_category->getResultByFlag($flag=1);//左边栏显示
        $this->load->view('address/address', $data);
    }
    
    public function addPost()
    {
        $postData = $this->input->post();
        $data['uid'] = $this->uid;
        $address_num = $this->mall_address->findById($data)->num_rows();
        if ($address_num < 5) {
            $data['receiver_name'] = $postData['receiver_name'];
            $data['detailed'] = $postData['detailed'];
            $data['tel'] = $postData['tel'];
            $data['code'] = $postData['code'];
            $data['province_id'] = $postData['province_id'];
            $data['city_id'] = $postData['city_id'];
            $data['district_id'] = $postData['district_id'];
            $region = $this->region->getWhereIn(array($postData['province_id'], $postData['city_id'], $postData['district_id']))->result();
            $data['province_name'] = $region[0]->region_name;
            $data['city_name'] = $region[1]->region_name;
            $data['district_name'] = $region[2]->region_name;
            $this->db->trans_start();
            if (isset($postData['is_default'])) {
                $data['is_default'] = $postData['is_default'];
                if ($postData['is_default'] == 2) {
                    $this->mall_address->update(array('uid'=>$this->uid, 'is_default'=>2), array('is_default'=>1));
                }
            }
            $res = $this->mall_address->insert($data);
            $this->db->trans_complete();
            if ($res>0 && $this->db->trans_status()) {
                echo json_encode(array('status'=>true, 'messages'=>base_url('Address/index')));
            } else {
                echo json_encode(array('status'=>false ,'messages'=>'新增失败'));
            }
        } else {
            echo json_encode(array('status'=>false ,'messages'=>'最多可以添加5个收货地址'));
        }
    }
    
    public function edit()
    {
        $address_id = $this->input->get('address_id');
        
        var_dump($address_id);
    }
    
    public function editPost()
    {
        
    }
    
    public function setDefault()
    {
        $address_id = $this->input->get('address_id');
        $this->db->trans_start();
        $this->mall_address->update(array('uid'=>$this->uid, 'is_default'=>2), array('is_default'=>1));
        $this->mall_address->update(array('address_id'=>$address_id), array('is_default'=>2));
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            $this->success('Address/index', '', '设置成功！');
	    } else {
	        $this->error('Address/index', '', '设置失败！');
	    }
    }
    
    public function delete()
    {
        $address_id = $this->input->get('address_id');
        $res = $this->mall_address->delete($address_id);
        if ($res) {
            $this->success('Address/index', '', '删除成功！');
        } else {
            $this->error('Address/index', '', '删除失败！');
        }
    }
    
}
