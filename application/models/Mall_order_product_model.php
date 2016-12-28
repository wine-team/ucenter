<?php
class Mall_order_product_model extends CI_Model
{
    private $table = 'mall_order_product';
    
    public function findByOrderId($order_id)
    {
    	return $this->db->get_where($this->table, array('order_id'=>$order_id));
    }
    
    public function getWhere($where)
    {
        return $this->db->get_where($this->table, $where);
    }
    
    public function getWhereIn($arr=array())
    {
        if (empty($arr)) return array();
        $this->db->where_in('order_id', $arr);
        return $this->db->get($this->table)->result();
    }
    
    public function update_at($order_id)
    {
        $this->db->where('order_id', $order_id);
        return $this->db->update($this->table, array('updated_at'=>date('Y-m-d H:i:s')));
    }
    
    /**
     * 更新数据
     */
    public function update($param=array(),$orderProductId) {
    	 
    	if (isset($param['refund_num'])) {
    		$data['refund_num'] = $param['refund_num'];
    	}
    	$data['updated_at'] = date('Y-m-d H:i:s');
    	$this->db->where('order_product_id',$orderProductId);
    	return $this->db->update($this->table,$data);
    }
    
}