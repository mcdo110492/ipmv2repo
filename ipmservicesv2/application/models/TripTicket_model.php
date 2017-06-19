<?php

class TripTicket_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->trip 	= 'tripTicket';
		$this->paleros  = 'tripTicketPaleros';
		$this->striker  = 'tripTicketStriker';
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
		
		$query		=	 $this->db->select('*')
							 ->from($this->trip.' as t')
							 ->join('shift as s','s.shift_id=t.shift_id','LEFT')
							 ->join('unit as u','u.unit_id=s.unit_id','LEFT')
							 ->join('equipment as e','e.equipment_id=t.equipment_id','LEFT')
							 ->join('tripDriverLunchbox as tdl','tdl.trip_ticket_id=t.trip_ticket_id','LEFT')
							 ->join('lunchbox as l','l.lunchbox_id=tdl.lunchbox_id','LEFT')
							 ->join('employeeInformation as ei','ei.employee_id=t.employee_id','LEFT')
							 ->having('t.project_id',$project_id)
							 ->like('t.'.$field,$filter)
							 ->or_like('u.unit_name',$filter)
							 ->or_like('e.body_no',$filter)
							 ->order_by('t.dispatch_date','DESC')
							 ->get()
							 ->result_array();
		

		return $query;

	}

	

	public function count($project_id)
	{
		$where  = array('project_id'=>$project_id);
		$count 	= $this->m->countResult($this->trip,$where);
		return $count;
	}

	public function checkData($where)
	{
		$count = $this->m->countResult($this->trip,$where);
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

	public function getLunchbox($project_id,$employee_id)
	{
		$data = array();
		$currentDate = $this->m->getDate();
		$where 		 = array('tdl.project_id'=>$project_id,'tdl.employee_id'=>$employee_id,'tdl.lunchbox_date'=>$this->m->getDate(),'tdl.lunchbox_status !='=>3);
		$query 		= $this->db->select('*')
					  ->from('tripDriverLunchbox as tdl')
					  ->join('lunchbox as l','l.lunchbox_id=tdl.lunchbox_id','LEFT')
					  ->where($where)
					  ->get()
					  ->result_array();
		foreach($query as $r)
		{
			$data [] = array('trip_lunchbox_id'=>$r['trip_lunchbox_id'],'lunchbox'=>$r['lunchbox']);
			
		}

		$response = array('data'=>$data);
		return $response;

	}

	public function getShift($project_id)
	{
		$data 		= array();
		$currentDate = $this->m->getDate();
		$where 		 = array('s.project_id'=>$project_id);
		$query 		= $this->db->select('*')
					  ->from('shift as s')
					  ->join('unit as u','u.unit_id=s.unit_id','LEFT')
					  ->join('collectionSchedule as cs','cs.collection_schedule_id=s.collection_schedule_id','LEFT')
					  ->join('equipment as e','e.equipment_id=s.equipment_id','LEFT')
					  ->join('geofence as g','g.shift_id=s.shift_id','LEFT')
					  ->where($where)
					  ->get()
					  ->result_array();
		foreach($query as $r)
		{
			$countwhere = array('dispatch_date'=>$currentDate,'shift_id'=>$r['shift_id']);
			$count = $this->m->countResult($this->trip,$countwhere);
			if($count == 0)
			{
				$data [] = array('shift_id'=>$r['shift_id'],'unit_id'=>$r['unit_id'],'unit_name'=>$r['unit_name'],'geofence_name'=>$r['geofence_name'],'collection_schedule'=>$r['collection_schedule'],'equipment_id'=>$r['equipment_id'],'body_no'=>$r['body_no']);
			}
		}

		$response = array('data'=>$data);
		return $response;

	}

	public function getDriver($project_id)
	{
		$data = array();
		$currentDate = $this->m->getDate();
		$where 			= array('ee.project_id'=>$project_id,'ee.employee_status_id'=>1,'ee.position_id'=>1);
		$query 			= $this->db->select('*')
						  ->from('employeeInformation as ei')
						  ->join('employeeEmployment as ee','ee.employee_id=ei.employee_id','LEFT')
						  ->where($where)
						  ->order_by('ei.lastname','ASC')
						  ->get()
						  ->result_array();

		foreach($query as $r)
		{
			$countwhere = array('dispatch_date'=>$currentDate,'employee_id'=>$r['employee_id']);
			$count 		= $this->m->countResult($this->trip,$countwhere);
			if($count == 0)
			{
				$data [] = array('employee_id'=>$r['employee_id'],'employee_no'=>$r['employee_no'],'lastname'=>$r['lastname'],'firstname'=>$r['firstname'],'middlename'=>$r['middlename']);
			}
		}

		$response = array('data'=>$data);
		return $response;
	}

	public function getEquipment($project_id)
	{
		$data = array();
		$currentDate = $this->m->getDate();
		$where 			= array('project_id'=>$project_id,'equipment_status'=>1);
		$query 			= $this->db->where($where)->order_by('body_no','ASC')->get('equipment')->result_array();
						  

		foreach($query as $r)
		{
			$countwhere = array('dispatch_date'=>$currentDate,'equipment_id'=>$r['equipment_id']);
			$count 		= $this->m->countResult($this->trip,$countwhere);
			if($count == 0)
			{
				$data [] = array('equipment_id'=>$r['equipment_id'],'equipment_code'=>$r['equipment_code'],'body_no'=>$r['body_no']);
			}
		}

		$response = array('data'=>$data);
		return $response;
	}


	public function getPaleros($project_id)
	{
		$data = array();
		$currentDate = $this->m->getDate();
		$where 			= array('ee.project_id'=>$project_id,'ee.employee_status_id'=>1,'ee.position_id'=>2);
		$query 			= $this->db->select('*')
						  ->from('employeeInformation as ei')
						  ->join('employeeEmployment as ee','ee.employee_id=ei.employee_id','LEFT')
						  ->where($where)
						  ->order_by('ei.lastname','ASC')
						  ->get()
						  ->result_array();

		foreach($query as $r)
		{
			$countwhere = array('t.dispatch_date'=>$currentDate,'p.employee_id'=>$r['employee_id']);
			$count 		= $this->db->select('*')->from($this->trip.' as t')->join($this->paleros.' as p','p.trip_ticket_id=t.trip_ticket_id','LEFT')->where($countwhere)->count_all_results();
			if($count == 0)
			{
				$data [] = array('employee_id'=>$r['employee_id'],'employee_no'=>$r['employee_no'],'lastname'=>$r['lastname'],'firstname'=>$r['firstname'],'middlename'=>$r['middlename']);
			}
		}

		$response = array('data'=>$data);
		return $response;
	}


	public function getStriker($project_id)
	{
		$data = array();
		$currentDate = $this->m->getDate();
		$where 			= array('project_id'=>$project_id,'striker_status'=>1);
		$query 			= $this->db->where($where)->order_by('striker_id','ASC')->get('striker')->result_array();

		foreach($query as $r)
		{
			$countwhere = array('t.dispatch_date'=>$currentDate,'s.striker_id'=>$r['striker_id']);
			$count 		= $this->db->select('*')->from($this->trip.' as t')->join($this->striker.' as s','s.trip_ticket_id=t.trip_ticket_id','LEFT')->where($countwhere)->count_all_results();
			if($count == 0)
			{
				$data [] = array('striker_id'=>$r['striker_id'],'striker_no'=>$r['striker_no'],'striker_lname'=>$r['striker_lname'],'striker_fname'=>$r['striker_fname'],'striker_mname'=>$r['striker_mname']);
			}
		}

		$response = array('data'=>$data);
		return $response;
	}

	public function getShiftInfo($shift,$project)
	{
		$data = array();
		$where = array('shift_id'=>$shift,'project_id'=>$project);
		$count =  $this->m->countResult('shift',$where);
		if($count>0)
		{
			$equipment = $this->db->where($where)->get('shift')->row()->equipment_id;
			$countDriver = $this->db->select('*')->from('driver as d')->join('driverEquipment as de','de.driver_id=d.driver_id')->where('de.equipment_id',$equipment)->count_all_results();
			if($countDriver>0)
			{
				$getDriver = $this->db->select('*')->from('driver as d')->join('driverEquipment as de','de.driver_id=d.driver_id')->where('de.equipment_id',$equipment)->get()->row();
				$driver = $getDriver->employee_id;
				$countPaleros = $this->db->where('driver_id',$getDriver->driver_id)->count_all_results('driverPaleros');
				if($countPaleros>0)
				{
					$getPaleros = $this->db->select('employee_id')->from('driverPaleros')->where('driver_id',$getDriver->driver_id)->get()->result_array();
					foreach($getPaleros as $p)
					{
						$paleros [] = $p['employee_id'];
					}
				}
				else
				{
					$paleros = array();
				}
			}
			else
			{
				$driver = '';
				$getPaleros = array();
				$paleros = array();
			}	
			$data = array('equipment_id'=>$equipment,'driver_id'=>$driver,'paleros'=>$paleros);
			$response = array('status'=>200,'data'=>$data);

		}
		else
		{
			$response = array('status'=>404,'msg'=>'No Date found');
		}

		return $response;
	}


	public function add($data,$paleros,$strikers,$lunchbox)
	{
		$this->db->trans_start();
		$this->db->insert($this->trip,$data);
		$trip_id = $this->db->insert_id();
		foreach($paleros as $p)
		{
			$palero = array('employee_id'=>$p,'trip_ticket_id'=>$trip_id);
			$this->db->insert($this->paleros,$palero);
		}

		foreach($strikers as $s)
		{
			$striker = array('striker_id'=>$s,'trip_ticket_id'=>$trip_id);
			$this->db->insert($this->striker,$striker);
		}

		$l['trip_ticket_id'] 	= $trip_id;
		$this->db->where('trip_lunchbox_id',$lunchbox)->update('tripDriverLunchbox',$l);
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



	
}
?>