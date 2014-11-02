<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity extends CI_Controller {

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
		$config['base_url'] = base_url("activity?");
		$total = $this->query->get('activity',array("count"=>1, "where"=>array("act_label !="=>"viewed", "act_from_user"=>getSessionUser())));
		$config['total_rows'] = $total[0]->total;		
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'page';
		
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();

		$offset = $this->input->get("page");

		if(empty($offset)){
			$offset = 0;
		}

		$data['act'] = $this->query->get('activity',array("limit"=>10, "offset"=>$offset, "order"=>"act_id desc", "where"=>array("act_from_user"=>getSessionUser(), "act_label !="=>"login")), array("user"=>"act_to_user"));		
		$this->load->view('user/activity',$data);
	}

}

/* End of file activity.php */
/* Location: ./application/controllers/activity.php */