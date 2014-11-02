<?php if($this->uri->segment(1) != "question" && $this->uri->segment(1) != "frontpage"):?>
<section class="container">
	<div class="row-fluid">
		<div class='col-md-12'>
			<div class="alert alert-info row">
				<b>Ooops..</b> you have not verified your email account. Please check your email inbox and click link for validation from us ( <span class='resend-email'><a href="#"> resend email confirmation</a></span> )
			</div>
		</div>
	</div>
</section>
<?php endif; ?>