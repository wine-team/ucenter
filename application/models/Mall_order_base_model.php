<?php
class Mall_order_base_model extends CI_Model
{
    private $table = 'mall_order_base';
    
    public function findById($where=array())
    {
    	return $this->db->get_where($this->table, $where);
    }
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    
    
    
}