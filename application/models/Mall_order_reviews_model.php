<?php
class Mall_order_reviews_model extends CI_Model
{
    private $table = 'mall_order_reviews';
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function getWhere($where=array())
    {
    	return $this->db->get_where($this->table, $where);
    }
}