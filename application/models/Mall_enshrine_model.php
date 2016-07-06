<?php
class Mall_enshrine_model extends CI_Model
{
    private $table = 'mall_enshrine';
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function getByUid($uid)
    {
    	return $this->db->get_where($this->table, array('uid'=>$uid));
    }
    
    public function delete($where)
    {
        $this->db->where($where);
        return $this->db->delete($this->table);
    }
    
}