<?php 

 function getAnswerWithKey($uid, $key){
	static $ci = null;

    if(is_null($ci)) {
        $ci =& get_instance();
    }

    $return = $ci->query->getAnswerWithKey($uid, $key);
    if(isset($return[0]->choice_text)){
    	return $return[0]->choice_text;
    }elseif(isset($return[0]->answer_choice)){
    	return $return[0]->answer_choice;
    }else{
    	return "-";
    }
 }