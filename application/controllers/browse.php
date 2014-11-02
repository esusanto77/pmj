<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Browse extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('query');
		if(getSessionUser() < 1){
			redirect(base_url());
		}

		checkHoursVerification();
	}

	public function index()
	{		
		$year = date("Y");
		
		if($this->input->get("min-age")=="-"){
			$min_year = reverse_birthday("28");
		}else{
			$min_year = reverse_birthday($this->input->get("min-age"));
		}

		if($this->input->get("max-age")=="-"){
			$max_year = reverse_birthday("90");
		}else{
			$max_year = reverse_birthday($this->input->get("max-age"));
		}

		
		$gender = getProfile(getSessionUser(),"gender");
		$city = $this->input->get("city");

		if(!isset($gender)){
			$gender = "Male";
		}

		$config['base_url'] = "?min-age=".$this->input->get("min-age")."&max-age=".$this->input->get("max-age")."&city=".$this->input->get("city");
		$total = $this->query->get("member",array("count"=>1, "where"=>array("city"=>$city, "gender != "=> $gender,"gender !=" =>"", "birthday <="=>$min_year, "birthday >="=>$max_year)));
		$config['total_rows'] =  $total[0]->total;				
        $config['per_page'] = 8;
		$config['num_links'] = 3;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		$offset = $this->input->get("page");

		if(empty($offset) || $offset == 0){
			$offset = 0;
		} 

		$data['bodyClass'] = "browse";
		$data['matches'] = $this->query->get("member",array("limit"=>8, "offset"=>$offset, "order"=>"birthday desc", "where"=>array("city"=>$city, "gender != "=> $gender, "gender !=" =>"", "birthday <="=>$min_year, "birthday >="=>$max_year)));				
		$data['pageTitle'] = "Search User";
		$this->load->view('user/browse',$data);
	}

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */