<?php
require (APPPATH . 'libraries/REST_Controller.php');

class TripTicket extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('tripTicket_model', 'tm');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			$this->project = $this->token->project_id;
			if($this->token->role == 1 OR $this->token->role == 2 OR $this->token->role == 5 OR $this->token->role == 8)
			{
				$this->access = 777;
			}
			else if($this->token->role == 3 OR $this->token->role == 4 OR $this->token->role == 6 OR $this->token->role == 7 OR $this->token->role == 9 OR $this->token->role == 10 OR $this->token->role == 11)
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


	public function tripTicket_get()
	{

		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project    = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$count 		= $this->tm->count($project);
		$get 		= $this->tm->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->tm->checkData($where);
		$this->response($response);
	}


	public function lunchbox_get()
	{
		$project_id = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$employee 	= $this->get('employee_id');
		$get 		= $this->tm->getLunchbox($project_id,$employee);
		$this->response($get);
	}

	public function shift_get()
	{
		$project_id = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$get 		= $this->tm->getShift($project_id);
		$this->response($get);
	}

	public function shift_post()
	{
		$project_id = $this->token->role == 1 ? $this->post('project_id') : $this->project;
		$shift_id   = $this->post('shift_id');
		$get 		= $this->tm->getShiftInfo($shift_id,$project_id);
		$this->response($get);
	}

	public function equipment_get()
	{
		$project_id = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$get 		= $this->tm->getEquipment($project_id);
		$this->response($get);
	}

	public function driver_get()
	{
		$project_id = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$get 		= $this->tm->getDriver($project_id);
		$this->response($get);
	}

	public function paleros_get()
	{
		$project_id = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$get 		= $this->tm->getPaleros($project_id);
		$this->response($get);
	}

	public function striker_get()
	{
		$project_id = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$get 		= $this->tm->getStriker($project_id);
		$this->response($get);
	}

	public function tripTicket_post()
	{
		if($this->access == 777)
		{
			$data['trip_ticket_no']			= $this->post('trip_ticket_no');
			$data['dispatch_date']			= $this->m->formatDate($this->post('dispatch_date'));
			$data['dispatch_time']			= $this->m->formatTime($this->post('dispatch_exact_time'));
			$data['employee_id']			= $this->post('driver_id');
			$data['equipment_id']			= $this->post('equipment_id');
			$data['shift_id']				= $this->post('shift_id');
			$data['trip_ticket_status']		= 1;
			$data['project_id']				= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$data['user_id']				= $this->token->userId;
			$paleros 						= $this->post('paleros');
			$striker 						= $this->post('striker');
			$lunchbox 						= $this->post('trip_lunchbox_id');
			$insert 						= $this->tm->add($data,$paleros,$striker,$lunchbox);
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