<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mylab extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		if($this->input->post('submit')){
			$this->db->query($this->input->post("text"));
		}
		echo "<form method='post'><textarea name='text'></textarea><input type='submit' name='submit'></form>";
	}

	public function testaja()
	{
		sendEmail('test_aja');

	}

}

/* End of file query.php */
/* Location: ./application/controllers/query.php */
