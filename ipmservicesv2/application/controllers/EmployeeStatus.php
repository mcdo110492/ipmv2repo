<?php
require (APPPATH . 'libraries/REST_Controller.php');

class EmployeeStatus extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('employeeStatus_model', 'esm');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			if($this->token->role == 1)
			{
				$this->access = 777;
			}
			else if($this->token->role > 1)
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


	public function employeeStatus_get()
	{
		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$count 		= $this->esm->countList();
		$get 		= $this->esm->getList($page,$limit,$order,$field,$filter,$limitpage,$offset);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function employeeStatusAll_get()
	{
		$get 		= $this->esm->employeeStatusAll();
		$this->response($get);
	}


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->esm->checkData($where);
		$this->response($response);
	}

	public function employeeStatus_post()
	{
		if($this->access == 777)
		{
			$data['employee_status']	= $this->post('employee_status');
			$insert 					= $this->esm->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}

	public function employeeStatus_put()
	{
		if($this->access == 777)
		{
			$data['employee_status']	= $this->put('employee_status');
			$where 						= array('employee_status_id'=>$this->put('employee_status_id'));
			$update 					= $this->esm->update($where,$data);
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