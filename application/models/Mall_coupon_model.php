<?php
class Mall_coupon_model extends CI_Model
{
    private $table = 'mall_coupon';
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function findById($where=array())
    {
    	return $this->db->get_where($this->table, $where);
    }
}