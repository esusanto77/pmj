<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here		
		$this->load->model('query');
	}

	public function index()
	{		
		if(getSessionUser() != ''){
			$data['bodyClass'] = "dashboard";
			checkHoursVerification();

			$array['id'] = getSessionUser();
			$data['user'] = $this->query->get("member",array("where"=>$array));

			// redirect to quetion if user has pending status
			if($data['user'][0]->status == "pending"){
				redirect("question");
			}

			// match
			$queryMatches =  $this->query->get("matches", array("where" => array("match_uid" => $array['id']),"limit"=>"1","order"=>"match_id desc"));
			$matches = array();

			foreach ($queryMatches as $user) {
				$matches = array_merge($matches, unserialize($user->match_data));
			}							

			$data['match'] = $matches;

			$data['totalMatch'] = count($data['match']);
			
			$data['act'] = $this->query->get('activity',array("limit"=>3, "order"=>"act_id desc", "where"=>array("act_from_user"=>getSessionUser(), "act_label !="=>"login")), array("user"=>"act_to_user"));		
			$data['viewed'] = $this->query->get('activity',array("limit"=>8, "order"=>"act_id desc", "where"=>array("act_to_user"=>getSessionUser(),"act_label"=>"viewed"),"select"=>" distinct(act_from_user),pmj_activity.act_from_user,pmj_activity.act_to_user,pmj_member.code_id, pmj_member.id "),array("user"=>"act_from_user"));		
			
			$this->load->view('user/dashboard', $data);	

		} else {
			$data['bodyClass'] = "index";
			$data['headerClass'] = "front-content-wrapper";
			$data['script'] = array("datepicker");
			$data['city'] = $this->query->get("city",array());
			$this->load->view('welcome',$data);
		}		
	}

	public function done()
	{		
		if(getSessionUser() != ''){
			$data['status'] = "online";
			$where['id'] = getSessionUser();
			$this->query->update("member",$data,$where);
			redirect(base_url());
		}
	}

	public function slideShow(){
		
		if(getSessionUser() > 1){
			$array['id'] = getSessionUser();
			$data['user'] = $this->query->get("member",array("where"=>$array));

			if($data['user'][0]->status == "pending"){
				redirect("question");
			}else{
				redirect(base_url("welcome"));
			}
		}

		$data['bodyClass'] = "slideshow";
		$data['headerClass'] = "front-slideshow";
		$this->load->view('slideshow',$data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */