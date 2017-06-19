<?php
require (APPPATH . 'libraries/REST_Controller.php');

class User extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'u');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			$this->project = $this->token->project_id;
			if($this->token->role == 1 OR $this->token->role == 2 OR $this->token->role == 3)
			{
				$this->access = 777;
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


	public function user_get()
	{

		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$role 		= $this->token->role;
		$count 		= $this->u->count($project,$role);
		$get 		= $this->u->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project,$role);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function role_get()
	{
		$role 	= $this->token->role;
		$get 	= $this->u->getRole($role);
		$this->response($get);
	}

	
	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->u->checkData($where);
		$this->response($response);
	}

	public function user_post()
	{
		if($this->access == 777)
		{
			$data['username']			= $this->post('username');
			$data['profile_name']		= $this->post('profile_name');
			$data['password']			= $this->m->hashPassword($data['username']);
			$data['role']				= $this->post('role');
			$data['status']				= 1;
			$data['profile_pic']		= 'default.jpg';
			$data['project_id']			= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$insert 					= $this->u->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function changeStatus_post()
	{
		if($this->access == 777)
		{
			$data['status']				= $this->post('status');
			$where 						= array('user_id'=>$this->post('id'));
			$update 					= $this->u->changeStatus($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function resetPassword_post()
	{
		if($this->access == 777)
		{
			$data['password']			= $this->m->hashPassword($this->post('username'));
			$where 						= array('user_id'=>$this->post('id'));
			$update 					= $this->u->update($where,$data);
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