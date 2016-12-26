<?php
class Coupon extends MW_Controller {
    
    public function _init()
    {
        $this->load->helper('validation');
        $this->load->model('region_model', 'region');
    }
    
    /**
	 * 优惠劵
	 */
	public function index() {
		
		$this->load->view('m/coupon',$data=array());
	}
	
}