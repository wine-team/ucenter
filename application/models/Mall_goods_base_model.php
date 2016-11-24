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
    
    public function updateStock($goods_id, $in_stock)
    {
        $this->db->set("in_stock", "in_stock + {$in_stock}", false);
        $this->db->where(array('goods_id'=>$goods_id));
        return $this->db->update($this->table);
    }
    
}