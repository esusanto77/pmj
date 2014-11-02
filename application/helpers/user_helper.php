<?php 

	function getNewCode()
	{
		$rand = strtoupper(substr(md5(microtime()),rand(0,26),8));
		return $rand;
	}		

	function getProfile($id,$field="")
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    if(empty($field)){
	    	$data['select'] = $field;
	    }
	    $data['where'] = array("id"=>$id);
	    $user = $ci->query->get("member",$data);
	    return $user[0]->$field;
	}	

	/**
	 * get user session function
	 * to get session of current user
	 * @return void
	 * @author 
	 **/
	function getSessionUser()
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    if($ci->input->cookie("rememberMe")=="TRUE"){
	    	return $ci->session->userdata("uid");
	    }else{
	    	if($ci->session->userdata("uid")!=""){
	    		$ci->session->sess_destroy();

	    		redirect(base_url());
	    	}
	    }
		
	}

	function getSessionCodeId()
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		return $ci->session->userdata("code_id");
	}

	function getSessionGender()
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		return $ci->session->userdata("gender");
	}

	function getSessionEmail()
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		return $ci->session->userdata("email");
	}

	function getSessionSubscript()
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		return $ci->session->userdata("subscription");
	}

	/**
	 * get auth user function
	 * to print username by session auth
	 * @return void
	 * @author 
	 **/
	function getAuthUsername()
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		return ucfirst($ci->session->userdata("uname"));
	}


	/**
	 * get avatar function
	 * to get avatar image
	 * @return void
	 * @author 
	 **/
	function getAvatarPhoto($uid)
	{

		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    $ci->load->model("query");
	    $array["registration_id"] = $uid;
	     $array["type"] = "main";

	    $filename = $ci->query->get("member_photo",array('where'=>$array,'order'=>"id desc"));
		
	    if(!empty($filename)){
	    	if($filename[0]->avatar=="1"){
	    		// $photo = base_url("public")."/assets/img/avatar/".$filename[0]->filename;	 
	    		$photo = $filename[0]->filename;	      
	    	}else{
	    		// $photo = base_url("public")."/upload/img/thumb/".$filename[0]->filename_thumb;
	    		$photo = $filename[0]->filename_thumb;	    
	    	}
	    	
	    } else {
	    	// check at facebook
	    	$user = $ci->query->get("member",array("where"=>array("id"=>$uid)));
	    	if($user[0]->login_with == "facebook"){
	    		$photo = "http://graph.facebook.com/".$user[0]->social_id."/picture";	    		
	    	} 	    	
	    }

	    if(empty($photo)){
	    	$photo = "http://placehold.it/138x138&text=noimage";
	    }
	    return $photo;
		
	}


	/* 
	 * get annoucement for user that active
	 */

	function getAnnouncement($uid)
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    $ci->load->model("query");
	    
		$ann = $ci->query->get("announcement",array( "order"=>"id_title desc","limit"=>1, "where"=>array("uid"=>$uid, "start_date <=" => date("Y-m-d"),"end_date >=" => date("Y-m-d"))));

		return $ann;

	}

	/* Get data user subscription */
	function getUserSubscription($code_id,$uri)
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    if(!empty($uri)){
	    	 $checkCode  = $ci->query->get('pmj_member',array("where"=>array("code_id"=>$uri)));

		   	if(!empty($checkCode)){
		   		$code_id = $checkCode[0]->code_id;
		   	}else{
		   		$code_id = getSessionCodeId();
		   	}	
	    }
	 
	   	$getSubscription = $ci->query->getDataSubcription($code_id);

		if(!empty($getSubscription)){
			return $getSubscription[0]->name_product;
		}
		else{
			return "No Subscription"; 
		}     
	}

	/* Get data expired user subscription */
	function checkExpiredUserSubscription($code_id,$uri)
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    $expired = "";

	    if(!empty($uri)){
	    	 $checkCode  = $ci->query->get('pmj_member',array("where"=>array("code_id"=>$uri)));

		   	if(!empty($checkCode)){
		   		$code_id = $checkCode[0]->code_id;
		   	}else{
		   		$code_id = getSessionCodeId();
		   	}	
	    }
	 
	   	$getSubscription = $ci->query->getDataSubcription($code_id);

		if(!empty($getSubscription)){
			$day = ceil((strtotime($getSubscription[0]->expire_date)-strtotime(date("Y-m-d H:i:s")))/(60*60*24));

			if($day > 1){
				$expired = "Expires in <strong> $day </strong> days";
			}elseif(($day > 0) && ($day<=1)){
				$expired = "Expires in <strong> $day </strong> day";
			}
			elseif($day <= 0){
				$expired = "Your account has been expired";
			} 
		}
		
		return $expired;  
	}

	/* Get data expired user session subscription */
	function checkExpiredUserSessionSubscription($id)
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    $user  = $ci->query->get("subscription",array("where"=>array("id_member"=>$id)));
	    if($user){
				if($user[0]->expire_date > date("Y-m-d H:i:s")){
					return "true";
				}else{
					return "false";
				}
		}else{
			return "false";
		}
	}


	/* Check Verification */
	function checkVerification(){
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    $getSubscription = $ci->query->getDataSubcription(getSessionCodeId());

	    if($getSubscription){
	    	return true;
	    }else{
		     $checkVerification  = $ci->query->get('pmj_verification',array("where"=>array("id_member"=>getSessionUser(),"status"=>"accept")));

		     if($checkVerification){
		     	return true;
		     }else{
		     	 $checkTotalReject  = $ci->query->get('pmj_verification',array("count"=>1,"where"=>array("id_member"=>getSessionUser(),"status"=>"reject","status !="=>"accept")));

			     if($checkTotalReject[0]->total >= 3){
			     		return true;
			     }else{
		     		return false;
		     	}
		     }
	 	}
	}

	/* Check 48 Hours Verification */
	function checkHoursVerification(){
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    redirectQuestion();

	    $getSubscription = $ci->query->getDataSubcription(getSessionCodeId());

	    if($getSubscription){
	    	return true;
	    }else{
	     $checkTotalReject  = $ci->query->get('pmj_verification',array("count"=>1,"where"=>array("id_member"=>getSessionUser(),"status"=>"reject","status !="=>"accept")));

	     if($checkTotalReject[0]->total >= 3){
	     	redirect(base_url("verification")."/suspendAccount");
	     }else{
	   		$checkVerification  = $ci->query->get('pmj_verification',array("where"=>array("id_member"=>getSessionUser(),"status"=>"accept")));

		     if($checkVerification){
		     	return true;
		     }else{
				$checkSubmitDate  = $ci->query->get('pmj_member',array("where"=>array("id"=>getSessionUser())));

				if($checkSubmitDate[0]->first_login){
					$hourdiff  = round((strtotime(date("Y-m-d H:i:s")) - strtotime(''.$checkSubmitDate[0]->first_login.''))/3600, 1);

					if(getSetting('8')=="true"){
						if($hourdiff >= 48){
							// redirect(base_url("verification")."/suspendAccount");
							redirect(base_url("verification")."/waitingVerification");
						}
					}				
				}else{
					return true;
				}
				
		     } 	
	     }	   
	   }
	}

	function checkVerificationLimit(){
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		$checkSubmitDate  = $ci->query->get('pmj_member',array("where"=>array("id"=>getSessionUser())));

		if($checkSubmitDate[0]->first_login){
			$hourdiff  = round((strtotime(date("Y-m-d H:i:s")) - strtotime(''.$checkSubmitDate[0]->first_login.''))/3600, 1);

			if(getSetting('8')=="true"){
				return $hourdiff >= 48 ?  true :  false;
			}else{
				return false;
			}				
		}else{
			return false;
		}
	}

	/**
	 * save user meta function
	 * to save the user meta
	 * @return void
	 * @author 
	 **/
	function saveUserMeta($uid,$key,$value,$group = "")
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		$data['mm_uid'] = $uid;
		$data['mm_key'] = $key;
		$data['mm_value'] = $value;
		$data['mm_group'] = $group;
		$ci->query->save("member_meta",$data);
	}

	/**
	 * get user meta function
	 * to get the user meta
	 * @return void
	 * @author 
	 **/
	function getUserMeta($uid,$key)
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		$get = $ci->query->get(
			"member_meta",
			array(
				"where" => array(
					"mm_key" => $key,
					"mm_uid" => $uid
				)
			)
		);

		if(!empty($get)){
			return $get[0]->mm_value;
		} else {
			return 0;
		}		
	}

	function checkActivity($from, $to)
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		$get = $ci->query->get(
			"activity",
			array(
				"where" => array(
					"act_from_user" => $from,
					"act_to_user" => $to,
					"act_label" => "favorite"
				),
				"order" => "act_id desc",
				"limit" => 1
			)
		);

		if(!empty($get)){
			if( $get[0]->act_label === "favorite" )
				return 1;
			else
				return 0;
		} else {
			return 0;
		}		
	}

	function checkAllActivity($from, $to, $label)
	{
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		$get = $ci->query->get(
			"activity",
			array(
				"where" => array(
					"act_from_user" => $from,
					"act_to_user" => $to,
					"act_label" => $label
				),
				"order" => "act_id desc",
				"limit" => 1
			)
		);

		if(!empty($get)){
			if( $get[0]->act_label === "favorite" )
				return 'favorite';
			elseif( $get[0]->act_label === "unfavorite" )
				return 'unfavorite';
			elseif( $get[0]->act_label === "viewed" )
				return 'viewed';
			elseif( $get[0]->act_label === "message" )
				return 'message';
			else
				return 0;
		} else {
			return 0;
		}		
	}

	function freshdeskLoginUrl($name, $email,$link) {
		$secret = 'f8e98c5387f5b216aae4104783becbb9';
		$base = 'http://pmj.freshdesk.com/';
		// $timestamp = time()(-15);
		$timestamp = time();
		$data = $name.$email.$timestamp;
		$hash_key = hash_hmac("md5",$data,$secret);

		return $base."/login/sso/?name=" . urlencode($name) . "&email=" . urlencode($email) ."&amp;timestamp=".$timestamp."&hash=" . $hash_key."&redirect_to=".base_url().$link;
		// baseUrl().$link
	}	

	function update80(){
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    if(empty($field)){
	    	$data['select'] = $field;
	    }

	    $ambil = $ci->query->get("pmj_answer",array("where"=>array("answer_uid"=>getSessionUser(),"answer_question"=>"66"),"select"=>"answer_choice"));
		$ci->query->update("pmj_member",array("_80"=>$ambil[0]->answer_choice),array("id"=>getSessionUser()));						
	}

	function insertActivity($data){
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		$ci->query->insert("activity",$data);
	}

	function getVerificationData(){
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		 $ambil = $ci->query->get("pmj_verification",array("where"=>array("id_member"=>getSessionUser()),"limit"=>1,"order"=>"created_date desc",));
		 if(empty($ambil) || $ambil[0]->status==='reject'){
		 	return true;
		 }else{
		 	return false;
		 }
	}

	function checkVerificationData(){
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		 $ambil = $ci->query->get("pmj_verification",array("where"=>array("id_member"=>getSessionUser()),"limit"=>1,"order"=>"created_date desc",));
		 if($ambil){
		 	return $ambil[0]->status==='pending' ? true : false;
		 }else{
		 	return false;
		 }
		 
	}

	function redirectQuestion(){
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		$objects   = $ci->query->get('pmj_question',array('select'=>'quiz_id,quiz_category'));
		$values   = $ci->query->get('pmj_answer',array('select'=>'answer_question as quiz_id',"where"=>array("answer_uid"=>getSessionUser())));
		
		$difference = array_udiff($objects, $values, function($obj_a, $obj_b) {
				  return $obj_a->quiz_id - $obj_b->quiz_id;
		});

		if($difference){
			foreach ($difference as $key => $value) {
				$quiz_id = $value->quiz_id;
				$quiz_category =  $value->quiz_category;
				break;
			}

			redirect(base_url("question")."?q=".$quiz_category."#".$quiz_id);
		}

		

	}

	function getCity(){
		static $ci = null;
    
	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }
	    
	    return $ci->query->get("pmj_city"); 
	}
