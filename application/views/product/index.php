<?php $this->load->view("product/header");?>
<!-- Header Logo -->
<div class="site-main payment-image" id="main">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="text-center welcome-premium">
					Hi, <?php echo getAuthUsername() ?>!
				</div>
				<!-- Nanti di validasi -->
				<div class="text-center tulisan-header">
					Thank you for answering the questionnaire. Now to complete you registration process<br>
					please choose your Membership Plan
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Payment Image -->
<div class="container">
	<div class="row product">
		<div class="col-md-12 text-center">
			<div class="text-select-premium-membership-1">
				<img src="<?php echo base_url("public")?>/assets/img/payment/IconRibbon.png" style="margin:-11px 0px -8px 0px;"> PMJakarta Premium Membership
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 text-center">
			<div class="text-select-premium-membership-2">
				<!-- Pick you Membership Plan according to your needs -->
				EARLY BIRD PROMO DISCOUNTS
			</div>
		</div>
	</div>

	<!--  Tabel Product -->
	<div class="row">

		<?php 
		$paket = 1;
		foreach ($id_product->result() as $row)
		{

			?>
			<div  class="col-md-4 nopadding " id="content">

				<div class="paket<?php echo $paket; ?> panel panel-default panel-hover ">

					<div class="panel-heading logo-product text-center" style="position:relative;">
						<h3><img src="<?php  echo base_url("public")."/".$row->logo_image; ?>" >
							<!-- <p style="position:absolute;top: 32px; left: 33%; font-weight:bold;font-size:1em;"> -->
								<?php
									// if($paket===1):
									// 	$teks = "Good Deal!";
									// elseif($paket===2):
									// 	$teks = "Great Deal!";
									// elseif($paket===3):
									// 	$teks = "&nbspBest Deal!";
									// endif;

									// echo "$teks";
								?>

							<!-- </p> -->
						</h3>
						
					</div>

					<div class="panel-body">
						<span class="price-product">IDR  <?php echo number_format($row->price); ?> / month<br></span>
						<span class="billed-one-time-product"><i>Billed one time:</i> IDR <?php echo number_format($row->billed_one_time); ?> <br></span>
						<?php
						if($this->discount['discount']>0)
							echo '<span class="price-product">You Got '.$this->discount['discount'].' % Discount<br></span>';
						?>
						<div><br>EARLY BIRD DISCOUNTS TILL END OF YEARS<br>
							DISCOUNT IF PAID BY :<br>
							50% IF PAID IN MONTH OF NOV. <?php echo getAmountDetail($paket,"35"); ?><br>
							25% IF PAID IN MONTH OF DEC. <?php echo getAmountDetail($paket,"15"); ?><br>
							DISCOUNT WILL BE APPLIED AUTOMATICALLY<br>
							ON THE PAYMENT PAGE<br>
							DON'T MISS OUT AND ENJOY THE LARGE<br>
							DISCOUNTS<br> 
						</div>
					</div>

					<ul class="list-group text-left">

						<?php echo $row->description; ?>

						<li class="list-group-item text-center">
							<a class="btn btn-primary btn-custom" href="<?php if($this->uri->segment(3)=="gift_code"){ echo base_url("product")."/payment_gift_code/$paket"; }else { echo base_url("product")."/payment/$paket"; }?>">Proceed</a>
						</li>

						<li class="list-group-item text-center"><a class="learn-more" href="">Learn More</a></li>

					</ul>

				</div>          

			</div>

			<?php
			$paket++;
		}
		?>	</div>
		<!-- <div class="row">
			<div class="col-md-12 text-center">
				<div class="form-group">
					<a class="btn btn-primary" href="http://match-matters.com/">Or continue to match-matters.com</a>
				</div>
			</div>
		</div> -->

	</div>

	<script type="text/javascript">
	jQuery.noConflict()(function ($) {
		$( document ).ready(function(){
			for (var i = 1; i <= 3; i++) {
				$(".paket"+i+"").hover(

					function() {
						$(this).css({'box-shadow':'0 0 10px rgba(0,0,0,.5)'});
					}, function() {
						$(this).css({'box-shadow': ''})
					});

			};
		});
	});   
	</script>


	<?php $this->load->view("product/footer");?>
