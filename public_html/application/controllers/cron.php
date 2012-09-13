<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('cron_model');
		$this->load->model('users_model');
	}
	
	function loginreminder(){
		$results = $this->cron_model->check_last_login();
		if ($results){
			foreach($results as $value){
				$strUserID = $value['user_id'];
				$reminder = $this->cron_model->check_last_reminder($strUserID);
				$reminder_sent = strtotime($reminder[0]['reminder']);
				if($reminder_sent){
					$DateTimeNow = time();
					$hourdiff = ($DateTimeNow - $reminder_sent)/3600;
					if($hourdiff >= 24){
						$setReminder = date('Y-m-d H:i:s', $DateTimeNow);
						$this->cron_model->update_reminder($setReminder, $strUserID);
						$strMessage = "<p>Hi there,</p><p>Reminder</p><p><a href=\"http://beta.codearmy.com\" target=\"_blank\">Click here</a> to check out our account</p>";
						$this->users_model->notify($strUserID, 'Reminder: Login to CodeArmy', $strMessage);
					}
				} else {
					$DateTimeNow = time();
					$setReminder = date('Y-m-d H:i:s', $DateTimeNow);
					$this->cron_model->update_reminder($setReminder, $strUserID);
					$strMessage = "<p>Hi there,</p><p>You had not login to CodeArmy for more that 7 days.</p><p><a href=\"http://beta.codearmy.com\" target=\"_blank\">Click here</a> to check out our account</p>";
					$this->users_model->notify($strUserID, 'You had not login to CodeArmy for a week', $strMessage);
				}
			}
		}
	}
}
?>