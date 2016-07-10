<?php
class Mall_brand_model extends CI_Model{
	
	private $table = 'mall_brand';
	
	/**
	 * 
	 * @param unknown $limit
	 */
	public function findBrand($limit){
		
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('sort_order','asc');
		$this->db->limit($limit);
		return $this->db->get();
	}
}