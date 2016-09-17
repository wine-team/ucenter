<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ucenter extends CS_Controller {

    public function _init()
    {
        $this->load->model('cms_block_model', 'cms_block');
        $this->load->model('user_model', 'user');
        $this->load->model('mall_order_reviews_model', 'mall_order_reviews');
        $this->load->model('account_log_model', 'account_log');
        $this->load->model('mall_order_base_model', 'mall_order_base');
        $this->load->model('mall_enshrine_model', 'mall_enshrine');
        $this->load->model('user_coupon_get_model', 'user_coupon_get');
    }
    
    public function user_reviews()
    {
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['user_reviews'] = $this->mall_order_reviews->getByUid($this->uid)->result();
        $data['reviews_status'] = array('1'=>'待审核', '2'=>'通过', '3'=>'未通过审核');
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/user_reviews', $data);
    }
    
     /**
     *商户的用户信息
     */
    public function user_info()
    {
        $data['head_menu'] = 'on';
        $data['user_info'] = $this->get_user_info();
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/user_info', $data);
    }
    
     /**
     *更改图片
     */
    public function edit_photo()
    {
    	$postData = $this->input->post();
    	$frontUserInfo = $this->get_user_info();
    	$old_photo = in_array($frontUserInfo->photo, user_photo()) ? '' : $frontUserInfo->photo;
        if (!empty($_FILES['photo']['name'])) {
        	$imageData = $this->dealWithImages('photo', $old_photo,'common/touxiang');
        }
        $photo = isset($imageData['file_name']) ? $imageData['file_name'] : $postData['user_photo'];
        $res = $this->user->updatePhoto($this->uid, $photo);
        $this->redirect('ucenter/user_info');
    }
    
    public function edit_user_info()
    {
        $postData = $this->input->post();
        if (mb_strlen($postData['alias_name']) < 2){
        	$this->jsonMessage('用户名不得少于2个字！');
        }
        if (empty($postData['birthday'])){
        	$this->jsonMessage('生日不能为空！');
        }
        if (!validEmail($postData['email'])){
        	$this->jsonMessage('请填写正确的邮箱！');
        }
        if (!validateMobilePhone($postData['phone'])){
        	$this->jsonMessage('请填写正确的手机号码！');
        }
        $res = $this->user->update($this->uid, $postData);
        if ($res) {
            $this->jsonMessage('', site_url('ucenter/user_info'));
        } 
        $this->jsonMessage('修改失败！');
    }
    
    public function edit_ok()
    {
        $data['head_menu'] = 'on';
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/edit_ok', $data);
    }
    
    public function reset_password()
    {
        if ($this->input->post('old_password') == $this->input->post('new_password')) {
            $this->jsonMessage('新密码与原密码相同');
        } 
        $pass = $this->user->findById($this->uid)->row()->password;
        if ($pass == sha1(base64_encode($this->input->post('old_password')))) {
           $res = $this->user->updatePwd($this->uid, $this->input->post('new_password'));
           if ($res) {
              $this->jsonMessage('', $this->config->passport_url.'login/logout');
           } 
           $this->jsonMessage('修改失败');
        } 
        $this->jsonMessage('原密码错误');
    }
    
    public function pay_points()
    {
        $data['head_menu'] = 'on';
        $data['points_num'] = $this->account_log->total(array('uid'=>$this->uid, 'account_type'=>2));
        $data['points_list'] = $this->account_log->getByAccountType($this->uid, 2);
        $data['user_info'] = $this->get_user_info();
        $data['cms_block'] = $this->cms_block->findByBlockIds(array('home_keyword'));
        $this->load->view('order/pay_points', $data);
    }
    
    
}
