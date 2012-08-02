<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Work_model extends CI_Model { 
	
	function __construct() {
		parent::__construct();
	}
	
	function create_mission($exp){
		
	}
	
	function upload_mission_file(){
		$file_id = $this->_gen_id();
		$check_file_id = $this->get_file($file_id);
		while($check_file_id->num_rows() > 1) {
			$file_id = $this->_gen_id();
			$check_file_id = $this->get_file($file_id);			
		}
		
		// file storing
		
		// end of file storing
		
		$res = array(
			"file_id" => $file_id,
			"file_type" => $file_type,
			"file_name" => $file_name,
			"file_title" => $file_title,
			"file_description" => $file_description,
			"created_at" => date('Y-m-d H:i:s')
		);
		if($this->db->insert('work_files', $res)) {
			return $file_id;
		} else {
			return false;
		}
	}
	
	function _gen_id() {
		$work_id = '';
		list($usec, $sec) = explode(' ', microtime());
		$rand_seed = (float)$sec + ((float)$usec * 100000);
		mt_srand($rand_seed);
		for ($r = 0; $r<13; $r++) { $work_id .= mt_rand(0,9); }
		return $work_id;
	}

	function get_work($work_id) {
		return $this->db->get_where('works', array('work_id' => $work_id));
	}
	
	function get_file($file_id) {
		return $this->db->get_where('work_files', array('file_id' => $file_id));
	}
	
	function get_main_category(){
		$sql = "SELECT * FROM mission_category ORDER BY category_id";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	
	function get_sub_category(){
		$sql = "SELECT * FROM class ORDER BY class_id";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
}