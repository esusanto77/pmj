<?php $this->load->view("product/header");?>
<!-- Header Logo -->
<div class="site-main payment-image" id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb breadcumb-process font-breadcumb">
				<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/IconStepGreen.png"></span><span class="color-breadcumb-1"><?php if($this->session->userdata('use_gift_code')===true){echo "Redeem Gift Code";}else{ echo "Choose Membership Plan"; } ?></span> &gt; </li>
				<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/IconStepPink.png"></span><span class="color-breadcumb-2">Confirm Detail Information</span> &gt; </li>
				<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/icon-step-gray-3.png"></span><span class="color-breadcumb-3">Process payment on iPay88 </span>&gt; </li>
				<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/icon-step-gray-4.png"></span><span class="color-breadcumb-3">Payment process complete</span></li>
			</ul>
			</div>
		</div>
	</div>
</div>

<!-- Payment Image -->
<?php
		/* Get First And Last Name*/
		$pieces = explode(" ", getAuthUsername());

		if(count($pieces)=="1"){
			$firstName =  getAuthUsername();
		}
		else{
			for ($i=0; $i < count($pieces)-1; $i++) { 
				$name .=  $pieces[$i]." ";
			}
			$firstName = $name;
			$lastName =  end($pieces);
		}
		?>
		<div class="container">
			<div class="row product">
				<div class="col-sm-12 text-center">
					<div class="text-select-premium-membership-1">
						<img src="<?php echo base_url("public")?>/assets/img/payment/IconRibbon.png" style="margin:-10px 0px -8px 0px;"> PMJakarta Premium Membership
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 text-center">
					<div class="text-select-premium-membership-2">
						<!-- Nanti di validasi -->
						Please confirm user profile to send the gift code to
					</div>
				</div>
			</div>


			<!--  Tabel Product -->
			<div class="row">
				<form id="paymentForm" action="<?php echo base_url("product")."/cek_proses_payment"; ?>" class="form-horizontal" role="form" method="POST">
					<div class="col-md-12 panel panel-default" style="padding:10px;margin-top:-60px;">
						<div class="col-md-6 nopadding line-right-payment">
							<div class="panel-body" >       
								<input type="hidden" name="id_product" value="<?php echo $product[0]->id_product; ?>">
								<input type="hidden" name="MerchantCode" value="<?php echo $this->payment['MerchantCode']; ?>">
								<input type="hidden" name="RefNo" value="<?php echo $this->payment['RefNo']; ?>">
								<input type="hidden" name="Amount" value="<?php echo $Amount; ?>">
								<input type="hidden" name="Currency" value="<?php echo $this->payment['Currency']; ?>">
								<input type="hidden" name="ProdDesc" value="<?php echo $this->payment['MechantKey']; ?>">
								<input type="hidden" name="UserName" value="<?php echo getAuthUsername(); ?>">
								<input type="hidden" name="UserEmail" value="<?php echo $member[0]->email; ?>">
								<input type="hidden" name="UserContact" value="<?php echo $member[0]->hand_phone; ?>">
								<input type="hidden" name="Remark" value="<?php echo $this->payment['Remark']; ?>">
								<input type="hidden" name="Lang" value="UTF-8">
								<input type="hidden" name="Signature" value="<?php echo $Signature; ?>">
								<input type="hidden" name="ResponseURL" value="<?php echo $this->payment['ResponseURL']; ?>">
								<input type="hidden" name="BackendURL" value="<?php echo $this->payment['BackendURL']; ?>">


								<div class="form-group text-center">
									<div class="col-md-12 col-sm-12"><label class="control-label">RECIPIENT</label></div>	
								</div>

								<div class="form-group">
									<ul class="col-md-12 checkbox-member-or-non">
										<li>
											<label><input type="radio" name="recepeint" value="member" id="recepeint-member"> Member</label>
										</li>                       
										<li>
											<label><input type="radio" name="recepeint" value="non-member" id="recepeint-non-member"> Non Member</label>
										</li>   
									</ul>
								</div> 


								<div id="member">
									<div class="form-group">
										<div class="col-md-12 col-sm-12"><label for="memberCodeId" class="control-label" >Member Code ID</label></div>	
									</div>
									<div class="form-group">
										<div class="col-md-12 col-sm-12">
											<input id="memberCodeId" name="memberCodeId" class="form-control" type="text" placeholder="Member Code ID"></div>
										</div>
									</div>

									<div id="non-member">
										<div class="form-group">
											<div class="col-md-12 col-sm-12"><label for="firstNameRecepeint" class="control-label" >First Name</label></div>	
										</div>

										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<input id="firstNameRecepeint" name="firstNameRecepeint" class="form-control" type="text" placeholder="First Name"></div>
											</div>

											<div class="form-group">
												<div class="col-md-12 col-sm-12"><label for="lastNameRecepeint" class="control-label" >Last Name</label></div>	
											</div>

											<div class="form-group">
												<div class="col-md-12 col-sm-12">
													<input id="lastNameRecepeint" name="lastNameRecepeint" class="form-control" type="text" placeholder="Last Name"></div>
												</div>

												<div class="form-group">
													<div class="col-md-12 col-sm-12"><label for="addressRecepeint" class="control-label" >Address</label></div>
												</div>

												<div class="form-group">
													<div class="col-md-12 col-sm-12">
														<textarea id="addressRecepeint" name="addressRecepeint" class="form-control" type="text"  placeholder="Address"></textarea>
													</div>
												</div>

												<div class="form-group">
													<div class="col-md-12 col-sm-12"><label for="emailRecepeint" class="control-label">Email</label></div>	
												</div>

												<div class="form-group">
													<div class="col-md-12 col-sm-12">
														<input id="emailRecepeint" name="emailRecepeint" class="form-control" type="email" placeholder="Enter a valid email address"></div>
													</div>

													<div class="form-group">
														<div class="col-md-12 col-sm-12"><label for="homePhoneRecepeint" class="control-label">Homephone</label></div>
													</div>

													<div class="form-group">
														<div class="col-md-12 col-sm-12">
															<input id="homePhoneRecepeint" name="homePhoneRecepeint" class="form-control" type="text" placeholder="Home Phone"  >
														</div>
													</div>

													<div class="form-group">
														<div class="col-md-12 col-sm-12"><label for="handPhoneRecepeint" class="control-label">Handphone</label></div>
													</div>

													<div class="form-group">
														<div class="col-md-12 col-sm-12">
															<input id="handPhoneRecepeint" name="handPhoneRecepeint" class="form-control" type="text" placeholder="Hand Phone"  >
														</div>
													</div>
												</div>

												<div class="form-group text-center">
													<div class="col-md-12 col-sm-12"><label class="control-label">SENDER</label></div>	
												</div>

												<div class="form-group">
													<div class="col-md-12 col-sm-12"><label for="firstNameUser" class="control-label">First Name</label></div>	
												</div>

												<div class="form-group">
													<div class="col-md-12 col-sm-12">
														<input id="firstNameUser" name="firstNameUser" class="form-control" type="text" value="<?php echo $firstName; ?>" disabled/></div>
													</div>

													<div class="form-group">
														<div class="col-md-12 col-sm-12"><label for="lastNameUser" class="control-label">Last Name</label></div>    
													</div>

													<div class="form-group">
														<div class="col-md-12 col-sm-12">
															<input id="lastNameUser" name="lastNameUser" class="form-control" type="text" value="<?php echo $lastName; ?>" disabled/></div>
														</div>


														<div class="form-group">
															<div class="col-md-12 col-sm-12"><label for="addressUser" class="control-label" required>Address</label></div>
														</div>

														<div class="form-group">
															<div class="col-md-12 col-sm-12">
																<textarea id="addressUser" name="addressUser" class="form-control" type="text"  placeholder="Address" required><?php echo $member[0]->address; ?></textarea>
															</div>
														</div>

														<div class="form-group">
															<div class="col-md-12 col-sm-12"><label for="emailUser" class="control-label">Email</label></div>
														</div>

														<div class="form-group">
															<div class="col-md-12 col-sm-12"><input id="emailUser" name="emailUser" class="form-control" type="email"  placeholder="Email"  value="<?php echo $member[0]->email; ?>" disabled/></div>
														</div>

														<div class="form-group">
															<div class="col-md-12 col-sm-12"><label for="homePhoneUser" class="control-label">Homephone</label></div>
														</div>

														<div class="form-group">
															<div class="col-md-12 col-sm-12">
																<input id="homePhoneUser" name="homePhoneUser" class="form-control" type="text" placeholder="Home Phone" value="<?php echo $member[0]->home_phone; ?>" required>
															</div>
														</div>

														<div class="form-group">
															<div class="col-md-12 col-sm-12"><label for="handPhoneUser" class="control-label">Handphone</label></div>
														</div>

														<div class="form-group">
															<div class="col-md-12 col-sm-12">
																<input id="handPhoneUser" name="handPhoneUser" class="form-control" type="text" placeholder="Hand Phone" value="<?php echo $member[0]->hand_phone; ?>" required>
															</div>
														</div>


														<div class="form-group">
															<div class="col-md-12 col-sm-12" style="color:black;">
																Disclamer : Phone numbers and emails will not be sold or used for marketing purpose<br><br>
															</div>
														</div>


													</div>
												</div>

												<div class="col-md-6 nopadding" style="margin-top:100px;"><span style="position: relative;">
													<div class="panel-body">
														<div class="product-heading logo-payment-header" >
															<img src="<?php  echo base_url("public")."/".$product[0]->logo_image; ?>">
														</div>

														<ul class="list-group payment-information">
															<li class="list-group-item">IDR <?php echo number_format($product[0]->price); ?> / month</b><br></li>
															<li class="list-group-item"><i>Billed one time:</i> IDR  <?php echo number_format($product[0]->billed_one_time); ?></b><br></li>
															<?php
															if($this->discount['discount']>0)
																echo '<li class="list-group-item">You Got '.$this->discount['discount'].' % Discount<br></li>';
															?>
														</ul>

														<ul class="list-group payment-description">
															<?php echo $product[0]->description; ?>
														</ul>

													<div class="col-md-12">
													<ul class="breadcrumb breadcumb-payment pull-left">
														<li>
															<div class="col-sm-12 col-md-12 col-xs-12">
																<div class="form-group">
																	<input type="radio" name="PaymentId" value="1" checked>
																	<img src="<?php echo base_url("public")?>/assets/img/payment/LogoVisa.png">
																	<img src="<?php echo base_url("public")?>/assets/img/payment/LogoMaster.png">
																</div>
															</div>
														</li>  	
														<li><div class="col-sm-12 col-md-12 col-xs-12"><div class="form-group">
															<input type="radio" name="PaymentId" value="4">
															<img src="<?php echo base_url("public")?>/assets/img/payment/LogoMandiri.png" ></div></div>
														</li>   
														<li><div class="col-sm-12 col-md-12 col-xs-12"><div class="form-group">
															<input type="radio" name="PaymentId" value="7">
															<img src="<?php echo base_url("public")?>/assets/img/payment/cimb_logo.png" width="50px;" height="34px;">
														</div></div>
													</li>							
												</ul>
											</div>

													</div>  
												</div>  
												<div class="col-md-12  panel panel-button">
													<button class="btn btn-primary btn-primary btn-lg pull-right" type="submit">Continue</button>  	          
												</form> 
												
											</div>
										</div>
									</div>

									<script>
									jQuery.noConflict()(function ($) {
										$(document).ready(function() {
											$('#paymentForm').bootstrapValidator({
												fields: {
													addressUser: {
														validators: {
															notEmpty: {
																message: 'Address is required and cannot be empty'
															}
														}
													},
													homePhoneUser: {
														validators: {
															notEmpty: {
																message: 'Homephone is required and cannot be empty'
															}
														}
													},
													handPhoneUser: {
														validators: {
															notEmpty: {
																message: 'Handphone is required and cannot be empty'
															}
														}
													},
													recepeint: {
														validators: {
															notEmpty: {
																message: 'Recepeint is required and cannot be empty'
															}
														}
													},
													memberCodeId: {
														validators: {
															notEmpty: {
																message: 'Member Code ID is required and cannot be empty'
															}
														}
													},
													firstNameRecepeint: {
														validators: {
															notEmpty: {
																message: 'First Name recepeint is required and cannot be empty'
															}
														}
													},
													lastNameRecepeint: {
														validators: {
															notEmpty: {
																message: 'Last Name recepeint is required and cannot be empty'
															}
														}
													},
													emailRecepeint: {
														validators: {
															notEmpty: {
																message: 'Email recepeint is required and cannot be empty'
															}
														}
													}           
												}
											});

$('#recepeint-member').change(function() {
	if ($(this).is(':checked')) {
		$('#member').css({'display':'block'});
		$('#non-member').css({'display':'none'});
		$('#buttonContinue').removeAttr('disabled');

	}  
});

$('#recepeint-non-member').change(function() {
	if ($(this).is(':checked')) {
		$('#member').css({'display':'none'});
		$('#non-member').css({'display':'block'})
		$("#memberCodeId").val("");
		$('#buttonContinue').removeAttr('disabled');
	} 
});

});
});
</script>

<?php $this->load->view("product/footer");?>
