<?php
class Mall_order_base_model extends CI_Model
{
    private $table = 'mall_order_base';
    
    public function findById($order_id)
    {
        return $this->db->get_where($this->table, array('order_id'=>$order_id));
    }
    
    public function findByStatus($payer_uid, $status='')
    {
        if ($status) $this->db->where('status', $status);
        $this->db->where('payer_uid', $payer_uid);
        return $this->db->get($this->table);
    }
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    
    
    
}