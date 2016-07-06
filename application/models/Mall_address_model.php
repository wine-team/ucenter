<?php
class Mall_address_model extends CI_Model
{
    private $table = 'mall_address';
    
    public function _init()
    {
        $this->load->model('region_model', 'region');
    }
    
    public function total($where)
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function findById($address_id)
    {
    	return $this->db->get_where($this->table, array('address_id'=>$address_id));
    }
    
    public function findByUid($uid)
    {
        return $this->db->get_where($this->table, array('uid'=>$uid));
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
            'code'          => $param['code'],
            'province_id'   => $param['province_id'],
            'city_id'       => $param['city_id'],
            'district_id'   => $param['district_id'],
            'is_default'    => isset($param['is_default']) ? $param['is_default'] : 1,
        );
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
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
            'code'          => $param['code'],
            'province_id'   => $param['province_id'],
            'city_id'       => $param['city_id'],
            'district_id'   => $param['district_id'],
            'is_default'    => isset($param['is_default']) ? $param['is_default'] : 1,
        );
        return $this->db->update($this->table, $data, array('address_id'=>$address_id));
    }
    
    public function setNotDefault($uid)
    {
        return $this->db->update($this->table, array('is_default'=>1), array('uid'=>$uid, 'is_default'=>2));
    }
    
    public function setDefault($address_id)
    {
        return $this->db->update($this->table, array('is_default'=>2), array('address_id'=>$address_id));
    }
    
    public function delete($address_id) {
        $this->db->where('address_id', $address_id);
        return $this->db->delete($this->table);
    }
}