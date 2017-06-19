<?php

class Striker_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table 			= 'striker';
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
							 ->from($this->table)
							 ->having('project_id',$project_id)
							 ->like($field,$filter)
							 ->or_like('striker_lname',$filter)
							 ->limit($limit, $offset)
							 ->order_by($field, $order_by)
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
		if($data['striker_no'] != NULL && $data['striker_lname'] != NULL && $data['striker_fname'] != NULL && $data['striker_mname'] != NULL)
		{
			$this->db->trans_start();
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