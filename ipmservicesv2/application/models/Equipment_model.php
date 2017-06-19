<?php

class Equipment_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table 	= 'equipment';
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
							 ->where($this->table.'.project_id',$project_id)
							 ->like($this->table.'.'.$field,$filter)
							 ->limit($limit, $offset)
							 ->order_by($this->table.'.'.$field, $order_by)
							 ->order_by($this->table.'.equipment_status', 'DESC')
							 ->get()
							 ->result_array();
		

		return $query;

	}


	public function getListAll($project_id)
	{
		$where 		= 	array('project_id'=>$project_id,'equipment_status'=>1);
		$query		=	 $this->db->select('*')
							 ->from($this->table)
							 ->where($where)
							 ->order_by('body_no','ASC')
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
		if($data['equipment_code'] != NULL)
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
		if($data['equipment_code'] != NULL)
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