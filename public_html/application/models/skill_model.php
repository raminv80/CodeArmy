<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skill_model extends CI_Model { 
	
	var $data = '';
	
	function __construct() {
		parent::__construct();
	}
	
	function get_all_skills() {
		$query = "SELECT * FROM skill order by name";
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function get_work_skills($work_id){
		$query = "select * from work_skill, skill where skill.id = work_skill.skill_id and work_id = ?";
		$result = $this->db->query($query, array($work_id));
		return $result->result_array();	
	}
	
	function get_all_skills_with_select($work_id){
		$query = "SELECT name, skill.id, work_skill.point FROM skill left join work_skill on (work_id = ? and skill_id = skill.id) order by name";
		$result = $this->db->query($query, array($work_id));
		return $result->result_array();
	}
}