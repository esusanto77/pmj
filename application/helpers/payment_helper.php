<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/* ==========================================================================
                            Payment Helper
        Author : DyCode Faerul Salamun (faerulsalamun@gmail.com) 
========================================================================== */

    function create_rnd_id_payment() {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;

        while ($i <= 15) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        return $pass;
    }

    function cvr_hex_bin($hexSource)
    {
        $bin = '';

        for ($i=0;$i<strlen($hexSource);$i=$i+2)
        {
          $bin .= chr(hexdec(substr($hexSource,$i,2)));
        }
      return $bin;
    }

    function ipay88_sgn($source)
    {
      return base64_encode(cvr_hex_bin(sha1($source)));
    }

    function getAmount($id){
        static $ci = null;

        if(is_null($ci)) {
            $ci =& get_instance();
        }
        
        $data['product'] = $ci->query->get('pmj_product',array("where"=>array("id_product"=>$id)));

        $diskon = $ci->query->get('pmj_setting',array("where"=>array("id"=>3)));
        foreach ($diskon as $d) {
            $getDiskon =  $d->value;
        }

        foreach ($data['product'] as $p) {
            return $p->billed_one_time - ($p->billed_one_time * $getDiskon/100)."00";
        }
    }

    function checkValidProduct($id){
        static $ci = null;

        if(is_null($ci)) {
            $ci =& get_instance();
        }

        $cekProduct =  $ci->query->checkData('pmj_product',"id_product",$id);
            if($cekProduct===false){
                return redirect(base_url("product"));
            }
    }

    function checkSubcription(){
        static $ci = null;

        if(is_null($ci)) {
            $ci =& get_instance();
        }

        $checkSubcription =  $ci->query->checkData('pmj_subscription',"id_member",getSessionUser());
            if($checkSubcription===true){
                $ci->query->delete('pmj_subscription',array("id_member"=>getSessionUser()));
            }
    }

    function randomGiftCode()
    {
        $character_set_array = array();
        $character_set_array[] = array('count' => 4, 'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $character_set_array[] = array('count' => 4, 'characters' => '0123456789');
        $temp_array = array();
        foreach ($character_set_array as $character_set) {
            for ($i = 0; $i < $character_set['count']; $i++) {
                $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
            }
        }
        shuffle($temp_array);
        return implode('', $temp_array);
    }

    function getProduct($id,$field="")
    {
        static $ci = null;
    
        if(is_null($ci)) {
            $ci =& get_instance();
        }

        if(empty($field)){
            $data['select'] = $field;
        }
        $data['where'] = array("id_product"=>$id);
        $user = $ci->query->get("pmj_product",$data);
        return $user[0]->$field;
    }

    function sendEmailPayment($action,$param,$id)
    {
        static $ci = null;

        if(is_null($ci)) {
            $ci =& get_instance();
        }

         $ci->mandrill->init();
        
        $email = getEmailTemplatesPayment($action,$param,$id);

         $ci->mandrill->messages_send($email);
    }

    function getEmailTemplatesPayment($action,$param,$id){

        static $ci = null;

        if(is_null($ci)) {
            $ci =& get_instance();
        }

        // send email as same author
        $from = "PMJakarta.com";
        $from_email = "noreply@pmjwebsite.com";

        switch ($action) {

            // template for send message for subscription
            case 'subscription':                
                //$from = getProfile($msg[0]->msg_from,"code_id");
                $name_product = getProduct($param['id_product'],"name_product");
                $to = getProfile($param['id_member'],"name");
                $to_email = getProfile($param['id_member'],"email");
                $subject = "PMJ Subscription Information";
                $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html>
                              <head>
                              </head>
                              
                              <body>
                                <center>
                                  <table width="600px" height="663px" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="font-family: Arial, sans-serif; color: #262626;" align="center">
                                    <tr height="263px">
                                      <td>
                                        <img src="https://pmjstorage.blob.core.windows.net/newsletter/pmemail.jpg" alt="Perfect Match Jakarta">
                                      </td>
                                    </tr>
                                    <tr height="29px">
                                      <td>
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" style="font-size: 16px;">
                                          <tr height="100%">
                                            <td width="6px"></td>
                                            <td width="297px" align="left" style="text-transform: capitalize;">Dear '.$to.'</td>
                                            <td width="297px" align="right"></td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    <tr height="1px" bgcolor="#009bb1">
                                      <td></td>
                                    </tr>
                                    <tr height="35px">
                                      <td></td>
                                    </tr>
                                    <tr height="179px">
                                      <td valign="middle">
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                                          <tr>
                                            <td width="6px"></td>
                                            <td width="594px" style="text-align: center;" align="left" mc:edit="main">
                                              <p style="margin-bottom: 14px; margin-top: -60px;">Congratulations</p>
                                              <p style="margin-bottom: 14px;"><strong>'.$to.'</strong> On Your <strong>'.$name_product.' Subscription</strong>.</p>
                                              <p style="margin-bottom: 14px; line-height: 20px">You Are Now Ready To Start Finding That Special Someone.</p>
                                              <p style="margin-bottom: 14px; line-height: 20px">Please Click On The Link Below And Let The Journey Begin.</p>
                                              <p style="margin-bottom: 14px; line-height: 20px"><a href="www.pmjakarta.com">www.pmjakarta.com</a></p>
                                            </td>
                                          </tr>
                                        </table>
                                        
                                      </td>
                                    </tr>
                                    <tr height="65px">
                                      <td valign="middle">
                                        <!--
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" style="font-size: 14px; color: #999999;">
                                          <tr>
                                            <td width="6px"></td>
                                            <td width="594px" align="left" style="text-align: left;">
                                              Addressed to <span style="color: #1155cc; text-decoration: underline;">'.$_POST['email'].'</span> -- <a href="#" target="_blank" style="color: #999999;"><i></i></a>
                                              <br/>
                                              <a href="#" target="_blank" style="text-decoration: none; color: #999999;">Unsubscribe</a> | <a href="#" target="_blank" style="text-decoration: none; color: #999999;"></a>
                                              <br/>
                                            </td>
                                          </tr>
                                        </table>
                                        -->
                                      </td>
                                    </tr>
                                  </table>
                                </center>
                              </body>
                            </html>';
            break;

            // template for send message for gift_code
            case 'gift_code':  
                $name_sender = getProfile($param['id_member'],"name");
                $name_product = getProduct($param['id_product'],"name_product");
                $to = $param['member_name'];
                $to_email = $param['email_recepeint'];
                $subject = "PMJ Gift Code Subscription Information";
                $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html>
                              <head>
                              </head>
                              
                              <body>
                                <center>
                                  <table width="600px" height="663px" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="font-family: Arial, sans-serif; color: #262626;" align="center">
                                    <tr height="263px">
                                      <td>
                                        <img src="https://pmjstorage.blob.core.windows.net/newsletter/pmemail.jpg" alt="Perfect Match Jakarta">
                                      </td>
                                    </tr>
                                    <tr height="29px">
                                      <td>
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" style="font-size: 16px;">
                                          <tr height="100%">
                                            <td width="6px"></td>
                                            <td width="297px" align="left" style="text-transform: capitalize;">Dear '.$to.'</td>
                                            <td width="297px" align="right"></td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    <tr height="1px" bgcolor="#009bb1">
                                      <td></td>
                                    </tr>
                                    <tr height="35px">
                                      <td></td>
                                    </tr>
                                    <tr height="179px">
                                      <td valign="middle">
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                                          <tr>
                                            <td width="6px"></td>
                                            <td width="594px" style="text-align: center;" align="left" mc:edit="main">
                                              <p style="margin-bottom: 14px; margin-top: -60px;">Hi, '.$to.'</p>
                                              <p style="margin-bottom: 14px;">'.$name_sender.' has sent you a gift code: <strong>'.$param['gift_code'].'</strong><br><br>To redeem open url '.base_url().'redeem and enter the gift code</p>
                                              <p style="margin-bottom: 14px;">or click this link: '.base_url('product').'/redeem_code/'.$param['gift_code'].'</p>
                                            </td>
                                          </tr>
                                        </table>
                                        
                                      </td>
                                    </tr>
                                    <tr height="65px">
                                      <td valign="middle">
                                        <!--
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" style="font-size: 14px; color: #999999;">
                                          <tr>
                                            <td width="6px"></td>
                                            <td width="594px" align="left" style="text-align: left;">
                                              Addressed to <span style="color: #1155cc; text-decoration: underline;">'.$_POST['email'].'</span> -- <a href="#" target="_blank" style="color: #999999;"><i></i></a>
                                              <br/>
                                              <a href="#" target="_blank" style="text-decoration: none; color: #999999;">Unsubscribe</a> | <a href="#" target="_blank" style="text-decoration: none; color: #999999;"></a>
                                              <br/>
                                            </td>
                                          </tr>
                                        </table>
                                        -->
                                      </td>
                                    </tr>
                                  </table>
                                </center>
                              </body>
                            </html>';
            break;
            
            default:
                # code...
                break;
        }

        $email = array(
            'html' => $message, //Consider using a view file            
            'subject' => $subject,
            'from_email' => $from_email,
            'from_name' => $from,
            'to' => array(array('email' => $to_email ))             
        );

        return $email;
        
    }   

    function getAmountDetail($id,$diskon){
        static $ci = null;

        if(is_null($ci)) {
            $ci =& get_instance();
        }
        
        $data = $ci->query->get('pmj_product',array("where"=>array("id_product"=>$id)));

        return  number_format($data[0]->billed_one_time * $diskon/100);
 
    }