<?php
require (APPPATH . 'libraries/REST_Controller.php');

class GadgetType extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('gadgetType_model', 'g');
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


	public function gadgetType_get()
	{

		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$count 		= $this->g->count();
		$get 		= $this->g->getList($page,$limit,$order,$field,$filter,$limitpage,$offset);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function gadgetTypeAll_get()
	{
		$get 		= $this->g->getListAll();
		$this->response($get);
	}


	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->g->checkData($where);
		$this->response($response);
	}

	public function gadgetType_post()
	{
		if($this->access == 777)
		{
			$data['gadget_type']		= $this->post('gadget_type');
			$insert 					= $this->g->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}

	public function gadgetType_put()
	{
		if($this->access == 777)
		{
			$data['gadget_type']		= $this->put('gadget_type');
			$where 						= array('gadget_type_id'=>$this->put('gadget_type_id'));
			$update 					= $this->g->update($where,$data);
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