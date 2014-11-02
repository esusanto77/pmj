 <header class="site-header <?php echo @$headerClass?> <?php if( isset($bodyClass) && $bodyClass == 'why-us' || $bodyClass == 'qa-transition') echo 'header-transparent'; ?>" id="masthead" role="banner">
        <div class="container">
          <div class="row">
           <div class="col-md-3 logo-wrap">
             <?php if($bodyClass != 'why-us'): ?>
              <a class="logo logo-brand" href="<?php echo base_url()?>">
                <img alt="" src="<?php echo base_url("public")?>/assets/img/logo-pmj-old.png" style="height:48px;">
              </a>
              <?php endif; ?>
            </div>
            <!-- end of .logo-wrap -->

            <div class="col-md-9 main-nav-wrap">
              <nav class="main-nav visible-lg visible-md">
                <ul class="nav navbar-right nav-front">
                  <?php if($bodyClass == 'why-us'): ?>
                   <li>
                    <a href="<?php echo base_url()?>">HOME</a>
                  </li>
                   <li>
                    <a href="<?php echo base_url()?>welcome/index">SIGN UP</a>
                  </li>
                  <?php endif; ?>
                 <!--  <li>
                    <a href="javascript:void(0);">HELP</a>
                  </li> -->
                </ul>
                <!-- end of ul -->

              </nav>
              <!-- end of .main-nav -->

            </div>
            <!-- end of end of .main-nav-wrap -->

          </div>
        </div>
        <!-- end of .container -->

      </header>