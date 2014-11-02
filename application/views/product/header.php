<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta content="width=device-width" name="viewport">
    <title>Selamat Datang <?php echo getAuthUsername() ?> | PM Jakarta</title>
     <link rel="shortcut icon" href="<?php echo base_url("public")?>/assets/img/favico.ico">
    <link href="<?php echo base_url("public")?>/assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url("public")?>/assets/css/main.css" rel="stylesheet">
    <link href="<?php echo base_url("public")?>/assets/css/payment.css" rel="stylesheet">
<!--     <link href="<?php echo base_url("public")?>/assets/css/custom-chat.css" rel="stylesheet">
    <link href="<?php echo base_url("public")?>/assets/css/custom-online-list.css" rel="stylesheet">
    <link href="<?php echo base_url("public")?>/assets/css/custom-notify.css" rel="stylesheet"> -->

    <link href="<?php echo base_url("public")?>/assets/css/plugins/mmenu/mmenu-all.css" rel="stylesheet">    
    <link href="<?php echo base_url("public")?>/assets/css/datepicker.css" rel="stylesheet">    
    <link href="<?php echo base_url("public")?>/assets/css/plugins/mmenu/mmenu-all.css" rel="stylesheet">        
    <link href="<?php echo base_url("public")?>/assets/css/plugins/selectize.bootstrap3.css" rel="stylesheet">        
    <link href="<?php echo base_url("public")?>/assets/css/select2.css" rel="stylesheet">
    <link href="<?php echo base_url("public")?>/assets/css/payment.css" rel="stylesheet">
    <script src="<?php echo base_url()?>public/assets/js/jquery.js"></script>
    <script src="<?php echo base_url("public")?>/assets/js/bootstrapValidator.min.js"></script>
    
    <!--[if lt IE 9]>
      <script src="<?php echo base_url("public")?>/assets/js/html5shiv.js"></script>
      <script src="<?php echo base_url("public")?>/assets/js/respond.js"></script>
    <![endif]-->
  </head>
  <body >
    
    <div class="hfeed" id="page">
      <!-- .site-header #masthead -->
      <?php if($this->session->userdata('login_mobile')!="true"): ?>
      <header class="site-header" id="masthead" role="banner">
        <div class="container">
          <div class="row">
            
            <div class="col-md-3 logo-wrap">
              <a class="logo logo-brand"  href="<?php echo base_url(); ?>">
                <img alt="" src="<?php echo base_url("public")?>/assets/img/payment/logo-pmj.png" style="padding: 14px 0;">
              </a>
            </div>
           
            
            <!-- end of .logo-wrap -->
            <div class="col-md-9 main-nav-wrap">
              <nav class="main-nav visible-lg visible-md">
                
                
                <!-- end of ul -->
              </nav>
              
              <!-- end of .main-nav -->
            </div>
            
            <!-- end of end of .main-nav-wrap -->
          </div>
        </div>
        
        <!-- end of .container -->
      </header>
       <?php endif; ?>

    