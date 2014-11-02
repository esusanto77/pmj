<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('query');

		if($this->uri->segment(4)!="dycode" || $this->uri->segment(5)!="setrasari"){
			redirect(base_url());
		}

	}

	public function cronjobMatch(){
		/*
		8-9 = Energetic 
		10-11 = Attractive
		12-13 = Loyal
		14-15 = Humorous
		16-17 = Patient
		18-19 = Passionate
		10-21 = Caring
		22-23 = Wise
		24-25 = Bossy
		26-27 = Leader
		28-29 = Aggressive
		30-31 = Outspoken
		32-33 = Romantic
		34-35 = Stubborn
		36 = I usually wait for others to lead the way
		37 = I love routine 
		38 = I think it is important to continually try to improve myself 
		39 = I care about the physical shape Im in
		40 = I feel better when I am around other people
		41 = I do things according to a plan
		42 = I seek adventure
		43 = I am easily discouraged 
		44 = Personal Interest Belum
		45 = Being exclusive (i.e., monogamous)
		46 = My partners dependability
		47 = My partners sex appeal
		48 = My partners physical appearance
		49 = Enjoying the way I feel around my partner
		50 = The friendship between me and my partner
		51 = Enjoying physical closeness with my partner
		52 = Being able to spend as much time as possible with my partner
		53 = Doing special things to let my partner know how important he/she is to me
		54 = I try to understand the other person
		55 = I try to be respectful of all opinions different from my own
		56 = I try to resolve conflict well
		57 = When I get romantically involved, I tell my partner just about everything
		58 = Its important to me to have close friends in my life 
		59 = I sometimes find it difficult to trust people I get romantically involved with
		60 = I find it easy to get emotionally close to people 
		Harus AND
		69 = How important is your match religion? * if yes check 70 = Match me with members who are... (select religion)
		71 = I would like my perfect match to drink
		72 = I would like my perfect match to SMOKE
		7 =  Are you open to meeting someone who already has children? if yes check 6 = Do you have any children 
		*/

		/* Mengambil data user */
		// $data['user'] = $this->query->getDataAnswerUser(getSessionUser(),'');
		$data['user'] = $this->query->getDataAnswerUser($this->uri->segment(3),'');

		foreach ($data['user'] as $key => $value) {
			$userMatch['answer_question'][$value->answer_question] = $value->answer_choice;
			$userMatch['answer_question_text'][$value->answer_question] = "$value->choice_text";
			$userMatch['answer_question_value'][$value->answer_question] = "$value->choice_value";
		}

		$query ="SELECT *
		FROM
		(select 
			a.answer_uid,
			b.gender,
			b.birthday,
			b.code_id,
			b.email,
			b._80,
			MAX(IF(a.answer_question = '6', a.answer_choice, NULL)) AS _6,
			MAX(IF(a.answer_question = '8',  c.choice_value, NULL)) AS _8,
			MAX(IF(a.answer_question = '10', c.choice_value, NULL)) AS _10,
			MAX(IF(a.answer_question = '12', c.choice_value, NULL)) AS _12,
			MAX(IF(a.answer_question = '14', c.choice_value, NULL)) AS _14,
			MAX(IF(a.answer_question = '16', c.choice_value, NULL)) AS _16,
			MAX(IF(a.answer_question = '18', c.choice_value, NULL)) AS _18,
			MAX(IF(a.answer_question = '20', c.choice_value, NULL)) AS _20,
			MAX(IF(a.answer_question = '22', c.choice_value, NULL)) AS _22, 
			MAX(IF(a.answer_question = '24', c.choice_value, NULL)) AS _24, 
			MAX(IF(a.answer_question = '26', c.choice_value, NULL)) AS _26, 
			MAX(IF(a.answer_question = '28', c.choice_value, NULL)) AS _28, 
			MAX(IF(a.answer_question = '30', c.choice_value, NULL)) AS _30, 
			MAX(IF(a.answer_question = '32', c.choice_value, NULL)) AS _32, 
			MAX(IF(a.answer_question = '34', c.choice_value, NULL)) AS _34,
			MAX(IF(a.answer_question = '36', a.answer_choice, NULL)) AS _36, 
			MAX(IF(a.answer_question = '37', a.answer_choice, NULL)) AS _37, 
			MAX(IF(a.answer_question = '38', a.answer_choice, NULL)) AS _38,
			MAX(IF(a.answer_question = '39', a.answer_choice, NULL)) AS _39,  
			MAX(IF(a.answer_question = '40', a.answer_choice, NULL)) AS _40,
			MAX(IF(a.answer_question = '41', a.answer_choice, NULL)) AS _41,  
			MAX(IF(a.answer_question = '42', a.answer_choice, NULL)) AS _42,
			MAX(IF(a.answer_question = '43', a.answer_choice, NULL)) AS _43,  
			MAX(IF(a.answer_question = '44', a.answer_choice, NULL)) AS _44, 
			MAX(IF(a.answer_question = '45', a.answer_choice, NULL)) AS _45, 
			MAX(IF(a.answer_question = '46', a.answer_choice, NULL)) AS _46, 
			MAX(IF(a.answer_question = '47', a.answer_choice, NULL)) AS _47, 
			MAX(IF(a.answer_question = '48', a.answer_choice, NULL)) AS _48, 
			MAX(IF(a.answer_question = '49', a.answer_choice, NULL)) AS _49, 
			MAX(IF(a.answer_question = '50', a.answer_choice, NULL)) AS _50, 
			MAX(IF(a.answer_question = '51', a.answer_choice, NULL)) AS _51, 
			MAX(IF(a.answer_question = '52', a.answer_choice, NULL)) AS _52, 
			MAX(IF(a.answer_question = '53', a.answer_choice, NULL)) AS _53, 
			MAX(IF(a.answer_question = '54', a.answer_choice, NULL)) AS _54, 
			MAX(IF(a.answer_question = '55', a.answer_choice, NULL)) AS _55, 
			MAX(IF(a.answer_question = '56', a.answer_choice, NULL)) AS _56, 
			MAX(IF(a.answer_question = '57', a.answer_choice, NULL)) AS _57, 
			MAX(IF(a.answer_question = '58', a.answer_choice, NULL)) AS _58, 
			MAX(IF(a.answer_question = '59', a.answer_choice, NULL)) AS _59, 
			MAX(IF(a.answer_question = '60', a.answer_choice, NULL)) AS _60,
			MAX(IF(a.answer_question = '63', c.choice_text, NULL)) AS _63,
			MAX(IF(a.answer_question = '64', c.choice_value, NULL)) AS _64, 
			MAX(IF(a.answer_question = '65', c.choice_value, NULL)) AS _65
			from pmj_answer a
			inner join pmj_member b on a.answer_uid=b.id 
			inner join pmj_choice c on a.answer_choice=c.choice_id
			GROUP BY
			a.answer_uid) as x ";

		$query .= "where ((_8<='".($userMatch['answer_question_value']['9']+1)."' and _8>='".($userMatch['answer_question_value']['9']-1)."' ) or";
		$query .= " (_10<='".($userMatch['answer_question_value']['11']+1)."' and _10>='".($userMatch['answer_question_value']['11']-1)."' ) or";
		$query .= " (_12<='".($userMatch['answer_question_value']['13']+1)."' and _12>='".($userMatch['answer_question_value']['13']-1)."' ) or";
		$query .= " (_14<='".($userMatch['answer_question_value']['15']+1)."' and _14>='".($userMatch['answer_question_value']['15']-1)."' ) or";
		$query .= " (_16<='".($userMatch['answer_question_value']['17']+1)."' and _16>='".($userMatch['answer_question_value']['17']-1)."' ) or";
		$query .= " (_18<='".($userMatch['answer_question_value']['19']+1)."' and _18>='".($userMatch['answer_question_value']['19']-1)."' ) or";
		$query .= " (_20<='".($userMatch['answer_question_value']['21']+1)."' and _20>='".($userMatch['answer_question_value']['21']-1)."' ) or";
		$query .= " (_22<='".($userMatch['answer_question_value']['23']+1)."' and _22>='".($userMatch['answer_question_value']['23']-1)."' ) or";
		$query .= " (_24<='".($userMatch['answer_question_value']['25']+1)."' and _24>='".($userMatch['answer_question_value']['25']-1)."' ) or";
		$query .= " (_26<='".($userMatch['answer_question_value']['27']+1)."' and _26>='".($userMatch['answer_question_value']['27']-1)."' ) or";
		$query .= " (_28<='".($userMatch['answer_question_value']['29']+1)."' and _28>='".($userMatch['answer_question_value']['29']-1)."' ) or";
		$query .= " (_30<='".($userMatch['answer_question_value']['31']+1)."' and _30>='".($userMatch['answer_question_value']['31']-1)."' ) or";
		$query .= " (_32<='".($userMatch['answer_question_value']['33']+1)."' and _32>='".($userMatch['answer_question_value']['33']-1)."' ) or";
		$query .= " (_34<='".($userMatch['answer_question_value']['35']+1)."' and _34>='".($userMatch['answer_question_value']['35']-1)."' ) or";
		$query .= " (_36<='".($userMatch['answer_question']['36']+1)."' and _36>='".($userMatch['answer_question']['36']-1)."' ) or";
		$query .= " (_37<='".($userMatch['answer_question']['37']+1)."' and _37>='".($userMatch['answer_question']['37']-1)."' ) or";
		$query .= " (_38<='".($userMatch['answer_question']['38']+1)."' and _38>='".($userMatch['answer_question']['38']-1)."' ) or";
		$query .= " (_39<='".($userMatch['answer_question']['39']+1)."' and _39>='".($userMatch['answer_question']['39']-1)."' ) or";
		$query .= " (_40<='".($userMatch['answer_question']['40']+1)."' and _40>='".($userMatch['answer_question']['40']-1)."' ) or";
		$query .= " (_41<='".($userMatch['answer_question']['41']+1)."' and _41>='".($userMatch['answer_question']['41']-1)."' ) or";
		$query .= " (_42<='".($userMatch['answer_question']['42']+1)."' and _42>='".($userMatch['answer_question']['42']-1)."' ) or";
		$query .= " (_43<='".($userMatch['answer_question']['43']+1)."' and _43>='".($userMatch['answer_question']['43']-1)."' ) or";
		$query .= " (_44<='".($userMatch['answer_question']['44']+1)."' and _44>='".($userMatch['answer_question']['44']-1)."' ) or";
		$query .= " (_45<='".($userMatch['answer_question']['45']+1)."' and _45>='".($userMatch['answer_question']['45']-1)."' ) or";
		$query .= " (_46<='".($userMatch['answer_question']['46']+1)."' and _46>='".($userMatch['answer_question']['46']-1)."' ) or";
		$query .= " (_47<='".($userMatch['answer_question']['47']+1)."' and _47>='".($userMatch['answer_question']['47']-1)."' ) or";
		$query .= " (_48<='".($userMatch['answer_question']['48']+1)."' and _48>='".($userMatch['answer_question']['48']-1)."' ) or";
		$query .= " (_49<='".($userMatch['answer_question']['49']+1)."' and _49>='".($userMatch['answer_question']['49']-1)."' ) or";
		$query .= " (_50<='".($userMatch['answer_question']['50']+1)."' and _50>='".($userMatch['answer_question']['50']-1)."' ) or";
		$query .= " (_51<='".($userMatch['answer_question']['51']+1)."' and _51>='".($userMatch['answer_question']['51']-1)."' ) or";
		$query .= " (_52<='".($userMatch['answer_question']['52']+1)."' and _52>='".($userMatch['answer_question']['52']-1)."' ) or";
		$query .= " (_53<='".($userMatch['answer_question']['53']+1)."' and _53>='".($userMatch['answer_question']['53']-1)."' ) or";
		$query .= " (_54<='".($userMatch['answer_question']['54']+1)."' and _54>='".($userMatch['answer_question']['54']-1)."' ) or";
		$query .= " (_55<='".($userMatch['answer_question']['55']+1)."' and _55>='".($userMatch['answer_question']['55']-1)."' ) or";
		$query .= " (_56<='".($userMatch['answer_question']['56']+1)."' and _56>='".($userMatch['answer_question']['56']-1)."' ) or";
		$query .= " (_57<='".($userMatch['answer_question']['57']+1)."' and _57>='".($userMatch['answer_question']['57']-1)."' ) or";
		$query .= " (_58<='".($userMatch['answer_question']['58']+1)."' and _58>='".($userMatch['answer_question']['58']-1)."' ) or";
		$query .= " (_59<='".($userMatch['answer_question']['59']+1)."' and _59>='".($userMatch['answer_question']['59']-1)."' ) or";

		//What are your personal interests?
		$arr55 = explode(',', $userMatch['answer_question']['44']);
		$max55 = count($arr55) - 1;
		for($i=0; $i<=$max55; $i++) {
			$query.= "`_44` like '%".$arr55[$i]."%' OR ";
		}

		$query .= " (_60<='".($userMatch['answer_question']['60']+1)."' and _60>='".($userMatch['answer_question']['60']-1)."' )) and";
		$query .= " (_65='".($userMatch['answer_question_value']['72'])."') and ";
		$query .= " (_64='".($userMatch['answer_question_value']['73'])."') and ";
		$query .= " (gender!='".$data['user'][0]->gender."') and ";
		$query .= " (gender!='') ";

		// Religion
		if($userMatch['answer_question']['70']=="327" or $userMatch['answer_question']['70']=="328" ){
			if($userMatch["answer_question_text"]["71"]!="Any"){
				$query .= "and _63='".$userMatch["answer_question_text"]["71"]."' ";
			}
		}

		// Children
		if($userMatch['answer_question']['7']=="10"){
			$query .= "and _6='8' ";
		}

		$resultQuery = $this->db->query($query);

		$i=0;
		foreach ($resultQuery->result() as $value)
		{

			if($i<=50){
				$photo = $this->query->get("pmj_member_photo",array("where"=>array("registration_id"=>$value->answer_uid,"type"=>"main"),
				"select"=>"filename_thumb"));

				$ok[$i] = array('id'=>$value->answer_uid,
							'gender'=>$value->gender,
							'birthday'=>$value->birthday,
							'code_id'=>$value->code_id,
							'email'=>$value->email,
							'_80'=>$value->_80,
							'photo'=>$photo[0]->filename_thumb);
			}else{
				break;
			}
			
			$i++;
		}

		$str =  serialize($ok);
		$this->query->save("pmj_matches",array("match_uid"=>$this->uri->segment(3),"match_data"=>$str,"match_date"=>date("Y-m-d h:i:s")));

		echo json_encode("success");
	}

	public function cronjobMatchWithEmail(){
		/* Mengambil data user */
		$data['user'] = $this->query->getDataAnswerUser($this->uri->segment(3),'');

		foreach ($data['user'] as $key => $value) {
			$userMatch['answer_question'][$value->answer_question] = $value->answer_choice;
			$userMatch['answer_question_text'][$value->answer_question] = "$value->choice_text";
			$userMatch['answer_question_value'][$value->answer_question] = "$value->choice_value";
		}

		$query ="SELECT *
		FROM
		(select 
			a.answer_uid,
			b.gender,
			b.birthday,
			b.code_id,
			b.email,
			b._80,
			MAX(IF(a.answer_question = '6', a.answer_choice, NULL)) AS _6,
			MAX(IF(a.answer_question = '8',  c.choice_value, NULL)) AS _8,
			MAX(IF(a.answer_question = '10', c.choice_value, NULL)) AS _10,
			MAX(IF(a.answer_question = '12', c.choice_value, NULL)) AS _12,
			MAX(IF(a.answer_question = '14', c.choice_value, NULL)) AS _14,
			MAX(IF(a.answer_question = '16', c.choice_value, NULL)) AS _16,
			MAX(IF(a.answer_question = '18', c.choice_value, NULL)) AS _18,
			MAX(IF(a.answer_question = '20', c.choice_value, NULL)) AS _20,
			MAX(IF(a.answer_question = '22', c.choice_value, NULL)) AS _22, 
			MAX(IF(a.answer_question = '24', c.choice_value, NULL)) AS _24, 
			MAX(IF(a.answer_question = '26', c.choice_value, NULL)) AS _26, 
			MAX(IF(a.answer_question = '28', c.choice_value, NULL)) AS _28, 
			MAX(IF(a.answer_question = '30', c.choice_value, NULL)) AS _30, 
			MAX(IF(a.answer_question = '32', c.choice_value, NULL)) AS _32, 
			MAX(IF(a.answer_question = '34', c.choice_value, NULL)) AS _34,
			MAX(IF(a.answer_question = '36', a.answer_choice, NULL)) AS _36, 
			MAX(IF(a.answer_question = '37', a.answer_choice, NULL)) AS _37, 
			MAX(IF(a.answer_question = '38', a.answer_choice, NULL)) AS _38,
			MAX(IF(a.answer_question = '39', a.answer_choice, NULL)) AS _39,  
			MAX(IF(a.answer_question = '40', a.answer_choice, NULL)) AS _40,
			MAX(IF(a.answer_question = '41', a.answer_choice, NULL)) AS _41,  
			MAX(IF(a.answer_question = '42', a.answer_choice, NULL)) AS _42,
			MAX(IF(a.answer_question = '43', a.answer_choice, NULL)) AS _43,  
			MAX(IF(a.answer_question = '44', a.answer_choice, NULL)) AS _44, 
			MAX(IF(a.answer_question = '45', a.answer_choice, NULL)) AS _45, 
			MAX(IF(a.answer_question = '46', a.answer_choice, NULL)) AS _46, 
			MAX(IF(a.answer_question = '47', a.answer_choice, NULL)) AS _47, 
			MAX(IF(a.answer_question = '48', a.answer_choice, NULL)) AS _48, 
			MAX(IF(a.answer_question = '49', a.answer_choice, NULL)) AS _49, 
			MAX(IF(a.answer_question = '50', a.answer_choice, NULL)) AS _50, 
			MAX(IF(a.answer_question = '51', a.answer_choice, NULL)) AS _51, 
			MAX(IF(a.answer_question = '52', a.answer_choice, NULL)) AS _52, 
			MAX(IF(a.answer_question = '53', a.answer_choice, NULL)) AS _53, 
			MAX(IF(a.answer_question = '54', a.answer_choice, NULL)) AS _54, 
			MAX(IF(a.answer_question = '55', a.answer_choice, NULL)) AS _55, 
			MAX(IF(a.answer_question = '56', a.answer_choice, NULL)) AS _56, 
			MAX(IF(a.answer_question = '57', a.answer_choice, NULL)) AS _57, 
			MAX(IF(a.answer_question = '58', a.answer_choice, NULL)) AS _58, 
			MAX(IF(a.answer_question = '59', a.answer_choice, NULL)) AS _59, 
			MAX(IF(a.answer_question = '60', a.answer_choice, NULL)) AS _60,
			MAX(IF(a.answer_question = '63', c.choice_text, NULL)) AS _63,
			MAX(IF(a.answer_question = '64', c.choice_value, NULL)) AS _64, 
			MAX(IF(a.answer_question = '65', c.choice_value, NULL)) AS _65
			from pmj_answer a
			inner join pmj_member b on a.answer_uid=b.id 
			inner join pmj_choice c on a.answer_choice=c.choice_id
			GROUP BY
			a.answer_uid) as x ";

		$query .= "where ((_8<='".($userMatch['answer_question_value']['9']+1)."' and _8>='".($userMatch['answer_question_value']['9']-1)."' ) or";
		$query .= " (_10<='".($userMatch['answer_question_value']['11']+1)."' and _10>='".($userMatch['answer_question_value']['11']-1)."' ) or";
		$query .= " (_12<='".($userMatch['answer_question_value']['13']+1)."' and _12>='".($userMatch['answer_question_value']['13']-1)."' ) or";
		$query .= " (_14<='".($userMatch['answer_question_value']['15']+1)."' and _14>='".($userMatch['answer_question_value']['15']-1)."' ) or";
		$query .= " (_16<='".($userMatch['answer_question_value']['17']+1)."' and _16>='".($userMatch['answer_question_value']['17']-1)."' ) or";
		$query .= " (_18<='".($userMatch['answer_question_value']['19']+1)."' and _18>='".($userMatch['answer_question_value']['19']-1)."' ) or";
		$query .= " (_20<='".($userMatch['answer_question_value']['21']+1)."' and _20>='".($userMatch['answer_question_value']['21']-1)."' ) or";
		$query .= " (_22<='".($userMatch['answer_question_value']['23']+1)."' and _22>='".($userMatch['answer_question_value']['23']-1)."' ) or";
		$query .= " (_24<='".($userMatch['answer_question_value']['25']+1)."' and _24>='".($userMatch['answer_question_value']['25']-1)."' ) or";
		$query .= " (_26<='".($userMatch['answer_question_value']['27']+1)."' and _26>='".($userMatch['answer_question_value']['27']-1)."' ) or";
		$query .= " (_28<='".($userMatch['answer_question_value']['29']+1)."' and _28>='".($userMatch['answer_question_value']['29']-1)."' ) or";
		$query .= " (_30<='".($userMatch['answer_question_value']['31']+1)."' and _30>='".($userMatch['answer_question_value']['31']-1)."' ) or";
		$query .= " (_32<='".($userMatch['answer_question_value']['33']+1)."' and _32>='".($userMatch['answer_question_value']['33']-1)."' ) or";
		$query .= " (_34<='".($userMatch['answer_question_value']['35']+1)."' and _34>='".($userMatch['answer_question_value']['35']-1)."' ) or";
		$query .= " (_36<='".($userMatch['answer_question']['36']+1)."' and _36>='".($userMatch['answer_question']['36']-1)."' ) or";
		$query .= " (_37<='".($userMatch['answer_question']['37']+1)."' and _37>='".($userMatch['answer_question']['37']-1)."' ) or";
		$query .= " (_38<='".($userMatch['answer_question']['38']+1)."' and _38>='".($userMatch['answer_question']['38']-1)."' ) or";
		$query .= " (_39<='".($userMatch['answer_question']['39']+1)."' and _39>='".($userMatch['answer_question']['39']-1)."' ) or";
		$query .= " (_40<='".($userMatch['answer_question']['40']+1)."' and _40>='".($userMatch['answer_question']['40']-1)."' ) or";
		$query .= " (_41<='".($userMatch['answer_question']['41']+1)."' and _41>='".($userMatch['answer_question']['41']-1)."' ) or";
		$query .= " (_42<='".($userMatch['answer_question']['42']+1)."' and _42>='".($userMatch['answer_question']['42']-1)."' ) or";
		$query .= " (_43<='".($userMatch['answer_question']['43']+1)."' and _43>='".($userMatch['answer_question']['43']-1)."' ) or";
		$query .= " (_44<='".($userMatch['answer_question']['44']+1)."' and _44>='".($userMatch['answer_question']['44']-1)."' ) or";
		$query .= " (_45<='".($userMatch['answer_question']['45']+1)."' and _45>='".($userMatch['answer_question']['45']-1)."' ) or";
		$query .= " (_46<='".($userMatch['answer_question']['46']+1)."' and _46>='".($userMatch['answer_question']['46']-1)."' ) or";
		$query .= " (_47<='".($userMatch['answer_question']['47']+1)."' and _47>='".($userMatch['answer_question']['47']-1)."' ) or";
		$query .= " (_48<='".($userMatch['answer_question']['48']+1)."' and _48>='".($userMatch['answer_question']['48']-1)."' ) or";
		$query .= " (_49<='".($userMatch['answer_question']['49']+1)."' and _49>='".($userMatch['answer_question']['49']-1)."' ) or";
		$query .= " (_50<='".($userMatch['answer_question']['50']+1)."' and _50>='".($userMatch['answer_question']['50']-1)."' ) or";
		$query .= " (_51<='".($userMatch['answer_question']['51']+1)."' and _51>='".($userMatch['answer_question']['51']-1)."' ) or";
		$query .= " (_52<='".($userMatch['answer_question']['52']+1)."' and _52>='".($userMatch['answer_question']['52']-1)."' ) or";
		$query .= " (_53<='".($userMatch['answer_question']['53']+1)."' and _53>='".($userMatch['answer_question']['53']-1)."' ) or";
		$query .= " (_54<='".($userMatch['answer_question']['54']+1)."' and _54>='".($userMatch['answer_question']['54']-1)."' ) or";
		$query .= " (_55<='".($userMatch['answer_question']['55']+1)."' and _55>='".($userMatch['answer_question']['55']-1)."' ) or";
		$query .= " (_56<='".($userMatch['answer_question']['56']+1)."' and _56>='".($userMatch['answer_question']['56']-1)."' ) or";
		$query .= " (_57<='".($userMatch['answer_question']['57']+1)."' and _57>='".($userMatch['answer_question']['57']-1)."' ) or";
		$query .= " (_58<='".($userMatch['answer_question']['58']+1)."' and _58>='".($userMatch['answer_question']['58']-1)."' ) or";
		$query .= " (_59<='".($userMatch['answer_question']['59']+1)."' and _59>='".($userMatch['answer_question']['59']-1)."' ) or";

		//What are your personal interests?
		$arr55 = explode(',', $userMatch['answer_question']['44']);
		$max55 = count($arr55) - 1;
		for($i=0; $i<=$max55; $i++) {
			$query.= "`_44` like '%".$arr55[$i]."%' OR ";
		}

		$query .= " (_60<='".($userMatch['answer_question']['60']+1)."' and _60>='".($userMatch['answer_question']['60']-1)."' )) and";
		$query .= " (_65='".($userMatch['answer_question_value']['72'])."') and ";
		$query .= " (_64='".($userMatch['answer_question_value']['73'])."') and ";
		$query .= " (gender!='".$data['user'][0]->gender."') and ";
		$query .= " (gender!='') ";

		// Religion
		if($userMatch['answer_question']['70']=="327" or $userMatch['answer_question']['70']=="328" ){
			if($userMatch["answer_question_text"]["71"]!="Any"){
				$query .= "and _63='".$userMatch["answer_question_text"]["71"]."' ";
			}
		}

		// Children
		if($userMatch['answer_question']['7']=="10"){
			$query .= "and _6='8' ";
		}

		$resultQuery = $this->db->query($query);

		$i=0;
		foreach ($resultQuery->result() as $value)
		{
			if($i<=50){
				$photo = $this->query->get("pmj_member_photo",array("where"=>array("registration_id"=>$value->answer_uid,"type"=>"main"),
				"select"=>"filename_thumb"));

				$ok[$i] = array('id'=>$value->answer_uid,
							'gender'=>$value->gender,
							'birthday'=>$value->birthday,
							'code_id'=>$value->code_id,
							'email'=>$value->email,
							'_80'=>$value->_80,
							'photo'=>$photo[0]->filename_thumb);
			}else{
				break;
			}
			
			$i++;
		}

		$str =  serialize($ok);

		// Data sebelumnya
		$queryMatchesBefore = $this->query->get("matches", array("where" => array("match_uid" => $this->uri->segment(3)),"limit"=>"1","order"=>"match_id desc"));
		$matchesBefore = array();

		$matchesBefore = array_merge($matchesBefore, unserialize($queryMatchesBefore[0]->match_data));

		// Data sesudahnya
		$matchesAfter = array();
		$matchesAfter = array_merge($matchesAfter, unserialize($str));

		$countMatch=0;
		foreach($matchesAfter as $i => $ma){
			$cek="true";
			foreach($matchesBefore as $i => $mb){
				if($ma['code_id']==$mb['code_id']){
					$cek = "false";
					break;
				}
			}

			if($cek=="true"){
				$dataUser['user']['new_match']['code_id'][$countMatch] =  $ma['code_id'];
			 	$dataUser['user']['new_match']['code_id']['gender'][$countMatch] =  $ma['gender'];	
			 	if($ma['photo']==""){
			 		$dataUser['user']['new_match']['code_id']['photo'][$countMatch] =  "http://placehold.it/160x160&text=no+image";	
			 	}else{
			 		$dataUser['user']['new_match']['code_id']['photo'][$countMatch] =  $ma['photo'];	
			 	}

			 	if($ma['_80']===""){
			 		$dataUser['user']['new_match']['code_id']['_80'][$countMatch] = "No Description";
			 	}else{
			 		$description = substr($ma['_80'], 0, 28);
 					if (strlen($ma['_80']) > 28){
 						$dataUser['user']['new_match']['code_id']['_80'][$countMatch]  =$description." ...";
 					}
 					else{
 						$dataUser['user']['new_match']['code_id']['_80'][$countMatch] =  $ma['_80'];		
 					}				
			 	}
				$countMatch++;
			}
		}
		
		$param['user'] = array();	
					$tengah = 0;
					$data = "";
		if($countMatch > 0){
			for ($i=0; $i < $countMatch ; $i++) { 
					if($tengah>2){
						$tengah = 0;
					}

					if($tengah===1){
						$persen = "33%";
					}else{
						$persen = "33.5%";
					}
					$data .= '<table width="'.$persen.'" align="left" cellpadding="0" cellspacing="0" class="deviceWidth">
                                        <tr>
                                            <<td valign="top" align="center" style="padding: 10px 0 0px;">
                                                    <p style="mso-table-lspace:0;mso-table-rspace:0; margin:0"><a href="#"><img src="'.$dataUser['user']['new_match']['code_id']['photo'][$i].'" alt="" height="170" width="170" border="0" style="width: 170px;border-radius:5px;" class="deviceWidth" /></a></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 10px 20px 10px">
                                                <p style="font-size: 14px; color: black	; font-weight: bold; ">'.$dataUser['user']['new_match']['code_id'][$i].'</p>
                                                <p style="color:#ddd; text-align:left; font-size: 14px; line-height:17px">'.$dataUser['user']['new_match']['code_id']['_80'][$i].'</p>
                                            </td>
                                        </tr>
                                    </table>';
                                    $tengah++;


                    if($i>4){
                    	break;
                    }         
			}

			$sendEmail = array("data"=>$data,"id"=>$this->uri->segment(3));
			sendEmail("emailMatch",$sendEmail);
		}

		$this->query->save("pmj_matches",array("match_uid"=>$this->uri->segment(3),"match_data"=>$str,"match_date"=>date("Y-m-d h:i:s")));

		echo json_encode("success");
	}

}



/* End of file cronjob.php */
/* Location: ./application/controllers/cronjob.php */