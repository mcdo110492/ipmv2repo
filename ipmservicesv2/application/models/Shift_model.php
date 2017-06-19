<?php

class Shift_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table 	= 'shift';
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
							 ->from($this->table)
							 ->join('unit as u','u.unit_id='.$this->table.'.unit_id','LEFT')
							 ->join('collectionSchedule as cs','cs.collection_schedule_id='.$this->table.'.collection_schedule_id','LEFT')
							 ->join('equipment as e','e.equipment_id='.$this->table.'.equipment_id','LEFT')
							 ->having($this->table.'.project_id',$project_id)
							 ->like($this->table.'.'.$field,$filter)
							 ->or_like('e.body_no',$filter)
							 ->or_like('u.unit_name',$filter)
							 ->limit($limit, $offset)
							 ->order_by($this->table.'.'.$field, $order_by)
							 ->get()
							 ->result_array();
		

		return $query;

	}

	public function getListAll($project)
	{
		$where 		= array('s.project_id'=>$project);
		$query 		= $this->db->select('*')->from($this->table.' as s')
					  ->join('unit as u','u.unit_id=s.unit_id')
					  ->join('equipment as e','e.equipment_id=s.equipment_id')
					  ->join('collectionSchedule as cs','cs.collection_schedule_id=s.collection_schedule_id')
					  ->where($where)
					  ->get()
					  ->result_array();
		$response 	= array('data'=>$query);
		return $response;
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
			$where = array('shift_id'=>$keyId,$field=>$value);
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
		if($data['geofence_name'] != NULL)
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
		if($data['geofence_name'] != NULL)
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

	public function getEquipments($project,$shift)
	{
		$data 		= array();
		$where 		= array('project_id'=>$project,'equipment_status'=>1);
		$query 		= $this->db->where($where)->get('equipment')->result_array();
		foreach($query as $r)
		{
			if($shift != NULL)
			{
				$checkwhere = array('shift_id'=>$shift,'equipment_id'=>$r['equipment_id']);
				$count     = $this->m->countResult($this->table,$checkwhere);
				if($count>0)
				{
					$data [] = array('equipment_id'=>$r['equipment_id'],'body_no'=>$r['body_no'],'equipment_capacity'=>$r['equipment_capacity']);
				}
				else
				{
					$checkwhere2 = array('equipment_id'=>$r['equipment_id']);
					$count2      = $this->m->countResult($this->table,$checkwhere2);
					if($count2 == 0)
					{
						$data [] = array('equipment_id'=>$r['equipment_id'],'body_no'=>$r['body_no'],'equipment_capacity'=>$r['equipment_capacity']);
					}
				}
				
			}
			else
			{
				$checkwhere2 = array('equipment_id'=>$r['equipment_id']);
				$count2      = $this->m->countResult($this->table,$checkwhere2);
				if($count2 == 0)
				{
					$data [] = array('equipment_id'=>$r['equipment_id'],'body_no'=>$r['body_no'],'equipment_capacity'=>$r['equipment_capacity']);
				}
			}
		}

		$response = array('data'=>$data);
		return $response;
	}

	


	
}
?>