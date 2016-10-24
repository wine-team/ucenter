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
    	$this->db->where('address_id',$address_id);
    	$this->db->where('uid',$this->uid);
    	return $this->db->get($this->table);
    }
    
    public function findByUid($uid)
    {
    	$this->db->where('uid',$uid);
    	$this->db->order_by('is_default','desc');
    	$this->db->order_by('address_id','desc');
        return $this->db->get($this->table);
    }
    
    public function insert($param)
    {
        $region = $this->region->getWhereIn(array($param['province_id'], $param['city_id'], $param['district_id']))->result();
        $data = array(
            'province_name' => $region[0]->region_name,
            'city_name'     => $region[1]->region_name,
            'district_name' => $region[2]->region_name,
            'uid'           => $this->uid,
            'receiver_name' => $param['receiver_name'],
            'detailed'      => $param['detailed'],
            'tel'           => $param['tel'],
            'code'          => (int)$param['code'],
            'province_id'   => (int)$param['province_id'],
            'city_id'       => (int)$param['city_id'],
            'district_id'   => (int)$param['district_id'],
            'is_default'    => isset($param['is_default']) ? $param['is_default'] : 1,
        );
        return $this->db->insert($this->table, $data);
    }
    
    public function update($address_id, $param) 
    {
        $region = $this->region->getWhereIn(array($param['province_id'], $param['city_id'], $param['district_id']))->result();
        $data = array(
            'province_name' => $region[0]->region_name,
            'city_name'     => $region[1]->region_name,
            'district_name' => $region[2]->region_name,
            'uid'           => $this->uid,
            'receiver_name' => $param['receiver_name'],
            'detailed'      => $param['detailed'],
            'tel'           => $param['tel'],
            'code'          => (int)$param['code'],
            'province_id'   => (int)$param['province_id'],
            'city_id'       => (int)$param['city_id'],
            'district_id'   => (int)$param['district_id'],
            'is_default'    => isset($param['is_default']) ? $param['is_default'] : 1,
        );
        $this->db->where('address_id',$address_id);
        return $this->db->update($this->table, $data);
    }
    
     /**
     * 让默认地址变为不默认
     * @param unknown $uid
     */
    public function setNotDefault($uid)
    {
        $data = array(
        	'is_default' => 1
        );
        $this->db->where('uid',$uid);
        $this->db->where('is_default',2);
    	return $this->db->update($this->table,$data);
    }
    
    public function setDefault($address_id) {
    	
    	$data['is_default'] = 2;
    	$this->db->where('address_id',$address_id);
    	$this->db->where('uid',$this->uid);
        return $this->db->update($this->table,$data);
    }
    
    public function delete($address_id) {
    	
        $this->db->where('address_id', $address_id);
        $this->db->where('uid',$this->uid);
        return $this->db->delete($this->table);
    }
}