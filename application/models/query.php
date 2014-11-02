<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		// list table 
		$this->tableQuestion = "question";
		$this->tableChoice = "choice";
		$this->tableUser = "member";
	}


	public function insert($db, $data)
	{
		$this->db->insert($db,$data);
		return $this->db->insert_id();
	}

	public function get($db, $data, $join=array())
	{				
		if(!empty($data['select'])){
			$this->db->select($data['select']);
		}

		if(!empty($data['where'])){
			$this->db->where($data['where']);
		}

		if(!empty($data['like'])){
			$this->db->like($data['like']);
		}

		if(!empty($data['limit'])){
			if(!empty($data['offset'])){
				$this->db->limit($data['limit'],$data['offset']);
			} else {
				$this->db->limit($data['limit']);
			}			
		}

		if(!empty($data['order'])){
			$this->db->order_by($data['order']);
		}

		if(!empty($data['group'])){
			$this->db->group_by($data['group']);
		}

		if(!empty($data['count'])){
			$this->db->select("count(".$data['count'].") as total");
		}

		// parameterize join
		if(!empty($join['user'])){						
			$this->db->join($this->tableUser,"id = ".$join['user']);
		}

		// spesial for getting last message :|
		if(!empty($join['last_message'])){			
			if(!empty($data['where'][$this->db->dbprefix($db).'.msg_from'])){
				$owner = $this->db->dbprefix($db).".msg_id >= last.msg_id and last.msg_from = ".$data['where'][$this->db->dbprefix($db).'.msg_from'];
			}
			if(!empty($data['where'][$this->db->dbprefix($db).'.msg_to'])){
				$owner = $this->db->dbprefix($db).".msg_id <= last.msg_id and last.msg_to = ".$data['where'][$this->db->dbprefix($db).'.msg_to'];
			}

			$this->db->join($db." as last",$db.".msg_code = last.msg_code and  ".$owner);
		}

		$get = $this->db->get($db);	

		if(!empty($data['debug'])){
			print_r($this->db->last_query());exit;
		}
		return $get->result();
	}	

	public function save($db,$data)
	{
		$this->db->insert($db,$data);
		return $this->db->insert_id();
	}

	public function update($db,$data,$where)
	{
		$this->db->where($where);
		$this->db->set($data);
		$this->db->update($db);	
		
	}

	public function delete($db,$where)
	{
		$this->db->where($where);
		$this->db->delete($db);
	}


	/*
	 * GET LIST OF QUESTSION, CHOICE, AND RELATED QUESTION
	 */ 
	public function getQuestion($options=array())
	{
		// count the total
				 $this->db->select("count(quiz_id) as total");
		$count = $this->db->get($this->tableQuestion)->row();

		$question['total_slides'] = 5;
		$question['total_questions'] = $count->total;

		if(!empty($options["where"])){
			$this->db->where($options["where"]);
		}

		$this->db->where("quiz_related",0);
		$this->db->where("quiz_status",1);

		if(!empty($options["orderby"])){
			$this->db->order_by($options["orderby"]);
		} else {
			$this->db->order_by("quiz_priority");
		}

		if(!empty($options["limit"])){
			if(!empty($options["offset"])){
				$this->db->limit($options["limit"],$options["offset"]);
			} else {
				$this->db->limit($options["limit"]);
			}			
		}

		$get = $this->db->get($this->tableQuestion);				
		$get = $get->result();
		if(!empty($get)){			
			if(!empty($options['offset'])){
				$number = $options['offset'] + 1;				
			} else {
				$number = 1;			
			}
			
			// looping get question			
			foreach ($get as $i => $q) {
				$question['questions'][$i]['question_no'] = $number;
				$question['questions'][$i]['question_id'] = $q->quiz_id;
				$question['questions'][$i]['question_title'] = $q->quiz_text;
				$question['questions'][$i]['input_name'] = $q->quiz_id;								
				$question['questions'][$i]['type'] = $q->quiz_type;
				$question['questions'][$i]['category'] = $q->quiz_category;								
				
			// get the choices	
						$this->db->where("choice_question",$q->quiz_id);
						$this->db->order_by("choice_order");
				$opt = 	$this->db->get($this->tableChoice);
				$opt = $opt->result();
			
			if(!empty($opt)){
			// looping get choice
				foreach ($opt as $j => $o) {
					$question['questions'][$i]['choices'][$j]['value'] = $o->choice_id;
					$question['questions'][$i]['choices'][$j]['label'] = $o->choice_text;
					$question['questions'][$i]['choices'][$j]['parent'] = $o->choice_parent;
				}
			}

			// get the related question
							$this->db->where("quiz_related",$q->quiz_id);
				$related = 	$this->db->get($this->tableQuestion);
				$related = $related->result();
				if(!empty($related)){
					foreach ($related as $k => $r) {
						$question['questions'][$i]['related'][$k]['question_id'] = $r->quiz_id;
						$question['questions'][$i]['related'][$k]['question_title'] = $r->quiz_text;
						$question['questions'][$i]['related'][$k]['question_related'] = $r->quiz_related;
						$question['questions'][$i]['related'][$k]['input_name'] = $r->quiz_id;								
						$question['questions'][$i]['related'][$k]['type'] = $r->quiz_type;
						$question['questions'][$i]['related'][$k]['category'] = $r->quiz_category;

						// get the choices	
								$this->db->where("choice_question",$r->quiz_id);
						$opt = 	$this->db->get($this->tableChoice);
						$opt = $opt->result();

						if(!empty($opt)){
							// looping get choice
							foreach ($opt as $j => $o) {
								$question['questions'][$i]['related'][$k]['choices'][$j]['value'] = $o->choice_id;
								$question['questions'][$i]['related'][$k]['choices'][$j]['label'] = $o->choice_text;
								$question['questions'][$i]['related'][$k]['choices'][$j]['parent'] = $o->choice_parent;
							}
						}
					}
				}



			}

			return $question;
		} else {
			return false;
		}
	}

	public function checkAnswerQuestion($uid)
	{
		// get the question first, 
		$this->db->where("answer_uid",$uid);
		$this->db->where("answer_question",'0');
		$answer = $this->db->get("answer");		
		return $answer->result();
	}

	/* 
	 * get the user answer via key choice
	 */
	public function getAnswerWithKey($uid,$key)
	{
		// get the question first, 
		$this->db->where("quiz_key",$key);
		$this->db->join("answer","answer_question = quiz_id and answer_uid = ".$uid,"left");
		$this->db->join("choice","choice_id = answer_choice","left");
		$quiz = $this->db->get("question");		
		return $quiz->result();
	}

	public function getAnswerCategory($uid,$key)
	{
		// get the question first, 
		$this->db->where("quiz_category",$key);
		$this->db->join("answer","answer_question = quiz_id and answer_uid = ".$uid."","inner");
		$question = $this->db->get("question");
		return $question->result();
		
	}

	public function getAnswerMember($uid)
	{
		$this->db->where("answer_uid",$uid);
		$answer = $this->db->get("answer");
		return $answer->result();
		
	}

	public function getAnswerQuestion($uid,$key)
	{
		$this->db->where("answer_question",$key);
		$this->db->where("answer_uid",$uid);
		$answer = $this->db->get("answer");
		return $answer->result();
		
	}


	public function getActivity($where)
	{
		$this->db->where($where);		
		if(!empty($where['act_from_user'])){
			$this->db->join("member","activity.act_to_user = member.id");
		} else if(!empty($where['act_to_user'])) {
			$this->db->join("member","activity.act_from_user = member.id");
		}
		
		$user = $this->db->get("activity");
		return $user->result();
	}

	public function getMemberData($id)
	{
		$this->db->where("pmj_member.id",$id);
		$this->db->join("pmj_member_data","pmj_member.id = pmj_member_data.id_member","left");
		$memberData = $this->db->get("pmj_member");
		return $memberData->result();
	}

	public function checkData($db,$data,$where)
	{
		$this->db->where($data,$where);
		$checkMemberData = $this->db->get($db);
		if($checkMemberData->num_rows() > 0)
			return true;
		else
			return false;
	}

	public function getDataAnswer($idMatch,$idUser){
		$this->db->select("pmj_answer.answer_uid,pmj_answer.answer_question,pmj_answer.answer_choice,pmj_member.gender,pmj_member.birthday,
							pmj_member.code_id,pmj_member.email,pmj_member._80,pmj_choice.choice_text,pmj_choice.choice_value");
		$this->db->join("pmj_member","pmj_member.id = pmj_answer.answer_uid","inner");
		$this->db->join("pmj_choice","pmj_choice.choice_id = pmj_answer.answer_choice","inner");
		// $this->db->join("pmj_member_photo","pmj_member_photo.registration_id = pmj_member.id","LEFT");
		$this->db->where("pmj_answer.answer_uid !=",$idUser);
		$this->db->where("pmj_answer.answer_question !=","0");
		if(!empty($idMatch)){						
			$this->db->where("pmj_answer.answer_uid",$idMatch);
		}
		// $this->db->where("pmj_member_photo.registration_id",$idMatch);
		// $this->db->where("pmj_member_photo.type","main");
		$this->db->order_by("pmj_answer.answer_uid asc");
		$get= $this->db->get("pmj_answer");
		return $get->result();
	}

	public function getDataAnswerUser($idMatch,$distinct){
		if(!empty($distinct)){						
			$this->db->select("distinct(answer_uid) as answer_uid");
		}else{
			$this->db->select("*");
		}
		
		$this->db->join("pmj_choice","pmj_choice.choice_id = pmj_answer.answer_choice","inner");
		$this->db->join("pmj_member","pmj_member.id = pmj_answer.answer_uid","inner");
		$this->db->where("pmj_answer.answer_question !=","0");
		if(!empty($idMatch)){						
			$this->db->where("pmj_answer.answer_uid",$idMatch);
		}
		$this->db->order_by("pmj_answer.answer_question asc");
		$get= $this->db->get("pmj_answer");
		return $get->result();
	}

	public function getDataSubcription($code_id){
		$this->db->select("pmj_product.name_product,pmj_subscription.submit_date,pmj_subscription.expire_date");
		$this->db->join("pmj_product","pmj_product.id_product = pmj_subscription.id_product","inner");
		$this->db->join("pmj_member","pmj_subscription.id_member = pmj_member.id","inner");
		$this->db->where("pmj_member.code_id",$code_id);
		$this->db->where("pmj_subscription.expire_date >",date("Y-m-d H:i:s"));
		$get= $this->db->get("pmj_subscription");
		return $get->result();
	}

}

/* End of file query.php */
/* Location: ./application/models/query.php */