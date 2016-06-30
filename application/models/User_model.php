<?php
class User_model extends CI_Model
{
    private $table = 'user';
    
    public function findById($uid)
    {
    	return $this->db->get_where($this->table, array('uid'=>$uid));
    }
    
    public function update($where=array(), $data=array())
    {
        $this->db->where($where);
        return $this->db->update($this->table, $data);
    }
    
    
}