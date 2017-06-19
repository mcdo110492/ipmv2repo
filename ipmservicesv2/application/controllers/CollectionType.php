<?php
require (APPPATH . 'libraries/REST_Controller.php');

class CollectionType extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('CollectionType_model', 'ctm');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
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


	public function collectionType_get()
	{
		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$count 		= $this->ctm->countList();
		$get 		= $this->ctm->getList($page,$limit,$order,$field,$filter,$limitpage,$offset);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function collectionTypeAll_get()
	{
		$get 		= $this->ctm->getListAll();
		$this->response($get);
	}

	public function check_post()
	{
		$field 			= $this->post('uniqueField');
		$value 			= $this->post('uniqueValue');
		$where[$field]	= $value;
		$response 		= $this->ctm->checkData($where);
		$this->response($response);
	}

	public function collectionType_post()
	{
		if($this->access == 777)
		{
			$data['collection_type']		= $this->post('collection_type');
			$insert 						= $this->ctm->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}

	public function collectionType_put()
	{
		if($this->access == 777)
		{
			$data['collection_type']		= $this->put('collection_type');
			$where 							= array('collection_type_id'=>$this->put('collection_type_id'));
			$update 						= $this->ctm->update($where,$data);
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