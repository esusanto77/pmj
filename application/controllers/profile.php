<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here

		if(getSessionUser() == ""){
			redirect("auth/login");
		}


		$this->load->model('query');

		checkHoursVerification();
	}

	public function index()
	{
		$data['avatar'] = $this->query->get("pmj_avatar_photo",array("where"=>array("gender"=>getSessionGender()),"order","id asc"));

		$notif = "";
		$sukses = "";
		if($this->uri->segment(2) == "edit"){			
			if($this->input->post("submit")){

				$notif = $sukses = "";
				$allUpdate = 0;
				
				if(get_age(strip_tags($this->input->post("birth"))) < 27){
					$notif = $notif . "<li>Minimal age is 27</li>";
				}elseif($this->input->post("name") != "" && $this->input->post("email") != "" && $this->input->post("birth") != ""){					
					$update["name"] = strip_tags($this->input->post("name"));
					$update["email"] = strip_tags($this->input->post("email"));
					$update["birthday"] = strip_tags($this->input->post("birth"));
					$update["gender"] = strip_tags($this->input->post("gender"));
					$update["city"] = strip_tags($this->input->post("city"));
					$where["id"] = getSessionUser();
					$this->query->update("member",$update,$where);

					$this->session->set_userdata('uname', $update["name"]);
				} else {
					$notif = $notif . "<li>Fill all field</li>";
				}

				$current_password = $this->input->post("current_password");
				$new_password = $this->input->post("new_password");
				$confirm_password = $this->input->post("confirm_password");

				if(!empty($current_password)){
					// check if all field was filled 
					if(!empty($current_password) || !empty($new_password) || !empty($current_password)){
						// check if new and confirm are same
						if($new_password == $confirm_password){
							// check if password correct
							$check = $this->query->get("member",array("where"=>array("id"=>getSessionUser(),"password"=>md5($current_password))));
							if(!empty($check)){
								// update the password
								$this->query->update(
										"member",
										array("password"=>md5($new_password)),
										array("id"=>getSessionUser())
									);
								$sukses = $sukses . "<li>Password Update Successfull</li>";
								$allUpdate += 1;
							} else {
								$notif = $notif . "<li>Current Password not match</li>";
							}
						} else {
							$notif = $notif . "<li>New Password and Confirm Password must be same</li>";	
						}
					} else {
						$notif = $notif . "<li>Fill all password field</li>";
					}
				}else{
					if($this->input->post("name") != "" && $this->input->post("email") != "" && $this->input->post("birth") != "" && get_age(strip_tags($this->input->post("birth"))) > 27){		
						$sukses = $sukses . "<li>Profile Update Successfull</li>";
					}		
				}

				if($allUpdate==1){
					$sukses = "";
					$sukses = "<li>Profile and Password Update Successfull</li>";
				}

			}
			$data['notif'] = $notif;
			$data['sukses'] = $sukses;
			$array['id'] = getSessionUser();
			$user = $this->query->get("member",array("where"=>$array));
			$data['user'] = $user[0];			
			$data['bodyClass'] = "edit-profile";
			$this->load->view('user/profile_edit', $data);	
		} else {

		

			if($this->uri->segment(2)){
				$array['code_id'] = $this->uri->segment(2);
				$user = $this->query->get("member",array("where"=>$array));

				foreach ($user as $key => $value) {
					$match_gender = $value->gender;
				}
				if($match_gender == 'Male'){
				$data['gender'] = 'Female';
				} else if($match_gender == 'Female'){
					$data['gender'] = 'Male';
				}

				$data['user'] = $user[0];
				$data['title'] = $user[0]->code_id;
				$data['bodyClass'] = "profile";
				$this->load->view('user/profile', $data);
			} else {						
				$array['id'] = getSessionUser();
				$user = $this->query->get("member",array("where"=>$array));

				foreach ($user as $key => $value) {
					$match_gender = $value->gender;
				}
				if($match_gender == 'Male'){
				$data['gender'] = 'Female';
				} else if($match_gender == 'Female'){
					$data['gender'] = 'Male';
				}

				$data['user'] = $user[0];
				$data['bodyClass'] = "profile";
				$this->load->view('user/profile', $data);
			}
			
				
		}		
	}

}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */