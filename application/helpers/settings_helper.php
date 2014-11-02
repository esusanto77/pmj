<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/* ==========================================================================
                            Setting Helper
        Author : DyCode Faerul Salamun (faerulsalamun@gmail.com) 
========================================================================== */

   
    function getSetting($id){
        static $ci = null;

        if(is_null($ci)) {
            $ci =& get_instance();
        }
        
        $data = $ci->query->get('pmj_setting',array("where"=>array("id"=>$id)));

        return $data[0]->value;
    }

    