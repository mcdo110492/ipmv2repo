<?php

class Main_model extends CI_Model {

	function __construct() {
    	parent::__construct();
    	date_default_timezone_set('Asia/Manila'); 

	}


	public function hashPassword($raw)
	{
		return password_hash($raw,PASSWORD_DEFAULT);
	}



	public function tokenEncode($token){
		$key = $this->config->item('jwt_key');
		return $jwt = JWT::encode($token,$key);
	}

	public function tokenDecode($header){
		$extract = explode(" ", $header);
		$token = end($extract);
		$key = $this->config->item('jwt_key');
		$algo = $this->config->item('encryption_key');
		return $jwt = JWT::decode($token,$key,$algo);
	}
	
	public function getDate()
	{
		$date 	= new DateTime();
		return $date->format('Y-m-d');
	}

	public function getDateTime()
	{
		$dateTime 	= new DateTime();
		return $dateTime->format('Y-m-d H:i:s');
	}

	public function convertTimestamp($date)
	{
		$timestamp	=	strtotime($date);
		return 	$timestamp;
	}

	public function formatDate($date)
	{
		$format 	= new DateTime($date);
		$dateFormatted	= $format->format('Y-m-d');
		return $dateFormatted;
	}

	public function formatDateTime($dateTime)
	{
		$format 	= new DateTime($dateTime);
		$dateTimeFormatted	= $format->format('Y-m-d H:i:s');
		return $dateTimeFormatted;
	}

	public function formatTime($time)
	{
		$format 	= new DateTime($time);
		$timeFormatted 	= $format->format('H:i:s');
		return $timeFormatted;
	}

	public function addDateTime($dateTime)
	{
		$format 	= new DateTime($dateTime);
		$alter 		= $format->modify('+6 hours');
		$formatted  = $format->format('Y-m-d H:i:s');
		return $formatted;
	}

	public function uploadFiles($userFile,$allowedTypes,$uploadPath)
	{
		$config['upload_path']          = $uploadPath;
        $config['allowed_types']        = $allowedTypes;
        $config['max_size']             = 5000;
        $config['overwrite']			= false;
        $config['encrypt_name']			= true;
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($userFile))
        {
                $response = array('status'=>500,'msg'=>'Something Went Wrong.','error' => $this->upload->display_errors());
        }
        else
        {
                $response = array('status' => 200,'msg'=>'File Uploaded Successfully.','file_name'=>$this->upload->data('file_name'));

                
        }

        return $response;
         
	}

	public function countResult($table,$where)
	{
		return $this->db->where($where)->count_all_results($table);
	}

	public function countResultAll($table)
	{
		return $this->db->count_all_results($table);
	}

	public function getSingleRow($table,$where,$field)
	{
		$count 	= $this->countResult($table,$where);
		if($count>0)
		{
			$data = $this->db->where($where)->get($table)->row()->$field;
		}
		else
		{
			$data = '';
		}

		return $data;
	}

	public function getRow($table,$where)
	{
		$count 	= $this->countResult($table,$where);
		if($count>0)
		{
			$data = $this->db->where($where)->get($table)->row();
			$response = array('status'=>200,'data'=>$data);
		}
		else
		{
			$response = array('status'=>404);
		}

		return $response;
	}


	public function addData($table,$data)
	{
		$insert 	= $this->db->insert($table,$data);
		return $insert;
	}

	public function updateData($table,$data,$where)
	{
		$update 	= $this->db->where($where)->update($table,$data);
		return $update;
	}

}
?>