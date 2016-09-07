<?php
class Deliver_order_model extends CI_Model
{
    private $table = 'deliver_order';

    public function findByOrderId($order_id)
    {
        $this->db->where('order_id', $order_id);
        return $this->db->get($this->table);
    }
    
    
}