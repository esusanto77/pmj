<?php $this->load->view("template/header");?>
<div class="site-main" id="main">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <section class="form-verification">
          <div class="panel panel-default panel-primary panel-verification header-waiting-verification text-center">
            <h3>Dear valued Customer</h3>
            <div class="panel-body" id="form-panel">
              <article>
               <p>Your account have been suspended from PMJakarta because you don't
                  meet our criteria for authenticity and security</p>
               </article>
               <article> 
                <p>If you think is a mistake, contact PMJakarta admin by clicking
                  button below</p>
              </article>    
            </div>
             <div class="panel-footer panel-verification-footer">
               <button class="btn btn-primary btn-file"  data-toggle="modal" data-target="#modalContactAdmin" id="button-contact-admin">Contact Admin</button>
            </div>
          </div>
        </section>
      </div>
      <!-- end of .left-content -->
    </div>
</div>
<!-- end of .container -->
</div>

<!-- Modal -->
<div class="modal fade" id="modalContactAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Contact Admin</h4>
      </div>
      <div class="modal-body">
      <form role="form" action="<?php echo base_url("verification")."/formContactAdmin"?>" method="post" >
      <div class="form-group">
        <label for="message-admin">Message</label>
        <div class="alert alert-danger hidden-alert-verification" id="alert-message"></div>
        <textarea class="form-control" rows="3" id="message-admin" name="message-admin"></textarea>
         <div class="alert alert-success hidden-alert-verification" id="information-message"></div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="send-email-admin">Send</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <script src="<?php echo base_url()?>public/assets/js/contact.js"></script>
<?php $this->load->view("template/footer");?>