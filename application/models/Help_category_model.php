<?php
class Help_category_model extends CI_Model{
	
	private $table = 'help_category';        
	
	/**
	 * 
	 * @param unknown $param
	 */
	public function getResultByFlag($flag){
		
		$this->db->where('flag',$flag);
		 $this->db->order_by('sort','desc');
		return $this->db->get($this->table);
	}
}