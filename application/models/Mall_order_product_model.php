<?php
class Mall_order_product_model extends CI_Model
{
    private $table = 'mall_order_product';
    
    public function findById($order_id)
    {
    	return $this->db->get_where($this->table, array('order_id'=>$order_id));
    }
    
    public function getWhereIn($arr=array())
    {
        if (empty($arr)) return array();
        $this->db->where_in('order_id', $arr);
        return $this->db->get($this->table)->result();
    }
    
    
    
    
}