<?php $this->load->view("product/header");?>
<!-- Header Logo -->
<div class="payment-image">
	<div class="container">
		<div class="row">
			<ul class="breadcrumb breadcumb-process font-breadcumb ">
				<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/IconStepGreen.png"></span><span class="color-breadcumb-1"><?php if($this->session->userdata('use_gift_code')===true){echo "Redeem Gift Code";}else{ echo "Choose Membership Plan"; } ?></span> &gt; </li>
				<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/IconStepPink.png"></span><span class="color-breadcumb-2">Confirm Detail Information</span> &gt; </li>
				<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/icon-step-gray-3.png"></span><span class="color-breadcumb-3">Process payment on iPay88 </span>&gt; </li>
				<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/icon-step-gray-4.png"></span><span class="color-breadcumb-3">Payment process complete</span></li>
			</ul>
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
						Please confirm your profile and Membership Plan
					</div>
				</div>
			</div

			<!--  Tabel Product -->
			<div class="row">
				<form id="paymentForm" action="<?php echo base_url("product")."/cek_proses_payment"; ?>" class="form-horizontal" role="form" method="POST">	
					<div class="col-md-12 panel panel-default panel-left">
						<div class="col-md-6 nopadding line-right-payment ">
							<div class="panel-body" >       
								<input type="hidden" name="id_product" value="<?php echo $product[0]->id_product; ?>">
								<input type="hidden" name="MerchantCode" value="<?php echo $this->payment['MerchantCode']; ?>">
								<input type="hidden" name="RefNo" value="<?php echo $this->payment['RefNo']; ?>">
								<input type="hidden" name="Amount" value="<?php echo $Amount; ?>">
								<input type="hidden" name="Currency" value="<?php echo $this->payment['Currency']; ?>">
								<input type="hidden" name="ProdDesc" value="<?php echo $this->payment['ProdDesc']; ?>">
								<input type="hidden" name="UserName" value="<?php echo getAuthUsername(); ?>">
								<input type="hidden" name="UserEmail" value="<?php if($this->session->userdata("email")!=""): echo $this->session->userdata("email");  else: echo $member[0]->email; endif; ?>">
								<input type="hidden" name="UserContact" value="<?php if($this->session->userdata("email")!=""): echo $this->session->userdata("email");  else: echo $member[0]->hand_phone; endif; ?>">
								<input type="hidden" name="Remark" value="<?php echo $this->payment['Remark']; ?>">
								<input type="hidden" name="Lang" value="UTF-8">
								<input type="hidden" name="Signature" value="<?php echo $Signature; ?>">
								<input type="hidden" name="ResponseURL" value="<?php echo $this->payment['ResponseURL']; ?>">


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
											<div class="col-md-12 col-sm-12"><label for="addressUser" class="control-label">Address</label></div>
										</div>

										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<textarea id="addressUser" name="addressUser" class="form-control" type="text"  placeholder="Address"><?php if($this->session->userdata("address")!=""): echo $this->session->userdata("address");  else: echo $member[0]->address; endif; ?></textarea>
											</div>
										</div>

										<div class="form-group">
											<div class="col-md-12 col-sm-12"><label for="emailUser" class="control-label">Email</label></div>
										</div>

										<div class="form-group">
											<div class="col-md-12 col-sm-12"><input id="emailUser" name="emailUser" class="form-control" type="email"  placeholder="Email"  value="<?php if($this->session->userdata("email")!=""): echo $this->session->userdata("email");  else: echo $member[0]->email; endif; ?>" disabled/></div>
										</div>

										<div class="form-group">
											<div class="col-md-12 col-sm-12"><label for="homePhoneUser" class="control-label">Homephone</label></div>
										</div>

										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<input id="homePhoneUser" name="homePhoneUser" class="form-control" type="text" placeholder="Home Phone" value="<?php if($this->session->userdata("home_phone")!=""): echo $this->session->userdata("home_phone");  else: echo $member[0]->home_phone; endif; ?>">
											</div>
										</div>

										<div class="form-group">
											<div class="col-md-12 col-sm-12"><label for="handPhoneUser" class="control-label">Handphone</label></div>
										</div>

										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<input id="handPhoneUser" name="handPhoneUser" class="form-control" type="text" placeholder="Hand Phone" value="<?php if($this->session->userdata("hand_phone")!=""): echo $this->session->userdata("hand_phone");  else: echo $member[0]->hand_phone; endif; ?>">
											</div>
										</div>


										<div class="form-group">
											<div class="col-md-12 col-sm-12" style="color:black;">
												Disclamer : Phone numbers and emails will not be sold or used for marketing purpose<br><br>
											</div>
										</div>


									</div>
								</div>

								<div class="col-md-6 nopadding panel-right">
									<div class="panel-body">
										<div class="product-heading logo-payment-header" >
											<img src="<?php  echo base_url("public")."/".$product[0]->logo_image; ?>">
										</div>

										<ul class="list-group payment-information">
											<li class="list-group-item">IDR <?php echo number_format($product[0]->price); ?> / month<br></li>
											<li class="list-group-item"><i>Billed one time:</i> IDR  <?php echo number_format($product[0]->billed_one_time); ?><br></li>
											<?php
											if($this->discount['discount']>0)
												echo '<li class="list-group-item">You Got '.$this->discount['discount'].' % Discount<br></li>';
											?>
										</ul>

										<ul class="list-group payment-description">
											<?php echo $product[0]->description; ?>
										</ul>

										<!-- Jika tidak menggunakan gift code -->
										<?php if($this->session->userdata('use_gift_code')!==true){ ?>
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-12">
													<label for="PaymentId" class="text-payment-method">Select Payment Method</label>
												</div>
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
									
									<?php } ?>

								</div>  
							</div>  
							<div class="col-md-12  panel panel-button">
								<button class="btn btn-primary btn-primary btn-lg pull-right" type="submit">Continue</button>  	          
							</form> 
						</div>
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
							}
						}
					});
				});
			});
			</script>

			<?php $this->load->view("product/footer");?>