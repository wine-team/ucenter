<?php
class User_model extends CI_Model
{
    private $table = 'user';
    
    public function findById($uid)
    {
    	return $this->db->get_where($this->table, array('uid'=>$uid));
    }
    
    public function updatePhoto($uid, $photo)
    {
        $this->db->where(array('uid'=>$uid));
        return $this->db->update($this->table, array('photo'=>$photo));
    }
    
    public function update($uid, $param)
    {
        $data = array(
            'alias_name' => $param['alias_name'],
            'birthday'   => $param['birthday'],
            'sex'        => $param['sex'],
            'email'      => $param['email'],
            'phone'      => $param['phone']
        );
        $this->db->where(array('uid'=>$uid));
        return $this->db->update($this->table, $data);
    }
    
    public function updatePwd($uid, $pwd)
    {
        $this->db->where(array('uid'=>$uid));
        return $this->db->update($this->table, array('password'=>sha1(base64_encode(trim($pwd)))));
    }
    
    
}