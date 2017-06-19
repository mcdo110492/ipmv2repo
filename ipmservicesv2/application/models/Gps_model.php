<?php

class Gps_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table 	= 'geofence';
	}

	public function getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project_id)
	{
		$table 		= $this->table;
		if($order === '-order')
		{
			$order_by = 'DESC';
		}
		else
		{
			$order_by = 'ASC';
		}
		
		$query		=	 $this->db->select('*')
							 ->from($this->table.' as g')
							 ->join('collectionType as ct','ct.collection_type_id=g.collection_type_id','LEFT')
							 ->join('shift as s','s.shift_id=g.shift_id','LEFT')
							 ->join('unit as u','u.unit_id=s.unit_id','LEFT')
							 ->join('collectionSchedule as cs','cs.collection_schedule_id=s.collection_schedule_id')
							 ->join('equipment as e','e.equipment_id=s.equipment_id')
							 ->having('g.project_id',$project_id)
							 ->like('e.'.$field,$filter)
							 ->or_like('g.sector',$filter)
							 ->or_like('u.unit_name',$filter)
							 ->limit($limit, $offset)
							 ->order_by('e.'.$field, $order_by)
							 ->order_by('g.geofence_status', 'ASC')
							 ->get()
							 ->result_array();
		

		return $query;

	}

	

	

	public function count($project_id)
	{
		$where  = array('project_id'=>$project_id);
		$count 	= $this->m->countResult($this->table,$where);
		return $count;
	}

	public function checkData($field,$value,$keyId)
	{
		if($keyId != NULL OR $keyId != '')
		{
			$where = array('geofence_id'=>$keyId,$field=>$value);
			$count = $this->m->countResult($this->table,$where);
			if($count>0)
			{
				$response = array('status'=>200);
			}
			else
			{
				$where2 = array($field=>$value);
				$count2 = $this->m->countResult($this->table,$where2);
				if($count2>0)
				{
					$response = array('status'=>403);
				}
				else
				{
					$response = array('status'=>200);
				}
			}
		}
		else
		{
			$where3 = array($field=>$value);
			$count3 = $this->m->countResult($this->table,$where3);
			if($count3>0)
			{
				$response = array('status'=>403);
			}
			else
			{
				$response = array('status'=>200);
			}
		}

		return $response;
	}


	public function add($data)
	{
		if($data['shift_id'] != NULL)
		{
			$insert	= $this->db->insert($this->table,$data);
			if($insert)
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
		if($data['shift_id'] != NULL)
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