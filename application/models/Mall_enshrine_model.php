<?php
class Mall_enshrine_model extends CI_Model
{
    private $table = 'mall_enshrine';
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function enshrineList($page, $perpage, $uid)
    {
        $this->db->where('uid', $uid);
        $this->db->limit($perpage, $perpage*$page);
        return $this->db->get($this->table);
    }
    
    public function delete($where)
    {
        $this->db->where($where);
        return $this->db->delete($this->table);
    }
    
}