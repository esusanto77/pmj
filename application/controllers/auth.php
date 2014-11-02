<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('query');
	}

	// public function index()
	// {
	// 	redirect(base_url());
	// }

	public function register()
	{

		// save the user 
		if(get_age(strip_tags($this->input->post("birth"))) < 27){
			$data['notif'] = 'Minimal age is 27';
			$data['auth'] = $this->input->post();
			$data['city'] = $this->query->get("city",array());	
			$data['script'] = array("datepicker");
			$this->load->view('auth/register',$data);
		}
		elseif(
			$_POST &&
			$this->input->post("name") !== "" &&
			$this->input->post("email") !== "" && 
			$this->input->post("password") !== "" &&
			$this->input->post("birth") !== "" &&
			$this->input->post("gender") !== "" &&
			$this->input->post("city") !== ""
			){
		$data['name'] = strip_tags($this->input->post('name'));
		$data['email'] = strip_tags($this->input->post('email'));
		$data['password'] = md5($this->input->post('password'));			
		$data['code_id'] = getNewCode();
		$data['prefix'] = 0;
		$data['validate'] = 0;
		$data['reg_code'] = md5(getNewCode());	
		$data['gender'] = strip_tags($this->input->post('gender'));
		$data['city'] = strip_tags($this->input->post('city'));
		$data['birthday'] = strip_tags($this->input->post('birth'));		
		$data['submit_date'] = date("Y-m-d H:i:s");
		$data['first_login'] = date("Y-m-d H:i:s");
		$data['social_id'] = '';
		$data['forget_code'] = '';
		$data['login_with'] = '';

		$uid = $this->query->save("member",$data);			
		$code_id = $this->query->get("pmj_member",array("where"=>array("id" => $uid)));

		$cookie = array(
					'name'   => 'rememberMe',
					'value'  => 'TRUE',
					'expire' => '7200'
				);
			

		$this->input->set_cookie($cookie);

		$array = array(
			'uid' => $uid,
			'uname' => $data['name'],
			'gender'=>$data['gender'],
			'subscription' =>checkExpiredUserSessionSubscription($check[0]->id),
			'code_id'=> $code_id[0]->code_id
			);

		$activity['act_from_user'] = strip_tags($uid);
		$activity['act_to_user'] = strip_tags($uid);
		$activity['act_label'] = strip_tags('login');
		$activity['act_date'] = date("Y-m-d H:i:s");

		insertActivity($activity);

		$this->session->set_userdata( $array );

		// send email validated
		sendEmail("signup",$uid);

		redirect(base_url('question'));
	} else {				
		$data['notif'] = 'all forms are required';
		$data['auth'] = $this->input->post();
		$data['city'] = $this->query->get("city",array());	
		$data['script'] = array("datepicker");
		$this->load->view('auth/register',$data);
	}				
}


public function login()
{
	if(getSessionUser() != ""){
		redirect(base_url());
	}

	if($this->input->post("email")){	
		$array['email'] = $this->input->post("email");
		$array['password'] = md5($this->input->post("password"));
		$rememberMe = $this->input->post("rememberMe");

		$check = $this->query->get("member",array("where"=>$array));


		if(!empty($check)){

			if(empty($check[0]->first_login)){
				$this->query->update("pmj_member",array("first_login"=>date("Y-m-d h:i:s")),array("id"=>$check[0]->id));
			}
		
			$session = array(
				'uid' => $check[0]->id,
				'code_id' => $check[0]->code_id,
				'uname' => $check[0]->name,
				'gender' => $check[0]->gender,
				'subscription' => checkExpiredUserSessionSubscription($check[0]->id)
				);

	 		curl_best_match($check[0]->id);

			foreach ($check[0] as $key => $value) {
				$session[$key] = $value;
			}

			if($rememberMe){
				$cookie = array(
					'name'   => 'rememberMe',
					'value'  => 'TRUE',
					'expire' => '604800'
				);
			}else{
				$cookie = array(
					'name'   => 'rememberMe',
					'value'  => 'TRUE',
					'expire' => '7200'
				);
			}
			
			$activity['act_from_user'] = strip_tags($check[0]->id);
			$activity['act_to_user'] = strip_tags($check[0]->id);
			$activity['act_label'] = strip_tags('login');
			$activity['act_date'] = date("Y-m-d H:i:s");

			insertActivity($activity);


			$this->input->set_cookie($cookie);

			$this->session->set_userdata( $session );

			if($this->session->userdata('gift_code_not_login')===true){
				$url = 'product/payment/'.$this->session->userdata("id_product_gift");
			}else{
				$url = 'welcome';
			}

			redirect(freshdeskLoginUrl($this->session->userdata('uname'),$array['email'],$url));
		}else{
			 $this->session->set_flashdata('invalidLogin', "Oops.. , Wrong email or password combination.");
		}

	}else{
		 $this->session->set_flashdata('invalidLogin', "Oops.. , Email or Password must be filled.");
	}
		redirect(base_url("welcome")."/index");
}

