<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('query');
		if(getSessionUser() == 0){
			redirect(base_url());
		}
	}

	public function index()
	{	

		if($this->input->get("q")){
			$category = $this->input->get("q");
		} else {
			$category = 1;
		}

		$data['qacategory'] = $category;
		//$data['percent'] = 25 * ($category - 1);  //$this->input->post("progress");

		$user = $this->query->get("member",array("where"=>array("id"=>getSessionUser())));	


		switch ($category) {
			case 1:				
			$categoryLabel = "Starting Question";
			break;
			case 2:				
			$categoryLabel = "Personal Assesment";
			break;	
			case 3:
			$categoryLabel = "Interest";
			break;		
			case 4:
			$categoryLabel = "Match Request";
			break;				
		}

		$data['categoryLabel'] = $categoryLabel;		

		$totalQuestion = $this->query->get("question",array("count"=>1));
		$totalQuestion = $totalQuestion[0]->total;
		$data['totalQuestion'] = $totalQuestion;
		$data['value'] = 100/$totalQuestion;

		$sisaQa = $this->query->get("question",array("count"=>1, "where"=>array("quiz_category >=" => $category)));		
		$sisaQa = $sisaQa[0]->total;
		$progress = $totalQuestion - $sisaQa;
		$data['percent'] = floor($progress / $totalQuestion * 100);
		$data['percent'] = $data['percent'] > 100 ? 100 : $data['percent'];

		if($this->input->post()){

			foreach ($this->input->post() as $key => $v) {								

				if($key == "progress" || $key == "qa-category"){
					continue;
				}				

				$checkbox =  strpos($key, "check");

				if ($checkbox === false) {		
					// pertanyaan biasa			
					$check['answer_question'] = $insert["answer_question"] = strip_tags($key);	
					$check['answer_uid'] = $insert["answer_uid"] = getSessionUser();
					$insert["answer_choice"] = strip_tags($v);								
				} else {				
					// pertanyaan checkbox		  
					$answerCheckboxCombined = "";
					$answerCheckbox = $this->input->post($key);
					foreach ($answerCheckbox as $inc => $box) {				    	
						$answerCheckboxCombined = $answerCheckboxCombined.$box.",";
					}				    				    
					$explode = explode("_", $key);				    				    

					$check['answer_question'] = $insert["answer_question"] = strip_tags($explode[1]);	
					$check['answer_uid'] = $insert["answer_uid"] = getSessionUser();

					$insert["answer_choice"] = strip_tags(substr($answerCheckboxCombined,0,-1));								
				}						
				
				// check data first
				$get = $this->query->get("answer",array("where"=>$check));

				if(empty($get)){				
					$insert['answer_date'] = date("Y-m-d H:i:s");	
					// save data 			
					$this->query->save("answer", $insert);
					//update data
					update80();

				} else {
					$update['answer_choice'] = $insert['answer_choice'];
					$update['answer_date'] = date("Y-m-d H:i:s");	
					$where['answer_question'] = $insert['answer_question'];
					$where['answer_uid'] = $insert['answer_uid'];

					//update data
					update80();
					$this->query->update("answer",$update,$where);	
//					$this->insertMatch();
				}
			}			

			// set status user
			if($category == "done"){
				$this->insertMatch();
				$userUpdate["status"] = "online";
				$userWhere["id"] = getSessionUser();

				//update data
				update80();
				$this->query->update("member",$userUpdate,$userWhere);
				//$this->insertMatch();

				
				redirect(base_url('verification'));
			}
			$answer = $this->query->get("answer",array("where"=> array("answer_uid"=>getSessionUser())));
			$total_answer = count($answer);
			
			$question = $this->query->get('question');
			$total_question = count($question);

			$data['percent'] = ($total_answer/$total_question) * 100;
			$data['percent'] = $data['percent'] > 100 ? 100 : $data['percent'];

			$data['bodyClass'] = "qa-transition";
			$this->load->view('question/transition', $data);

		} else {
			$answer = $this->query->get("answer",array("where"=> array("answer_uid"=>getSessionUser())));
			$total_answer = count($answer);

			$question = $this->query->get('question');
			$total_question = count($question);

			$data['percent'] = ($total_answer/$total_question) * 100;
			$data['percent'] = $data['percent'] > 100 ? 100 : $data['percent'];
				//echo $data['percent'];

			if($user[0]->status == "pending"){
				$data["question"] = $this->query->getQuestion(array("where"=>array("quiz_category"=>$category)));				
				$data['bodyClass'] = "qa";

				$this->load->view('question/qa', $data);

			} else {
				//redirect(base_url());
				$data["question"] = $this->query->getQuestion(array("where"=>array("quiz_category"=>$category)));
				$this->load->view('question/qa', $data);
			}
		}
	}

	public function insertMatch(){
//			$data['user'] = $this->query->getDataAnswerUser($this->uri->segment(3),'');

			$uid_me		= getSessionUser(); 

			$matchs		= "";

			//query umum
			$primaryquery 	= "SELECT a.answer_uid, a.answer_question, a.answer_choice, b.gender FROM pmj_answer a, pmj_member b";

			//agama
			$pribadia		= mysql_fetch_array(mysql_query($primaryquery." WHERE answer_question='71' AND answer_uid='".$uid_me."' GROUP BY answer_question"));
			$cariagama		= mysql_fetch_array(mysql_query("SELECT choice_text FROM pmj_choice WHERE choice_id = '".$pribadia['answer_choice']."'"));
			$agamamatch 	= $cariagama['choice_text'];

			//drink
			$drinks			= mysql_fetch_array(mysql_query($primaryquery." WHERE answer_question='72' AND answer_uid='".$uid_me."' GROUP BY answer_question"));
			$drink			= mysql_fetch_array(mysql_query("SELECT choice_value FROM pmj_choice WHERE choice_id = '".$drinks['answer_choice']."'"));
			$drinkmatch 	= $drink['choice_value'];

			//smoke
			$smokes			= mysql_fetch_array(mysql_query($primaryquery." WHERE answer_question='73' AND answer_uid='".$uid_me."' GROUP BY answer_question"));
			$smoke			= mysql_fetch_array(mysql_query("SELECT choice_value FROM pmj_choice WHERE choice_id = '".$smokes['answer_choice']."'"));
			$smokematch 	= $smoke['choice_value'];


			$genderku		= mysql_fetch_array(mysql_query("SELECT gender FROM pmj_member WHERE id='".$uid_me."'"));
			//pencarian match
			$gender 		= $genderku['gender'];
			$caripribadi	= mysql_query($primaryquery." WHERE answer_uid='".$uid_me."' GROUP BY answer_question");

			while($pribadi = mysql_fetch_array($caripribadi)){

				//match children
				if($pribadi['answer_question']=='7'){
					if($pribadi['answer_choice']=='10'){
						$carimatch = mysql_query($primaryquery."
							WHERE
								a.answer_question = '6' AND
								a.answer_choice ='8' AND
								b.gender!='".$gender."' AND
								b.gender!=''
							GROUP BY
								answer_uid
						");
					}
					else{
						$carimatch = mysql_query($primaryquery."
							WHERE
								a.answer_question = '6' AND
								a.answer_choice ='7' AND
								b.gender!='".$gender."' AND
								b.gender!=''
							GROUP BY
								answer_uid
						");
					}
					while($match = mysql_fetch_array($carimatch)){
						@$matchs[$match['answer_uid']] = 1;
						$alert['children']='1';
					}
				}

				//inisialisasi agama
				if($pribadi['answer_question']=='63'){
					$agama = $pribadi['answer_choice'];
				}

				//inisialisasi education
				if($pribadi['answer_question']=='69'){
					$education = $pribadi['answer_choice'];
				}


				//match religion
				elseif($pribadi['answer_question']=='70'){

					if($pribadi['answer_choice']=="327" OR $pribadi['answer_choice']=="328"){
						$textagama	= mysql_fetch_array(mysql_query("
							SELECT choice_id FROM
							pmj_choice
							WHERE choice_text = '".$agamamatch."'
							ORDER BY choice_id ASC
							"));
						if($textagama['choice_id']=="301"){
							$carimatch = mysql_query($primaryquery."
								WHERE
									a.answer_question = '63' AND
									a.answer_choice !='' AND
									b.gender!='".$gender."' AND
									b.gender!=''
								GROUP BY
									answer_uid
							");
						}
						else{
							$carimatch = mysql_query($primaryquery."
								WHERE
									a.answer_question = '63' AND
									a.answer_choice ='".$textagama['choice_id']."' AND
									b.gender!='".$gender."' AND
									b.gender!=''
								GROUP BY
									answer_uid
							");
						}
					}
					else{
						$carimatch = mysql_query($primaryquery."
							WHERE
								a.answer_question = '63' AND
								a.answer_choice !='' AND
								b.gender!='".$gender."' AND
								b.gender!=''
							GROUP BY
								answer_uid
						");
					}
					while($match = mysql_fetch_array($carimatch)){
						if(@$matchs[$match['answer_uid']]!=""){
							@$matchs[$match['answer_uid']] += 1;
						}
						else{
							@$matchs[$match['answer_uid']] = 1;
						}
						$alert['religion']='1';
					}
				}


				//match drink
				elseif($pribadi['answer_question']=='72'){
					if($pribadi['answer_choice']=="337"){
						$pribadi['answer_choice'] = "305";
					}
					elseif($pribadi['answer_choice']=="338"){
						$pribadi['answer_choice'] = "306";
					}
					else{
						$pribadi['answer_choice'] = "307";
					}
					$carimatch = mysql_query("
						SELECT
							a.answer_uid,
							a.answer_question,
							a.answer_choice,
							b.gender
						FROM
							pmj_answer a,
							pmj_member b
						WHERE
							a.answer_question = '65' AND
							a.answer_choice ='".$pribadi['answer_choice']."' AND
							b.gender!='".$gender."' AND
							b.gender!=''
						GROUP BY
							answer_uid
					");
					while($match = mysql_fetch_array($carimatch)){
						if(@$matchs[$match['answer_uid']]!=""){
							@$matchs[$match['answer_uid']] += 1;
						}
						else{
							@$matchs[$match['answer_uid']] = 1;
						}
						$alert['drink']='1';
					}
				}


				//match smoke
				elseif($pribadi['answer_question']=='73'){
					if($pribadi['answer_choice']=="340"){
						$pribadi['answer_choice'] = "302";
					}
					elseif($pribadi['answer_choice']=="341"){
						$pribadi['answer_choice'] = "303";
					}
					else{
						$pribadi['answer_choice'] = "304";
					}
					$carimatch = mysql_query("
						SELECT
							a.answer_uid,
							a.answer_question,
							a.answer_choice,
							b.gender
						FROM
							pmj_answer a,
							pmj_member b
						WHERE
							a.answer_question = '64' AND
							a.answer_choice ='".$pribadi['answer_choice']."' AND
							b.gender!='".$gender."' AND
							b.gender!=''
						GROUP BY
							answer_uid
					");
					while($match = mysql_fetch_array($carimatch)){
						if(@$matchs[$match['answer_uid']]!=""){
							@$matchs[$match['answer_uid']] += 1;
						}
						else{
							@$matchs[$match['answer_uid']] = 1;
						}
						$alert['smoke']='1';
				    }
				}


				//match education
				elseif($pribadi['answer_question']=='74'){
					if($pribadi['answer_choice']=="344" OR $pribadi['answer_choice']=="345"){
						$carimatch = mysql_query($primaryquery."
							WHERE
								a.answer_question = '69' AND
								b.gender!='".$gender."' AND
								b.gender!=''
							GROUP BY
								answer_uid
						");
					}
					else{
						$carimatch = mysql_query($primaryquery."
							WHERE
								a.answer_question = '69' AND
								a.answer_choice ='".$education."' AND
								b.gender!='".$gender."' AND
								b.gender!=''
							GROUP BY
								answer_uid
						");
					}
					while($match = mysql_fetch_array($carimatch)){
						if(@$matchs[$match['answer_uid']]!=""){
							@$matchs[$match['answer_uid']] += 1;
						}
						else{
							@$matchs[$match['answer_uid']] = 1;
						}
						$alert['education']='1';
					}
				}

				//match relationship
				if($pribadi['answer_question']=='77'){
					$carimatch = mysql_query($primaryquery."
						WHERE
							a.answer_question = '".$pribadi['answer_question']."' AND
							a.answer_choice ='".$pribadi['answer_choice']."' AND
							b.gender!='".$gender."' AND
							b.gender!=''
						GROUP BY
							answer_uid
					");
					while($match = mysql_fetch_array($carimatch)){
						if(@$matchs[$match['answer_uid']]!=""){
							@$matchs[$match['answer_uid']] += 1;
						}
						else{
							@$matchs[$match['answer_uid']] = 1;
						}
						$alert['relationship']='1';
					}
				}
				
			}
			$i=0;
			foreach ($matchs as $key=>$info) {
				if($info==(count($alert))){
					if($i<5){
							$data = mysql_fetch_array(mysql_query("SELECT b.answer_uid, a.gender, a.birthday, a.code_id, a.email, a._80, c.filename_thumb FROM pmj_member a, pmj_answer b, pmj_member_photo c WHERE answer_uid='".$key."' AND b.answer_uid=a.id AND c.registration_id=a.id"));
							if($data['gender']!="" and $data['gender']!=$gender){
								$ok[$i] = array('id'=>$data['answer_uid'],
											'gender'=>$data['gender'],
											'birthday'=>$data['birthday'],
											'code_id'=>$data['code_id'],
											'email'=>$data['email'],
											'_80'=>$data['_80'],
											'photo'=>$data['filename_thumb']);
								$i++;
						}
					}
				}
			}

			if($i<1){
				//pencarian match jika kurang dari 1
				$caripribadi	= mysql_query($primaryquery." WHERE answer_uid='".$uid_me."' AND answer_question = '44' GROUP BY answer_question");
				while($pribadi = mysql_fetch_array($caripribadi)){
					$gender = $gender;
					$repl  = str_replace(" ", "", $pribadi['answer_choice']);
					$arr55 = explode(',', $repl);
					$max55 = count($arr55) - 1;
					for($i=0; $i<=$max55; $i++) {
					$carimatch = mysql_query($primaryquery."
						WHERE
							a.answer_question = '".$pribadi['answer_question']."' AND
							a.answer_choice LIKE '%".$arr55[$i]."%' AND
							b.gender!='".$gender."' AND
							b.gender!=''
						GROUP BY
							answer_uid
					");
					while($match = mysql_fetch_array($carimatch)){
						@$matcha[$match['answer_uid']] = 1;
						}
						$alertz['hobby']='1';
					}
				}

				$i=0;
				foreach ($matcha as $key=>$info) {
					if($info==(count($alertz))){
						if($i<5){
								$data = mysql_fetch_array(mysql_query("SELECT b.answer_uid, a.gender, a.birthday, a.code_id, a.email, a._80, c.filename_thumb FROM pmj_member a, pmj_answer b, pmj_member_photo c WHERE answer_uid='".$key."' AND b.answer_uid=a.id AND c.registration_id=a.id"));
								if($data['gender']!="" and $data['gender']!=$gender){
									$ok[$i] = array('id'=>$data['answer_uid'],
												'gender'=>$data['gender'],
												'birthday'=>$data['birthday'],
												'code_id'=>$data['code_id'],
												'email'=>$data['email'],
												'_80'=>$data['_80'],
												'photo'=>$data['filename_thumb']);
									$i++;
							}
						}
					}
				}
			}

			$str =  serialize($ok);
			if(count($alert)=="6"){
				$this->query->save("pmj_matches",array("match_uid"=>$uid_me,"match_data"=>$str,"match_date"=>date("Y-m-d h:i:s")));
			}
			else{
				$str = "N;";
				$this->query->save("pmj_matches",array("match_uid"=>$uid_me,"match_data"=>$str,"match_date"=>date("Y-m-d h:i:s")));
			}
			//echo json_encode("success");
	}

}

/* End of file question.php */
/* Location: ./application/controllers/question.php */