<?php
class Mall_enshrine_model extends CI_Model
{
    private $table = 'mall_enshrine';
    private $table1 = 'mall_goods_base';
    
    public function total($where=array())
    {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
    
    public function enshrineList($page, $perpage, $uid)
    {
        $this->db->select('mall_enshrine.id AS enshrine_id, mall_goods_base.goods_id,mall_goods_base.goods_name,mall_goods_base.market_price,mall_goods_base.promote_price,mall_goods_base.goods_img');
        $this->db->from($this->table);
        $this->db->join($this->table1, 'mall_enshrine.goods_id = mall_goods_base.goods_id','inner');
        $this->db->where('uid', $uid);
        $this->db->limit($perpage, $perpage*$page);
        return $this->db->get();
    }
    
     /**
     * 删除收藏
     * @param unknown $param
     */
    public function delete($param=array())
    {
        $this->db->where($param);
        return $this->db->delete($this->table);
    }
    
}