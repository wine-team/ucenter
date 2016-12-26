<?php
class Enshrine extends MW_Controller {
    
    public function _init()
    {
        $this->load->helper('validation');
        $this->load->model('region_model', 'region');
    }
    
    /**
	 * 优惠劵
	 */
	public function index() {
		
		$this->load->view('m/enshrine',$data=array());
	}
	
}