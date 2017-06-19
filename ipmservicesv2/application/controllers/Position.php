<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Position extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('position_model', 'pos');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			if($this->token->role == 1)
			{
				$this->access = 777;
			}
			else if($this->token->role > 1)
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


	public function position_get()
	{

		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$count 		= $this->pos->countPosition();
		$get 		= $this->pos->getPosition($page,$limit,$order,$field,$filter,$limitpage,$offset);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function positionAll_get()
	{
		$get 		= $this->pos->getPositionAll();
		$this->response($get);
	}


	public function checkData_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->pos->checkData($where);
		$this->response($response);
	}

	public function position_post()
	{
		if($this->access == 777)
		{
			$data['position_name']		= $this->post('position_name');
			$insert 					= $this->pos->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function position_put()
	{
		if($this->access == 777)
		{
			$data['position_name']		= $this->put('position_name');
			$where 						= array('position_id'=>$this->put('position_id'));
			$update 					= $this->pos->update($where,$data);
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