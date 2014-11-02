<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Online extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('query');
		if(getSessionUser() < 1){
			redirect(base_url());
		}

		checkHoursVerification();
	}

	public function index()
	{
		$this->load->view('user/online');
	}

}

/* End of file activity.php */
/* Location: ./application/controllers/activity.php */