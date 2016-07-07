<?php
class Mall_goods_related_model extends CI_Model
{
    private $table = 'mall_goods_related';
    
    public function getWhereIn($arr=array())
    {
        if (empty($arr)) return array();
        $this->db->where_in('goods_id', $arr);
        $this->db->limit(5);
        return $this->db->get($this->table)->result();
    }
    
}