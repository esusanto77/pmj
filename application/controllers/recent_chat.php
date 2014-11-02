<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recent_chat extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here		
		$this->load->model('query');

		checkHoursVerification();
	}


	public function index()
	{
		$this->load->view('user/recent_chat');
	}


}

/* End of file chat.php */
/* Location: ./application/controllers/chating.php */