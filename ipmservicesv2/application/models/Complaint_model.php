<?php

class Complaint_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table = 'complaint';
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
							 ->from($this->table.' as c')
							 ->join('collectionType as ct','ct.collection_type_id=c.collection_type_id','LEFT')
							 ->having('c.project_id',$project_id)
							 ->like('c.'.$field,$filter)
							 ->or_like('ct.collection_type',$filter)
							 ->or_like('c.client_name',$filter)
							 ->or_like('c.location',$filter)
							 ->limit($limit, $offset)
							 ->order_by('c.'.$field, $order_by)
							 ->get()
							 ->result_array();
		

		return $query;

	}

	public function countList($project_id)
	{
		$where 	= array('project_id'=>$project_id);
		$count 	= $this->m->countResult($this->table,$where);
		return $count;
	}


	public function getTripTicket($project)
	{
		$sel   = 'tt.trip_ticket_id, tt.trip_ticket_no, tt.dispatch_date, tt.dispatch_time, e.body_no, ei.employee_no, ei.lastname, ei.firstname, ei.middlename, u.unit_name, s.geofence_name';
		$query = $this->db->select($sel)
				 ->from('tripTicket as tt')
				 ->join('shift as s','s.shift_id=tt.shift_id','LEFT')
				 ->join('employeeInformation as ei','ei.employee_id=tt.employee_id','LEFT')
				 ->join('equipment as e','e.equipment_id=tt.equipment_id','LEFT')
				 ->join('unit as u','u.unit_id=s.unit_id','LEFT')
				 ->where('tt.project_id',$project)
				 ->get()
				 ->result_array();
		$response = array('data'=>$query);
		return $response;
	}


	public function getTripTicketDetails($trip_ticket_id)
	{
		$sel   = 'tt.trip_ticket_id, tt.trip_ticket_no, tt.dispatch_date, tt.dispatch_time, e.body_no, ei.employee_no, ei.lastname, ei.firstname, ei.middlename, u.unit_name, s.geofence_name';
		$query = $this->db->select($sel)
				 ->from('tripTicket as tt')
				 ->join('shift as s','s.shift_id=tt.shift_id','LEFT')
				 ->join('employeeInformation as ei','ei.employee_id=tt.employee_id','LEFT')
				 ->join('equipment as e','e.equipment_id=tt.equipment_id','LEFT')
				 ->join('unit as u','u.unit_id=s.unit_id','LEFT')
				 ->where('tt.trip_ticket_id',$trip_ticket_id)
				 ->get()
				 ->result_array();
		$response = array('data'=>$query);
		return $response;
	}

	

	public function add($data)
	{
		if($data['collection_type_id'] != NULL)
		{
			$this->db->trans_start();
			$getMax = $this->db->select_max('complaint_no')->get($this->table)->row()->complaint_no;
			$data['complaint_no'] = $getMax + 1;
			$this->db->insert($this->table,$data);
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
		if($data['collection_type_id'] != NULL)
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


	public function clearedComplaint($where,$data)
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