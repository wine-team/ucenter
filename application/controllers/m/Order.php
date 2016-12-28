<?php
class Order extends MW_Controller {
    
    public function _init()
    {
        $this->load->helper('validation');
        $this->load->model('region_model', 'region');
    }
    
    /**
     * @订单列表
     */
    public function grid() {
    
        $this->load->view('m/order',$data=array());
    }
    
    /**
     * @订单详情
     */
    public function detail() {
    
        $this->load->view('m/detail',$data=array());
    }
	
}