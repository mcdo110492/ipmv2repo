<?php

class Project_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table 	= 'project';
	}

	public function getProject($page,$limit,$order,$field,$filter,$limitpage,$offset)
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
							 ->from($table)
							 ->like($field,$filter)
							 ->limit($limit, $offset)
							 ->order_by($field, $order_by)
							 ->get()
							 ->result_array();
		

		return $query;

	}

	public function getAllProject()
	{
		$count  = $this->countProject();
		$get 	= $this->db->get($this->table)->result_array();
		$response = array('count'=>$count,'data'=>$get);
		return $response;
	}

	public function countProject()
	{
		$count 	= $this->m->countResultAll($this->table);
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
		if($data['project_name'] != NULL && $data['project_code'] != NULL)
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
		if($data['project_name'] != NULL && $data['project_code'] != NULL)
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