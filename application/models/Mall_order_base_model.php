<?php
class Mall_order_base_model extends CI_Model
{
    private $table = 'mall_order_base';
    
    public function findById($order_id)
    {
        return $this->db->get_where($this->table, array('order_id'=>$order_id));
    }
    
    public function mallOrderList($page, $perpage, $payer_uid, $order_status='')
    {
        if ($order_status) {
        	$this->db->where('order_status', $order_status);
        }
        $this->db->where('payer_uid', $payer_uid);
        $this->db->limit($perpage, $perpage*$page);
        $this->db->order_by('order_id DESC');
        return $this->db->get($this->table);
    }
    
    public function total($payer_uid, $order_status='')
    {
        if ($order_status) {
        	$this->db->where('order_status', $order_status);
        }
        $this->db->where('payer_uid', $payer_uid);
        return $this->db->count_all_results($this->table);
    }
    
    public function updateOrderStatus($order_id, $state=0, $status=0)
    {
        if ($state) {
        	$data['order_state'] = $state;
        } 
        if ($status) {
        	$data['order_status'] = $status;
        } 
        $data['updated_at'] = date('Y-m-d H:i:s'); 
        return $this->db->update($this->table, $data, array('order_id'=>$order_id));
    }
    
    
    
}