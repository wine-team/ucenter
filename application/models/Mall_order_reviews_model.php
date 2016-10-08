<?php
class Mall_order_reviews_model extends CI_Model
{
    private $table = 'mall_order_reviews';
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function getByUid($uid)
    {
    	return $this->db->get_where($this->table, array('uid'=>$uid));
    }
    
    public function getByOrderid($orderid)
    {
        return $this->db->get_where($this->table, array('order_id'=>$orderid));
    }
    
    public function insertArray($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }
    
}