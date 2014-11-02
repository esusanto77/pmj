<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(getSessionUser() < 1){
			redirect(base_url());
		}
		//Do your magic here		
		$this->load->model('query');
	}

	
	public function sendReportUser(){
		header("Content-Type: application/json", true);
		if($this->input->post('textMessage') && $this->input->post('userReportCodeId')){
			$data =array('from_id' => getSessionUser(),
						 'to_code_id'=>$this->input->post('userReportCodeId'),
						 'message'=>$this->input->post('textMessage'),
						 'submit_date'=>date("Y-m-d H:i:s"),
						 'status'=>'online');

			$this->query->insert("member_report",$data);
			

			/* Send Email */
			sendEmail("report-user",$data);

			$json = array("info" => 'success');
		}else{
			$json = array("info" => 'failed');
		}

		echo json_encode($json);
	}

}

/* End of file api_login.php */
/* Location: ./application/controllers/api_login.php */