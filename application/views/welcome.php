<?php $this->load->view("template/header");?>
      <div class="site-main front-content-bg" id="main" data-stretch="<?php echo base_url()?>public/assets/img/bg-home-2.jpg">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="logo-welcome text-center">
                <img alt="Welcome PM Jakarta" src="<?php echo base_url("public")?>/assets/img/logo-home.png">
              </div>

              <div class="form-login-wrapper center-block">
                <?php if($this->session->flashdata('invalidLogin')!=""):?> 
                  <span class='alert alert-danger form-login-alert center-block'><?php echo $this->session->flashdata('invalidLogin');?></span>
                <?php endif; ?>
                <form class="form-inline" role="form" action="<?php echo base_url('auth/login')?>" id="formAuth" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input class="form-control" name="email" placeholder="Username" type="email">
                      </div>
                      <div class="form-group">
                        <input class="form-control" name="password" placeholder="Password" type="password">
                      </div>
                      <div class="form-group">
                        <button class="btn btn-default" name='submit' value='submit' type="submit">LOGIN</button>
                      </div>
                    </div>
                    <div class="col-md-12 remember-me-login">
                      <div class="checkbox">
                      <label >
                        <input type="checkbox" style="width:auto !important;" name="rememberMe"> Remember me
                      </label>
                      </div>
                    </div>
                  </div>
                </form>
                <!-- end of form.form-inline -->
                <a class="forgot-password" href="#">Forgot Password?</a>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-signup-wrapper center-block">
        <div class="row">
          <div class="col-sm-7">
            <h4>ARE YOU NOT A MEMBER?</h4>
            <h3>
              JOIN US NOW
              <span class="small">AND FIND YOUR PERFECT MATCH!</span>
            </h3>
            <br>
            <br>
            <a href="https://play.google.com/store/apps/details?id=com.dycode.pmjakarta" target='_blank'>
              <img alt="Get it on Google Play"
              src="https://developer.android.com/images/brand/en_generic_rgb_wo_45.png" />
            </a>
          </div>
          <div class="col-sm-5">
            <form role="form" method="post" id='form-register' action="<?php echo base_url('auth/register')?>">
              <h5>SIGN UP 
                <div class="pull-right">
                  <!-- <a href="#" onclick="fbLogin()"><i class="fa fa-facebook-square"></i></a> -->
                  <a href="<?php echo base_url('auth/loginWithLinkedin')?>"><i class="fa fa-linkedin-square"></i></a>
                </div>
              </h5>
              <div class="form-group">
                <input class="form-control pre-input-name" name="name" placeholder="Name" type="text">
              </div>
              <div class="form-group">
                <input class="form-control pre-input-email" name="email" placeholder="Email Address" type="email">
              </div>              
              <div class="form-group text-right">
             	  <div class="login-loading"></div>
                <button class="btn btn-signup btn-pre-signup" type="submit">Continue</button>
              </div>
            </form>
          </div>
        </div>
      </div>


<!-- Modal -->
<form id="form-popup-signup" role="form" method="post" action="<?php echo base_url('auth/register')?>">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Sign Up</h4>
      </div>
      <div class="modal-body">
         <div id="errorMessage"></div>
          
          <div class="form-group">
            <label for="input-name">Name</label>
            <input type="text" name="name" class="form-control input-name" placeholder="Enter Your Name">
          </div>

          <div class="form-group">
            <label for="input-email">Email</label>
            <input type="email" name="email" class="form-control input-email" placeholder="Enter Your Email">
          </div>

          <div class="form-group">
            <label for="input-password">Password</label>
            <input type="password" name="password" class="form-control input-password" placeholder="Enter Your Password">
          </div>

          <div class="form-group">
            <label for="input-birth">Birth of Date</label>
            <input type="text" name="birth" class="form-control input-birth datepicker" data-date-format="yyyy-mm-dd" data-date-viewmode="years" placeholder="Enter Your Birth of Date">
          </div>

          <div class="form-group">
            <label for="input-gender">Gender</label>
            <br>
            <input type="radio" id='input-gender-male' value='Male' name='gender' style="display: inline !important;"> Male
            <input type="radio" id='input-gender-female' value="Female" name='gender' style="display: inline !important;"> Female
          </div>

          <div class="form-group">
            <label for="input-birth">City</label>
            <br>
            <select name="city" id="">
              <?php foreach($city as $c):?>
                <option><?php echo $c->city_name?></option>
              <?php endforeach; ?>
            </select>
          </div>


      </div>
      <div class="modal-footer">
        <div class="signup-popup-loading"></div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="button" class="btn btn-primary btn-save-signup" value="Sign Up">
        <div id="flash"></div>
      </div>
    </div>
  </div>
</div>
</form>



<!-- Modal forget password -->
<form id="form-popup-forgot" role="form" method="post">
<div class="modal fade" id="myModalForgetPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
      </div>
      <div class="modal-body modal-forgotPassword">
          <div id="errorMessage"></div>        
          <div class="form-group">
            <p>Insert your email address below, we'll send you link to reset your password</p>
            <input type="email" name="email" class="form-control input-email-forgot" placeholder="Enter Your Email">
          </div>                                   
      </div>
      <div class="modal-footer">
        <div class="signup-popup-loading"></div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary btn-forgotPassword" value="Submit">
        <div id="flash"></div>
      </div>
    </div>
  </div>
</div>
</form>

<?php $this->load->view("template/footer");?>