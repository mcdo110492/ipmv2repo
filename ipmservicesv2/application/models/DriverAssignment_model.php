<?php

class DriverAssignment_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->info 			= 'employeeInformation';
		$this->employment		= 'employeeEmployment';
		$this->employeeUser 	= 'employeeUser';
		$this->user 			= 'user';
	}

	public function getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project_id)
	{
		$data 	= array();
		$where = array('e.project_id'=>$project_id,'e.position_id'=>1,'e.employee_status_id'=>1);
		if($order === '-order')
		{
			$order_by = 'DESC';
		}
		else
		{
			$order_by = 'ASC';
		}
		
		$query 		=		$this->db->select('*')
							 ->from($this->info.' as i')
							 ->join($this->employment.' as e','e.employee_id=i.employee_id','LEFT')
							 ->join($this->employeeUser.' as eu','eu.employee_id=i.employee_id','LEFT')
							 ->join($this->user.' as u','u.user_id=eu.user_id','LEFT')
							 ->having($where)
							 ->like('i.'.$field,$filter)
							 ->or_like('i.employee_no',$filter)
							 ->order_by('i.'.$field,$order_by)
							 ->get()
							 ->result_array();
				foreach($query as $q)
				{
					$getEquipment = $this->db->select('body_no')->from('driver as d')->join('driverEquipment as de','de.driver_id=d.driver_id')->join('equipment as e','e.equipment_id=de.equipment_id')->where('d.employee_id',$q['employee_id'])->get()->result_array();
					$getPaleros  = $this->db->select('i.employee_no,i.lastname,i.firstname,i.middlename')->from('driver as d')->join('driverPaleros as dp','dp.driver_id=d.driver_id','LEFT')->join($this->info.' as i','i.employee_id=dp.employee_id','LEFT')->where('d.employee_id',$q['employee_id'])->get()->result_array();
					$data [] = array('employee_id'=>$q['employee_id'],'employee_no'=>$q['employee_no'],'firstname'=>$q['firstname'],'middlename'=>$q['middlename'],'lastname'=>$q['lastname'],'profile_pic'=>$q['profile_pic'],'equipment'=>$getEquipment,'paleros'=>$getPaleros);
				}
		

		return $data;

	}

	public function countList($project_id)
	{
		$where 	= array('project_id'=>$project_id,'position_id'=>1);
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

	public function getDriverDetails($employee_id,$project)
	{
		$where 	= array('e.project_id'=>$project,'e.employee_id'=>$employee_id,'e.position_id'=>1);
		$count 	= $this->m->countResult($this->employment.' as e',$where);
		if($count>0)
		{
			$get = $this->db->select('i.employee_id,i.employee_no,i.firstname,i.middlename,i.lastname,u.profile_pic,d.driver_id,de.equipment_id')
					->from($this->info.' as i')
					->join($this->employment.' as e','e.employee_id=i.employee_id','LEFT')
					->join($this->employeeUser.' as eu','eu.employee_id=i.employee_id','LEFT')
					->join($this->user.' as u','u.user_id=eu.user_id','LEFT')
					->join('driver as d','d.employee_id=i.employee_id','LEFT')
					->join('driverEquipment as de','de.driver_id=d.driver_id','LEFT')
					->where($where)
					->get()
					->result_array();
			$data = array('status'=>200,'data'=>$get);
		}
		else
		{
			$data = array('status'=>404,'msg'=>'No data found.');
		}

		return $data;

	}

	public function add($data)
	{
		$driver['employee_id'] = $data['employee_id'];
		$driver['project_id']	= $data['project_id'];
		$this->db->trans_start();
		$this->db->insert('driver',$driver);
		$driver_id = $this->db->insert_id();
		$equipment['equipment_id']	= $data['equipment_id'];
		$equipment['driver_id']		= $driver_id;
		$this->db->insert('driverEquipment',$equipment);
		$this->db->trans_complete();
		if($this->db->trans_status())
		{
			$response = array('status'=>200);
		}
		else
		{
			$response = array('status'=>200);
		}

		return $response;
	}

	public function update($where,$data)
	{
		if($data['equipment_id'] != NULL)
		{
			$update	= $this->db->where($where)->update('driverEquipment',$data);
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


	public function getPaleros($driver_id)
	{
		$where 		= array('dp.driver_id'=>$driver_id,'e.employee_status_id'=>1);
		$get 		= $this->db->select('i.employee_id,i.employee_no,i.firstname,i.middlename,i.lastname,u.profile_pic')
					  ->from($this->info.' as i')
					  ->join($this->employment.' as e','e.employee_id=i.employee_id','LEFT')
					  ->join($this->employeeUser.' as eu','eu.employee_id=i.employee_id','LEFT')
					  ->join($this->user.' as u','u.user_id=eu.user_id')
					  ->join('driverPaleros as dp','dp.employee_id=i.employee_id','LEFT')
					  ->where($where)
					  ->order_by('i.lastname','ASC')
					  ->get()
					  ->result_array();
		$response 	= array('data'=>$get);
		return $response;
	}

	public function getSelectPaleros($project_id)
	{
		$data 		= array();
		$where 		= array('e.project_id'=>$project_id,'e.position_id'=>2,'e.employee_status_id'=>1);
		$get 		= $this->db->select('i.employee_id,i.employee_no,i.firstname,i.middlename,i.lastname')
					  ->from($this->info.' as i')
					  ->join($this->employment.' as e','e.employee_id=i.employee_id','LEFT')
					  ->where($where)
					  ->order_by('i.lastname','ASC')
					  ->get()
					  ->result_array();

		foreach($get as $r)
		{
			$where = array('employee_id'=>$r['employee_id']);
			$count = $this->m->countResult('driverPaleros',$where);
			if($count ==0)
			{
				$data [] = array('employee_id'=>$r['employee_id'],'firstname'=>$r['firstname'],'middlename'=>$r['middlename'],'lastname'=>$r['lastname'],'employee_no'=>$r['employee_no']);
			}
		}
		$response 	= array('data'=>$data);
		return $response;
	}

	public function savePaleros($driver_id,$paleros)
	{
		$this->db->trans_start();
		foreach($paleros as $p)
		{
			$data 		= array('driver_id'=>$driver_id,'employee_id'=>$p);
			$this->db->insert('driverPaleros',$data);
		}

		$this->db->trans_complete();

		if($this->db->trans_status())
		{
			$response = array('status'=>200);
		}
		else
		{
			$response = array('status'=>500);
		}

		return $response;
	}




	
}
?>