<?php $this->load->view("template/header");?>

<div class="container">
	<div class="row">
		<div class="col-md-6">
			<h2>SIGN UP NOW</h2>
			<p class="alert alert-danger">
        <?php echo $notif; ?>

			</p>
			<form id="form-popup-signup" role="form" method="post" action="<?php echo base_url('auth/register')?>">
          <div class="form-group">
            <label for="input-name">Name</label>
            <input type="text" name="name" class="form-control input-name" placeholder="Enter Your Name" value="<?php echo @$auth['name']?>">
          </div>

          <div class="form-group">
            <label for="input-email">Email</label>
            <input type="email" name="email" class="form-control input-email" placeholder="Enter Your Email" value="<?php echo @$auth['email']?>">
          </div>

          <div class="form-group">
            <label for="input-password">Password</label>
            <input type="password" name="password" class="form-control input-password" placeholder="Enter Your Password">
          </div>

          <div class="form-group">
            <label for="input-birth">Birth of Date</label>
            <input type="text" name="birth" class="form-control input-birth datepicker" data-date-format="yyyy-mm-dd" data-date-viewmode="years" placeholder="Enter Your Birth of Date" value="<?php echo @$auth['birth']?>">
          </div>

          <div class="form-group">
            <label for="input-gender">Gender</label>
            <br>
            <input type="radio" id="input-gender-male" value='Male' name='gender' <?php if(!empty($auth['gender']) && $auth['gender'] == "Male"){ echo "checked"; }?>> Male
            <input type="radio" id="input-gender-female" value="Female" name='gender' <?php if(!empty($auth['gender']) && $auth['gender'] == "Female"){ echo "checked"; }?>> Female
          </div>

          <div class="form-group">
            <label for="input-birth">City</label>
            <br>
            <select name="city" id="">
              <?php foreach($city as $c):?>
                <option <?php if(!empty($auth['city']) && $auth['city'] == $c->city_name){ echo "selected"; }?>><?php echo $c->city_name?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <input type="submit" class="btn btn-signup btn-save-signup" value="Sign Up">
			</form>
		</div>
	</div>
</div>

<?php $this->load->view("template/footer");?>