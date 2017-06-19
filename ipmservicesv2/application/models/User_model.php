<?php

class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table 	= 'user';
	}

	public function getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project_id,$role)
	{

		if($order === '-order')
		{
			$order_by = 'DESC';
		}
		else
		{
			$order_by = 'ASC';
		}
		$data 		= array();
		if($role == 1)
		{
			$where 		= array('project_id'=>$project_id,'role !='=>13);	
		}
		else {
			$where 		= array('project_id'=>$project_id,'role !='=>13,'role !='=>2);
		}
		
		
		$query		=	$this->db->where($where)
						->like($field,$filter)
						->limit($limit, $offset)
						->order_by($field, $order_by)
						->get($this->table)
						->result_array();
		foreach($query as $r)
		{
			$data[] = array('username'=>$r['username'],'profile_name'=>$r['profile_name'],'role_name'=>$this->selectRole($r['role']),'profile_pic'=>$r['profile_pic'],'user_id'=>$r['user_id'],'status'=>$r['status']);
		}	

		return $data;

	}


	public function selectRole($role)
	{
		$where = array('role'=>$role);
		$table = 'userRole';
		$count = $this->m->countResult($table,$where);
		if($count>0)
		{
			$get = $this->db->where($where)->get($table)->row()->role_name;
		}
		else
		{
			$get = '';
		}
		
		return $get;
	}

	

	public function count($project_id,$role)
	{
		if($role == 1)
		{
			$where  = array('project_id'=>$project_id,'role !='=>13);
		}	
		else
		{
			$where  = array('project_id'=>$project_id,'role !='=>13,'role !='=>2);
		}
		
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


	public function getRole($role)
	{
		if($role == 1)
		{
			$query 	= $this->db->get('userRole')->result_array();
		}
		else
		{
			$where = array('role !='=>2);
			$query 	= $this->db->where($where)->get('userRole')->result_array();
		}
		
		$response = array('data'=>$query);
		return $response;
	}


	public function add($data)
	{
		if($data['username'] != NULL)
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