<?php
class Mall_enshrine_model extends CI_Model
{
    private $table = 'mall_enshrine';
    private $table1 = 'mall_goods_base';
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function enshrineList($page, $perpage, $uid)
    {
        $this->db->select('mall_enshrine.id AS enshrine_id, mall_goods_base.*');
        $this->db->from($this->table);
        $this->db->join($this->table1, 'mall_enshrine.goods_id = mall_goods_base.goods_id', 'left');
        $this->db->where('uid', $uid);
        $this->db->limit($perpage, $perpage*$page);
        return $this->db->get();
    }
    
    public function delete($where)
    {
        $this->db->where($where);
        return $this->db->delete($this->table);
    }
    
}