<?php $this->load->view("template/header");?>
  <script src="<?php echo base_url("public")?>/assets/js/jtransit.js"></script>
  <section class="section-qa-progress" data-stretch="<?php echo base_url("public")?>/assets/img/dummy/bg-full-2.jpg">
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2 qa-progress">
              <div class="qa-progress-heading">
                <h2 class="title">
                  <strong>You're</strong>
                  <span><?php echo floor($percent) ?>%</span>
                  Done
                </h2>
                <!--<h3 class="subtitle">And you're polishing off your question in style</h3>-->
              </div>
              <!-- end of .qa-progress-heading -->
              
              <div class="qa-progress-bar-wrapper">
                <div class="qa-progress-bar">
                  <span class="percentage"><?php echo floor($percent) ?>%</span>
                  <div style="width:<?php echo floor($percent) ?>%"></div>
                  <!-- <a class="view-match" href="#">View Your Matches</a> -->
                </div>
              </div>
              <!-- end of .qa-progress-bar-wrapper -->
              
              <div class="qa-progress-next-wrapper">
                <div class="qa-progress-next">
                  <span class="qa-progress-icon">
                    <i class="fa fa-user"></i>
                  </span>
                  
						    <a class="qa-progress-next-btn btn text-uppercase pull-right" href="<?php echo base_url()?>question?q=<?php echo $qacategory; ?>">Continue</a>

                  
                  <div class="qa-progress-next-text">
                    <p>Next Tells Us About Your</p>
                    <p>
                      <strong><?php echo $categoryLabel?></strong>
                    </p>
                  </div>
                </div>
                
                <a href="<?php echo base_url()?>question?q=<?php echo $qacategory-1; ?>">&laquo; Back</a>
              </div>
              <!-- end .of qa-progress-next-wrapper -->
              
            </div>
            <!-- end of .qa-progress -->
          </div>
        </div>
      </section>
      <?php $this->load->view("template/footer");?>