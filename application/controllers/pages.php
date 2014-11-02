<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('query');

	}

	public function index()
	{
		redirect(base_url());	
	}

	public function why_us()
	{
		$data['bodyClass'] = "why-us";
		$data['pageTitle'] = "Why Us";

		$pages = array(
					"whyChooseTitle","whyChooseTagline","whyChooseConfidentally","whyChooseCompatibility","whyChooseConnectivity","whyChooseEfficiency",
					"aboutUsTitle","aboutUsContentLeft","aboutUsContentRight","safetyFirstTitle","safetyFirstContent",
					"TOSTitle","TOSContent",
					"ContactTitle","ContactAddress","ContactPhone","ContactEmail","ContactWebsite"
				);

		foreach ($pages as $key => $value) {
			$content = $this->query->get("pages",array("where"=>array("pmj_slug"=>$value)));
			$data[$value] = ( !empty($content) && $content[0]->pmj_content !== "")? $content[0]->pmj_content : "";
		}

		$this->load->view('pages/why_us',$data);
	}

	public function sendEmailWhyUs(){
		$dataEmail =array(	'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'message'   =>  $this->input->post('message'));
		
		if($this->input->post('name')!="" or  $this->input->post('email')!="" or  $this->input->post('message')!=""){
			sendEmail("contactus",$dataEmail);
			echo "success";
		}else{
			echo "failed";
		}
		
	}

}

/* End of file why-us.php */
/* Location: ./application/controllers/why-us.php */