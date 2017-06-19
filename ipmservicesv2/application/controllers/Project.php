<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Project extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('project_model', 'p');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			if($this->token->role != 1)
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


	public function project_get()
	{
		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$count 		= $this->p->countProject();
		$get 		= $this->p->getProject($page,$limit,$order,$field,$filter,$limitpage,$offset);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function projectAll_get()
	{
		$get 		= $this->p->getAllProject();
		$this->response($get);
	}


	public function checkData_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->p->checkData($where);
		$this->response($response);
	}

	public function project_post()
	{
		$data['project_name']		= $this->post('project_name');
		$data['project_code']		= $this->post('project_code');
		$insert 					= $this->p->add($data);
		$this->response($insert);
	}

	public function project_put()
	{
		$data['project_name']		= $this->put('project_name');
		$data['project_code']		= $this->put('project_code');
		$where 						= array('project_id'=>$this->put('project_id'));
		$update 					= $this->p->update($where,$data);
		$this->response($update);
	}	

	
}

?>