<?php if($this->uri->segment(1) != "question" && $this->uri->segment(1) != "frontpage"):?>
<section class="container">
	<div class="row-fluid">
		<div class='col-md-12'>
			<div class="alert alert-info row">
				You are not verified, you have 48 hours to verify your identity now. (<a href="<?php echo base_url(); ?>verification/waitingVerification"> Verify now </a> )
			</div>
		</div>
	</div>
</section>
<?php endif; ?>