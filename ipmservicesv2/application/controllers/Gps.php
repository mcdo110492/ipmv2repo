<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Gps extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('gps_model', 'gm');
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


	public function gps_get()
	{

		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project    = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$count 		= $this->gm->count($project);
		$get 		= $this->gm->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}




	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$keyId 			= $this->post('uniqueId');
		$response 		= $this->gm->checkData($field,$value,$keyId);
		$this->response($response);
	}

	public function gps_post()
	{
		if($this->access == 777)
		{
			$data['collection_type_id']			= $this->post('collection_type_id');
			$data['shift_id']					= $this->post('shift_id');
			$data['sector']						= $this->post('sector');
			$data['geofence_status']			= 1;
			$data['geofence_file']				= 'default.jpg';
			$data['project_id']					= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$insert 							= $this->gm->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function gps_put()
	{
		if($this->access == 777)
		{
			$data['collection_type_id']			= $this->put('collection_type_id');
			$data['shift_id']					= $this->put('shift_id');
			$data['sector']						= $this->put('sector');
			$where 								= array('geofence_id'=>$this->put('geofence_id'));
			$update 							= $this->gm->update($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}

	public function gpsStatus_post()
	{
		if($this->access == 777)
		{
			$data['geofence_status']			= $this->post('geofence_status');
			$where 								= array('geofence_id'=>$this->post('geofence_id'));
			$update 							= $this->gm->changeStatus($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	} 	


	public function gpsUpload_post()
	{
		if($this->access == 777)
		{
			$allowedTypes	= 'jpg|jpeg';
			$uploadPath 	= '../ipmrepository/routes/';
			$upload 		= $this->m->uploadFiles('userfile',$allowedTypes,$uploadPath);
			if($upload['status'] == 200)
			{
				$where 									= array('geofence_id'=>$this->post('geofence_id'));
				$data['geofence_file']					= $upload['file_name'];
				$update 								= $this->gm->changeStatus($where,$data);
				if($update)
				{
					$response = array('status'=>200);
				}
				else
				{
					$response = array('status'=>500);
				}
			}
			else
			{
				$response 	= $upload;
			}
			$this->response($response);
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