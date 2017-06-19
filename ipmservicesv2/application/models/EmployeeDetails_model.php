<?php

class EmployeeDetails_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->club 			= 'employeeClub'; //0
		$this->contact 			= 'employeeContact'; //1
		$this->education 		= 'employeeEducation'; //2
		$this->employment		= 'employeeEmployment'; //3
		$this->family 			= 'employeeFamily'; //4
		$this->government 		= 'employeeGovernment'; //5
		$this->info 			= 'employeeInformation'; //6
		$this->license 			= 'employeeLicense'; //7
		$this->training 		= 'employeeTrainingSeminar'; //8
		$this->employeeUser 	= 'employeeUser'; //9
		$this->user 			= 'user'; //10
		
		
	}

	public function countEmployee($id,$project_id)
	{
		$where = array('employee_id'=>$id,'project_id'=>$project_id);
		$count = $this->m->countResult($this->employment,$where);
		if($count>0)
		{
			$response = 200;
		}
		else
		{
			$response = 404;
		}
		return $response;
	}

	public function getBasicInfo($id,$project_id)
	{
		$selCol = 'ei.employee_no, ei.firstname, ei.middlename, ei.lastname, ei.dob, ei.pob, ei.height, ei.weight, ei.blood, ei.distinguishing_mark, ei.civil_status, ei.citizenship, ei.religion, '.$this->employment.'.project_id as ep_id, '.$this->user.'.user_id, '.$this->user.'.profile_pic';
		$where = array('ei.employee_id'=>$id,$this->employment.'.project_id'=>$project_id);
		$query 	= $this->db->select($selCol)
					->from($this->info.' as ei')
					->join($this->employment,$this->employment.'.employee_id=ei.employee_id')
					->join($this->employeeUser,$this->employeeUser.'.employee_id=ei.employee_id')
					->join($this->user,$this->user.'.user_id='.$this->employeeUser.'.user_id')
					->where($where)
					->get()
					->result_array();

		return $query;

	}

	public function updateEmployeeInfo($where,$data,$project,$tableNo)
	{
		$table = array($this->club,$this->contact,$this->education,$this->employment,$this->family,$this->government,$this->info,$this->license,$this->training,$this->employeeUser,$this->user);
		if($project == 0)
		{
			$update 	=  $this->m->updateData($table[$tableNo],$data,$where);
			if($update)
			{
				$response 	= array('status'=>200);
			}
			else
			{	
				$response 	= array('status'=>500);
			}
		}
		else
		{
			$countwhere = array('project_id'=>$project,'employee_id'=>$where['employee_id']);
			$count 		= $this->m->countResult($this->employment,$countwhere);
			if($count>0)
			{
				$update 	=  $this->m->updateData($table[$tableNo],$data,$where);
				if($update)
				{
					$response 	= array('status'=>200);
				}
				else
				{	
					$response 	= array('status'=>500);
				}
			}
			else
			{
				$response 	= array('status'=>500);
			}
		}

		return $response;
	}

	public function getContactInfo($id,$project_id)
	{
		$where = array($this->contact.'.employee_id'=>$id,$this->employment.'.project_id'=>$project_id);
		$query 	= $this->db->select('*')
					->from($this->contact)
					->join($this->employment,$this->employment.'.employee_id='.$this->contact.'.employee_id')
					->where($where)
					->get()
					->result_array();
		return $query;

	}

	public function getEmploymentInfo($id,$project_id)
	{
		$where = array($this->employment.'.employee_id'=>$id,$this->employment.'.project_id'=>$project_id);
		$query 	= $this->db->select('*')
					->from($this->employment)
					->where($where)
					->get()
					->result_array();
		return $query;

	}

	public function getEducationInfo($id,$project_id)
	{
		$where = array($this->education.'.employee_id'=>$id,$this->employment.'.project_id'=>$project_id);
		$query 	= $this->db->select('*')
					->from($this->education)
					->join($this->employment,$this->employment.'.employee_id='.$this->education.'.employee_id')
					->where($where)
					->get()
					->result_array();
		return $query;

	}

	public function addData($data,$tableNo)
	{
		$table = array($this->club,$this->contact,$this->education,$this->employment,$this->family,$this->government,$this->info,$this->license,$this->training,$this->employeeUser,$this->user);
		$insert 	= $this->m->addData($table[$tableNo],$data);
		if($insert)
		{
			$response = array('status'=>200);
		}
		else
		{
			$response = array('status'=>500);
		}
		return $response;
	}

	public function updateData($data,$where,$tableNo)
	{
		$table = array($this->club,$this->contact,$this->education,$this->employment,$this->family,$this->government,$this->info,$this->license,$this->training,$this->employeeUser,$this->user);
		$update 	= $this->m->updateData($table[$tableNo],$data,$where);
		if($update)
		{
			$response = array('status'=>200);
		}
		else
		{
			$response = array('status'=>500);
		}
		return $response;
	}

	public function getGovernmentInfo($id)
	{
		$where = array('employee_id'=>$id);
		$query 	= $this->db->select('*')
					->from($this->government)
					->where($where)
					->get()
					->result_array();
		return $query;
	}

	public function getLicenseInfo($id)
	{
		$where = array('employee_id'=>$id);
		$query 	= $this->db->select('*')
					->from($this->license)
					->where($where)
					->get()
					->result_array();
		return $query;
	}

	public function getFamilyInfo($id)
	{
		$where = array('employee_id'=>$id);
		$query 	= $this->db->select('*')
					->from($this->family)
					->where($where)
					->get()
					->result_array();
		return $query;
	}

	public function getTrainingInfo($id)
	{
		$where = array('employee_id'=>$id);
		$query 	= $this->db->select('*')
					->from($this->training)
					->where($where)
					->get()
					->result_array();
		return $query;
	}

	public function getClubInfo($id)
	{
		$where = array('employee_id'=>$id);
		$query 	= $this->db->select('*')
					->from($this->club)
					->where($where)
					->get()
					->result_array();
		return $query;
	}


	public function getAccountInfo($id)
	{
		$where = array($this->employeeUser.'.employee_id'=>$id);
		$sel = $this->user.'.username, '.$this->user.'.status, '.$this->user.'.user_id';
		$query 	= $this->db->select($sel)
					->from($this->employeeUser)
					->join($this->user,$this->user.'.user_id='.$this->employeeUser.'.user_id')
					->where($where)
					->get()
					->result_array();
		return $query;
	}


	



	
}
?>