<?php $this->load->view("template/header");?>
  <script src="<?php echo base_url("public")?>/assets/js/bootstrapValidator.min.js"></script>
  <script src="<?php echo base_url("public")?>/assets/js/jtransit.js"></script>
  <style>
  .block-contact-form input[type="email"]{
    background:none;
  }
  </style>
  <section class="section-main" data-stretch="<?php echo base_url()?>public/assets/img/dummy/bg-full-1.jpg">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="logo-welcome text-center">
                <img alt="Welcome PM Jakarta" src="<?php echo base_url()?>public/assets/img/logo-home.png">
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- end of .section-main -->
      <section class="section-block section-why-choose">
        <div class="section-block-header">
          <h2 class="section-block-title">
            <span id="why_us"><?php echo @$whyChooseTitle?></span>
            <i class="fa fa-user"></i>
          </h2>
         <!--  <p class="section-block-tagline">
            <?php echo @$whyChooseTagline?>
          </p> -->
        </div>
        <!-- end of .section-block-header -->
        
        <div class="section-block-content">
          <div class="container">
            <div class="row">
              <div class="col-md-6 block-column">
                <div class="block-column-icon">
                  <span>
                    <i class="fa fa-lock"></i>
                  </span>
                </div>
                <div class="block-content">
                  <h4 class="block-column-title">Confidentially</h4>
                  <p><?php echo @$whyChooseConfidentally?></p>
                </div>
              </div>
              
              <div class="col-md-6 block-column">
                <div class="block-column-icon">
                  <span>
                    <i class="fa fa-heart"></i>
                  </span>
                </div>
                <div class="block-content">
                  <h4 class="block-column-title">Compatibility</h4>
                  <p><?php echo @$whyChooseCompatibility?></p>
                </div>
              </div>
              
              <div class="col-md-6 block-column">
                <div class="block-column-icon">
                  <span>
                    <i class="fa fa-users"></i>
                  </span>
                </div>
                <div class="block-content">
                  <h4 class="block-column-title">Connectivity</h4>
                  <p><?php echo @$whyChooseConnectivity?></p>
                </div>
              </div>
              
              <div class="col-md-6 block-column">
                <div class="block-column-icon">
                  <span>
                    <i class="fa fa-clock-o"></i>
                  </span>
                </div>
                <div class="block-content">
                  <h4 class="block-column-title">Efficiency</h4>
                  <p><?php echo @$whyChooseEfficiency?></p>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <!-- end of .section-block-content -->
      </section>
      <!-- end of .section-why-choose -->
      <section class="section-block-alt section-about-us">
        <div class="section-block-header">
          <h2 class="section-block-title">
            <span id="about_us"><?php echo @$aboutUsTitle?></span>
          </h2>
        </div>
        <!-- end of .section-block-header -->
        
        <div class="section-block-content section-full-bg" data-stretch="<?php echo base_url("public")?>/assets/img/dummy/bg-full-1.jpg">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <?php echo @$aboutUsContentLeft?>
              </div>
              <div class="col-md-6">
                <?php echo @$aboutUsContentRight?>
              </div>
            </div>
          </div>
        </div>
        <!-- end of .section-block-content -->
      </section>
      <!-- end of .section-about-us -->
      <section class="section-block section-safety-first">
        <div class="section-block-header">
          <h2 class="section-block-title">
            <span id="safety_first"><?php echo @$safetyFirstTitle?></span>
            <i class="fa fa-lock"></i>
          </h2>
        </div>
        <!-- end of .section-block-header -->
        
        <div class="section-block-content">
          <div class="container">
            <div class="scroller-block">
              <div class="scroller-content">
                <?php echo @$safetyFirstContent?>
              </div>
            </div>
          </div>
        </div>
        <!-- end of .section-block-content -->
      </section>
      <!-- end of .section-why-choose -->
      <section class="section-block section-gray section-terms-of-use">
        <div class="section-block-header">
          <h2 class="section-block-title">
            <span id="term_condition"><?php echo @$TOSTitle?></span>
            <i class="fa fa-lock"></i>
          </h2>
        </div>
        <!-- end of .section-block-header -->
        
        <div class="section-block-content">
          <div class="container">
            <div class="scroller-block">
              <div class="scroller-content">
                <?php echo @$TOSContent?>
              </div>
            </div>
          </div>
        </div>
        <!-- end of .section-block-content -->
      </section>
      <!-- end of .section-why-choose -->
      <section class="section-block-alt section-contact-us">
        <div class="section-block-header pink">
          <h2 class="section-block-title">
            <span id="contact_us"><?php echo @$ContactTitle?></span>
          </h2>
        </div>
        <!-- end of .section-block-header -->
        
        <div class="section-block-content section-full-bg" data-stretch="<?php echo base_url("public")?>/assets/img/dummy/bg-full-2.jpg">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <h4>Contact</h4>
                <ul class="contact-list">
                  <li>
                    <i class="fa fa-map-marker"></i>
                    <span><?php echo @$ContactAddress?></span>
                  </li>
                  <li>
                    <i class="fa fa-phone"></i>
                    <span><?php echo @$ContactPhone?></span>
                  </li>
                  <li>
                    <i class="fa fa-envelope"></i>
                    <span>
                      <a href="mailto:<?php echo @$ContactEmail?>"><?php echo @$ContactEmail?></a>
                    </span>
                  </li>
                  <li>
                    <i class="fa fa-globe"></i>
                    <span>
                      <a href="http://<?php echo @$ContactWebsite?>"><?php echo @$ContactWebsite?></a>
                    </span>
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                <form class="block-contact-form" id="messageForm"  method="post">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <input class="form-control" placeholder="Name" id="name" name="name" type="text">
                    </div>
                    <div class="col-md-6 form-group">
                      <input class="form-control" placeholder="Email" id="email" name="email" type="email">
                    </div>
                    <div class="col-md-12 form-group">
                      <textarea class="form-control" placeholder="Message" id="message" name="message" rows="5"></textarea>
                    </div>
                  </div>
                   <span class="pull-left" id="messageSuccess"></span>
                  <input class="pull-right btn" type="submit" value="Send">
                  <span id="loading" class="pull-right" style="display:none;margin-right:10px;margin-top:3px;">
                    <img src="<?php echo base_url("public")."/assets/img/ajax-loader.gif"; ?>">
                  </span>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end of .section-block-content -->
      </section>

      <script>
      jQuery.noConflict()(function ($) {
        $(document).ready(function() { 
          $('#messageForm').bootstrapValidator({
            submitHandler: function(validator, form, submitButton) {
              var formData = {name:$("#name").val(),email:$("#email").val(),message:$("#message").val()};
              var info;
              $('#loading').css('display','block');
              
              $.ajax({
                  type: "POST", 
                  url: "<?php echo base_url("pages")."/sendEmailWhyUs"?>",
                  data: formData,
                  success: function(data){
                   info = data;
                  }
                }).done(function(){
                   $('#loading').css('display','none');

                    if(info=="success"){
                      $('#messageSuccess').append("Your message has been sent");
                    }else{
                      $('#messageSuccess').append("Your message failed to sent");
                    }

                });
            },
            fields: {
              name: {
                validators: {
                  notEmpty: {
                    message: 'Name is required and cannot be empty'
                  }
                }
              },
              email: {
                validators: {
                  notEmpty: {
                    message: 'Email is required and cannot be empty'
                  }
                }
              },
              message: {
                validators: {
                  notEmpty: {
                    message: 'Message is required and cannot be empty'
                  }
                }
              }
            }
          });

        });
      });
      </script>
<?php $this->load->view("template/footer");?>