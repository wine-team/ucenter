<?php
class Mall_goods_base_model extends CI_Model
{
    private $table = 'mall_goods_base';
    
    public function getWhereIn($arr=array())
    {
        if (empty($arr)) {
        	return array();
        } 
        $this->db->where_in('goods_id', $arr);
        return $this->db->get($this->table);
    }
    
}