<?php
require (APPPATH . 'libraries/REST_Controller.php');

class RouteResolver extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		
	
	}


	public function securityCheck_get()
	{
		$header = $this->input->get_request_header('Authorization', TRUE);
		try{
			$this->m->tokenDecode($header);
			$response  = array('status'=>200,'msg'=>'Authorized');
			$this->response($response,200);
		}
		catch (Exception $e){
			$this->response(array(
				'msg' => 'Unauthorized'
			) , 400);
			exit;
		}
	}




	
}

?>