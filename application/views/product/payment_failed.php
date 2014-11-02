<?php $this->load->view("product/header");?>
<div class="site-main payment-failed" id="main">
  <div class="container">
   <div class="row">
    <div class="col-md-12">
      <div class="text-payment text-center">
        <span><h1 class="text-payment-failed">Sorry..</h1></span>
        <span><h4>Your payment process is failed</h4></span>
        <span><h4>We are unable to process your <strong>subcription</strong></h4></span>
        <span><h4>Please Try Again</h4></span>
      </div>

      <div class="form-login-wrapper text-center center-block btn-group btn-block">  
      <div class="col-md-6">
        <div class="form-group">
          <a href="<?php echo base_url(); ?>profile"><button class="btn btn-primary" name="submit" value="submit" type="submit">Report</button></a>
        </div>
         
      </div>      
       <div class="col-md-6">
        <div class="form-group">
          <a href="<?php echo base_url(); ?>profile"><button class="btn btn-default" name="submit" value="submit" type="submit">Try Again</button></a>
          </div>
       </div>
      
      </div>
    </div>
  </div>
</div>
</div>
<?php $this->load->view("product/footer");?>

