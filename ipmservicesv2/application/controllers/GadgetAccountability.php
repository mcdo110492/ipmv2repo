<?php
require (APPPATH . 'libraries/REST_Controller.php');

class GadgetAccountability extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GadgetAccountability_model', 'gam');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			$this->project = $this->token->project_id;
			if($this->token->role == 1 OR $this->token->role == 2 OR $this->token->role == 5 OR $this->token->role == 6)
			{
				$this->access = 777;
			}
			else if($this->token->role == 3 OR $this->token->role == 4 OR $this->token->role == 7 OR $this->token->role == 8 OR $this->token->role == 11)
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


	public function gadgetAccountability_get()
	{

		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->m->formatDate($this->get('filter'));
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project    = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$where 		= array('project_id'=>$project,'lunchbox_date'=>$filter);
		$count 		= $this->gam->count($where);
		$get 		= $this->gam->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function driver_get()
	{
		$project_id = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$get 		= $this->gam->getDrivers($project_id);
		$this->response($get);
	}

	public function lunchbox_get()
	{
		$project_id = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$get 		= $this->gam->getLunchbox($project_id);
		$this->response($get);
	}



	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where 			= array($field=>$value,'lunchbox_date'=>$this->m->getDate(),'lunchbox_status !='=>3);
		$response 		= $this->gam->checkData($where);
		$this->response($response);
	}


	public function gadgetAccountability_post()
	{
		if($this->access == 777)
		{
			$data['employee_id']			= $this->post('employee_id');
			$data['lunchbox_id']			= $this->post('lunchbox_id');
			$data['lunchbox_date']			= $this->m->getDate();
			$data['lunchbox_status']		= 2;
			$data['user_id']				= $this->token->userId;
			$data['project_id']				= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$insert 						= $this->gam->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}


	public function gadgetAccountability_put()
	{
		if($this->access == 777)
		{
			$data['lunchbox_status']	= $this->put('lunchbox_status');
			$where 						= array('trip_lunchbox_id'=>$this->put('id'));
			$update 					= $this->gam->changeStatus($where,$data);
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