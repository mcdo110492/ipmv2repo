<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Striker extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Striker_model', 'striker');
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


	public function striker_get()
	{
		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project 	= $this->get('project_id');
		$count 		= $this->striker->countList($project);
		$get 		= $this->striker->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->striker->checkData($where);
		$this->response($response);
	}



	public function striker_post()
	{
		if($this->access == 777)
		{
			$data['striker_no']					= $this->post('striker_no');
			$data['striker_fname']				= $this->post('striker_fname');
			$data['striker_mname']				= $this->post('striker_mname');
			$data['striker_lname']				= $this->post('striker_lname');
			$data['position_id']				= 3;
			$data['striker_dob']				= $this->m->formatDate($this->post('striker_dob'));
			$data['striker_date_employed']		= $this->m->formatDate($this->post('striker_date_employed'));
			$data['striker_status']				= 1;
			$data['project_id']					= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$data['striker_photo']				= 'default.jpg';
			$insert 							= $this->striker->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}


	public function striker_put()
	{
		if($this->access == 777)
		{
			$data['striker_fname']				= $this->put('striker_fname');
			$data['striker_mname']				= $this->put('striker_mname');
			$data['striker_lname']				= $this->put('striker_lname');
			$data['position_id']				= 3;
			$data['striker_dob']				= $this->m->formatDate($this->put('striker_dob'));
			$data['striker_date_employed']		= $this->m->formatDate($this->put('striker_date_employed'));
			$where 								= array('striker_id'=>$this->put('striker_id'));
			$update 							= $this->striker->update($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}

	public function strikerStatus_post()
	{
		if($this->access == 777)
		{
			$data['striker_status']				= $this->post('striker_status');
			$where 								= array('striker_id'=>$this->post('striker_id'));
			$update 							= $this->striker->update($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function strikerImageUpload_post()
	{
		if($this->access == 777)
		{
			$allowedTypes	= 'jpg|jpeg';
			$uploadPath 	= '../ipmrepository/striker/';
			$upload 		= $this->m->uploadFiles('userfile',$allowedTypes,$uploadPath);
			if($upload['status'] == 200)
			{
				$where 									= array('striker_id'=>$this->post('striker_id'));
				$data['striker_photo']					= $upload['file_name'];
				$update 								= $this->striker->update($where,$data);
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