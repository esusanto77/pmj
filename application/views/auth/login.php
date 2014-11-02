<?php $this->load->view("template/header");?>

      <div class="site-main front-content-bg" id="main">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="logo-welcome text-center">
                <img alt="Welcome PM Jakarta" src="<?php echo base_url("public")?>/assets/img/logo-home.png">
              </div>

              <div class="form-login-wrapper center-block">
                <?php if(!empty($alert)):?> 
                  <span class='alert alert-danger form-login-alert center-block'><?php echo $alert?></span>
                <?php endif; ?>
                <form class="form-inline" role="form" id="formAuth" method="POST">
                  <div class="form-group">
                    <input class="form-control" name="email" placeholder="Username" type="email">
                  </div>
                  <div class="form-group">
                    <input class="form-control" name="password" placeholder="Password" type="password">
                  </div>
                  <button class="btn btn-default" name='submit' value='submit' type="submit">LOGIN</button>
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
              <span class="small">AND FIND YOUR FERPECT MATCH!</span>
            </h3>
          </div>
          <div class="col-sm-5">
            <form role="form">
              <h5>SIGN UP</h5>
              <div class="form-group">
                <input class="form-control" name="name" placeholder="Name" type="text">
              </div>
              <div class="form-group">
                <input class="form-control" name="email" placeholder="Email Address" type="email">
              </div>
              <div class="form-group text-right">
                <button class="btn btn-signup" type="submit">Continue</button>
              </div>
            </form>
          </div>
        </div>
      </div>

<?php $this->load->view("template/footer");?>