<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	var $payment;

	public function __construct(){
		parent::__construct();
		//Do your magic here
		$this->load->model('query');

		$id = $this->uri->segment(3);
		$token = $this->uri->segment(4);
		$cekToken = $this->query->get('pmj_token',array("where"=>array("registration_id"=>$id,"session_id"=>$token)));

		if(!empty($cekToken)){
			$curlProfile['url'] = "http://pmjapi.azurewebsites.net/detailProfile?session=".$cekToken[0]->session_id;
			$getProfile = json_decode(curl_get($curlProfile));
		

			$session = array('uid' => $getProfile->data[0]->id,
							'code_id' => $getProfile->data[0]->code_id,
							'uname' => $getProfile->data[0]->name,
							'gender' => $getProfile->data[0]->gender,
							'email'=> $getProfile->data[0]->email,
							'address' => $getProfile->data[0]->address,
							'home_phone' => $getProfileCompleted->data[0]->home_phone,
							'hand_phone' => $getProfile->data[0]->hand_phone,
							'token' => $token,
							'login_mobile' => "true",
							);

			$cookie = array(
				'name'   => 'rememberMe',
				'value'  => 'TRUE',
				'expire' => '604800'
			);

			$this->input->set_cookie($cookie);

			$this->session->set_userdata($session);
		}

		elseif(getSessionUser() < 1 && $this->uri->segment(2)!="redeem_code" && $this->uri->segment(2)!="cek_code"){
			redirect(base_url());
		}

		/* Variabel For Payment */
		$this->payment = array(
            'MechantKey' => 'BnSjX8yQ26',
            'MerchantCode' => 'ID00083',
            'Currency' => "IDR",
            'Status' => "1",
            'ProdDesc' => "PMJ Membership Payment",
            'Remark' => "PMJ Membership Payment",
            'RefNo' => "3_".create_rnd_id_payment(),
            'ResponseURL' => base_url("product")."/respon",
  			'BackendURL' => base_url("product")."/respon"
        );

        /* Variabel For Discount */
        $checkDiskon = $this->query->get('pmj_setting',array("where"=>array("id"=>3)));
		$this->discount['discount'] =  $checkDiskon[0]->value;
	}
	
	public function index(){
		/* Bersihkan Session */
		/*$arraySession = array('use_gift_code'=>'');

		$this->session->unset_userdata($arraySession);*/
		$data['id_product'] = $this->db->get('pmj_product');
		
		$this->load->view('product/index',$data,$this->discount['discount']);
	}

	public function payment(){	
		/* Check apakah product yang diminta ada */
		checkValidProduct($this->uri->segment(3));

		/* Unset Session Gift Code Not Login */
		$this->session->unset_userdata('gift_code_not_login');

		$data['product'] = $this->query->get('pmj_product',array("where"=>array("id_product"=>$this->uri->segment(3))));
    	$data['member'] =  $this->query->getMemberData(getSessionUser());

    	/* Harga Product */
		$data['Amount'] = getAmount($this->uri->segment(3));
		
     	/* For Payment */
     	$source = $this->payment['MechantKey'].$this->payment['MerchantCode'].$this->payment['RefNo'].$data['Amount'].$this->payment['Currency'];
		$data['Signature'] = ipay88_sgn($source);

		$this->load->view('product/payment',$data,$this->payment);
	}

	public function payment_gift_code(){	
		/* Check apakah product yang diminta ada*/
		checkValidProduct($this->uri->segment(3));
		
		$data['product'] = $this->query->get('pmj_product',array("where"=>array("id_product"=>$this->uri->segment(3))));
    	$data['member'] =  $this->query->getMemberData(getSessionUser());

		/* Harga Product */
		$data['Amount'] = getAmount($this->uri->segment(3));

     	/* For Payment */
     	$source = $this->payment['MechantKey'].$this->payment['MerchantCode'].$this->payment['RefNo'].$data['Amount'].$this->payment['Currency'];
		$data['Signature'] = ipay88_sgn($source);

		/* Membuat Session untuk gift code */
		$this->session->set_userdata('gift_code_payment', true);

		$this->load->view('product/payment_gift_code',$data,$this->payment,$this->discount['discount']);
	}

	public function cek_proses_payment(){
		$id_product = $this->input->post('id_product');
		$this->session->set_userdata('id_product_payment', $id_product);

		if($this->input->post('PaymentId')=="7"){
			$MerchantCode="IF00066";
			$MechantKey = "UZva3Re3CT";
			$Currency = "IDR";
			$source = $MechantKey.$MerchantCode.$this->input->post('RefNo').$this->input->post('Amount').$Currency;
			$Signature = ipay88_sgn($source);
		}
		else{
			$MerchantCode = $this->input->post('MerchantCode');
			$Signature = $this->input->post('Signature');
		}

		/* Variabel for payment */
		$PaymentId = $this->input->post('PaymentId');
		$RefNo = $this->input->post('RefNo');
		$Amount = $this->input->post('Amount');
		$Currency = $this->input->post('Currency');
		$ProdDesc = $this->input->post('ProdDesc');
		$UserName = $this->input->post('UserName');
		$UserEmail = $this->input->post('UserEmail');
		$UserContact = $this->input->post('UserContact');
		$Remark = $this->input->post('Remark');
		$Lang = $this->input->post('Lang');
		$ResponseURL = $this->input->post('ResponseURL');
		$BackendURL = $this->input->post('BackendURL');

		/* Variabel untuk gift code */
		$memberCodeId = $this->input->post('memberCodeId');
		// $for_email = $this->input->post('sendgiftemail');

		/* Variabel member */
		$handPhoneUser = $this->input->post('handPhoneUser');
		$homePhoneUser = $this->input->post('homePhoneUser');
		$addressUser = $this->input->post('addressUser');

		$complete = "";

			if($handPhoneUser==="" || $homePhoneUser==="" || $addressUser===""){
				/* Redirect Halaman */
				redirect(base_url("product")."/payment_failed");
			}

		// if($this->session->userdata('login_mobile')=="true"){
		// 		$curlInsertprofile['url'] = "http://pmjakarta.com/apidev/insertDataMember/".getSessionUser()."/".str_replace(' ','%20',$addressUser)."/".str_replace(' ','%20',$homePhoneUser)."/".str_replace(' ','%20',$handPhoneUser)."/".str_replace(' ','%20',date("Y-m-d h:i:s"))."/".str_replace(' ','%20',date("Y-m-d h:i:s"))."?session=".$this->session->userdata('token')."";

		// 		curl_get($curlInsertprofile);
		// }

		/* Cek nama product */
		$cariNameProduct = $this->query->get('pmj_product',array("where"=>array("id_product"=>$id_product)));
		$this->session->set_userdata('name_product',$cariNameProduct[0]->name_product);

		/* Cek data member apakah sudah ada didatabase */
		$checkMemberData = $this->query->checkData("pmj_member_data","id_member",getSessionUser());

		/* Jika sudah ada */
		if($checkMemberData===true){		
			$this->query->update("pmj_member_data",array("address"=>$addressUser,"home_phone"=>$homePhoneUser,"hand_phone"=>$handPhoneUser,"updated_date"=>date("Y-m-d h:i:s")),array("id_member"=>getSessionUser()));
		}
		/* Jika belum ada */
		else{
			$this->query->save("pmj_member_data",array("id_member"=>getSessionUser(),"address"=>$addressUser,"home_phone"=>$homePhoneUser,"hand_phone"=>$handPhoneUser,"created_date"=>date("Y-m-d h:i:s"),"updated_date"=>date("Y-m-d h:i:s"),"created_by"=>"SYSTEM"));
		}

		/*  Validasi jika menggunakan gift code */
		if($this->session->userdata('use_gift_code')===true){
			$complete = "";
			$checkEmailValidGiftCode = $this->query->get('pmj_member',array("where"=>array("id"=>getSessionUser())));
			$emailValidGiftCode =  $checkEmailValidGiftCode[0]->email;

			if($emailValidGiftCode!=$this->session->userdata('for_email_gift_code')){
				/* Bersihkan Session */
				$arraySession = array('id_gift' => '','id_product_gift' => '', 'use_gift_code' => '', 'name_product_gift'=>'','for_email_gift_code'=> '');

				$this->session->unset_userdata($arraySession);

				/* Redirect Halaman */
				redirect(base_url("product")."/payment_failed");
			}else{
				$cariProductGiftCode = $this->query->get('pmj_product',array("where"=>array("id_product"=>$this->session->userdata('id_product_gift'))));
				$data_product =array('id_product'   =>  $cariProductGiftCode[0]->id_product,
									        'price'   => $cariProductGiftCode[0]->billed_one_time,
									        'duration'  => $cariProductGiftCode[0]->duration);

				

				date_default_timezone_set("Asia/Jakarta");
		  		$date= date( 'Y-m-d H:i:s', time());
				$bulan="+".$data_product['duration']." month";  
				$expired_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . $bulan));
				$submit_date = date("Y-m-d");

				/* Cek di tabel subcription sudah ada atau belum */
				checkSubcription();

				/* Masukkan data ke table subcription */
				$this->query->save("pmj_subscription",array("id_member"=>getSessionUser(),"id_product"=>$data_product['id_product'],"submit_date"=>$submit_date,"expire_date"=>$expired_date));

				/* Update Status Gift Code */
				$this->query->update("pmj_gift_code",array("status"=>"use","updated_date"=>$date),array("id_gift"=>$this->session->userdata('id_gift')));

				/* Bersihkan Session */
				$arraySession = array('id_gift' => '','id_product_gift' => '',  'name_product_gift'=>'','for_email_gift_code'=> '','use_gift_code' => '');

				$this->session->unset_userdata($arraySession);

				/* Redirect Halaman */
				redirect(base_url("product")."/payment_sukses");
			}
		}

		/* Jika pembayaran untuk gift code */

		/* Jika menggunakan member code id */
		if($memberCodeId!=""){
		    // Cari data dari tabel member
		    $cariDataMember =  $this->query->checkData('pmj_member',"code_id",$memberCodeId);

		    if($cariDataMember=="" && $this->session->userdata('gift_code_payment')===true){
					redirect(base_url("product")."/payment_failed");
			}
		    else{	
		     $getDataMember = $this->query->get('pmj_member',array("where"=>array("code_id"=>$memberCodeId)));
					$name_member = $getDataMember[0]->name;
					$this->session->set_userdata('emailRecepeint', $getDataMember->email);
			        $code_id_recepeint = $getDataMember->id;
			        $complete = "ok";
	    	}
	    
		    // Get First Name Or Last Name
		    $pieces = explode(" ", $name_member);

		    if(count($pieces)=="1"){
		    	$this->session->set_userdata('firstNameRecepeint',  $name_member);
		    }
		    else{
		        for ($i=0; $i < count($pieces)-1; $i++) { 
		            $name .=  $pieces[$i]." ";
		        }
		        $this->session->set_userdata('firstNameRecepeint',  $name);
		        $this->session->set_userdata('lastNameRecepeint',  end($pieces));
		    }

		    // Cari data dari tabel member data
		    $cariDataMemberData = $this->query->get('pmj_member',array("where"=>array("code_id"=>$memberCodeId)));

		    foreach ($getDataMember as $m) {
				$this->session->set_userdata('addressRecepeint',  $m->address);
				$this->session->set_userdata('homePhoneRecepeint',  $m->home_phone);
				$this->session->set_userdata('handPhoneRecepeint',  $m->hand_phone);
			}
		 }
		 /* Jika tidak menggunakan member code id */
		 else if($this->session->userdata('gift_code_payment')===true && $this->input->post('firstNameRecepeint')!=="" 
		 			&& $this->input->post('lastNameRecepeint')!=="" && $this->input->post('emailRecepeint')!==""){

            $this->session->set_userdata('firstNameRecepeint',  $this->input->post('firstNameRecepeint'));
	        $this->session->set_userdata('lastNameRecepeint',  $this->input->post('lastNameRecepeint'));
	        $this->session->set_userdata('addressRecepeint',  $this->input->post('addressRecepeint'));
			$this->session->set_userdata('homePhoneRecepeint',  $this->input->post('homePhoneRecepeint'));
			$this->session->set_userdata('handPhoneRecepeint',  $this->input->post('handPhoneRecepeint'));
			$this->session->set_userdata('emailRecepeint', $this->input->post('emailRecepeint'));
			$complete = "ok";
  		}
		 else{
		 	$complete = "ok";
		 }
	  

	/* 	Jika Promo Code 
		Coming Soon
	*/


	/* 	Jika pembayaran untuk dirinya sendiri */

	/* Cek apakah pembayaran menggunakan sandbox atau real */
	 $settingPayment = $this->query->get('pmj_setting',array("where"=>array("id"=>4)));
	 $checkSettingPayment = $settingPayment[0]->value;

	if($checkSettingPayment=="true"){
		 $url="http://payment.ipay88.co.id/epayment/entry.asp";
	}else{
		 $url="http://sandbox.ipay88.co.id/epayment/entry.asp";
	}

	if($complete == "ok"){
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
		      <html xmlns='http://www.w3.org/1999/xhtml'>
		      <head>
		      <title>Process Payment</title>
		      <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />	      
		      <SCRIPT LANGUAGE='JavaScript'>setTimeout('document.test.submit()',0);</SCRIPT>
		      </head>
		      <body> 
		      <form name='test' id='form1' method='post' action='$url'>
		      <INPUT type='hidden' name='id_product' value='$id_product'>
		      <INPUT type='hidden' name='MerchantCode' value='$MerchantCode'>
		      <INPUT type='hidden' name='PaymentId' value='$PaymentId'>
		      <INPUT type='hidden' name='RefNo' value='$RefNo'>
		      <INPUT type='hidden' name='Amount' value='$Amount'>
		      <INPUT type='hidden' name='Currency' value='$Currency'>
		      <INPUT type='hidden' name='ProdDesc' value='$ProdDesc'>
		      <INPUT type='hidden' name='UserName' value='$UserName'>
		      <INPUT type='hidden' name='UserEmail' value='$UserEmail'>
		      <INPUT type='hidden' name='UserContact' value='$handPhoneUser'>
		      <INPUT type='hidden' name='Remark' value='$Remark'>
		      <INPUT type='hidden' name='Lang' value='UTF-8'>
		      <INPUT type='hidden' name='Signature' value='$Signature'>
		      <INPUT type='hidden' name='ResponseURL' value='$ResponseURL'>
		      <INPUT type='hidden' name='BackendURL' value='$BackendURL'>
		      <button class='btn btn-primary btn-info btn-lg pull-right' type='submit' style='visibility:hidden'></button>
		      </form>  
		      </body>
		      </html>";  
	}
	
	}

	public function confirm()
	{
		$this->load->view('product/confirm');
	}

	public function respon(){
		$id_product= $this->input->post('id_product');
		$merchantcode = $this->input->post('MerchantCode');
		$paymentid = $this->input->post('PaymentId');
		$refno = $this->input->post('RefNo');
		$amount = $this->input->post('Amount');
		$ecurrency = $this->input->post('Currency');
		$remark = $this->input->post('Remark');
		$transid = $this->input->post('TransId');
		$authcode = $this->input->post('AuthCode');
		$estatus = $this->input->post('Status');
		$errdesc = $this->input->post('ErrDesc');
		$signature = $this->input->post('Signature');
		$PaymentId = $this->input->post('PaymentId');
		$RefNo = $this->input->post('RefNo');
		$Amount = $this->input->post('Amount');
		$Currency = $this->input->post('Currency');
		$Status = $this->input->post('Status');

		if( $this->input->post('PaymentId')=="7"){
			$MerchantCode="IF00066";
			$MechantKey = "UZva3Re3CT";
			$Currency = "IDR";
			$source = $MechantKey.$MerchantCode.$this->input->post('RefNo').$this->input->post('Amount').$Currency;
		}
		else{
			$MechantKey = "BnSjX8yQ26";
			$MerchantCode = $this->input->post('MerchantCode');
			$source = $MechantKey.$MerchantCode.$PaymentId.$RefNo.$Amount.$Currency.$Status;
		}

		$iPay88Response_signature = ipay88_sgn($source);

		/* Variabel untuk history paytest */
		$cariProduct = $this->query->get('pmj_product',array("where"=>array("id_product"=>$this->session->userdata('id_product_payment'))));
		$data_product =array('id_product'   =>  $cariProduct[0]->id_product,
								        'price'   => $cariProduct[0]->billed_one_time,
								        'duration'  => $cariProduct[0]->duration);

		date_default_timezone_set("Asia/Jakarta");
  		$date= date( 'Y-m-d H:i:s', time() );
		$bulan="+".$data_product['duration']." month";  
		$expired_date = date(('Y-m-d H:i:s'),strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . $bulan));
		$submit_date = date('Y-m-d H:i:s');

		//Cek buy from paytest or pmj
		$url_pay = stristr(base_url(),'payment')==TRUE ? "payment" : "main";

		//Cek original amount
		$Amount = $Amount/100;

		/* Jika pembayaran match */
		if ($estatus == '1' && $signature == $iPay88Response_signature) {
   			/* Jika pembayaran gift code */
   			if($this->session->userdata('gift_code_payment')===true){
   				 $gift_code = randomGiftCode();

   				 /* Masukkan data ke table gift code */
				$this->query->save("pmj_gift_code",array("id_product"=>$this->session->userdata('id_product_payment'),
															"gift_code"=>$gift_code,
															"first_name"=>$this->session->userdata('firstNameRecepeint'),
															"last_name"=>$this->session->userdata('lastNameRecepeint'),
															"address"=>$this->session->userdata('addressRecepeint'),
															"homephone"=>$this->session->userdata('homePhoneRecepeint'),
															"handphone"=>$this->session->userdata('handPhoneRecepeint'),
															"for_email"=>$this->session->userdata('emailRecepeint'),
															"created_date"=>$date,
															"updated_date"=>date("Y-m-d h:i:s"),
															"created_by"=>"SYSTEM"));


				/* Variabel Untuk Kirim Email */
				$sendEmail =array(	'id_member' => getSessionUser(),
									'member_name' => $this->session->userdata('firstNameRecepeint')." ".$this->session->userdata('lastNameRecepeint'),
									'email_recepeint'   =>  $this->session->userdata('emailRecepeint'),
									'id_product'   => $this->session->userdata('id_product_payment'),
									'gift_code'=>  $gift_code);

				/* Kirim email jika pembayaran sendiri */
				sendEmailPayment("gift_code",$sendEmail);

				
			}
			/* Jika pembayaran untuk dirinya sendiri */
			else{
				/* Cek di tabel subcription sudah ada atau belum */
				checkSubcription();

				/* Masukkan data ke table subcription */
				// if($this->session->userdata('login_mobile')=="true"){
				// 		$curlProfileCompleted['url'] = "http://pmjakarta.com/apidev/insertSubscription/".getSessionUser()."/".$this->session->userdata('id_product_payment')."/".str_replace(' ','%20',$submit_date)."/".str_replace(' ','%20',$expired_date)."?session=".$this->session->userdata('token')."";

				// 		curl_get($curlProfileCompleted);
				// }

				$this->query->save("pmj_subscription",array("id_member"=>getSessionUser(),"id_product"=>$this->session->userdata('id_product_payment'),"submit_date"=>$submit_date,"expire_date"=>$expired_date));
				
				$sessionSubscription= array('subscription'=>'true');

				$this->session->set_userdata($sessionSubscription);

				/* Variabel Untuk Kirim Email */
				$sendEmail =array(	'id_member'   =>  getSessionUser(),
									'id_product'   => $this->session->userdata('id_product_payment'));

				/* Kirim email jika pembayaran sendiri */
				sendEmailPayment("subscription",$sendEmail);

			}
		}else{
			/* Masukkan data ke tabel history ipay88*/
			$this->query->save("pmj_history_ipay88",array("id_user"=>getSessionUser(),"id_product"=>$this->session->userdata('id_product_payment'),"price"=>$Amount,"ref_no"=>$refno,"estatus"=>$estatus,"errdesc"=>$errdesc,"signature"=>$signature,"purchase_coming" => $url_pay,"date"=>$date));

			redirect(base_url("product")."/payment_failed");
		}

			/* Masukkan data ke tabel history ipay88*/
			$this->query->save("pmj_history_ipay88",array("id_user"=>getSessionUser(),"id_product"=>$this->session->userdata('id_product_payment'),"price"=>$Amount,"ref_no"=>$refno,"estatus"=>$estatus,"errdesc"=>$errdesc,"signature"=>$signature,"purchase_coming" => $url_pay,"date"=>$date));
			
			/* Bersihkan Session */
			$arraySession = array('firstNameRecepeint' => '','lastNameRecepeint' => '', 'addressRecepeint' => '',
								  'homePhoneRecepeint'=>'','handPhoneRecepeint'=>'','id_product_payment' =>'');


			$this->session->unset_userdata($arraySession);

			/* Redirect ke halaman sukses bayar */
			redirect(base_url("product")."/payment_sukses");
	}

	public function cek_code(){
		$code_id = $this->uri->segment(3);
		$cekGiftCode =  $this->query->checkData('pmj_gift_code',"gift_code",$code_id);
        if($cekGiftCode===false){
            echo "	<p><h4>Oops.. , your promo/gift code is invalid<br>Please contact our support</h4></p>
            		<a href='".base_url('product')."/redeem_code' type='button' class='btn btn-primary btn-custom'>Back</a></button>";
        }else{
    		$cariGift = $this->query->get('pmj_gift_code',array("where"=>array("gift_code"=>$code_id)));
			$sessionGift = array('id_product_gift'=>$cariGift[0]->id_product,'id_gift'=>$cariGift[0]->id_gift,'for_email_gift_code'=>$cariGift[0]->for_email);

			$this->session->set_userdata($sessionGift);
			$cekStatus = $cariGift[0]->status;

			if($cekStatus!="use"){
				$cariProductGift = $this->query->get('pmj_product',array("where"=>array("id_product"=>$this->session->userdata("id_product_gift"))));
				$sessionProductGift = array('name_product_gift'=>$cariProductGift[0]->name_product,'use_gift_code'=>true);

					$this->session->set_userdata($sessionProductGift);

					if(getSessionUser() < 1){
						$sessionProductGift = array('gift_code_not_login'=>true);

						$this->session->set_userdata($sessionProductGift);
						$redeemButton =  "<a href='".base_url('product')."/payment/".$this->session->userdata("id_product_gift")."' type='button' class='btn btn-primary btn-custom'>Redeem</a></button>";
					}else{
						$redeemButton = "<a href='".base_url('product')."/payment/".$this->session->userdata("id_product_gift")."' type='button' class='btn btn-primary btn-custom'>Redeem</a></button>";
					}

        			echo "	<p><h4>Your promo/gift code is valid and eligible for:<br><br><strong>".$this->session->userdata("name_product_gift")." Subscription</strong> <br><br>You should be a registerd user in order to redeem.</h4></p>
		        			<a href='' type='button' class='btn btn-primary btn-custom'>Cancel</a></button>
		        			$redeemButton";
					
			}
			else{
				echo "	<p><h4>Oops.. , your promo/gift code is invalid<br>Please contact our support</h4></p>
            			<a href='' type='button' class='btn btn-primary btn-custom'>Back</a></button>";
			}
		}

	}

	function payment_sukses(){
		// if($this->session->userdata('name_product')!=""){
			$this->load->view('product/payment_sukses');
		// }else{
		// 	redirect(base_url());
		// }
		
	}

	function payment_failed(){
		$this->load->view('product/payment_failed');
	}

	function redeem_code(){
		
		$this->load->view('product/redeem_code');
	}
}

/* End of file product.php */
/* Location: ./application/controllers/product.php */