<?php
require (APPPATH . 'libraries/REST_Controller.php');

class EmployeeDetails extends REST_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('employeeDetails_model', 'edm');
		$header = $this->input->get_request_header('Authorization', TRUE);
		try {
			$this->token = $this->m->tokenDecode($header);
			$this->project = $this->token->project_id;
			if($this->token->role == 1 OR $this->token->role == 2 OR $this->token->role == 3)
			{
				$this->access = 777;
			}
			else if($this->token->role > 3)
			{
				$this->access = 766;
			}
			else
			{
				$this->response(array(
					'error' => 'Error'
				) , 403);
				exit(1);
			}
			
			
		} catch (Exception $e) {
			$this->response(array(
				'error' => 'Error'
			) , 400);

			exit(1);
		}
	
	}


	public function employeeDetails_get()
	{
		
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$id 		= $this->get('employee_id');
		$count 		= $this->edm->countEmployee($id,$project);
		$get 		= $this->edm->getBasicInfo($id,$project);
		$response 	= array('status'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function employeeDetails_post()
	{
		if($this->access == 777)
		{
			$project 						= $this->project;
			$data['firstname']				= $this->post('firstname');
			$data['middlename']				= $this->post('middlename');
			$data['lastname']				= $this->post('lastname');
			$data['dob']					= $this->m->formatDate($this->post('dob'));
			$data['pob']					= $this->post('pob');
			$data['height']					= $this->post('height');
			$data['weight']					= $this->post('weight');
			$data['blood']					= $this->post('blood');
			$data['distinguishing_mark']	= $this->post('distinguishing_mark');
			$data['civil_status']			= $this->post('civil_status');
			$data['citizenship']			= $this->post('citizenship');
			$data['religion']				= $this->post('religion');
			$where 							= array('employee_id'=>$this->post('employee_id'));
			$update 						= $this->edm->updateEmployeeInfo($where,$data,$project,6);
			$this->response($update);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}		
	}

	public function employeeContact_get()
	{
		
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$id 		= $this->get('employee_id');
		$count 		= $this->edm->countEmployee($id,$project);
		$get 		= $this->edm->getContactInfo($id,$project);
		$response 	= array('status'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function employeeContact_post()
	{
		if($this->access == 777)
		{
			$project 								= $this->project;
			$data['present_address']				= $this->post('present_address');
			$data['provincial_address']				= $this->post('provincial_address');
			$data['cel_no']							= $this->post('cel_no');
			$data['tel_no']							= $this->post('tel_no');
			$where 									= array('employee_id'=>$this->post('employee_id'));
			$update 								= $this->edm->updateEmployeeInfo($where,$data,$project,1);
			$this->response($update);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}		
	}

	public function employeeEmployment_get()
	{
		
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$id 		= $this->get('employee_id');
		$count 		= $this->edm->countEmployee($id,$project);
		$get 		= $this->edm->getEmploymentInfo($id,$project);
		$response 	= array('status'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function employeeEmployment_post()
	{
		if($this->access == 777)
		{
			$project 								= $this->project;
			$data['position_id']					= $this->post('position_id');
			$data['date_employed']					= $this->m->formatDate($this->post('date_employed'));
			$data['date_retired']					= $this->m->formatDate($this->post('date_retired'));
			$data['employee_status_id']				= $this->post('employee_status_id');
			$data['employment_status_id']			= $this->post('employment_status_id');
			$data['salary']							= $this->post('salary');
			$data['remarks']						= $this->post('remarks');
			$where 									= array('employee_id'=>$this->post('employee_id'));
			$update 								= $this->edm->updateEmployeeInfo($where,$data,$project,3);
			$this->response($update);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}		
	}

	public function employeeEducation_get()
	{
		
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$id 		= $this->get('employee_id');
		$count 		= $this->edm->countEmployee($id,$project);
		$get 		= $this->edm->getEducationInfo($id,$project);
		$response 	= array('status'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function employeeEducation_post()
	{
		if($this->access == 777)
		{
			$data['school_name']					= $this->post('school_name');
			$data['school_address']					= $this->post('school_address');
			$data['school_year']					= $this->post('school_year');
			$data['degree']							= $this->post('degree');
			$data['honors']							= $this->post('honors');
			$data['major']							= $this->post('major');
			$data['minor']							= $this->post('minor');
			$data['employee_id']					= $this->post('employee_id');
			$insert 								= $this->edm->addData($data,2);
			$this->response($insert);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeEducation_put()
	{
		if($this->access == 777)
		{
			$data['school_name']					= $this->put('school_name');
			$data['school_address']					= $this->put('school_address');
			$data['school_year']					= $this->put('school_year');
			$data['degree']							= $this->put('degree');
			$data['honors']							= $this->put('honors');
			$data['major']							= $this->put('major');
			$data['minor']							= $this->put('minor');
			$where 									= array('employee_education_id'=>$this->put('employee_education_id'));
			$insert 								= $this->edm->updateData($data,$where,2);
			$this->response($insert);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeGovernment_get()
	{
		
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$id 		= $this->get('employee_id');
		$count 		= $this->edm->countEmployee($id,$project);
		$get 		= $this->edm->getGovernmentInfo($id);
		$response 	= array('status'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function employeeGovernment_post()
	{
		if($this->access == 777)
		{
			$project 								= $this->project;
			$data['sss']							= $this->post('sss');
			$data['pag_ibig']						= $this->post('pag_ibig');
			$data['tin']							= $this->post('tin');
			$data['philhealth']						= $this->post('philhealth');
			$where 									= array('employee_id'=>$this->post('employee_id'));
			$update 								= $this->edm->updateEmployeeInfo($where,$data,$project,5);
			$this->response($update);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}		
	}

	public function employeeLicense_get()
	{
		
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$id 		= $this->get('employee_id');
		$count 		= $this->edm->countEmployee($id,$project);
		$get 		= $this->edm->getLicenseInfo($id);
		$response 	= array('status'=>$count,'data'=>$get);
		$this->response($response);
	}


	public function employeeLicense_post()
	{
		if($this->access == 777)
		{
			$data['license_no']						= $this->post('license_no');
			$data['license_type']					= strtoupper($this->post('license_type'));
			$data['date_issued']					= $this->m->formatDate($this->post('school_year'));
			$data['date_expired']					= $this->m->formatDate($this->post('date_expired'));
			$data['license_file']					= 'default.jpg';
			$data['employee_id']					= $this->post('employee_id');
			$insert 								= $this->edm->addData($data,7);
			$this->response($insert);	

		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeLicense_put()
	{
		if($this->access == 777)
		{
			$data['license_no']						= $this->put('license_no');
			$data['license_type']					= strtoupper($this->put('license_type'));
			$data['date_issued']					= $this->m->formatDate($this->put('school_year'));
			$data['date_expired']					= $this->m->formatDate($this->put('date_expired'));
			$data['employee_id']					= $this->put('employee_id');
			$where 									= array('employee_license_id'=>$this->put('employee_license_id'));
			$insert 								= $this->edm->updateData($data,$where,7);
			$this->response($insert);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	

	public function employeeLicenseUpload_post()
	{
		if($this->access == 777)
		{
			$allowedTypes	= 'jpg|jpeg';
			$uploadPath 	= '../ipmrepository/license/';
			$upload 		= $this->m->uploadFiles('userfile1',$allowedTypes,$uploadPath);
			if($upload['status'] == 200)
			{
				$where 									= array('employee_license_id'=>$this->post('employee_license_id'));
				$data['license_file']					= $upload['file_name'];
				$update 								= $this->edm->updateData($data,$where,7);
				if($update)
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
				$response 	= $upload;
			}
			$this->response($response);
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeFamily_get()
	{
		
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$id 		= $this->get('employee_id');
		$count 		= $this->edm->countEmployee($id,$project);
		$get 		= $this->edm->getFamilyInfo($id);
		$response 	= array('status'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function employeeFamily_post()
	{
		if($this->access == 777)
		{
			$data['family_name']					= strtoupper($this->post('family_name'));
			$data['family_occupation']				= strtoupper($this->post('family_occupation'));
			$data['family_dob']						= $this->m->formatDate($this->post('family_dob'));
			$data['family_address']					= strtoupper($this->post('family_address'));
			$data['family_relation']				= strtoupper($this->post('family_relation'));
			$data['employee_id']					= $this->post('employee_id');
			$insert 								= $this->edm->addData($data,4);
			$this->response($insert);	

		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeFamily_put()
	{
		if($this->access == 777)
		{
			$data['family_name']					= strtoupper($this->put('family_name'));
			$data['family_occupation']				= strtoupper($this->put('family_occupation'));
			$data['family_dob']						= $this->m->formatDate($this->put('family_dob'));
			$data['family_address']					= strtoupper($this->put('family_address'));
			$data['family_relation']				= strtoupper($this->put('family_relation'));
			$where 									= array('employee_family_id'=>$this->put('employee_family_id'));
			$insert 								= $this->edm->updateData($data,$where,4);
			$this->response($insert);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeTraining_get()
	{
		
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$id 		= $this->get('employee_id');
		$count 		= $this->edm->countEmployee($id,$project);
		$get 		= $this->edm->getTrainingInfo($id);
		$response 	= array('status'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function employeeTraining_post()
	{
		if($this->access == 777)
		{
			$data['training_nature']				= strtoupper($this->post('training_nature'));
			$data['training_title']					= strtoupper($this->post('training_title'));
			$data['training_period_to']				= $this->m->formatDate($this->post('training_period_to'));
			$data['training_period_from']			= $this->m->formatDate($this->post('training_period_from'));
			$data['employee_id']					= $this->post('employee_id');
			$insert 								= $this->edm->addData($data,8);
			$this->response($insert);	

		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeTraining_put()
	{
		if($this->access == 777)
		{
			$data['training_nature']				= strtoupper($this->put('training_nature'));
			$data['training_title']					= strtoupper($this->put('training_title'));
			$data['training_period_to']				= $this->m->formatDate($this->put('training_period_to'));
			$data['training_period_from']			= $this->m->formatDate($this->put('training_period_from'));
			$where 									= array('employee_training_seminar_id'=>$this->put('employee_training_seminar_id'));
			$insert 								= $this->edm->updateData($data,$where,8);
			$this->response($insert);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeClub_get()
	{
		
		$project 	= $this->token->role == 1 ? $this->get('project_id') : $this->project;
		$id 		= $this->get('employee_id');
		$count 		= $this->edm->countEmployee($id,$project);
		$get 		= $this->edm->getClubInfo($id);
		$response 	= array('status'=>$count,'data'=>$get);
		$this->response($response);
	}

	public function employeeClub_post()
	{
		if($this->access == 777)
		{
			$data['club_name']						= strtoupper($this->post('club_name'));
			$data['club_position']					= strtoupper($this->post('club_position'));
			$data['club_membership']				= strtoupper($this->post('club_membership'));
			$data['employee_id']					= $this->post('employee_id');
			$insert 								= $this->edm->addData($data,0);
			$this->response($insert);	

		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeClub_put()
	{
		if($this->access == 777)
		{
			$data['club_name']						= strtoupper($this->put('club_name'));
			$data['club_position']					= strtoupper($this->put('club_position'));
			$data['club_membership']				= strtoupper($this->put('club_membership'));
			$where 									= array('employee_club_id'=>$this->put('employee_club_id'));
			$insert 								= $this->edm->updateData($data,$where,0);
			$this->response($insert);		
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}


	public function employeeImageUpload_post()
	{
		if($this->access == 777)
		{
			$allowedTypes	= 'jpg|jpeg';
			$uploadPath 	= '../ipmrepository/profilePicture/';
			$upload 		= $this->m->uploadFiles('userfile',$allowedTypes,$uploadPath);
			if($upload['status'] == 200)
			{
				$where 									= array('user_id'=>$this->post('user_id'));
				$data['profile_pic']					= $upload['file_name'];
				$update 								= $this->edm->updateData($data,$where,10);
				if($update)
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
				$response 	= $upload;
			}
			$this->response($response);
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}


	public function employeeAccount_get()
	{
		if($this->access == 777)
		{
			$id 		= $this->get('employee_id');
			$get 		= $this->edm->getAccountInfo($id);
			$response 	= array('data'=>$get);
			$this->response($response);
		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeAccount_post()
	{
		if($this->access == 777)
		{
			
			$data['password']						= $this->m->hashPassword($this->post('username')); 
			$where 									= array('user_id'=>$this->post('user_id'));
			$update 								= $this->edm->updateData($data,$where,10);
			if($update)
			{
					$response = array('status'=>200);
			}
			else
			{
					$response = array('status'=>500);
			}
			$this->response($response);	

		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}

	public function employeeAccount_put()
	{
		if($this->access == 777)
		{
			
			$data['status']							= $this->put('status');
			$where 									= array('user_id'=>$this->put('user_id'));
			$update 								= $this->edm->updateData($data,$where,10);
			if($update)
			{
					$response = array('status'=>200);
			}
			else
			{
					$response = array('status'=>500);
			}
			$this->response($response);	

		}
		else
		{

				$this->response(array(
					'error' => 'Error'
				) , 403);
		}	
	}




	
}

?>