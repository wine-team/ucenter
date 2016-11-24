<?php
class User_coupon_get_model extends CI_Model
{
    private $table = 'user_coupon_get';
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function findByStatus($uid, $status='')
    {
        if ($status) {
            if ($status == 1) {
                $where['status'] = 1;
                $where['end_time >'] = date('Y-m-d H:i:s');
            }
            if ($status == 2) {
                $where['status'] = 2;
            }
            if ($status == 3) {
                $where['end_time <'] = date('Y-m-d H:i:s');
            }
            $this->db->where($where);
        }
        $this->db->where('uid', $uid);
    	return $this->db->get($this->table);
    }
    
    public function updateStatus($coupon_id)
    {
        $this->db->where('coupon_get_id', $coupon_id);
        return $this->db->update($this->table, array('status'=>1));
    }
    
    
}