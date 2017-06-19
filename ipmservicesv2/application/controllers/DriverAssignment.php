<?php
require (APPPATH . 'libraries/REST_Controller.php');

class DriverAssignment extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('DriverAssignment_model', 'dam');
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


	public function driverAssignment_get()
	{
		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$count 		= $this->dam->countList($project);
		$get 		= $this->dam->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->dam->checkData($where);
		$this->response($response);
	}

	public function driverAssignmentDetails_get()
	{
		$project 		= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$employee_id 	= $this->get('employee_id');
		$get 			= $this->dam->getDriverDetails($employee_id,$project);
		$this->response($get);
	}

	public function driverAssignmentDetails_post()
	{
		if($this->access == 777)
		{
			$data['employee_id']		= $this->post('employee_id');
			$data['equipment_id']		= $this->post('equipment_id');
			$data['project_id']			= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$insert 					= $this->dam->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}

	public function driverAssignmentDetails_put()
	{
		if($this->access == 777)
		{
			$data['equipment_id']		= $this->put('equipment_id');
			$where 						= array('driver_id'=>$this->put('driver_id'));
			$update 					= $this->dam->update($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}

	public function driverAssignmentPaleros_get()
	{
		$driver_id 			= $this->get('driver_id');
		$get 				= $this->dam->getPaleros($driver_id);
		$this->response($get);
	}

	public function driverAssignmentPaleros_post()
	{
		$driver_id 			= $this->post('driver_id');
		$paleros 			= $this->post('paleros');
		$insert 			= $this->dam->savePaleros($driver_id,$paleros);
		$this->response($insert);
	}

	public function getPaleros_get()
	{
		$project_id			= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$getPAleros 		= $this->dam->getSelectPaleros($project_id);
		$this->response($getPAleros);
	}


	
}

?>