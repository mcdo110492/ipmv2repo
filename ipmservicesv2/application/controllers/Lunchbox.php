<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Lunchbox extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('lunchbox_model', 'lm');
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


	public function lunchbox_get()
	{

		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project    = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$count 		= $this->lm->count($project);
		$get 		= $this->lm->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function gadgetsAll_get()
	{
		$project    	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$lunchbox_id 	= $this->get('lunchbox_id'); 
		$get 			= $lunchbox_id == NULL ? $this->lm->getGadgets($project) : $this->lm->getGadgets2($project,$lunchbox_id) ;
		$this->response($get);
	}	


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->lm->checkData($where);
		$this->response($response);
	}

	public function lunchbox_post()
	{
		if($this->access == 777)
		{
			$data['lunchbox']			= $this->post('lunchbox');
			$data['project_id']			= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$gadgets 					= $this->post('gadgets');
			$insert 					= $this->lm->add($data,$gadgets);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function lunchboxGadgets_get()
	{
		$project_id 		= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$lunchbox_id 		= $this->get('lunchbox_id');
		$where 				= array('project_id'=>$project_id,'lunchbox_id'=>$lunchbox_id);
		$count 				= $this->lm->count2($where);
		if($count>0)
		{
			$get 				= $this->lm->getLunchboxGadgets($lunchbox_id,$project_id);
		}
		else
		{
			$get = array();
		}

		$response = array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function lunchboxGadgets_post()
	{
		if($this->access == 777)
		{
			$data['project_id']			= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$lunchbox_id 				= $this->post('lunchbox_id');
			$gadgets 					= $this->post('gadgets');
			$insert 					= $this->lm->addNewGadgets($data,$gadgets,$lunchbox_id);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	

	public function lunchboxGadgetStatus_post()
	{
		if($this->access == 777)
		{
			$lunchbox_gadget_id 	= $this->post('lunchbox_gadget_id');
			$project_id 			= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$gadget_id 				= $this->post('gadget_id');
			$status 				= $this->post('lunch_box_gadget_status');
			$change 				= $this->lm->changeGadgetStatus($lunchbox_gadget_id,$gadget_id,$status,$project_id);
			$this->response($change);
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