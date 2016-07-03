<?php
class Mall_address_model extends CI_Model
{
    private $table = 'mall_address';
    
    public function total($where)
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function findById($address_id)
    {
    	return $this->db->get_where($this->table, array('address_id'=>$address_id));
    }
    
    public function getWhere($where=array())
    {
        return $this->db->get_where($this->table, $where);
    }
    
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($where=array(), $data=array()) 
    {
        return $this->db->update($this->table, $data, $where);
    }
    
    public function delete($address_id) {
        $this->db->where('address_id', $address_id);
        return $this->db->delete($this->table);
    }
}