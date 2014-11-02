<?php $this->load->view("template/header");?>
<div class="site-main" id="main">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <section class="form-verification">
          <div class="panel panel-default panel-primary panel-verification header-waiting-verification text-center">
            <h3>Dear valued PMJ member</h3>
            <div class="panel-body" id="form-panel">
              <?php if(checkVerificationData()===false): ?>
                <article>
                  <p>To ensure authenticity and security for PMJakarta members,
                  we are now require all members to verify their profile by providing both
                  face photo and identification photo</p>
                </article>

                <article> 
                  <p>You can skip verification process now.However you must be verified within 48 hours or we will suspend your account</p>
                </article> 
              <?php else: ?>
               <article>
                  <p>Thanks for verification your account. We will check your photo and verify you soon </p>
                </article>
              <?php endif; ?>
                 
            </div>
              <?php if(checkVerificationData()===false): ?>
              <div class="panel-footer panel-verification-footer">
              <a href="<?php echo base_url('verification');?>"><button class="btn btn-primary btn-file">Verify Now</button></a>
              <?php if(checkVerificationLimit()===false): ?><a href="<?php echo base_url();?>"><button class="btn btn-primary btn-file">Skip</button></a> <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </section>
      </div>
      <!-- end of .left-content -->
    </div>
</div>
<!-- end of .container -->
</div>

<?php $this->load->view("template/footer");?>