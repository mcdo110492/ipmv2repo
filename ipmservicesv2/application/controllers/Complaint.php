<?php
require (APPPATH . 'libraries/REST_Controller.php');

class Complaint extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('complaint_model', 'cm');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			$this->project = $this->token->project_id;
			if($this->token->role == 1 OR $this->token->role == 2 OR $this->token->role == 5 OR $this->token->role == 11)
			{
				$this->access = 777;
			}
			else if($this->token->role == 3 OR $this->token->role == 4 OR $this->token->role == 6 OR $this->token->role == 8 OR $this->token->role == 9 OR $this->token->role == 10 OR $this->token->role == 7)
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


	public function complaint_get()
	{
		$page 		= $this->get('page');
		$limit 		= $this->get('limit');
		$order 		= $this->get('order');
		$field 		= $this->get('field');
		$filter 	= $this->get('filter');
		$limitpage 	= $page - 1;
		$offset 	= $limit * $limitpage;
		$project    = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$count 		= $this->cm->countList($project);
		$get 		= $this->cm->getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project);
		$response 	= array('count'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function getTripTicket_get()
	{
		$project = $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$get 	= $this->cm->getTripTicket($project);
		$this->response($get);
	}

	public function getTripTicket_put()
	{
		$trip_ticket_id = $this->put('trip_ticket_id');
		$get 	= $this->cm->getTripTicketDetails($trip_ticket_id);
		$this->response($get);
	}




	public function complaint_post()
	{
		if($this->access == 777)
		{
			$data['collection_type_id']		= $this->post('collection_type_id');
			$data['client_name']			= $this->post('client_name');
			$data['client_type']			= $this->post('client_type');
			$data['contact_no']				= $this->post('contact_no');
			$data['details']				= $this->post('details');
			$data['location']				= $this->post('location');
			$data['complaint_date']			= $this->m->formatDate($this->post('complaint_date'));
			$data['project_id']				= $this->token->role == 1 ? $this->post('project_id') : $this->project;
			$insert 						= $this->cm->add($data);
			$this->response($insert);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
		
	}

	public function complaint_put()
	{
		if($this->access == 777)
		{
			$data['collection_type_id']		= $this->put('collection_type_id');
			$data['client_name']			= $this->put('client_name');
			$data['client_type']			= $this->put('client_type');
			$data['contact_no']				= $this->put('contact_no');
			$data['details']				= $this->put('details');
			$data['location']				= $this->put('location');
			$data['complaint_date']			= $this->m->formatDate($this->put('complaint_date'));
			$where 							= array('complaint_id'=>$this->put('complaint_id'));
			$update 						= $this->cm->update($where,$data);
			$this->response($update);
		}
		else
		{
			$this->response(array(
					'error' => 'Error'
				) , 403);
		}
	}	


	public function complaintDispatch_post()
	{
		$data['trip_ticket_id']			= $this->post('trip_ticket_id');
		$where 							= array('complaint_id'=>$this->post('complaint_id'));
		$update 						= $this->cm->clearedComplaint($where,$data);

		$this->response($update);
	}

	
}

?>