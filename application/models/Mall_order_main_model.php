<?php
class Mall_order_main_model extends CI_Model
{
    private $table   = 'mall_order_main';
    private $table1  = 'mall_order_base';
    
    public function orderMainList($page, $perpage, $payer_uid, $status='')
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->where('payer_uid', $payer_uid);
        $this->db->limit($perpage, $perpage*$page);
        $this->db->order_by('order_id DESC');
        return $this->db->get($this->table);
    }
    
     /**
     * 获取总订单信息
     * @param unknown $param
     */
    public function findOrderMainByRes($param=array()) {
    	
    	 $this->db->select('*');
    	 $this->db->from($this->table);
    	 if (!empty($param['uid'])){
    	 	$this->db->where('uid',$param['uid']);
    	 }
    	 if (!empty($param['order_main_sn'])){
    	 	$this->db->where('order_main_sn',$param['order_main_sn']);
    	 }
    	 return $this->db->get();
    }
}