<?php

class GadgetAccountability_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table 	= 'tripDriverLunchbox';
	}

	public function getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project_id)
	{
		if($order === '-order')
		{
			$order_by = 'DESC';
		}
		else
		{
			$order_by = 'ASC';
		}
		$data 		= array();
		$where 		= 	array('td.project_id'=>$project_id,'td.lunchbox_date'=>$filter);
		$query		=	 $this->db->select('*')
							->from($this->table.' as td')
							->join('tripTicket as tt','tt.trip_ticket_id=td.trip_ticket_id','LEFT')
							->join('lunchbox as l','l.lunchbox_id=td.lunchbox_id','LEFT')
							->join('employeeInformation as ei','ei.employee_id=td.employee_id','LEFT')
							->join('user as u','u.user_id=td.user_id','LEFT')
							->where($where)
							->limit($limit, $offset)
							->order_by('tt.trip_ticket_no',$order_by)
							->get()
							->result_array();
		foreach($query as $q)
		{
			

			$where2   = array('lg.lunchbox_id'=>$q['lunchbox_id']);
			$gadgets 	= $this->db->select('*')
						->from('lunchboxGadget as lg')
						->join('gadget as g','g.gadget_id=lg.gadget_id','LEFT')
						->join('gadgetType as gt','gt.gadget_type_id=g.gadget_type_id','LEFT')
						->where($where2)
						->order_by('g.gadget_id','ASC')
						->get()
						->result_array();
			$data [] = array('trip_lunchbox_id'=>$q['trip_lunchbox_id'],'trip_ticket_no'=>$q['trip_ticket_no'],'employee_no'=>$q['employee_no'],'lastname'=>$q['lastname'],'firstname'=>$q['firstname'],'middlename'=>$q['middlename'],'lunchbox'=>$q['lunchbox'],'gadgets'=>$gadgets,'lunchbox_status'=>$q['lunchbox_status'],'profile_name'=>$q['profile_name'],'lunchbox_date'=>$q['lunchbox_date']);
		}
		

		return $data;

	}

	public function getDrivers($project_id)
	{
		$where 		= array('ee.project_id'=>$project_id,'ee.position_id'=>1,'ee.employee_status_id'=>1);
		$get 		= $this->db->select('*')
					  ->from('employeeInformation as ei')
					  ->join('employeeEmployment as ee','ee.employee_id=ei.employee_id','LEFT')
					  ->where($where)
					  ->order_by('ei.employee_no','ASC')
					  ->get()
					  ->result_array();
		$response 	= array('data'=>$get);
		return $response;
	}

	public function getLunchbox($project_id)
	{
		$where 		= array('project_id'=>$project_id);
		$get 		= $this->db->where($where)->get('lunchbox')->result_array();
		$response 	= array('data'=>$get);
		return $response;
	}

	

	public function count($where)
	{
		$count 	= $this->m->countResult($this->table,$where);
		return $count;
	}


	public function checkData($where)
	{
		$count = $this->m->countResult($this->table,$where);
		if($count>0)
		{
			$response = array('status'=>403);
		}
		else
		{
			$response = array('status'=>200);
		}

		return $response;
	}


	public function add($data)
	{
		if($data['employee_id'] != NULL OR $data['lunchbox_id'] != NULL OR $data['lunchbox_date'] != NULL)
		{
			$insert = $this->db->insert($this->table,$data);
			if($insert)
			{
				$response = array('status'=>200,'msg'=>'Saved.');
			}
			else
			{
				$response = array('status'=>500,'msg'=>'Server Error.');
			}
		}
		else
		{
			$response = array('status'=>403,'msg'=>"There' s an error while trying to save check the requirements.");
		}

		return $response;
	}



	public function changeStatus($where,$data)
	{
		
			$update	= $this->db->where($where)->update($this->table,$data);
			if($update)
			{
				$response = array('status'=>200,'msg'=>"Success.");
			}
			else
			{
				$response = array('status'=>500,'msg'=>"Server Error.");
			}
		

		return $response;
	}



	
}
?>