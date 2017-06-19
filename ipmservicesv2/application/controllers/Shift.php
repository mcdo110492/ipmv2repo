<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Shift extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('shift_model', 'sm');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			$this->project = $this->token->project_id;
			if($this->token->role == 1 OR $this->token->role == 2 OR $this->token->role == 5 OR $this->token->role == 7)
			{
				$this->access = 777;
			}
			else if($this->token->role == 3 OR $this->token->role == 4 OR $this->token->role == 6 OR $this->token->role == 8 OR $this->token->role == 9 OR $this->token->role == 10 OR $this->token->role == 11)
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


	public function shift_get()
	{

		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project    = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$count 		= $this->sm->count($project);
		$get 		= $this->sm->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function shiftAll_get()
	{
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$get 		= $this->sm->getListAll($project);
		$this->response($get);
	}


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$keyId 			= $this->post('uniqueId');
		$response 		= $this->sm->checkData($field,$value,$keyId);
		$this->response($response);
	}

	public function shift_post()
	{
		if($this->access == 777)
		{
			$data['unit_id']					= $this->post('unit_id');
			$data['geofence_name']				= $this->post('geofence_name');
			$data['collection_schedule_id']		= $this->post('collection_schedule_id');
			$data['shift_time']					= $this->m->formatTime($this->post('exact_time'));
			$data['equipment_id']				= $this->post('equipment_id');
			$data['project_id']					= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$insert 							= $this->sm->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function shift_put()
	{
		if($this->access == 777)
		{
			$data['unit_id']					= $this->put('unit_id');
			$data['geofence_name']				= $this->put('geofence_name');
			$data['collection_schedule_id']		= $this->put('collection_schedule_id');
			$data['shift_time']					= $this->m->formatTime($this->put('exact_time'));
			$data['equipment_id']				= $this->put('equipment_id');
			$where 								= array('shift_id'=>$this->put('shift_id'));
			$update 							= $this->sm->update($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}	


	public function equipment_get()
	{
		$project 		= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$shift 			= $this->get('shift_id');
		$get 			= $this->sm->getEquipments($project,$shift);
		$this->response($get);
	}

	

	
}

?>