<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verification extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('query');
		
		if(getSessionUser() < 1){
			redirect(base_url());
		}

		 $getSubscription = $this->query->getDataSubcription(getSessionCodeId());

	    if($getSubscription){
	    	redirect(base_url(""));
	    }else{
			$checkVerification  = $this->query->get('pmj_verification',array("where"=>array("id_member"=>getSessionUser(),"status"=>"accept")));

			if($checkVerification){
				redirect(base_url(""));
			}
		}
	}

	public function index()
	{
		 $checkTotalReject  = $this->query->get('pmj_verification',array("count"=>1,"where"=>array("id_member"=>getSessionUser(),"status"=>"reject","status !="=>"accept")));

	     if($checkTotalReject[0]->total >= 3){
	     	redirect(base_url("verification")."/suspendAccount");
	     }else{
			$data['bodyClass'] = "verification";
			$this->load->view('user/verification',$data);
		}
		
	}

	public function waitingVerification()
	{
		$checkTotalReject  = $this->query->get('pmj_verification',array("count"=>1,"where"=>array("id_member"=>getSessionUser(),"status"=>"reject","status !="=>"accept")));
		 
	     if($checkTotalReject[0]->total >= 3){
	     	redirect(base_url("verification")."/suspendAccount");
	     }else{
			$data['info_verification'] = "You are not verified";
		 }

		$data['bodyClass'] = "waiting-verification";
		$this->load->view('user/waitingVerification',$data);
	}


	public function suspendAccount()
	{
		$data['bodyClass'] = "suspend-account";
		$this->load->view('user/suspendAccount',$data);
	}

	public function formContactAdmin(){
		header("Content-Type: application/json", true);

		if($this->input->post('from')){
			$dataEmail =array('code_id' => getSessionCodeId(),'message'=>$this->input->post('from'));

			/* Send Email */
			sendEmail("contact-admin",$dataEmail);

			$json = array("info" => 'success');
		}else{
			$json = array("info" => 'failed');
		}

		

		echo json_encode($json);

		exit;
	}


}

/* End of file query.php */
/* Location: ./application/controllers/query.php */