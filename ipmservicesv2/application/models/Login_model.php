<?php
class Login_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->table 	= 'user';
	}

	public function authenticate($username,$rawPassword)
	{
		$where 				= array('username'=>$username);
		$checkUsername 		= $this->m->countResult($this->table,$where);
		if($checkUsername>0)
		{
			$hashPassword 	= $this->m->getSingleRow($this->table,$where,'password');
			$verifyPassword = password_verify($rawPassword,$hashPassword);
			if($verifyPassword)
			{
				$rows 		= $this->m->getRow($this->table,$where);
				if($rows['status'] == 200)
				{
					$row 	= $rows['data'];
					if($row->role == 12)
					{
						$employee 		= $this->db->select('ei.employee_id,ei.firstname,ei.middlename,ei.lastname')->from('employeeUser as eu')->join('employeeInformation as ei','ei.employee_id=eu.employee_id')->get()->row();
						$profileName 	= $employee->firstname.' '.$employee->middlename.' '.$employee->lastname; 
						$data 			= array('user_id'=>$row->user_id,'profile_name'=>$profileName,'role'=>$row->role,'status'=>$row->status,'profilePic'=>$row->profile_pic,'project_id'=>$row->project_id);
						$token 			= $this->tokenizer($data);

					}
					else
					{
						$data 			= array('user_id'=>$row->user_id,'profile_name'=>$row->profile_name,'role'=>$row->role,'status'=>$row->status,'profilePic'=>$row->profile_pic,'project_id'=>$row->project_id);
						$token 			= $this->tokenizer($data);
					}

					if($data['status'] == 1)
					{
						$response 	= array('status'=>200,'tokenizer'=>$token,'profileName'=>$data['profile_name'],'profilePicture'=>$data['profilePic'],'userType'=>$data['role']);
					}
					else
					{
						$response 	= array('status'=>403,'msg'=>'Account Locked.');
					}
					
					
				}
				else
				{
					$response 	= array('status'=>404);
				}
				
			}
			else
			{
				$response 	= array('status'=>404);
			}
		}
		else
		{
			$response 	= array('status'=>404);
		}

		return $response;
	}

	public function tokenizer($data)
	{
		$dateTime 				= 	$this->m->getDateTime();
		$token['iss']			=	'ipm';
		$token['iat']			= 	$this->m->convertTimestamp($dateTime);
		$token['nbf']			= 	$this->m->convertTimestamp($dateTime);
		$token['exp']			= 	$this->m->convertTimestamp($this->m->addDateTime($dateTime));
		$token['jti']			=	uniqid($data['user_id'],true);
		$token['userId']		= 	$data['user_id'];
		$token['profileName']	=	$data['profile_name'];
		$token['role']			= 	$data['role'];
		$token['project_id']	=	$data['project_id'];
		$encode 				= 	$this->m->tokenEncode($token);
		return $encode;
	}
}
?>