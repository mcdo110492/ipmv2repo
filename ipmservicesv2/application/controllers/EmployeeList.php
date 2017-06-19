<?php
require (APPPATH . 'libraries/REST_Controller.php');

class EmployeeList extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('EmployeeList_model', 'elm');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			$this->project = $this->token->project_id;
			if($this->token->role == 1 OR $this->token->role == 2 OR $this->token->role == 3)
			{
				$this->access = 777;
			}
			else if($this->token->role > 3)
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


	public function employeeList_get()
	{
		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project 	= $this->get('project_id');
		$count 		= $this->elm->countList($project);
		$get 		= $this->elm->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->elm->checkData($where);
		$this->response($response);
	}

	public function employeeList_post()
	{
		if($this->access == 777)
		{
			$info['employee_no']			= $this->post('employee_no');
			$info['firstname']				= $this->post('firstname');
			$info['middlename']				= $this->post('middlename');
			$info['lastname']				= $this->post('lastname');
			$emp['position_id']				= $this->post('position_id');
			$emp['employment_status_id']	= $this->post('employment_status_id');
			$emp['employee_status_id']		= 1;
			$emp['project_id']				= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$emp['salary']					= 0;
			$dob 							= $this->post('dob');
			$dateEmployed					= $this->post('date_employed');
			$dateRetired					= $this->post('date_retired');
			$insert 						= $this->elm->add($info,$dob,$emp,$dateEmployed,$dateRetired);
			$this->response($insert);
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