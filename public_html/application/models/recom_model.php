<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recom_model extends CI_Model { 
	
	var $data = '';
	
	function __construct() {
		parent::__construct();
	}
	
	function get_tallents($work_id){
		$work_skills = $this->get_work_skills($work_id);
		$users = $this->getTallentedUsers($work_skills);
		$res = array();
		foreach($users as $user){
			$i = count($res);
			$res[$i]=$user;
			$user_skills = $this->get_user_skills($user['user_id']);
			$sum=0;
			foreach($work_skills as $ws):
				foreach($user_skills as $us):
					if($us['skill_id']==$ws['skill_id']){
						$sum +=	30-abs($ws['point']-$us['point']);
					}
				endforeach;
			endforeach;
			$match = $sum / (count($work_skills)*30) * 100;
			$res[$i]['match'] = $match;
		}
		$this->array_sort_by_column($res, 'match', SORT_DESC);
		return $res;
	}
	
	private function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
	
		array_multisort($sort_col, $dir, $arr);
	}
	
	function getTallentedUsers($work_skills){
		$skl = "";
		foreach($work_skills as $skill)$skl[]="'".$skill['id']."'";
		$skl = implode(',',$skl);
		$sql = "SELECT users.user_id, count(1) AS num_skill from users, skill_set WHERE skill_set.skill_id IN ($skl) AND users.user_id = skill_set.user_id group by users.user_id having num_skill > 0 ORDER BY num_skill DESC limit 0,60";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	
	function get_work_skills($work_id){
		$sql = "SELECT * from work_skill, skill where work_skill.work_id = ? AND work_skill.skill_id = skill.id";
		$res = $this->db->query($sql, $work_id);
		return $res->result_array();
	}
	
	function get_user_skills($user_id){
		$sql = "SELECT * from skill_set WHERE user_id=?";
		$res = $this->db->query($sql, $user_id);
		return $res->result_array();
	}
}
?>