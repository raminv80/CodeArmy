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
	
	function get_my_skills($user_id){
		$sql = "SELECT skill.id, point, name from skill_set, skill where skill_set.user_id = ? and skill_set.skill_id = skill.id";
		$res = $this->db->query($sql, array($user_id));
		if($res->num_rows()>0){
			$res = $res->result_array();
			return $res;
		}else{
			return false;
		}
	}
	
	function get_last_badge($user_id){
		$sql= "select achievements.* from achievements, achievement_set where achievements.achievement_id = achievement_set.achievement_id and user_id = ? order by achievement_set.id desc limit 0,1";
		$res = $this->db->query($sql, array($user_id));
		if($res->num_rows()>0){
			$data = $res->result_array();
			return $data[0];
		}else return false;
	}
	
	function get_my_badges($user_id){
		$sql= "select achievements.* from achievements, achievement_set where achievements.achievement_id = achievement_set.achievement_id and user_id = ? order by achievement_set.id";
		$res = $this->db->query($sql, array($user_id));
		if($res->num_rows()>0){
			return $res;
		}else return false;
	}
}