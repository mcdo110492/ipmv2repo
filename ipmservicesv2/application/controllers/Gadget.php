<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Gadget extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('gadget_model', 'gm');
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


	public function gadget_get()
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
		$where[$field]	= $value;
		$response 		= $this->gm->checkData($where);
		$this->response($response);
	}

	public function gadget_post()
	{
		if($this->access == 777)
		{
			$data['gadget_code']		= $this->post('gadget_code');
			$data['gadget_model']		= $this->post('gadget_model');
			$data['gadget_type_id']		= $this->post('gadget_type_id');
			$data['gadget_status']		= 1;
			$data['project_id']			= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$insert 					= $this->gm->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function gadget_put()
	{
		if($this->access == 777)
		{
			$data['gadget_code']		= $this->put('gadget_code');
			$data['gadget_model']		= $this->put('gadget_model');
			$data['gadget_type_id']		= $this->put('gadget_type_id');
			$where 						= array('gadget_id'=>$this->put('gadget_id'));
			$update 					= $this->gm->update($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}	

	public function gadgetStatus_post()
	{
		if($this->access == 777)
		{
			$data['gadget_status']		= $this->post('gadget_status');
			$where 						= array('gadget_id'=>$this->post('gadget_id'));
			$update 					= $this->gm->changeStatus($where,$data);
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