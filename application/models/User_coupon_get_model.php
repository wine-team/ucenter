<?php
class User_coupon_get_model extends CI_Model
{
    private $table = 'user_coupon_get';
    
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