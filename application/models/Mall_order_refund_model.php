<?php
class Mall_order_refund_model extends CI_Model
{
    private $table = 'mall_order_refund';
    
    public function findByOrderId($order_id)
    {
    	return $this->db->get_where($this->table, array('order_id'=>$order_id));
    }
    
    public function getWhere($where)
    {
        return $this->db->get_where($this->table, $where);
    }
    
    public function getWhereIn($arr=array())
    {
        if (empty($arr)) return array();
        $this->db->where_in('order_id', $arr);
        return $this->db->get($this->table)->result();
    }
    
    public function insertArray($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }
    
    
}