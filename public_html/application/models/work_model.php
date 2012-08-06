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
	
	function get_work_skills($work_id){
		$sql = "SELECT * from work_skill, skill where work_skill.work_id = ? AND work_skill.skill_id = skill.id";
		$res = $this->db->query($sql, $work_id);
		return $res->result_array();
	}
	
	function get_file($file_id) {
		return $this->db->get_where('work_files', array('file_id' => $file_id));
	}
	
	function get_main_category(){
		$sql = "SELECT * FROM mission_category ORDER BY category_id";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	
	function get_main_class($cat=''){
		if($cat==''){
			$sql = "SELECT class.* FROM class ORDER BY class_id";
			$res = $this->db->query($sql);
		}else{
			$sql = "SELECT class.* FROM class  WHERE class.category_id=? ORDER BY class_id";
			$res = $this->db->query($sql,$cat);
		}
		return $res->result_array();
	}

	function get_sub_class($cat='',$class_id=''){
		if($cat=='' && $class_id==''){
			$sql = "SELECT * FROM subclass ORDER BY class_id";
			$res = $this->db->query($sql);
		}else{
			if($cat==''){
				$sql = "SELECT * FROM subclass WHERE class_id=? ORDER BY class_id";
				$res = $this->db->query($sql,$class_id);
			}else{
				$sql = "SELECT subclass.* FROM subclass,class WHERE class.class_id=subclass.class_id AND class.category_id=? ORDER BY class_id";
				$res = $this->db->query($sql,$cat);
			}
		}
		return $res->result_array();
	}
	
	function previewMission($work_id, $user_id){
		//$sql = "SELECT works.*, mission_category.category as catname, class.class_name as classname, subclass.subclass_name as subclassname FROM works, mission_category, class, subclass WHERE works.work_id = ? AND works.creator = ? AND works.subclass = subclass.subclass_id AND subclass.class_id = class.class_id AND class.category_id = mission_category.category_id";
		$sql = "SELECT works.*, mission_category.category as catname, class.class_name as classname, subclass.subclass_name as subclassname FROM works, mission_category, class, subclass WHERE works.work_id = ? AND works.creator = ? AND class.category_id = mission_category.category_id";
		$res = $this->db->query($sql, array($work_id, $user_id));
		return $res->result_array();
	}
	
	function store_skill_model($key){
		$sql = "SELECT * FROM skill WHERE ? LIKE concat('%', name, '%')";
		$res = $this->db->query($sql, $key);
		return $res->result_array();
	}
	
	function store_level_model($key){
		$sql = "SELECT * FROM skill_level WHERE ? LIKE concat('%', skill_level, '%')";
		$res = $this->db->query($sql, $key);
		return $res->result_array();
	}
	
	function previewSkills($work_id){
		$sql = "SELECT * FROM work_skill, skill, skill_level WHERE work_skill.work_id = ? AND work_skill.skill_id = skill.id AND work_skill.skill_level = skill_level.id";
		$res = $this->db->query($sql, $work_id);
		return $res->result_array();
	}
	
	function previewFiles($work_id){
		$sql = "SELECT * FROM work_files WHERE work_id = ?";
		$res = $this->db->query($sql, $work_id);
		return $res->result_array();
	}
}