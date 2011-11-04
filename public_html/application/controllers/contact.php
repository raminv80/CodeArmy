<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {
	var $view_data = array();
	var $check_login =false;
	
	function __construct() {
		parent::__construct();
		//$this->load->model('users_model');
		
		$this->view_data['page_is'] = 'Contact';
		
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
	}
	
	function index(){
		if($this->input->post('submit') == 'Submit'){
			require(getcwd()."/application/helpers/phpmailer/class.phpmailer.php");

			$mail = new PHPMailer();
			$to = admin_email;
			
			$mail->IsSMTP();                                      // set mailer to use SMTP
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			$mail->Host       = "mail.vakilian.net";      // sets GMAIL as the SMTP server
			//$mail->Port       = 110;                   // set the SMTP port for the GMAIL server
			$mail->Username = "noreply@vakilian.net";  // SMTP username
			$mail->Password = "work123"; // SMTP password
			//$mail->SMTPDebug  = 1;
			
			$mail->SetFrom('noreply@motionworks.com.my', "Customer's voice");
			$mail->AddAddress($to);
			//$mail->AddAddress("ellen@example.com");                  // name is optional
			//$mail->AddReplyTo("info@example.com", "Information");
			
			$mail->WordWrap = 50;                                 // set word wrap to 50 characters
			//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
			//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
			$mail->IsHTML(true);                                  // set email format to HTML
			
			$mail->Subject = $this->input->post('state');
			$mail->Body    = "Customer name: ".$this->input->post('name')."<br/> phone number: ".$this->input->post('phone')."<br/> Email: ".$this->input->post('email')."<br/> Message: ".$this->input->post('message');
			$mail->AltBody = $this->input->post('message');
			
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			   exit;
			}else{
				$this->view_data['email_sent'] = true;	
			}
		}
		
		$this->view_data['window_title'] = 'Contact us';
		$this->load->view('contact_us_view', $this->view_data);
	}
}