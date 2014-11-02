<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Matches extends CI_Controller {

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
		$array['id'] = getSessionUser();
		$data['user'] = $this->query->get("member",array("where"=>$array));
		$queryMatches = $this->query->get("matches", array("where" => array("match_uid" => $array['id'])));
		$matches = array();
		
		foreach ($queryMatches as $user) {
			$matches = array_merge($matches, unserialize($user->match_data));
		}
		
		$data['matches'] = $matches;
		$data['pageTitle'] = "Matches";
		$this->load->view('user/matches',$data);
	}

	public function favorite()
	{
		$config['base_url'] = "?";
		$total =$this->query->get('activity',array("count"=>1,"where"=>array("act_from_user"=>getSessionuser(),"act_label"=>"favorite", "act_to_user !=" => getSessionuser())),array("user"=>"act_to_user"));		
		$config['total_rows'] =  $total[0]->total;				
        $config['per_page'] = 12;
		$config['num_links'] = 3;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		$offset = $this->input->get("page");

		if(empty($offset) || $offset == 0){
			$offset = 0;
		} 

		$array['id'] = getSessionUser();
		$data['user'] = $this->query->get("member",array("where"=>$array));
		$data['matches'] =  $this->query->get('activity',array("limit"=>$config['per_page'],"offset"=>$offset, "where"=>array("act_from_user"=>getSessionuser(),"act_label"=>"favorite", "act_to_user !=" => getSessionuser())),array("user"=>"act_to_user"));		
		$data['pageTitle'] = "Favorite User";
		$data['class'] = 'favorite-wrapper';
		$this->load->view('user/list',$data);
	}

	public function favoriteMe()
	{
		$config['base_url'] = "?";
		$total =$this->query->get('activity',array("count"=>1,"where"=>array("act_to_user"=>getSessionuser(),"act_label"=>"favorite")),array("user"=>"act_from_user"));		
		$config['total_rows'] =  $total[0]->total;				
        $config['per_page'] = 12;
		$config['num_links'] = 3;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page'; 

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		$offset = $this->input->get("page");

		if(empty($offset) || $offset == 0){
			$offset = 0;
		} 

		$array['id'] = getSessionUser();
		$data['user'] = $this->query->get("member",array("where"=>$array));
		$data['matches'] =  $this->query->get('activity',array("limit"=>$config['per_page'],"offset"=>$offset, "where"=>array("act_to_user"=>getSessionuser(),"act_label"=>"favorite")),array("user"=>"act_from_user"));		
		$data['pageTitle'] = "Favorite Me";
		$this->load->view('user/list',$data);
	}

	public function viewed()
	{
		$config['base_url'] = "?";
		$total = $this->query->get('activity',array("count"=>"distinct(act_from_user)","order"=>"act_id desc", "where"=>array("act_to_user"=>getSessionUser(),"act_label"=>"viewed")),array("user"=>"act_from_user"));
        $config['total_rows'] =  $total[0]->total;				
        $config['per_page'] = 12;
		$config['num_links'] = 3;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';  

		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();

		$offset = $this->input->get("page");

		if(empty($offset) || $offset == 0){
			$offset = 0;
		} 

		$array['id'] = getSessionUser();
		$data['user'] = $this->query->get("member",array("where"=>$array));
		$data['matches'] =  $this->query->get('activity',array("limit"=>$config['per_page'],"offset"=>$offset,"order"=>"act_id desc", "where"=>array("act_to_user"=>getSessionUser(),"act_label"=>"viewed"),"select"=>" distinct(act_from_user),pmj_activity.act_from_user,pmj_activity.act_to_user,pmj_member.code_id, pmj_member.id,pmj_member._80 "),array("user"=>"act_from_user"));		
		$data['pageTitle'] = "Viewed Me";
		$this->load->view('user/list',$data);	
	}

	public function best()
	{
		$array['id'] = getSessionUser();
		$data['user'] = $this->query->get("member",array("where"=>$array));
		$queryMatches = $this->query->get("matches", array("where" => array("match_uid" => $array['id']),"limit"=>"1","order"=>"match_id desc"));
		$matches = array();
		
		foreach ($queryMatches as $user){
			$matches = array_merge($matches, unserialize($user->match_data));
		}

		$data['matches'] = $matches;
		$data['pageTitle'] = "Best Matches";
		$this->load->view('user/list-match',$data);	
	}

}



/* End of file fav.php */
/* Location: ./application/controllers/fav.php */