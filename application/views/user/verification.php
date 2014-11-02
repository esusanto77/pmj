<?php $this->load->view("template/header");?>
<div class="site-main" id="main">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <section class="form-verification">
          <div class="panel panel-default panel-primary panel-verification"> 
            <div class="col-md-10 col-sm-10 col-md-offset-1  col-sm-offset-1 col-xs-10  col-xs-offset-1 header-verification text-center"><h3>PMJakarta Photo Verification</h3></div>
            <div class="clearfix"></div>
            <div class="panel-body" id="form-panel">
              <div class="col-md-4 col-md-offset-1" id="form-photo-1">
                <div class="row">
                  <div class="col-md-12"> 
                    <div class="form-group">
                      <h3 class="text-center">Face photo</h3>
                      <span class="clearfix">Please ensure your image is clear and includes your face area</span>
                      <div class="alert alert-danger hidden-alert-verification" id="alert-photo-1"></div>
                    </div>
                    <div class="form-group text-center" id="webcam1">
                      <img src="<?php echo base_url('public');?>/assets/img/default-avatar.png" class="img-thumbnail avatar" alt="Responsive image" >
                    </div>
                  </div>
                  <div class="col-md-12 form-inline text-center">
                    <span class="btn btn-primary btn-file" >
                      Browse <input type="file" id="verification-photo1" name="verification-photo[]" accept="image/jpeg">
                    </span> 
                    <input type="button" class="btn btn-primary btn-file" value="Webcam" id="buttonWebcam1">
                    <input type="button" class="btn btn-primary btn-file" value="Capture" id="capture-webcam1" style="display:none">
                  </div>                
                </div>
              </div>
              <div class="col-md-4 col-md-offset-2" id="form-photo-2">
                <div class="row">
                 <div class="col-md-12"> 
                  <div class="form-group">
                    <h3 class="text-center">Identification with photo</h3>
                    <span class="clearfix">Please ensure your image is clear and include your name, address, and photo</span>
                    <div class="alert alert-danger hidden-alert-verification" id="alert-photo-2" ></div>
                  </div>
                  <div class="form-group text-center" id="webcam2">
                    <img src="<?php echo base_url('public');?>/assets/img/default-avatar.png" class="img-thumbnail avatar" alt="Responsive image" >
                  </div>
                </div>
                  <div class="col-md-12 form-inline text-center">
                    <span class="btn btn-primary btn-file" id="button2" >
                      Browse <input type="file" id="verification-photo2" name="verification-photo[]" accept="image/jpeg">
                    </span> 
                    <input type="button" class="btn btn-primary btn-file" value="Webcam" id="buttonWebcam2">
                    <input type="button" class="btn btn-primary btn-file" value="Capture" id="capture-webcam2" style="display:none">
                  </div>
                  <div class="col-md-12 clearfix"><br>
                    You can use KTP, SIM, KITAS, PASSPORT or other identification with your photo on it
                  </div>  
                </div>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <div class="panel-footer panel-verification-footer form-inline">
                <button class="btn btn-primary btn-file"  id="submit-verification">Request Verification</button>  
                <button class="btn btn-primary btn-file" data-toggle="modal" data-target="#myModalExampleVerification">Example Verification Photo</button>
                <img src="<?php echo base_url("public")."/assets/img/ajax-loader.gif"; ?>" id="animation-loading-upload-verification" style="display:none">
              </div>
            </div>
          </section>
        </div>
        <!-- end of .left-content -->
      </div>
    </div>
    <!-- end of .container -->
  </div>

  <!-- Modal Metode Upload Photo -->
  <div class="modal fade" id="myModalExampleVerification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-example-verification">
      <div class="modal-content">
        <div class="modal-body text-center">  
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-primary panel-verification panel-example-verification text-center">
                <div class="col-md-10 col-sm-10 col-md-offset-1  col-sm-offset-1 col-xs-10  col-xs-offset-1 header-verification"><h1>Valid Photo Example</h1></div>
                <div class="panel-body" id="form-panel">
                  <div class="col-md-5 col-md-offset-1">
                    <div class="row">
                      <div class="col-md-12"> 
                        <div class="form-group">
                          <h3>Face Photo</h3>
                        </div>
                        <div class="form-group">
                          <img src="<?php echo base_url('public');?>/assets/img/ava.jpg" class="img-thumbnail avatar" alt="Responsive image" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="row">
                      <div class="form-group">
                        <h3>Identification with photo</h3>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <img src="<?php echo base_url('public');?>/assets/img/verification/ktp.jpg" class="img-thumbnail avatar"  alt="Responsive image">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end of .left-content -->
        </div>
      </div>
    </div>
  </div>


  <?php $this->load->view("template/footer");?>
  <script src="<?php echo base_url()?>public/assets/js/say-cheese.js"></script>