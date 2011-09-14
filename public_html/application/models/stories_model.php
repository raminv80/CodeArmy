<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stories_model extends CI_Model { 
	
	var $data = '';
	
	function __construct() {
		parent::__construct();
	}
	
	// - create new stories
	function create_user_story($creator_id) {
		if($this->input->post('category')){
			if($this->input->post('category')==0){
				//if item 0 is selected then category is general
				$category = NULL;
			}else{
				$category = $this->input->post('category');	
			}
		}else{
			if($this->input->post('new_category')!=''){
				$query = "select * from categories where name = ?";
				$data = $this->db->query($query, array($this->input->post('new_category')));
				if($data->num_rows()>0){
					//if new category is not really new and we have it in database don't add it
					$data = $data->result_array();
					$data = $data[0];
					$category = $data['id'];
				}else{
					//if its a new category add it to database
					$data = array(
						'name' => $this->input->post('new_category'),
						'project_id' => $this->input->post('project')
					);
					$this->db->insert('categories', $data);
					$query = "select max(id) as new_id from categories";
					$data = $this->db->query($query, array());
					$data = $data->result_array();
					$category = $data[0]['new_id'];
				}
			}else{
				$category = NULL;
			}
		}		
		
		// make random id for work_id
		$work_id = $this->_gen_id();
		$check_work_id = $this->get_work($work_id);
		while($check_work_id->num_rows() > 1) {
			$work_id = $this->_gen_id();
			$check_work_id = $this->get_work($work_id);			
		}
		
		$doc = array(
			"work_id" => $work_id,
			"title" => $this->input->post('title'),
			"type" => $this->input->post('type'),
			"category" => $category,
			"description" => $this->input->post('description'),
			"points" => $this->input->post('points'),
			"cost" => $this->input->post('cost'),
			"status" => 'open',
			"creator" => $creator_id,
			"owner" => $creator_id,
			"project_id" => $this->input->post('project'), // temporary...
			"created_at" => date('Y-m-d H:i:s'),
			"tutorial" => $this->input->post('tutorial'),
			"deadline" => $this->input->post('deadline_year').'-'.$this->input->post('deadline_month').'-'.$this->input->post('deadline_day'),
			"bid_deadline" => $this->input->post('biddead_year').'-'.$this->input->post('biddead_month').'-'.$this->input->post('biddead_day')
		); 
		
		if($this->db->insert('works', $doc)) {
			$query = "SELECT * FROM skill order by name";
			$result = $this->db->query($query);
			$skills = $result->result_array();
			foreach($skills as $skill):
				if($this->input->post('skill_id_'.$skill['id'])>1){
					$skill_data = array(
						"work_id" => $doc['work_id'],
						"skill_id" => $skill['id'],
						"point" => $this->input->post('skill_id_'.$skill['id'])
					);	
					$this->db->insert('work_skill',$skill_data);
				}
			endforeach;
			return $doc['work_id'];		
		} else {
			return false;
		}
		
	}
	
	function edit_user_story($id) {
		if($this->input->post('category')){
			if($this->input->post('category')==0){
				//if item 0 is selected then category is general
				$category = NULL;
			}else{
				$category = $this->input->post('category');	
			}
		}else{
			if($this->input->post('new_category')!=''){
				$query = "select * from categores where name = ?";
				$data = $this->db->query($query, array($this->input->post('new_category')));
				if($data->num_rows()>0){
					//if new category is not really new and we have it in database don't add it
					$data = $data->result_array();
					$data = $data[0];
					$category = $data['id'];
				}else{
					//if its a new category add it to database
					$data = array(
						'name' => $this->input->post('name'),
						'project_id' => $this->input->post('project')
					);
					$this->db->insert('categories', $data);
					$query = "select max(id) as new_id from categories";
					$data = $this->db->query($query, array());
					$data = $data->result_array();
					$category = $data[0]['new_id'];
				}
			}else{
				$category = NULL;
			}
		}	

		$doc = array(
			"title" => $this->input->post('title'),
			"type" => $this->input->post('type'),
			"category" => $category,
			"description" => $this->input->post('description'),
			"points" => $this->input->post('points'),
			"cost" => $this->input->post('cost'),
			"project_id" => $this->input->post('project_id'), 
			"tutorial" => $this->input->post('tutorial'),
			"deadline" => $this->input->post('deadline_year').'-'.$this->input->post('deadline_month').'-'.$this->input->post('deadline_day'),
			"bid_deadline" => $this->input->post('biddead_year').'-'.$this->input->post('biddead_month').'-'.$this->input->post('biddead_day')
		); 
		
		if($this->db->update('works', $doc, array('work_id' => $id))) {
			$query = "SELECT * FROM skill order by name";
			$result = $this->db->query($query);
			$skills = $result->result_array();
			foreach($skills as $skill):
				if($this->input->post('skill_id_'.$skill['id'])>1){
					$del_query = "delete from work_skill where work_id=? and skill_id = ?";
					$this->db->query($del_query, array($id, $skill['id']));
					$skill_data = array(
						"work_id" => $id,
						"skill_id" => $skill['id'],
						"point" => $this->input->post('skill_id_'.$skill['id'])
					);
					$this->db->insert('work_skill',$skill_data);
				}
			endforeach;
			return $id;		
		} else {
			return false;
		}
		
	}
	
	// - get stories
	function get_work($work_id) {
		return $this->db->get_where('works', array('work_id' => $work_id));
	}
	
	// - get work details
	function get_work_details($work_id) {
		$sql = "SELECT *,T.project_id as project_id, (CASE T.category WHEN NULL THEN 'General' ELSE categories.name END) as category_name FROM (SELECT work_id, priority, title, type, category, description, points, cost, status, creator, owner, works.project_id as project_id, works.created_at as created_at, work_horse, bid_deadline, deadline, assigned_at, done_at, tutorial, user_id, username, role, email, project_name FROM works, users, project WHERE works.work_id = ? AND users.user_id = works.creator AND works.project_id = project.project_id) as T LEFT JOIN categories on T.category = categories.id";
		$result = $this->db->query($sql, array($work_id));
		return $result;
	}
	
	// - get work list
	function get_works_list($status='', $project_sel = NULL, $skill_sel = NULL, $cash_sel = NULL) {
                if($status == '') {
		$sql = "SELECT * FROM works, users WHERE users.user_id = works.creator ORDER BY works.priority DESC";
        $result = $this->db->query($sql);   
                }elseif($status=='In progress'){
		$sql = "SELECT * FROM works, users WHERE users.user_id = works.creator AND works.status in ('In progress','Redo') ORDER BY works.priority DESC";
		$result = $this->db->query($sql);
                }elseif($status=='Done'){
		$sql = "SELECT * FROM works, users WHERE users.user_id = works.creator AND works.status in ('Done','Verify') ORDER BY works.priority DESC";
		$result = $this->db->query($sql);
                }elseif($status=='Open'){
		$sql = "SELECT work_id, priority, title, type, description, points, cost, status, creator, owner, project_id, work_horse, user_id, username, email, (select count(user_id) from bids where bids.work_id = works.work_id) as total_bids, (select count(user_id) from bids where work_id = works.work_id and created_at>= ? ) as last_week_bids, (select count(comment_body) from comments where story_id = works.work_id) as total_comments, (select count(comment_body) from comments where story_id = works.work_id and comment_created>= ? ) as last_week_comments
 FROM works, users WHERE users.user_id = works.creator AND works.status in ('open','Open', 'Reject') ORDER BY works.priority DESC, works.work_id ASC";
 		$last_week = date("Y-m-d H:i:s", strtotime("-1 weeks"));
		$result = $this->db->query($sql, array($last_week, $last_week));
                }else {
		$sql = "SELECT * FROM works, users WHERE users.user_id = works.creator AND works.status = ? ORDER BY works.priority DESC";
		$result = $this->db->query($sql, $status); 
                }
		return $result;
	}
	
	// - store uploaded file data
	function store_uploaded_file($file_data) {
		$doc = array(
			"file_id" => md5(microtime()),
			"file_type" => $file_data['file_type'],
			"file_name" => $file_data['file_name'],
			"file_title" => $file_data['file_title'],
			"file_description" => $file_data['file_description'],
			"created_at" => date('Y-m-d H:i:s'),
			"work_id" => $file_data['work_id']
		);
		
		return $this->db->insert('work_files', $doc);
	}
	
	
	// - get uploaded files
	function get_uploaded_files($work_id) {
		$sql = "SELECT * FROM work_files WHERE work_id = ? ORDER BY created_at DESC";
		$result = $this->db->query($sql, array($work_id));
		return $result;
	}
	
	// - get uploaded file detail
	function get_uploaded_file($file_id) {
		return $this->db->get_where('work_files', array('file_id' => $file_id));
	}
	
	// - delete uploaded files
	function delete_uploaded_file() {
		
	}
	
	//-----------------------------------------------------------------------//
	// generate work id
	function _gen_id() {
		$work_id = '';
		list($usec, $sec) = explode(' ', microtime());
		$rand_seed = (float)$sec + ((float)$usec * 100000);
		mt_srand($rand_seed);
		for ($r = 0; $r<6; $r++) { $work_id .= mt_rand(0,9); }
		return $work_id;
	}
	
	//function get projects
	function get_project_name($pid) {
		$query = "SELECT project_name, project_id FROM project WHERE project_id = ?";
		$result = $this->db->query($query, array($pid));
		return $result;
	}
	
	// function delete work
	function delete_confirm($id) {
		$query = "DELETE FROM works WHERE work_id = ?";
		$result = $this->db->query($query, array($id));
		return $result;
	}
	
	//check owner
	function check_owner($pro_id, $user_id) {
		$query = "SELECT * FROM project WHERE project_id = ? AND project_owner_id = ?";
		$result = $this->db->query($query, array($pro_id, $user_id));
		return $result;
	}
	
	//check admin
	function check_admin($story_id, $user_id) {
		$query = "SELECT * FROM works WHERE work_id = ? AND creator = ?";
		$result = $this->db->query($query, array($story_id, $user_id));
		return $result;
	}
	
	function get_comments($pro_id) {
		$query = "SELECT * FROM comments WHERE story_id = ? ORDER BY comment_created DESC";
		$result = $this->db->query($query, array($pro_id));
		return $result;
	}
	
	function create_comment() {
		$doc = array(
			'story_id' => $this->input->post('story_id'),
			'username' => $this->input->post('user_id'),
			'comment_body' => $this->input->post('comments')
		);
		return $this->db->insert('comments', $doc);
	}
	
	function make_bid() {
		$datetime = date('Y-m-d H:i:s');
		$doc = array(
			'work_id' => $this->input->post('work_id'),
			'user_id' => $this->input->post('user_id'),
			'bid_cost' => $this->input->post('set_cost'),
                        'days' => $this->input->post('set_days'),
			'created_at' => $datetime,
			'bid_status' => 'Bid'
		);
		return $this->db->insert('bids', $doc);
	}
	
	function get_bids($work_id) {
		$query = "SELECT a.*, b.user_id, b.username, works.status as work_status FROM bids a, users b, works WHERE a.work_id = ? AND a.user_id = b.user_id AND works.work_id=a.work_id ORDER BY bid_cost ASC, days ASC, bid_status ASC";
		$result = $this->db->query($query, array($work_id));
		return $result;
	}
	
	function get_bid($bid_id){
		$query = "SELECT * FROM bids where bid_id = ? ORDER BY bid_cost DESC";
		$result = $this->db->query($query, array($bid_id));
		return $result;	
	}
        
        function get_work_from_bid($id) {
            $query = "SELECT work_id FROM bids WHERE bid_id = ?";
            $result = $this->db->query($query, array($id));
	    return $result;
            
        }
        
        function accept_bid($id , $work_id) {
            $query = "UPDATE bids SET bid_status = 'Accepted' WHERE bid_id = ?";
			$user_query = "SELECT user_id from bids where bid_id = ?";
            $query2 = "UPDATE works SET status = 'In Progress', work_horse = ? WHERE work_id = ?";
            $result = $this->db->query($query, array($id));
			$user_data = $this->db->query($user_query,array($id));
			$user = $user_data->result_array();
			$user_id = $user[0]['user_id'];
            $result2 = $this->db->query($query2, array($user_id,$work_id));
	    return $result;
        }
		
		function get_my_works($user_id, $status){
			if($status == 'In progress'){
			$query = "SELECT * FROM bids, works where bids.work_id = works.work_id and bids.user_id = ?  and bids.bid_status = 'Accepted' and works.status in ('In progress', 'Redo')";
			$result = $this->db->query($query, array($user_id));
			}elseif($status=='Done'){
			$query = "SELECT * FROM bids, works where bids.work_id = works.work_id and bids.user_id = ?  and bids.bid_status = 'Accepted' and works.status in ('Done','Verify')";
			$result = $this->db->query($query, array($user_id));
			}else{
			$query = "SELECT * FROM bids, works where bids.work_id = works.work_id and bids.user_id = ? and bids.bid_status = 'Accepted' and works.status = ?";
			$result = $this->db->query($query, array($user_id,$status));
			}
			
			return $result;
		}
		
		function done($id){
			$query = "update works set status = 'Done', done_at='".date('Y-m-d H:i:s')."' where work_id = ?";
			$result = $this->db->query($query, array($id));
			return $result;
		}
		
		function redo($id){
			$query = "update works set status = 'Redo' where work_id = ?";
			$result = $this->db->query($query, array($id));
			return $result;
		}
		
		function verify($id){
			$query = "update works set status = 'Verify' where work_id = ?";
			$result = $this->db->query($query, array($id));
			return $result;
		}
		
		function signoff($id){
			$query = "update works set status = 'Signoff' where work_id = ?";
			$result = $this->db->query($query, array($id));
			return $result;
		}
		
		function reject($id){
			$query = "update works set status = 'Reject', done_at = NULL, assigned_at = NULL, work_horse = NULL where work_id = ?";
			$result = $this->db->query($query, array($id));
			$query = "delete from bids where work_id = ?";
			$result = $this->db->query($query, array($id));		
			return $result;
		}
		
		function get_user_email($work_id){
			$query = "select users.user_id, email,username from works, users where works.work_horse = users.user_id and works.work_id = ?";
			$result = $this->db->query($query, array($work_id));
			return $result;			
		}
		
	function log_history($user_id, $project_id, $work_id, $event, $status=0, $desc = ''){
		/*
			bid, cost
			win, cost
			done, point
			redo, point
			verify, point
			signoff, point
			reject, point
		*/
		$log = array(
			"user_id" => $user_id,
			"work_id" => $work_id,
			"event" => $event,
			"status" => $status,
			"project_id" => $project_id,
			"Desc" => $desc,
			"created_at" => date('Y-m-d H:i:s')
		); 
		
		$work = $this->get_work($work_id);
		$work = $work->result_array();
		$work = $work[0];
		 
		switch($event){
			case 'done': $exp = 1;
			break;
			case 'redo': $exp = -1;
			break;
			case 'verify': $exp = 2;
			break;
			case 'signoff': $exp = 3;
				if($work['deadline']!=NULL){
				$query = "update users set 	early_done = early_done + hour(timediff('".$work['deadline']."','".$work['done_at']."')), hour_spent = hour_spent + hour(timediff('".$work['done_at']."','".$work['assigned_at']."')) where user_id = ?";
				}else{
					$query = "update users set hour_spent = hour_spent + hour(timediff('".$work['done_at']."','".$work['assigned_at']."')) where user_id = ?";
				}
				$this->db->query($query,array($user_id));
			break;
			case 'reject': $exp = -5;
			break;
			case 'win':
				$query = "update works set work_horse = ? where work_id = ?";
				$this->db->query($query,array($user_id,$work_id));
			break;
			default: $exp = 0;
			break;
		}
		
		$query = "update users set exp = exp + ? where user_id = ?";
		$this->db->query($query, array($exp*$work['points'], $user_id));
		
		if($this->db->insert('history', $log)) {
			return $log['user_id'];
		} else {
			return false;
		}
	}
	
	function get_exp($user_id){
		//Calculate the experience points
		$query = "SELECT 
			ifnull(done.point,0)-ifnull(redo.point,0)+2*ifnull(verify.point,0)+3*ifnull(signoff.point,0)-5*ifnull(reject.point,0)+0*ifnull(win.point,0)+0*ifnull(bid.point,0) as exp
		FROM
			(select sum(status) as point from history where history.user_id = ? AND event = 'done') as done,
			(select sum(status) as point from history where history.user_id = ? AND event = 'redo') as redo,
			(select sum(status) as point from history where history.user_id = ? AND event = 'verify') as verify,
			(select sum(status) as point from history where history.user_id = ? AND event = 'signoff') as signoff,
			(select sum(status) as point from history where history.user_id = ? AND event = 'reject') as reject,
			(select count(1) as point from history where history.user_id = ? AND event = 'win') as win,
			(select count(1) as point from history where history.user_id = ? AND event = 'bid') as bid
		";
		$result = $this->db->query($query, array($user_id,$user_id,$user_id,$user_id,$user_id,$user_id,$user_id));
		$result = $result->result_array();
		$result = $result[0]['exp'];
		
		return $result;
	}
	
	function get_rank($user_id,$main=false){
		$exp = $this->get_exp($user_id);
		$query = "Select rank, url, url_main from ranks where start_exp<= ? and end_exp>= ?";
		$result = $this->db->query($query,array($exp, $exp));
		$num = $result->num_rows();
		$result = $result->result_array();
		if($num>0){
			if($main == false)
				$result = "<span class='rank'><img style='float:none; margin:0 5px 0 0; border:1px solid green;' align='absmiddle' src='".$result[0]['url']."' />".$result[0]['rank']."</span>";
			elseif($main == true)
				$result = "<span class='rank'><img style='float:none; margin:0 5px 0 0; width:55px; border:1px solid green;' align='absmiddle' src='".$result[0]['url_main']."' />".$result[0]['rank']."</span>";
		}else{
			$result = 'N/A';
		}
		return $result;
	}
	
	function get_rank_badge($user_id){
		$exp = $this->get_exp($user_id);
		$query = "Select rank, url from ranks where start_exp<= ? and end_exp>= ?";
		$result = $this->db->query($query,array($exp, $exp));
		$num = $result->num_rows();
		$result = $result->result_array();
		if($num>0){
			$result = "<span class='rank'><img alt='".$result[0]['rank']."' style='float:none; margin:0 5px 0 0; border:1px solid green;' align='absmiddle' src='".$result[0]['url']."' /></span>";
		}else{
			$result = 'N/A';
		}
		return $result;
	}
	
	function get_rank_main_badge($user_id){
		$exp = $this->get_exp($user_id);
		$query = "Select rank, url, url_main from ranks where start_exp<= ? and end_exp>= ?";
		$result = $this->db->query($query,array($exp, $exp));
		$num = $result->num_rows();
		$result = $result->result_array();
		if($num>0){
			$result = "<span class='rank'><img alt='".$result[0]['rank']."' style='float:none; margin:0 5px 0 0; border:1px solid green;' align='absmiddle' src='".$result[0]['url_main']."' /></span>";
		}else{
			$result = 'N/A';
		}
		return $result;
	}
	
	function points_last_week($user_id){
		date('Y-m-d',strtotime( '-1 week' ));
		$query = "select ifnull(sum(status),0) as point from history where history.user_id = ? AND event = 'done' AND created_at > ?";
		$result = $this->db->query($query,array($user_id, date('Y-m-d H:i:s',strtotime( '-1 week' ))));
		$data = $result->result_array();
		return $data[0]['point'];
	}
	
	function points_inrow($user_id){
		$query = "select max(id) as mid from history where history.user_id = ? AND event = 'redo'";
		$result = $this->db->query($query,array($user_id));
		$data = $result->result_array();
		$mid = $data[0]['mid'];
		$query = "select ifnull(sum(status),0) as point from history where id> ? AND history.user_id = ? AND event = 'done'";
		$result = $this->db->query($query,array($mid, $user_id));
		$data = $result->result_array();
		return $data[0]['point'];	
	}
		
	function get_stats($user_id){
		$query = "select ifnull(sum(status),0) as point from history where history.user_id = ? AND event = 'done'";
		$result = $this->db->query($query,array($user_id));
		$data = $result->result_array();
		$res['done'] = $data[0]['point']; 
		$query = "select ifnull(sum(status),0) as point from history where history.user_id = ? AND event = 'redo'";
		$result = $this->db->query($query,array($user_id));
		$data = $result->result_array();
		$res['redo'] = $data[0]['point']; 
		$query = "select ifnull(sum(status),0) as point from history where history.user_id = ? AND event = 'verify'";
		$result = $this->db->query($query,array($user_id));
		$data = $result->result_array();
		$res['verify'] = $data[0]['point']; 
		$query = "select ifnull(sum(status),0) as point from history where history.user_id = ? AND event = 'signoff'";
		$result = $this->db->query($query,array($user_id));
		$data = $result->result_array();
		$res['signoff'] = $data[0]['point']; 
		$query = "select ifnull(sum(status),0) as point from history where history.user_id = ? AND event = 'reject'";
		$result = $this->db->query($query,array($user_id));
		$data = $result->result_array();
		$res['reject'] = $data[0]['point']; 
		$query = "select ifnull(count(1),0) as point from history where history.user_id = ? AND event = 'win'";
		$result = $this->db->query($query,array($user_id));
		$data = $result->result_array();
		$res['win'] = $data[0]['point'];
		$query = "select ifnull(count(1),0) as point from history where history.user_id = ? AND event = 'bid'";
		$result = $this->db->query($query,array($user_id));
		$data = $result->result_array();
		$res['bid'] = $data[0]['point']; 
		return $res;
	}
}