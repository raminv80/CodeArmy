<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	private function isValidEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	
	public function index()
	{
		$this->load->helper(array('form', 'url'));
		$email = '';
		if($this->input->post('email')){
			$this->load->library('form_validation');
			$this->load->model('users_model');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			if ($this->form_validation->run() == FALSE)
			{
				$email = "";
			}
			else
			{
				$email = trim($this->input->post('email'));
				$type = 'none';
				if($this->input->post('startup_enlist'))$type = 'startup';
				if($this->input->post('talent_enlist'))$type = 'talent';
				if($this->input->post('startup_enlist')&&$this->input->post('talent_enlist'))$type = 'general';
				$ip = $this->input->ip_address();
				$agent = $this->input->user_agent();
				$this->users_model->subscribe($email,$type, $ip, $agent);
				$email = "You have successfully subscribed to CodeArmy";
			}
		}
		$this->load->view('welcome_message', array('email' => $email));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */