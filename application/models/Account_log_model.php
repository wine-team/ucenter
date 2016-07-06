<?php
class Account_log_model extends CI_Model
{
    private $table = 'account_log';
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function getByAccountType($uid, $account_type)
    {
        $this->db->where('uid', $uid); 
        $this->db->where('account_type', $account_type);
    	return $this->db->get($this->table);
    }
}