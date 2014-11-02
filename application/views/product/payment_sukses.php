<?php $this->load->view("product/header");?>
<div class="site-main payment-sukses" id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb breadcumb-process font-breadcumb">
					<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/IconStepGreen.png"></span><span class="color-breadcumb-1"><?php if($this->session->userdata('use_gift_code')===true){echo "Redeem Gift Code";}else{ echo "Choose Membership Plan"; } ?></span> &gt; </li>
					<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/IconStepGreen.png"></span><span class="color-breadcumb-1">Confirm Detail Information</span> &gt; </li>
					<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/IconStepGreen.png"></span><span class="color-breadcumb-1">Process payment on iPay88 </span>&gt; </li>
					<li><span><img src="<?php echo base_url("public")?>/assets/img/payment/icon-step-gray-4.png"></span><span class="color-breadcumb-2">Payment process complete</span></li>
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="text-payment text-center">
					<span><h1>Congratulations !</h1></span>
					<?php if($this->session->userdata('gift_code_payment')===true){ ?>
					<span><h4><strong> <?php echo $this->session->userdata('name_product'); ?> Subscription</strong> gift code is already sent to: <strong><?php echo $this->session->userdata('emailRecepeint'); ?></strong></h4>
						<?php } else { ?>
						<span><h4>Your registration process is complete and your</h4></span>
						<span><h4><strong><?php echo $this->session->userdata('name_product'); ?> Subscription</strong> is active now</h4></span>
						<?php } ?>

						<!-- Hapus Session -->
						<?php 
						$arraySession = array('gift_code_payment'=>'','emailRecepeint' => '','name_product' =>'');
						$this->session->unset_userdata($arraySession);

						?>
					</div>

					<div class="form-login-wrapper text-center center-block btn-group btn-block">  
						<div class="col-md-6">
							<div class="form-group">
								<a href="<?php echo base_url(); ?>profile"><button class="btn btn-primary" name="submit" value="submit" type="submit">View Active Membership</button></a>
							</div>

						</div>      
						<div class="col-md-6">
							<div class="form-group">
								<a href="<?php echo base_url(); ?>profile"><button class="btn btn-default" name="submit" value="submit" type="submit">Go To Your Profile</button></a>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view("product/footer");?>

