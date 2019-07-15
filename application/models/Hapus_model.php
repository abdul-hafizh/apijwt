<?php

class Hapus_model extends CI_Model{	
 
	function kategori($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

	function manga($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

	function chapter($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

	function detail($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
}

?>