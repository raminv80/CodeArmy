<?php
	function get_username($user_id) {
		
	}
	
	function get_rank($user_id){
		$CI = get_instance();
		$CI->load->model('stories_model','story');
		$CI->load->model('users_model','user');
		$query = $CI->user->get_user($user_id);
		$data = $query->result_array();
		return $CI->story->get_rank_badge($user_id)." <a href='/profile/show/".$user_id."'>".$data[0]['username']."</a>";
	}