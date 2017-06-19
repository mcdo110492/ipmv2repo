<?php

class Lunchbox_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->table1 	= 'lunchbox';
		$this->table2	= 'lunchboxGadget';
		$this->gadget 	= 'gadget';
	}

	public function getList($page,$limit,$order,$field,$filter,$limitpage,$offset,$project_id)
	{
		$data = array();
		if($order === '-order')
		{
			$order_by = 'DESC';
		}
		else
		{
			$order_by = 'ASC';
		}
		
		$query 		= $this->db->where('project_id',$project_id)->like($field,$filter)->order_by($field,$order_by)->get($this->table1)->result_array();
		foreach($query as $r)
		{
			$gadgets = $this->db->select('*')
					    ->from($this->table2)
					    ->join($this->gadget,$this->gadget.'.gadget_id='.$this->table2.'.gadget_id')
					    ->join('gadgetType as gt','gt.gadget_type_id='.$this->gadget.'.gadget_type_id','LEFT')
					    ->where($this->table2.'.lunchbox_id',$r['lunchbox_id'])
					    ->where($this->table2.'.lunch_box_gadget_status',1)
					    ->get()
					    ->result_array();
			$data [] = array('lunchbox_id'=>$r['lunchbox_id'],'lunchbox'=>$r['lunchbox'],'gadgets'=>$gadgets);
		}
		

		return $data;

	}

	

	public function count($project_id)
	{
		$where  = array('project_id'=>$project_id);
		$count 	= $this->m->countResult($this->table1,$where);
		return $count;
	}

	public function count2($where)
	{
		$count 	= $this->m->countResult($this->table1,$where);
		return $count;
	}

	public function checkData($where)
	{
		$count = $this->m->countResult($this->table1,$where);
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

	public function getGadgets($project_id)
	{
		$data 		= array();
		$where 		= array($this->gadget.'.project_id'=>$project_id,$this->gadget.'.gadget_status'=>1);
		$query 		= $this->db->select('*')->from($this->gadget)->join('gadgetType as gt','gt.gadget_type_id='.$this->gadget.'.gadget_type_id','LEFT')->where($where)->get()->result_array();
		foreach($query as $r)
		{
			$where2 = array('gadget_id'=>$r['gadget_id']);
			$checkR = $this->m->countResult($this->table2,$where2);
			if($checkR == 0)
			{
				$data [] = array('gadget_id'=>$r['gadget_id'],'gadget_code'=>$r['gadget_code'],'gadget_model'=>$r['gadget_model'],'gadget_type'=>$r['gadget_type']);
			}
			else 
			{
				$where3 = array('gadget_id'=>$r['gadget_id'],'lunch_box_gadget_status'=>1);
				$checkStatus = $this->m->countResult($this->table2,$where3);
				if($checkStatus == 0 )
				{
					$data [] = array('gadget_id'=>$r['gadget_id'],'gadget_code'=>$r['gadget_code'],'gadget_model'=>$r['gadget_model'],'gadget_type'=>$r['gadget_type']);
				}
			}
		}

		$response 		= array('data'=>$data);
		return $response;
	}

	public function getGadgets2($project_id,$lunchbox_id)
	{
		$data 		= array();
		$where 		= array($this->gadget.'.project_id'=>$project_id,$this->gadget.'.gadget_status'=>1);
		$query 		= $this->db->select('*')->from($this->gadget)->join('gadgetType as gt','gt.gadget_type_id='.$this->gadget.'.gadget_type_id','LEFT')->where($where)->get()->result_array();
		foreach($query as $r)
		{
			$where2 = array('gadget_id'=>$r['gadget_id']);
			$checkR = $this->m->countResult($this->table2,$where2);
			if($checkR == 0)
			{
				$data [] = array('gadget_id'=>$r['gadget_id'],'gadget_code'=>$r['gadget_code'],'gadget_model'=>$r['gadget_model'],'gadget_type'=>$r['gadget_type']);
			}
			else 
			{
				$where3 = array('gadget_id'=>$r['gadget_id'],'lunch_box_gadget_status'=>1);
				$checkStatus = $this->m->countResult($this->table2,$where3);
				if($checkStatus == 0 )
				{
					$where4 = array('gadget_id'=>$r['gadget_id'],'lunch_box_gadget_status'=>2,'lunchbox_id'=>$lunchbox_id);
					$check4 = $this->m->countResult($this->table2,$where4);
					if($check4 == 0)
					{
						$data [] = array('gadget_id'=>$r['gadget_id'],'gadget_code'=>$r['gadget_code'],'gadget_model'=>$r['gadget_model'],'gadget_type'=>$r['gadget_type']);
					}
				}
			}
		}

		$response 		= array('data'=>$data,'type'=>'gedget2');
		return $response;
	}

	public function getLunchboxGadgets($lunchbox_id,$project_id)
	{
		$where = array($this->table1.'.lunchbox_id'=>$lunchbox_id,$this->table1.'.project_id'=>$project_id);
		$query = $this->db->select('*')
				 ->from($this->table1)
				 ->join($this->table2,$this->table2.'.lunchbox_id='.$this->table1.'.lunchbox_id')
				 ->join($this->gadget,$this->gadget.'.gadget_id='.$this->table2.'.gadget_id')
				 ->join('gadgetType as gt','gt.gadget_type_id='.$this->gadget.'.gadget_type_id','LEFT')
				 ->where($where)
				 ->get()
				 ->result_array();
		return $query;
	}


	public function add($data,$gadgets)
	{
		if($data['lunchbox'] != NULL)
		{
			$this->db->trans_start();
			$this->db->insert($this->table1,$data);
			$lunchbox_id = $this->db->insert_id();
			foreach($gadgets as $g)
			{
				$array = array('lunchbox_id'=>$lunchbox_id,'gadget_id'=>$g,'lunch_box_gadget_status'=>1);
				$this->db->insert($this->table2,$array);
			}
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



	public function changeGadgetStatus($lunchbox_gadget_id,$gadget_id,$status,$project_id)
	{
		if($status == 1)
		{
			$activewhere  = array('gadget_id'=>$gadget_id,'lunch_box_gadget_status'=>1);
			$countActive  = $this->m->countResult($this->table2,$activewhere);
			if($countActive>0)
			{
				$currentActive = $this->db->where($activewhere)->get($this->table2)->row();
				$this->db->trans_start();
				if($lunchbox_gadget_id != $currentActive->lunchbox_gadget_id)
				{
					$data['lunch_box_gadget_status']	= 2;
					$this->db->where('lunchbox_gadget_id',$currentActive->lunchbox_gadget_id)->update($this->table2,$data);
				}
				$data2['lunch_box_gadget_status'] 	= 1;
				$this->db->where('lunchbox_gadget_id',$lunchbox_gadget_id)->update($this->table2,$data2);
				$this->db->trans_complete();
				if($this->db->trans_status())
				{
					$response = array('status'=>200);
				}
				else
				{
					$response = array('status'=>500);
				}

			}
			else
			{
				$data2['lunch_box_gadget_status'] 	= 1;
				$update = $this->db->where('lunchbox_gadget_id',$lunchbox_gadget_id)->update($this->table2,$data2);	
				if($update)
				{
					$response = array('status'=>200);
				}
				else
				{
					$response = array('status'=>500);
				}
			}
		}
		else
		{
			$data2['lunch_box_gadget_status'] 	= 2;
			$update = $this->db->where('lunchbox_gadget_id',$lunchbox_gadget_id)->update($this->table2,$data2);
			if($update)
			{
				$response = array('status'=>200);
			}
			else
			{
				$response = array('status'=>500);
			}
		}
		
		

		return $response;
		
	}


	public function addNewGadgets($data,$gadgets,$lunchbox_id)
	{
		
			$this->db->trans_start();
			foreach($gadgets as $g)
			{
				$array = array('gadget_id'=>$g,'lunch_box_gadget_status'=>1,'lunchbox_id'=>$lunchbox_id);
				$this->db->insert($this->table2,$array);
			}
			$this->db->trans_complete();
			if($this->db->trans_status())
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