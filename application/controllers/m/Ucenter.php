<?php
class Ucenter extends MW_Controller {
    
    public function _init()
    {
        $this->load->helper('validation');
        $this->load->model('region_model', 'region');
    }
    
    /**
	* @会员中心
	*/
	public function index() {
	    
		$this->load->view('m/ucenter',$data=array()); 
	}
    
	/**
	 * 修改密码
	 */
	public function password() {
	
	    $this->load->view('m/password',$data=array());
	}
	
	/**
	 * 个人资料
	 */
	public function setting() {
	
	    $this->load->view('m/setting',$data=array());
	}
	
	/**
	 * 个人资料
	 */
	public function profile() {
	
	    $this->load->view('m/profile',$data=array());
	}
    
	public function load_app() {
	   
	    $this->load->view('m/load_app');
	}
	
}