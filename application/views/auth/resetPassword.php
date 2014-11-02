<?php $this->load->view("template/header");?>


<div class="container">
			
<?php if(!empty($alert)){ ?>
	<div class="row">
		<div class="col-md-12">
<?php
		switch ($alert) {
			case '1':
				echo '<p class="alert alert-success">Your password was updated, please <a href="'.base_url().'">login</a></p>';
				break;

			case '2':
				echo '<p class="alert alert-danger">Your password doesnt match</p>';
				break;	

			case '3':
				echo '<p class="alert alert-danger">Sorry, you got a wrong code verification.</p>';
				break;	
			
		}
?>
		</div>
	</div>
<?php } ?>
<?php if( !empty($alert) && $alert == 3){} else { ?>
	<div class="row">
		<div class="col-md-5">

			<form action="" method="POST">
				<p>Insert your new password</p>
        <div class="form-group">
          <input type="password" name='password' class="form-control">
        </div>
        <div class="form-group">
          <input type="password" name='check_password' class="form-control">
        </div>
        <div class="form-group">
        	<input type='submit' name='submit' value='Reset Password' class="btn btn-primary">
        </div>
			</form>

		</div>
	</div>
<?php } ?>

</div>


<?php $this->load->view("template/footer");?>