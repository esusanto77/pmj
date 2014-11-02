<?php 

	function sendEmail($action,$param)
	{
		static $ci = null;

	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		$ci->mandrill->init();
		
		$email = getEmailTemplates($action,$param);

    	$ci->mandrill->messages_send($email);
	}

	function getEmailTemplates($action,$param){

		static $ci = null;

	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

	    // send email as same author
	    $from = "PMJakarta.com";
	    $from_email = "noreply@pmjakarta.com";

		switch ($action) {

			// template for if someone send messages
			// if send inbox, than param must be message_ID
			case 'send_message':				
				$msg = $ci->query->get(
					"message",
					array("where"=>array(
								"msg_id" => $param,								
							),
						)					
					);

				//$from = getProfile($msg[0]->msg_from,"code_id");
				$to = getProfile($msg[0]->msg_to,"name");
				$from = getProfile($msg[0]->msg_from,"code_id");
				$to_email = getProfile($msg[0]->msg_to,"email");
				$subject = "You've get new message";
				$message = '<!doctype html>
							<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								<title>You\'ve get new message</title>
								<link href="http://fonts.googleapis.com/css?family=Raleway:800,400)" rel="stylesheet" type="text/css">
							<style type="text/css">
							.ReadMsgBody {width: 100%; background-color: #ffffff;}
							.ExternalClass {width: 100%; background-color: #ffffff;}
							body	 {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Georgia, Times, serif}
							table {border-collapse: collapse;}
							.text{ margin: 20px;}


							@media only screen and (max-width: 640px)  {
								body .deviceWidth {width:440px!important; padding:0;}	
								body .center {text-align: center!important;}		
							}

							@media only screen and (max-width: 480px) {
								body .deviceWidth {width:280px!important; padding:0;}	
								body .center {text-align: center!important;}	 
							}
							</style>
							</head>

							<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="background-color:#F4F5F7;font-family: Raleway;font-weight: 400; "  bgcolor="red">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
									<tr>
										<td width="100%" valign="top" bgcolor="#F4F5F7" style="padding-top:20px">	
											<!-- One Column -->
											<table width="570"  class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center">
												<tr>
													<td valign="top" style="padding-bottom:40px;text-align:center;color:#D2CECC">
														To ensure delivery, add noreply@pmjakarta.com to your address book
													</td>
												</tr>
												<tr>
													<td valign="top" style="padding:0" bgcolor="#F4F5F7">
														<center><a href="#"><img  class="deviceWidth" src="https://pmjstorage.blob.core.windows.net/newsletter/logo-pmj.png" alt="" border="0" height="90" width="250" max-width="575" max-height="300" min-height="150" style="display: block;" /></a>	</center>					
													</td>
												</tr> 
											</table><br>

											<table width="575" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="white" style="
											border-bottom:3px;border-bottom-style: solid;border-bottom-color:  rgba(230,230,232,1);">
											<tr>
												<td valign="top">
													<tr>
														<td style="vertical-align: middle;font-size:20px;padding:20px 20px 10px;text-align:left;color:#EE7CA5;font-family: Raleway;font-weight: 700; ">
															Hi '.$to.'</font>,
														</td>
													</tr>
													<tr>
														<td style="vertical-align: middle;font-size:15px;padding:0px 20px 30px;text-align:left;">
															Someone <font style="font-weight:bold;">'.$from.'</font> sent you a message!
														</td>
													</tr>
													<tr>
														<td style="vertical-align: middle;font-size:20px;padding:0px 50px 40px;text-align:left;color:#D2CECC;font-style:italic;">
															"'.$msg[0]->msg_content.'"
														</td>
													</tr>
													<tr>

														<td style="vertical-align: middle;font-size:15px;padding:0px 20px 10px;text-align:left;">
															<p style=""><a href="'.base_url('/message/read/'.$msg[0]->msg_code).'" style="text-decoration: none;"><span style="border-radius: 5px;font-size: 16px; color: #fff; background-color: #1ecbb8;padding:8px 40px;">Reply</span></a></p>
														</td>
													</tr>
													<tr >
														<td style="padding:0px 0px 10px;">
															<hr width="93%" size="1px"></hr>
														</td>
													</tr>
													<tr>
														<td style="vertical-align: middle;font-size:15px;padding:10px 20px 5px;text-align:left;">
															<span style="text-transform: uppercase;">do not respond to this email</span>
														</td>
													</tr>
													<tr>
														<td style="vertical-align: middle;font-size:15px;padding:0px 20px 60px;text-align:left;">
															<span style="">Forgot your login detail? Request your login detail here :  <a href="'.base_url().'">link</a></span>
														</td>
													</tr>

												</tr>
											</table>
											<div style="height:25px">&nbsp;</div><!-- spacer -->
											<table width="575" height="40" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="">
												<tr>
													<td style="vertical-align: middle;font-size:13px;padding:5px;text-align:center;color:#D2CECC">
														If you\'d rather not receive emails from PMJakarta you can <font style="color:#EE7CA5;font-weight:bold;" >unsubscribe</font> immediately. To resubscribe or
														change other PMJ Email preferences visit your account setting to manage <font style="color:#EE7CA5;font-weight:bold;">email notices</font>.
													</tr>
												</table>
												<div style="height:25px">&nbsp;</div>		
											</td>
										</tr>
									</table>
								</body>
								</html>';
			break;


			// template for if someone was signup
			// if signup, than param must be user id
			case 'signup':					
				//  $from = "PMJakarta.com";
	   			//  $from_email = "validation@pmjakarta.com";							
				$to = getProfile($param,"name");
				$to_email = getProfile($param,"email");
				$reg_code = getProfile($param,"reg_code");
				$code_id = getProfile($param,"code_id");
				$subject = "Thanks for signup";
				//$message = "Hi ".$to.", congratulations, now you're a part of our familly. one more step to be more cool is validated your profile by open this url <a href='".base_url('auth/validate/'.$reg_code)."'>".base_url('auth/validate/'.$reg_code)."</a>";
				$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							<html>
							<head>
								<style>
								    @import url(\'http://fonts.googleapis.com/css?family=Raleway\');
								   /* All your usual CSS here */
								</style>
							</head>
								
								<body style="font-family:\'Raleway\', sans-serif; font-size: 13px; background-color: #F4F5F7; padding-left: 10%; padding-right: 10%">
									<center>
										<table width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="color: #5C5A5A; border-bottom:3px; border-bottom-style: solid;border-bottom-color:  rgba(230,230,232,1); " align="center">
											<tr height="100px" wi>
												<td>
													<center>
														<a href="#">
															<img  class="deviceWidth" src="https://pmjstorage.blob.core.windows.net/newsletter/email-greetings.jpg" alt="" border="0" style="display: block; max-width: 100%;height: auto;width: auto" />
														</a>
													</center> 
												</td>
											</tr>
											<tr>
												<td style="padding: 15px;">
													<center>
													<div  style="text-align:left;">
														<p style="font-size: 16px; color:#EE7CA5; font-weight: bold;">Dear '.$to.'</p>
													
														<p><b style="color:#000">Welcome to Perfect Match Jakarta</b>. We\'re pretty excited that you\'ve joined our community. There\'s so much to explore.</p>
														<p>You\'re account is stored securely in our system. You may start finding your Perfect Match by using this login information </p>
														<br/>
															<table>
																<tr>
																	<td><b style="color:#000">Login</b></td>
																	<td><bstyle="color:#000" >:</b></td>
																	<td>'.$to_email.'</td>
																</tr>
																<tr>
																	<td><b style="color:#000">Password</b></td>
																	<td><b style="color:#000">:</b></td>
																	<td>********</td>
																</tr>
																<tr>
																	<td><b style="color:#000">Personal ID</b></td>
																	<td><b style="color:#000">:</b></td>
																	<td>'.$code_id.'</td>
																</tr>
															</table>
														<br/>
														<p>Your personal ID above will be the only profile name visible to others members in your <span style="color:#EE7CA5;">PMJakarta</span></p>
														<br/>
														<p>By filling up the questionnaire to 100% completeion, you then optimize our match making engine and that will help  lead you to find your <b style="color:#000">Perfect Match</b></p>
														<p>Click Here to validate your profile and complete the questionnaire</p>
														<br/>
														<p style="text-align: center"><a href="'.base_url('auth/validate/'.$reg_code).'" style="text-decoration: none;"><span style="border-radius: 5px; padding: 10px; font-size: 15px; color: #fff; background-color: #1ecbb8">Validate Your Profile</span></a></p>
														<br/>
														<p>In no time, you can begin to explore our site and appreciate a pleasurable, exciting,</p>
														<p>and incomparable experience in online dating.</p>
														<p>Thanks again for joining. See You in the site!</p>
														<br/>
														<p style="font-style: italic;">LOVE</p>
														<p><b>PMJakarta</b></p>
														<hr style="border: 0; border-bottom: 1px dashed #ccc; background: #999;">
														<p>PMJ APP AVAILABLE NOW</p>
														<p>DOWNLOAD TODAY</p>
														<p><a href="https://play.google.com/store/apps/details?id=com.dycode.pmjakarta" target="_blank">
                 												 <img alt="Get it on Google Play" src="https://developer.android.com/images/brand/en_generic_rgb_wo_45.png" />
              												</a>
              											</p>
													</div>
												</center>
												</td>
											</tr>
										</table>
										<table width="100%" height="100%" cellpadding="0" cellspacing="0" style="color: #5C5A5A; padding: 15px; margin-top:20px" align="center">
											<tr>
												<td style="text-align: center; color:rgba(168, 162, 166, 1)">
													<center>
														<table style="margin-bottom:20px">
															<tr>
																<td style="text-align: center;">
																	<a href="#">
																		<img src="http://pmjstorage.blob.core.windows.net/newsletter/Icon_mail.png">
																	</a>
																</td>
																<td style="text-align: center;">
																	<a href="http://www.matchmatter.com">
																		<img src="http://pmjstorage.blob.core.windows.net/newsletter/icon_twitter.png">
																	</a>
																</td>
																<td style="text-align: center;">
																	<a href="#">
																		<img src="http://pmjstorage.blob.core.windows.net/newsletter/Icon_linkedin.png">
																	</a>
																</td>
															</tr>
														</table>
													</center>
												</td>
											</tr>
											<tr>
												<td style="text-align: center; color:rgba(168, 162, 166, 1)">
													If you\'d rather not receive emails from PMJakarta you can <font style="color:#EE7CA5;font-weight:bold;" >unsubscribe</font> immediately. To resubscribe or
							change other PMJ Email preferences visit your account setting to manage <font style="color:#EE7CA5;font-weight:bold;">email notices</font>
												</td>
											</tr>
										</table>
									</center>
								</body>
							</html>';
			break;

			case 'contactus':
			 	$from = $param['name'];
	    	$from_email = $param['email'];											
				$to_email = "support@pmjakarta.com";
				$subject = "Message From Contact Us";
				$message = $param['message'];
			break;

			/* Verification Email */
			case 'verification':												
				$to = "validation@pmjakarta.com";
				$to_email = "validation@pmjakarta.com";
				$subject = "Verification Notification";
				// $message = "New member code id ".$param['code_id']." registered and need to be verified. You can access <a href='".base_url('admin/edit/'.$param['id'])."'>this url</a> for direct link";
				$message = "New member code id ".$param['code_id']." registered and need to be verified. You can access <a href='".$ci->config->item('pmjadminUrl')."verification/edit/".$param['id']."'>this url</a> for direct link";
			break;

			/* Contact Admin Email */
			case 'contact-admin':												
				$to = "support@pmjakarta.com";
				$to_email = "support@pmjakarta.com";
				$subject = "PMJakarta Suspended Member Report";
				$message = "Member : ".$param['code_id']."<br>Status : suspended<br>Message : ".$param['message']."";
			break;

			/* Report Email */
			case 'report-user':												
				$to = "support@pmjakarta.com";
				$to_email = "support@pmjakarta.com";
				$subject = "PMJakarta Offensive Report";
				$message = "From : ".getSessionUser()."/".getSessionCodeId()." (".getSessionEmail().")
							<br><br>Personal Code ID : ".$param['to_code_id']."
							<br>Reason : ".$param['message']."";
			break;

			/* Send Email If Have A New Best Match */
			case 'emailMatch':												
				$to = getProfile($param['id'],"name");
				$to_email = getProfile($param['id'],"email");
				$name = getProfile($param['id'],"name");
				$subject = "New Best Match PMJakarta";
				$message = '<!doctype html>
							<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								<title>New Best Match PMJakarta</title>
								<link href="http://fonts.googleapis.com/css?family=Raleway:800,400)" rel="stylesheet" type="text/css">
							<style type="text/css">
							.ReadMsgBody {width: 100%; background-color: #ffffff;}
							.ExternalClass {width: 100%; background-color: #ffffff;}
							body	 {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Georgia, Times, serif}
							table {border-collapse: collapse;}
							.text{ margin: 20px;}


							@media only screen and (max-width: 640px)  {
								body .deviceWidth {width:440px!important; padding:0;}	
								body .center {text-align: center!important;}		
							}

							@media only screen and (max-width: 480px) {
								body .deviceWidth {width:280px!important; padding:0;}	
								body .center {text-align: center!important;}	 
							}
							</style>
							</head>

							<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="background-color:#F4F5F7;font-family: Raleway;font-weight: 400; "  bgcolor="red">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
									<tr>
										<td width="100%" valign="top" bgcolor="#F4F5F7" style="padding-top:20px">	
											<!-- One Column -->
											<table width="570"  class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center">
												<tr>
													<td valign="top" style="padding-bottom:40px;text-align:center;color:#D2CECC">
														To ensure delivery, add noreply@pmjakarta.com to your address book
													</td>
												</tr>
												<tr>
													<td valign="top" style="padding:0" bgcolor="#F4F5F7">
														<center><a href="#"><img  class="deviceWidth" src="https://pmjstorage.blob.core.windows.net/newsletter/logo-pmj.png" alt="" border="0" height="90" width="250" max-width="575" max-height="300" min-height="150" style="display: block;" /></a>	</center>					
													</td>
												</tr> 
											</table><br>

											<table width="575" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="white" style="
											border-bottom:3px;border-bottom-style: solid;border-bottom-color:  rgba(230,230,232,1);">
											<tr>
												<td valign="top">
													<tr>
														<td style="vertical-align: middle;font-size:20px;padding:20px 20px 10px;text-align:left;color:#EE7CA5;font-family: Raleway;font-weight: 700; ">
															Hi '.$to.'!
														</td>
													</tr>
													<tr>
														<td style="vertical-align: middle;font-size:15px;padding:0px 20px 30px;text-align:left;">
															We\'ve found new matches that you might be interested! Don\'t hesitate to get know them first!
														</td>
													</tr>
													<tr >
														<td style="padding:0px 0px 10px;">
															<hr width="93%" size="10px" color="#EFEFEF"></hr>
														</td>
													</tr>
													<tr>
														<td style="padding: 10px 20px;">
															'.$param['data'].'
														</td>
													</tr>
													<tr>

														<td style="vertical-align: middle;font-size:15px;padding:0px 20px 10px;text-align:center;">
															<p style=""><a href="'.base_url('/welcome').'" style="text-decoration: none;"><span style="border-radius: 5px;font-size: 16px; color: #fff; background-color: #1ecbb8;padding:8px 40px;">See All</span></a></p>
														</td>
													</tr>
													<tr >
														<td style="padding:0px 0px 10px;">
															<hr width="93%" size="1px"></hr>
														</td>
													</tr>
													<tr>
														<td style="vertical-align: middle;font-size:15px;padding:10px 20px 5px;text-align:left;">
															<span style="text-transform: uppercase;">do not respond to this email</span>
														</td>
													</tr>
													<tr>
														<td style="vertical-align: middle;font-size:15px;padding:0px 20px 60px;text-align:left;">
															<span style="">Forgot your login detail? Request your login detail here : <a href="'.base_url().'">link</a></span>
														</td>
													</tr>

												</tr>
											</table>
											<div style="height:25px">&nbsp;</div><!-- spacer -->
											<table width="575" height="40" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="">
												<tr>
													<td style="vertical-align: middle;font-size:13px;padding:5px;text-align:center;color:#D2CECC">
														If you\'d rather not receive emails from PMJakarta you can <font style="color:#EE7CA5;font-weight:bold;" >unsubscribe</font> immediately. To resubscribe or
														change other PMJ Email preferences visit your account setting to manage <font style="color:#EE7CA5;font-weight:bold;">email notices</font>.
													</tr>
												</table>
												<div style="height:25px">&nbsp;</div>		
											</td>
										</tr>
									</table>
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