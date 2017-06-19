<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Unit extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('unit_model', 'um');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			if($this->token->role == 1 OR $this->token->role == 2 OR $this->token->role == 5)
			{
				$this->access = 777;
			}
			else if($this->token->role == 3 OR $this->token->role == 4 OR $this->token->role == 6 OR $this->token->role == 7 OR $this->token->role == 8 OR $this->token->role == 9 OR $this->token->role == 10 OR $this->token->role == 11)
			{
				$this->access = 766;
			}
			else
			{
				$this->response(array(
					'error' => 'Error'
				) , 403);
				exit(1);
			}
			
			
		} catch (Exception $e) {
			$this->response(array(
				'error' => 'Error'
			) , 400);

			exit(1);
		}
	
	}


	public function unit_get()
	{
		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$count 		= $this->um->countList();
		$get 		= $this->um->getList($page,$limit,$order,$field,$filter,$limitpage,$offset);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function unitAll_get()
	{
		$get 		= $this->um->getListAll();
		$this->response($get);
	}


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->um->checkData($where);
		$this->response($response);
	}

	public function unit_post()
	{
		if($this->access == 777)
		{
			$data['unit_name']	= $this->post('unit_name');
			$insert 					= $this->um->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}

	public function unit_put()
	{
		if($this->access == 777)
		{
			$data['unit_name']	= $this->put('unit_name');
			$where 						= array('unit_id'=>$this->put('unit_id'));
			$update 					= $this->um->update($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}	

	
}

?>