public function FBLogin()
{
	$user_id = $this->facebook->getUser();

	if ($user_id) {
		try {
			$user_profile = $this->facebook->api('/me');                

                // check the email first
			$get = $this->query->get("member",array("where"=>array("email"=>$user_profile['email'])));

			if(!empty($get)){
				$uid = $get[0]->id;
				$data['name'] = $get[0]->name;
			} else {

				$date = explode("/", $user_profile['birthday']);

				$data['name'] = $user_profile['name'];
				$data['email'] = $user_profile['email'];
				$data['password'] = "facebook_login";			
				$data['code_id'] = getNewCode();
				$data['prefix'] = 0;
				$data['reg_code'] = 0;	
				$data['social_id'] = $user_id;
				$data['login_with'] = "facebook";		
				$data['submit_date'] = date("Y-m-d H:i:s");
				$data['gender'] = $user_profile['gender'];		
				$data['birthday'] = $date[2]."-".$date[0]."-".$date[1];
				$uid = $this->query->save("member",$data);

				if(!empty($user_profile['gender'])){
					saveUserMeta($uid,"gender",$user_profile['gender']);
				}
				if(!empty($user_profile['birthday'])){
					$date = explode("/", $user_profile['birthday']);
					saveUserMeta($uid,"birth",$date[2]."/".$date[0]."/".$date[1]);
				}
			}

			$code_id = $this->query->get("pmj_member",array("where"=>array("id" => $uid)));

			$cookie = array(
					'name'   => 'rememberMe',
					'value'  => 'TRUE',
					'expire' => '7200'
				);
			

			$this->input->set_cookie($cookie);

			if(empty($check[0]->first_login)){
				$this->query->update("pmj_member",array("first_login"=>date("Y-m-d h:i:s")),array("id"=>$uid));
			}

			$array = array(
				'uid' => $uid,
				'uname' => $data['name'],
				'gender'=>$data['gender'],
				'subscription' => checkExpiredUserSessionSubscription($check[0]->id),
				'code_id'=> $code_id[0]->code_id,
				'login_third_party' => 'true'
				);


			$activity['act_from_user'] = strip_tags($uid);
			$activity['act_to_user'] = strip_tags($uid);
			$activity['act_label'] = strip_tags('login');
			$activity['act_date'] = date("Y-m-d H:i:s");

			insertActivity($activity);
			

			curl_best_match($uid);

			$this->session->set_userdata( $array );

			if($this->session->userdata('gift_code_not_login')===true){
				$url = 'product/payment/'.$this->session->userdata("id_product_gift");
			}else{
				$url = 'welcome';
			}

			redirect(freshdeskLoginUrl($this->session->userdata('uname'),$array['email'],$url));

		} catch (FacebookApiException $e) {
			$user_id = null;
			print_r($e);exit;
		}
	}else {
		redirect(base_url());
	}
}

