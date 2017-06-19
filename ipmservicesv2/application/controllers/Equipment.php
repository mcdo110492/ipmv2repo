<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Equipment extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('equipment_model', 'em');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			$this->project = $this->token->project_id;
			if($this->token->role == 1 OR $this->token->role == 2 OR $this->token->role == 5)
			{
				$this->access = 777;
			}
			else if($this->token->role == 3 OR $this->token->role == 4 OR $this->token->role == 6 OR $this->token->role == 7 OR $this->token->role == 8 OR $this->token->role == 9 OR $this->token->role == 10 OR $this->token->role == 11 OR $this->token->role == 12)
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


	public function equipment_get()
	{

		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project    = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$count 		= $this->em->count($project);
		$get 		= $this->em->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function equipmentAll_get()
	{

		$project    = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$count 		= $this->em->count($project);
		$get 		= $this->em->getListAll($project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->em->checkData($where);
		$this->response($response);
	}

	public function equipment_post()
	{
		if($this->access == 777)
		{
			$data['equipment_code']		= $this->post('equipment_code');
			$data['body_no']			= $this->post('body_no');
			$data['equipment_model']	= $this->post('equipment_model');
			$data['equipment_capacity']	= $this->post('equipment_capacity');
			$data['equipment_plate_no']	= $this->post('equipment_plate_no');
			$data['equipment_remarks']	= $this->post('equipment_remarks');
			$data['equipment_status']	= 1;
			$data['project_id']			= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$insert 					= $this->em->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function equipment_put()
	{
		if($this->access == 777)
		{
			$data['equipment_code']		= $this->put('equipment_code');
			$data['body_no']			= $this->put('body_no');
			$data['equipment_model']	= $this->put('equipment_model');
			$data['equipment_capacity']	= $this->put('equipment_capacity');
			$data['equipment_plate_no']	= $this->put('equipment_plate_no');
			$data['equipment_remarks']	= $this->put('equipment_remarks');
			$where 						= array('equipment_id'=>$this->put('equipment_id'));
			$update 					= $this->em->update($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}	

	public function equipmentStatus_post()
	{
		if($this->access == 777)
		{
			$data['equipment_status']		= $this->post('equipment_status');
			$where 							= array('equipment_id'=>$this->post('equipment_id'));
			$update 						= $this->em->changeStatus($where,$data);
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