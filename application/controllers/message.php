<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('query');
		if(getSessionUser() < 1){
			redirect(base_url());
		}
		$this->tableMessage = "pmj_message";
		checkHoursVerification();
	}

	public function index()
	{
		
		$config['base_url'] = "?";
		$total = count($this->query->get(
				"message",
					array("count"=>1, "order"=>$this->tableMessage.".msg_id desc", "group"=>$this->tableMessage.".msg_code", "where"=>array($this->tableMessage.".msg_to"=>getSessionUser(),$this->tableMessage.".msg_owner"=>getSessionUser()))
					)
				);						
		$config['total_rows'] = $total;		
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

		$data['message'] = $this->query->get(
				"message",
				array("limit"=>$config['per_page'], "offset"=>$offset,"order"=>$this->tableMessage.".msg_id desc", "group"=>$this->tableMessage.".msg_code", "where"=>array($this->tableMessage.".msg_to"=>getSessionUser(),$this->tableMessage.".msg_owner"=>getSessionUser())),
				array("user"=>"msg_from","last_message"=>1)
			);		

		$data['subjectFor'] = "inbox";
		$data['title'] = 'Inbox';
		$data['bodyClass'] = "messages";
		$this->load->view('user/message',$data);
	}


	public function sent()
	{

		$config['base_url'] = "?";
		$total = count($this->query->get(
				"message",
					array("count"=>1, "order"=>$this->tableMessage.".msg_id desc", "group"=>$this->tableMessage.".msg_code", "where"=>array($this->tableMessage.".msg_from"=>getSessionUser(),$this->tableMessage.".msg_owner"=>getSessionUser()))
					)
				);						
		$config['total_rows'] = $total;		
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

		$data['subjectFor'] = "sent";
		$data['title'] = 'Sent';
		$data['message'] = $this->query->get(
				"message",
				array("limit"=>$config['per_page'], "offset"=>$offset, "order"=>$this->tableMessage.".msg_id desc", "group"=>$this->tableMessage.".msg_subject", "where"=>array($this->tableMessage.".msg_from"=>getSessionUser(),$this->tableMessage.".msg_owner"=>getSessionUser())),
				array("user"=>"msg_from")
			);				

		$this->load->view('user/message',$data);
	}

	public function create()
	{				
		$this->load->view('user/messageCreate',$data);
	}

	public function to($code_id)
	{	
		$getuser = $this->query->get("member",array("where"=>array("code_id"=>$code_id)));
		$data['code_id'] = $getuser[0]->code_id;
		$to = $getuser[0]->id;
		
		// if user not valid
		if(empty($to)){
			redirect(base_url("message"));
		} else {

			///print($to);exit;

			$room = array(getSessionUser(),$to[0]->id);
			sort($room);
			

			$room = $room[0]."_".$room[1];			

			$msg = $this->query->get("message",array("where"=>array("msg_room"=>$room)));
			
			// if user has make message before 
			if(!empty($msg)){
				redirect(base_url("message/read/".md5($room)));
			} else {

				// if never sending message before
				$data['to'] = $to;
				$data['to_code_id'] = $code_id;
				$data['room'] = md5($room);
				$this->load->view('user/messageDirect', $data);

			}
		}
	}


	public function read($code)
	{	
		$data['bodyClass'] = "create-message";
		$data['msg'] = $this->query->get(
				"message",
				array("order"=>"msg_id", "where"=>array("msg_code"=>$code,"msg_owner"=>getSessionUser())),
				array("user"=>"msg_from")
				);		

		// mark as read
		$this->query->update("message",array("msg_status"=>"read"), array("msg_status"=>"unread","msg_code"=>$code,"msg_from !=" =>getSessionUser(),"msg_owner"=>getSessionUser()));
		
		$room = explode("_", $data['msg'][0]->msg_room);
		$title = $this->query->get("message",array("where"=>array("msg_code"=>$code),"limit"=>"1","select"=>"msg_subject"));
		
		$data['title'] =  $title[0]->msg_subject;
		$data['from'] = getSessionUser();
		$data['to'] = (getSessionUser() == $room[0]) ? $room[1] : $room[0];
		$data['to_code_id'] = getProfile($data['to'], 'code_id');
		$data['code'] = $code;

		$this->load->view('user/messageDetail',$data);

		//echo json_encode($data['msg'][0]->msg_subject);
	}

	public function delMessage(){
		$info = $this->input->post('info');

		if($info==="id"){
			$msg_id = $this->input->post('msg_id');
	    	foreach ($msg_id as $message){
	    		$this->query->delete('pmj_message',array("msg_id"=>$message,"msg_owner"=>getSessionUser()));
	    	}
		}elseif($info==="subject"){
			$msg_code = $this->input->post('msg_code');
	    	foreach ($msg_code as $message){
	    		$this->query->delete('pmj_message',array("msg_code"=>$message,"msg_owner"=>getSessionUser()));
	    	}
		}
		
    	echo 1;
	}

	public function searchMessage(){
		header('Content-Type: application/json');
		$key = strip_tags($this->input->get("key"));
		$msg_code = strip_tags($this->input->get("msg_code"));
		$info = strip_tags($this->input->get("info"));
		$subject_for = strip_tags($this->input->get("subject_for"));
		
		if($info==="id"){
			$getMessage = $this->query->get("message",array("like"=>array("msg_content"=>$key),"where"=>array("msg_owner"=>getSessionUser(),"msg_code"=>$msg_code)),
			array("user"=>"msg_from"));
		}elseif($info==="subject"){
			if($key!==""){
				$like = "($this->tableMessage.msg_content LIKE '%$key%' OR $this->tableMessage.msg_subject LIKE '%$key%')"; 
			}else{
				$like = "$this->tableMessage.msg_content LIKE '%$key%'"; 
			}
			
			// $like = "$this->tableMessage.msg_content LIKE '%$key%'"; 
			
			if($subject_for==="inbox"){
				$getMessage = $this->query->get(
				"message",
				array("order"=>$this->tableMessage.".msg_id desc", "group"=>$this->tableMessage.".msg_code", "where"=>array($this->tableMessage.".msg_to"=>getSessionUser(),$this->tableMessage.".msg_owner"=>getSessionUser(),$this->tableMessage.".msg_to"=>getSessionUser(),$like=>null)),
				array("user"=>"msg_from","last_message"=>1)
			);		
			}elseif($subject_for==="sent"){
				$getMessage = $this->query->get(
				"message",
				array("order"=>$this->tableMessage.".msg_id desc", "group"=>$this->tableMessage.".msg_subject", "where"=>array($this->tableMessage.".msg_from"=>getSessionUser(),$this->tableMessage.".msg_owner"=>getSessionUser(),$like=>null)),
				array("user"=>"msg_from")
			);				
			}
			
		}
		

		foreach ($getMessage as $key => $v) {
			 $data['user'][$key]['msg_id'] = $v->msg_id;
			 $data['user'][$key]['msg_from'] = $v->msg_from;
			 $data['user'][$key]['msg_content'] =  word_limiter($v->msg_content,140);
			 $data['user'][$key]['msg_date'] = date("d M Y, h:m",strtotime($v->msg_date));
			 $data['user'][$key]['avatar_photo'] = getAvatarPhoto($v->msg_from);
			 $data['user'][$key]['code_id'] = $v->code_id;
			 $data['user'][$key]['url_message'] = base_url("message/read")."/".$v->msg_code;
			 $data['user'][$key]['msg_subject'] = $v->msg_subject;
		}

		$data['count'] = count($getMessage);
		
		echo json_encode($data);

	}

}

/* End of file message.php */
/* Location: ./application/controllers/message.php */