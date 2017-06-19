<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Login extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'l');
	
	}


	public function authenticate_post()
	{
		$username 	= $this->post('username');
		$password 	= $this->post('password');
		$response 	= $this->l->authenticate($username,$password);
		$this->response($response);
	}	

	
}

?>