<?php

class EmployeeList_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->info 			= 'employeeInformation';
		$this->employment		= 'employeeEmployment';
		$this->government 		= 'employeeGovernment';
		$this->employeeUser 	= 'employeeUser';
		$this->contact 			= 'employeeContact';
		$this->user 			= 'user';
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
		
		$query 		=		$this->db->select('*')
							 ->from($this->info)
							 ->join($this->employment,$this->employment.'.employee_id='.$this->info.'.employee_id')
							 ->join('position as p','p.position_id='.$this->employment.'.position_id')
							 ->join('employmentStatus as es','es.employment_status_id='.$this->employment.'.employment_status_id')
							 ->join('employeeStatus as eys','eys.employee_status_id='.$this->employment.'.employee_status_id')
							 ->join($this->employeeUser,$this->employeeUser.'.employee_id='.$this->info.'.employee_id')
							 ->join($this->user,$this->user.'.user_id='.$this->employeeUser.'.user_id')
							 ->having($this->employment.'.project_id',$project_id)
							 ->like($field,$filter)
							 ->or_like($this->info.'.employee_no',$filter)
							 ->limit($limit, $offset)
							 ->order_by($field, $order_by)
							 ->get()
							 ->result_array();
		

		return $query;

	}

	public function countList($project_id)
	{
		$where 	= array('project_id'=>$project_id);
		$count 	= $this->m->countResult($this->employment,$where);
		return $count;
	}

	public function checkData($where)
	{
		$count = $this->m->countResult($this->info,$where);
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


	public function add($info,$dob,$emp,$contractStart,$contractEnd)
	{
		if($info['employee_no'] != NULL && $info['firstname'] != NULL && $info['lastname'] != NULL)
		{
			$this->db->trans_start();
			$info['dob']				= $this->m->formatDate($dob);
			$this->db->insert($this->info,$info);
			$employee_id 				= $this->db->insert_id();
			$emp['date_employed']		= $this->m->formatDate($contractStart);
			$emp['date_retired']		= $this->m->formatDate($contractEnd);
			$emp['employee_id']			= $employee_id;
			$this->db->insert($this->employment,$emp);
			$contact['employee_id']		= $employee_id;
			$this->db->insert($this->contact,$contact);
			$gov['employee_id']			= $employee_id;
			$this->db->insert($this->government,$gov);
			$user['username']			= $info['employee_no'];
			$user['password']			= $this->m->hashPassword($info['employee_no']);
			$user['role']				= 12;
			$user['status']				= 1;
			$user['profile_pic']		= 'default.jpg';
			$user['project_id']			= 0;
			$this->db->insert($this->user,$user);
			$userid 					= $this->db->insert_id();
			$userE['user_id']			= $userid;
			$userE['employee_id']		= $employee_id;
			$this->db->insert($this->employeeUser,$userE);
			$this->db->trans_complete();
			if($this->db->trans_status())
			{
				$response = array('status'=>200,'msg'=>"Success.");
			}
			else
			{
				$response = array('status'=>500,'msg'=>"Server Error.");
			}

		}
		else
		{
			$response = array('status'=>403,'msg'=>"There's an error. Check the data again.");
		}

		return $response;
	}

	public function update($where,$data)
	{
		if($data['collection_schedule'] != NULL)
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
		}
		else
		{
			$response = array('status'=>403,'msg'=>"There's an error. Check the data again.");
		}

		return $response;
	}



	
}
?>