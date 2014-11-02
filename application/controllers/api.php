<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('query');
	}

	public function sync_dataMember()
	{
		$old = $this->db->query("select * from question_answer where registration_id > 10000 limit 1000");

		foreach ($old->result_array() as $key => $value) {

			$data['gender'] = $value[1];
			$data['birthday'] = $value[2];
			$data['city'] = $value[3];
			$data['_80'] = $value[55];

			$where['id'] = $value['registration_id'];			
			$this->query->update("member",$data,$where);
		}
	}

	/**
	 * get question list
	 *
	 * @ysupr 
	 **/

	function get_question($offset = 1)
	{		
		header('Content-Type: application/json');
		$question = $this->query->getQuestion(array("where"=>array("quiz_category"=>$offset)));
		if(!empty($question)){
			echo json_encode($question);
		} else {
			echo "empty";
		}		
	}

	function get_answer_by_category()
	{
		header('Content-Type: application/json');
		$data = $this->query->getAnswerCategory(getSessionUser(), $this->uri->segment(3));
		echo json_encode($data);		
	}

	function get_answer_by_category_mobile()
	{	
		header('Content-Type: application/json');
		$data = $this->query->getAnswerCategory($this->uri->segment(3), $this->uri->segment(4));

		echo json_encode($data);		
	}

	function get_answer_by_member()
	{
		header('Content-Type: application/json');
		$data = $this->query->getAnswerMember(getSessionUser());
		if(!empty($data)){
			echo json_encode($data);
		} else {
			echo "empty";
		}		
				
	}

	function get_answer_by_question()
	{
		header('Content-Type: application/json');
		$data = $this->query->getAnswerQuestion(getSessionUser(), $this->uri->segment(3));
		echo json_encode($data);		
	}

	/**
	 * get total question
	 *
	 * @ysupr 
	 **/

	function get_totalQuestion()
	{		
		header('Content-Type: application/json');
		$question = $this->query->get('question',array("count"=>"quiz_id"));
		echo json_encode($question);
	}

	function get_totalAnswer()
	{		
		header('Content-Type: application/json');
		$answer = $this->query->get("answer",array("count"=>"answer_id", "where"=>array("answer_uid"=>getSessionUser())));
		//$answer = $this->query->get("answer",array("where"=>array("answer_uid"=>getSessionUser())));
		echo json_encode($answer);
	}

	function getUserAnswer(){
		 header('Content-Type: application/json');

		$question = $this->query->get('question',array("count"=>"quiz_id"));
		$total = $question[0]->total;
		$query = "SELECT  pmj_answer.answer_uid as id
		FROM pmj_answer
		group by
		pmj_answer.answer_uid having count(*) > ".($total-5)."";

		$user = $this->db->query($query);

			$i=0;
			foreach ($user->result() as $key => $value) {
				$data[$i] = $value->id;
				$i++;
			}
		
		echo json_encode($data);
	}

	function getUserActive(){
		 header('Content-Type: application/json');

		$query =  $this->query->get(
			"activity",
			array(
				"where" => array(
					"act_date >" => date("Y-m-d"),
				),
				"order" => "act_id desc",
				"group" => "act_from_user"
			)
		);

			$i=0;
			foreach ($query as $key => $value) {
				$data[$i] = $value->act_from_user;
				$i++;
			}
		
		echo json_encode($data);
	}

	function get_precentage_answer()
	{		
		header('Content-Type: application/json');
		$question = $this->query->get('question',array("count"=>"quiz_id"));
		$answer = $this->query->get("answer",array("where"=>array("answer_uid"=>getSessionUser())));

		$countQuestion = $question[0]->total;
		$countAnswer = count($answer)-1;
		$precentage = ($countAnswer/$countQuestion)*100;
		echo json_encode($precentage);
	}

	/**
	 * post and save user answer
	 *
	 * @ysupr 
	 **/


	public function post_answer()
	{		
		if(getSessionUser() > 0){
			// sterilized
			$check['answer_question'] = $data["answer_question"] = strip_tags($this->input->get_post("question"));		
			$check['answer_uid'] = $data["answer_uid"] = getSessionUser();
			$data["answer_choice"] = strip_tags($this->input->post("answer"));

			$type = strip_tags($this->input->post("type"));
			
			if($type == "text" || $type == "choices"){
				// // check data first
				$get = $this->query->get("answer",array("where"=>$check));
				if(empty($get)){
					// save data 			
					$data['answer_date'] = date("Y-m-d H:i:s");
					$this->query->save("answer", $data);						
				} else {
					$update['answer_choice'] = $data['answer_choice'];
					$update['answer_date'] = date("Y-m-d H:i:s");
					$where['answer_question'] = $data['answer_question'];
					$where['answer_uid'] = $data['answer_uid'];
					$this->query->update("answer",$update,$where);						
				}							
			} else {
				$answer = explode(",", $data['answer_choice']);
				foreach ($answer as $key => $value) {
					if(empty($value)){
						$data['answer_date'] = date("Y-m-d H:i:s");
						$data['answer_choice'] = $value;						
						$this->query->save("answer", $data);					
					}						
				}
				
			}		

		}
	}

	public function post_answer_question()
	{		
		$rest_json = file_get_contents("php://input");
		// $rest_vars = json_decode($rest_json , true);
		$rest_vars = json_decode($this->input->post('data'), true);

		foreach($rest_vars as $user){
				$check['answer_question'] = $data["answer_question"] = strip_tags($user['question']);		
				$check['answer_uid'] = $data["answer_uid"] = $this->uri->segment(3);
				$data["answer_choice"] = strip_tags($user['answer']);
				$type = strip_tags($user['type']);
				

				if($type == "text" || $type == "choices" || $type == "3text" || $type == "checkbox" ){
					// // check data first
					$get = $this->query->get("answer",array("where"=>$check));
					if(empty($get)){
						// save data 			
						$this->query->save("answer", $data);						
					} else {
						$update['answer_choice'] = $data['answer_choice'];
						$where['answer_question'] = $data['answer_question'];
						$where['answer_uid'] = $data['answer_uid'];
						$this->query->update("answer",$update,$where);						
					}							
				}else{
					$answer = explode(",", $data['answer_choice']);
					foreach ($answer as $key => $value) {
						if(empty($value)){
							$data['answer_date'] = date("Y-m-d H:i:s");
							$data['answer_choice'] = $value;						
							$this->query->save("answer", $data);					
						}						
					}
				} 
		}
		$data = array("info"=>"no error");

		echo json_encode($data);
	}

	/**
	 * check user if email was used before
	 *
	 * @ysupr 
	 **/

	public function post_validUser()
	{
		// sterilized
		$data["email"] = strip_tags($this->input->post("email"));				

		// check data first
		$get = $this->query->get("member",array("where"=>$data));
		if(empty($get)){
			// save data 
			echo 0;
		} else {
			echo count($get);
		}				
	}

	/**
	 * post activity
	 *
	 * @ysupr 
	 **/

	public function post_activity()
	{
		if(getSessionUser() > 1){
			$data['act_from_user'] = strip_tags($this->input->post("from_user"));
			$data['act_to_user'] = strip_tags($this->input->post("to_user"));
			$data['act_label'] = strip_tags($this->input->post("label"));
			$data['act_date'] = date("Y-m-d H:i:s");

			$this->query->insert("activity",$data);
			echo 1;		
		} else {
			echo 0;
		}
	}

	public function del_activity()
	{
		if(getSessionUser() > 1){
			$data['act_from_user'] = strip_tags($this->input->post("from_user"));
			$data['act_to_user'] = strip_tags($this->input->post("to_user"));
			$data['act_label'] = strip_tags($this->input->post("label"));

			$this->query->insert("activity",$data);

			$data['act_label'] = str_replace("un", "", $data['act_label']);
			$update['act_label'] = "_".$data['act_label'];
			$this->query->update("activity",$update,$data);			
			echo 1;		
		} else {
			echo 0;
		}	
	}

	public function get_activity($id,$act)
	{	
		header('Content-Type: application/json');
		$from = getSessionUser();
		$to = strip_tags($id);
		$label = strip_tags($act);

		echo json_encode(checkAllActivity($from, $to, $label));
	}

	/**
	 * check user if email was used before
	 *
	 * @ysupr 
	 **/


	public function get_profileUser($id)
	{
		header('Content-Type: application/json');
		// sterilized		
		$data["member.id"] = strip_tags($id);						

		/*// log user viewed
		if(getSessionUser() > 1 && getSessionUser() != $id){
			$this->query->insert("activity",array("act_from_user"=>getSessionUser(), "act_to_user"=>$id, "act_label"=>"viewed"));
		}*/

		// check data first
		$get = $this->query->get("member",array("where"=>$data,"limit"=>1, "select"=>"member.id,city,gender,birthday,code_id,email,_80,member.status"));
		if(empty($get)){
			// save data 
			echo 0;
		} else {
			$get[0]->age = get_age($get[0]->birthday);
			$get[0]->photo = getAvatarPhoto($id);								
			$get[0]->religion = getAnswerWithKey($id,"WhatReligion");
			$get[0]->ethnicity = getAnswerWithKey($id,"WhatEthnicity");
			$get[0]->occupation = getAnswerWithKey($id,"WhatOccupation");
			$get[0]->relationship = getAnswerWithKey($id,"RelationshipStatus");
			$get[0]->_80 = $get[0]->_80;
			$get[0]->kids = getAnswerWithKey($id,"HaveChildren");
			echo json_encode($get[0]);
		}				
	}

	public function post_viewed_user($id){
		if(getSessionUser() > 1 && getSessionUser() != $id){
			$this->query->insert("activity",
				array(
					"act_from_user"=>getSessionUser(), 
					"act_to_user"=>$id, 
					"act_label"=>"viewed",
					"act_date" => date("Y-m-d H:i:s")
				)
			);
		}
	}


	/*
	 * message operation
	 */

	public function post_message()
	{	
		header("Content-Type: application/json", true);

		$from = getSessionUser();
		$to = strip_tags($this->input->post("to"));
		$sub = strip_tags($this->input->post("subject"));

		if(empty($from) || empty($to)){
			return false;
		} else {

			$room = array($from,$to);
			sort($room);			

			$data['msg_room'] = $room[0]."_".$room[1];
			$data['msg_code'] = md5($room[0]."_".$room[1].$sub);	
			$data['msg_subject'] = strip_tags($this->input->post("subject"));
			$data['msg_from'] = $from;
			$data['msg_to'] = $to;
			$data['msg_content'] = strip_tags($this->input->post("content"));
			$data['msg_date'] = date("Y-m-d H:i:s");
			$data['msg_status'] = "read";
			$data['msg_owner'] = $from;

			$messagesID = $this->query->insert("message",$data);		

			$data_to['msg_room'] = $data['msg_room'];
			$data_to['msg_code'] = $data['msg_code'];
			$data_to['msg_subject'] = $data['msg_subject'];
			$data_to['msg_from'] = $data['msg_from'];
			$data_to['msg_to'] = $data['msg_to'];
			$data_to['msg_content'] = $data['msg_content'];
			$data_to['msg_date'] = $data['msg_date'];
			$data_to['msg_owner'] = $to;

			$messagesTo = $this->query->insert("message",$data_to);	

			$getLastMessage = $this->query->get("message",array("where"=>array("msg_code"=>$data['msg_code'],"msg_owner"=>getSessionUser()),"limit"=>"1","order"=>"msg_id desc","select"=>"msg_id"));

			// send email
			$result = $this->post_sendemail("send_message",$messagesID);

			//add to activity
			$act['act_from_user'] = $from;
			$act['act_to_user'] = $to;
			$act['act_label'] = "Sent_Message";
			$act['act_date'] = date("Y-m-d H:i:s");
			$this->query->insert("activity",$act);

			$act['act_from_user'] = $to;
			$act['act_to_user'] = $from;
			$act['act_label'] = "Receive_Message";
			$act['act_date'] = date("Y-m-d H:i:s");
			$this->query->insert("activity",$act);			

			$json = array("msg_id" => $getLastMessage[0]->msg_id,"msg_code"=>$data['msg_code']);	

			echo json_encode($json);

			exit;
		}

	}

	public function get_message($mcode,$type="")
	{
		header('Content-Type: application/json');
		$where['msg_code'] = $mcode;
		$msg = $this->query->get("message",$where);						
		$pos = strpos($msg[0]->msg_room, getSessionUser());

		if ($pos === false) {			
		    return false;
		} else {
			switch ($type) {
				case 'inbox':				
					$whereMsg = array("msg_room"=>$msg[0]->msg_room,"msg_to"=>getSessionUser());
					$allMsg = $this->query->get("message", array("where"=>$whereMsg));
					break;
				case 'sent':								
					$whereMsg = array("msg_room"=>$msg[0]->msg_room,"msg_from"=>getSessionUser());
					$allMsg = $this->query->get("message", array("where"=>$whereMsg));
					break;										
				default:				
					$allMsg = $this->query->get("message", array("msg_room"=>$msg[0]->msg_room));
					break;
			}			
			echo json_encode($allMsg);
		}
	}

	public function post_sendemail($action = "",$param = "")
	{

		$this->mandrill->init();
		
		/*echo "Tes pro";

		$this->load->config("mandrill"); 

		    $email = array(
		    	
		        'html' => '<p>This is my message<p>', //Consider using a view file
		        'text' => 'This is my plaintext message',
		        'subject' => 'This is my subject',
		        'from_email' => 'me@ohmy.com',
		        'from_name' => 'Me-Oh-My',
		        'to' => array(array('email' => 'mail.yogasukma@gmail.com' )) //Check documentation for more details on this one
		        //'to' => array(array('email' => 'joe@example.com' ),array('email' => 'joe2@example.com' )) //for multiple emails
		        );

		   
		   	$params = array(
		   		'key' => $this->config->item('mandrill_api_key'),
		   		'message' => $email
		   	);


			// OK cool - then let's create a new cURL resource handle
			$fields = http_build_query($params);

			//print_r($params);exit;
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, "https://mandrillapp.com/api/1.0/messages/send.json");
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_HEADER, false);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2 * 60 * 1000);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

		    // Download the given URL, and return output
		    $output = curl_exec($ch);
		 
		    // Close the cURL resource, and free system resources
		    curl_close($ch);


		    print($output);exit;

                



		// $this->mandrill->init();*/
		
		if(empty($action)){
			$action = $this->input->post("action");	
		}

		if(empty($param)){
			$param = $this->input->post("param");	
		}		

		$email = getEmailTemplates($action,$param);

    $this->mandrill->messages_send($email);
    	
	}

	function get_searchUser()
	{
		header('Content-Type: application/json');
		$q = strip_tags($this->input->get("q"));

		$user = $this->query->get("member",array("limit"=>15, "like"=> array("code_id"=>$q)));
		foreach ($user as $key => $value) {
			$user[$key]->text = $value->code_id;
			$user[$key]->avatar = getAvatarPhoto($value->id);
			unset($user[$key]->name);
		}
		$data['suggestions'] = $user;
		echo json_encode($user);

	}

	function check_subscription()
	{

		$user = $this->query->get("subscription",array("where"=>array("id_member"=>getSessionUser())));
		if($user) echo "true";
		else echo "false";

	} 

	public function postImage()
	{		
		$nameFile = $this->input->post("namefile");
		$getImage = $this->input->post("getimage");
		$dirUpload = $this->input->post("dirupload");

		if (!file_exists($dirUpload)) {
			mkdir($dirUpload , 0777, true);
		}
		// "http://pmjbeta.azurewebsites.net/public/upload/img/thumb/896aa56776d852342e4007dbf886cdf6.jpg";
		// file_put_contents("public/upload/img/ok.jpg", file_get_contents($getImage));
		file_put_contents($nameFile, file_get_contents($getImage));
		
		echo json_encode("success");
	}	

	public function delImage()
	{		
		$filename = "public/upload/img/real/".$this->input->post("filename")."";
		$filename_thumb = "public/upload/img/thumb/".$this->input->post("filename")."";

		if (file_exists($filename)) unlink ($filename);
		if (file_exists($filename_thumb)) unlink ($filename_thumb);
	}

}

/* End of file api.php */
/* Location: ./application/controllers/api.php */