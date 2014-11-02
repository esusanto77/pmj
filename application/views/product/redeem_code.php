<?php $this->load->view("product/header");?>
  <!-- Header Logo -->
	  <div class="site-main payment-image" id="main">
	    <div class="container">
	      <div class="row">
	        <div class="col-sm-12">
	          <div class="text-center welcome-premium">
	          	<?php 	if(getAuthUsername()!=""){
	          		  	 echo "Hi,  ".getAuthUsername()."";
	          			}else{
	          				echo "<br>";
	          			}
	          	?>
	        
	          </div>
	          <div class="text-center tulisan-header">
	            Enter your promo code/gift code to check its validity
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
      
  	<div class="container">
        <div class="row product">
			<div class="col-md-12 text-center">
				<div id="sucess-gift-code" style="display:none">
					
					
				</div>	
				
				<div class="form-redeem-code center-block" id="form-code">
					<form class="form"  id="formPromoCode" method="POST">
						<label for="promoCode" id="lblPromoCode"><h4>Enter Your Promo Code</h4></label>
						<div class="form-group">
							<input type="text" class="form-control text-center" id="promoCode" name="promoCode" value="<?php echo $this->uri->segment(3); ?>" placeholder="Your Promo Code" >
						</div>
						<button class="btn btn-primary" type="submit">Submit</button>
					</form>
				</div>
			</div>
        </div>
 	</div>

<?php $this->load->view("product/footer");?>

<script type="text/javascript">
jQuery.noConflict()(function ($) {
	$(document).ready(function() {
		$('#formPromoCode').bootstrapValidator({
			submitHandler: function(validator, form, submitButton) {
				$.ajax({
					type: "GET", 
					url: <?php echo '"'.base_url('product').'/cek_code/"';?>+$('#promoCode').val(),
					dataType : "text",
					success: function(data){
						$('#form-code').css('display','none');
						$('#sucess-gift-code').css('display','block');
						$('#sucess-gift-code').html(data);
					}});
				
			},
			fields: {
				promoCode: {
					validators: {
						notEmpty: {
							message: 'Promo Code cannot be empty'
						}
					}
				}  
			}
		});


	});
 });
</script>