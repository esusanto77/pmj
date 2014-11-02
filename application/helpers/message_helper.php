<?php 

 function getMessageCount($uid){
	static $ci = null;

    if(is_null($ci)) {
        $ci =& get_instance();
    }

    $return = $ci->query->get("message",array( "count"=>1, "where"=>array("msg_status"=>"unread","msg_to"=>$uid,"msg_owner"=>getSessionUser())));
    return $return[0]->total;
 }