public function loginWithLinkedin()
{

		// // OAuth 2 Control Flow
	if ($this->input->get('error') != "") {
		    // LinkedIn returned an error
		print $this->input->get('error') . ': ' . $this->input->get('error_description');
		exit;
	} elseif ($this->input->get('code') != "") {

		    // User authorized your application
		if ($this->session->userdata('state') == $this->input->get('state')) {
		        // Get token so you can make API calls
			$this->linkedin->getAccessToken();
		} else {
		        // CSRF attack? Or did you mix up your states?
			exit;
		}
	} else { 			
		if (($this->session->userdata('expires_at') == "" ) || (time() > $this->session->userdata('expires_at'))) {
		        // Token has expired, clear the state		        
		}
		if ($this->session->userdata('access_token') == "") {
		        // Start authorization process
			$this->linkedin->getAuthorizationCode();
		}
	}

		// //Congratulations! You have a valid token. Now fetch your profile 
	$user = $this->linkedin->fetch('GET', '/v1/people/~:(id,firstName,lastName,emailAddress)');
		//print "Hello $user->id $user->firstName $user->lastName $user->emailAddress.";

		// check the email first
	$get = $this->query->get("member",array("where"=>array("email"=>$user->emailAddress)));

	if(!empty($get)){
		$uid = $get[0]->id;
		$data['name'] = $user->firstName." ".$user->lastName;
	} else {
		$data['name'] = $user->firstName." ".$user->lastName;
		$data['email'] = $user->emailAddress;
		$data['password'] = "linkedin_login";			
		$data['code_id'] = getNewCode();
		$data['prefix'] = 0;
		$data['reg_code'] = 0;		
		$data['social_id'] = $user->id;
		$data['login_with'] = "linkedin";
		$data['submit_date'] = date("Y-m-d H:i:s");
		$uid = $this->query->save("member",$data);
	}

	$code_id = $this->query->get("pmj_member",array("where"=>array("id" => $uid)));

	$cookie = array(
			'name'   => 'rememberMe',
			'value'  => 'TRUE',
			'expire' => '7200'
		);
	

	$this->input->set_cookie($cookie);

	if(empty($check[0]->first_login)){
			$this->query->update("pmj_member",array("first_login"=>date("Y-m-d h:i:s")),array("id"=>$uid));
		}

	$array = array(
		'uid' => $uid,
		'uname' => $data['name'],
		'gender'=>$data['gender'],
		'subscription' => checkExpiredUserSessionSubscription($check[0]->id),
		'code_id'=> $code_id[0]->code_id,
		'login_third_party' => 'true'
		);

	$activity['act_from_user'] = strip_tags($uid);
	$activity['act_to_user'] = strip_tags($uid);
	$activity['act_label'] = strip_tags('login');
	$activity['act_date'] = date("Y-m-d H:i:s");

	insertActivity($activity);

	curl_best_match($uid);

	$this->session->set_userdata( $array );

	if($this->session->userdata('gift_code_not_login')===true){
		$url = 'product/payment/'.$this->session->userdata("id_product_gift");
	}else{
		$url = 'welcome';
	}

	redirect(freshdeskLoginUrl($this->session->userdata('uname'),$array['email'],$url));
}



public function logout()
{
	$cookie = array(
			'name'   => 'rememberMe',
			'value'  => ''
	);
			
	$this->input->set_cookie($cookie);

	$this->session->sess_destroy();
	redirect(base_url());
}

public function forgotPassword()
	{
		$md5 = md5($this->input->post("email").date("ymdhis"));
		$data = array("forget_code"=>$md5);
		$where = array("email"=>$this->input->post("email"));
		$this->query->update("member",$data,$where);


		// sending email
		$this->load->library('email');
		
		$this->email->from('noreply@pmjakarta.com');
		$this->email->to($this->input->post("email"));		
		$this->email->subject('Reset Password at PMJakarta.com');
		$this->email->message('hi, someone was requested to reset your passsword. if you want to reset your password click this link <br> <a href='.base_url('auth/resetPassword/'.$md5).'>'.base_url('auth/resetPassword/'.$md5).'</a> <br> if it not you, just ignore it :) thanks ');
		
		$this->email->send();		
	}

	public function resetPassword($forget_code)
	{
		if(!empty($forget_code)){
				if($this->input->post("submit")){
					if( ($this->input->post("password") == $this->input->post("check_password")) && ($this->input->post("password") !== '') ){

						$update['password']  =  md5($this->input->post("password"));
						$update['forget_code'] = "";
						$where['forget_code'] = $forget_code;

						$this->query->update("member",$update,$where);						
						$data['alert'] = 1;
					} else {						
						$data['alert'] = 2;
					}
				} 

				$data['user'] = $this->query->get("member", array("where" => array("forget_code"=>$forget_code)));
				if( empty($data['user'])){
					$data['alert'] = 3;
					redirect(base_url());
				}
				$data['bodyClass'] = 'resetPassword';
				$this->load->view('auth/resetPassword', $data);
		}
	}

	public function validate($code)
	{
		$user = $this->query->get("member",array("where"=>array("reg_code"=>$code)));
		if(!empty($user)){
			$data = array("validate"=>1);
			$where = array("reg_code"=>$code);
			$this->query->update("member",$data,$where);
			$this->load->view('auth/validate');
		} else {
			redirect(base_url());
		}
	}

}

/* End of file untitled */
/* Location: ./application/controllers/untitled */