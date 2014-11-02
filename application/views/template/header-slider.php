<!DOCTYPE html>
<html lang="en-US" >
  <head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta content="width=device-width" name="viewport">
    <title>
    <?php if(!empty($pageTitle)):?>
      <?php echo $pageTitle;?>
    <?php else : ?>        
        <?php if($title!=""): echo $title;  ?>
        <?php elseif(getAuthUsername() != ""):?>
            <?php echo getAuthUsername()?>
        <?php else: ?>
            Welcome
        <?php endif; ?>               
    <?php endif; ?>
      | PM Jakarta 
    </title>
    
    <link rel="shortcut icon" href="<?php echo base_url("public")?>/assets/img/favico.ico">
    <link href="<?php echo base_url("public")?>/assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url("public")?>/assets/css/main.css" rel="stylesheet">
    <link href="<?php echo base_url("public")?>/assets/css/style.css" rel="stylesheet">

    <link href="<?php echo base_url("public")?>/assets/css/custom-chat.css" rel="stylesheet">
    <link href="<?php echo base_url("public")?>/assets/css/custom-online-list.css" rel="stylesheet">
    <link href="<?php echo base_url("public")?>/assets/css/custom-notify.css" rel="stylesheet">

    <!-- <link href="<?php echo base_url("public")?>/assets/css/extends.css" rel="stylesheet"> -->
    <link href="<?php echo base_url("public")?>/assets/css/plugins/mmenu/mmenu-all.css" rel="stylesheet">    
    <link href="<?php echo base_url("public")?>/assets/css/datepicker.css" rel="stylesheet">    
    <link href="<?php echo base_url("public")?>/assets/css/plugins/mmenu/mmenu-all.css" rel="stylesheet">        
    <link href="<?php echo base_url("public")?>/assets/css/plugins/selectize.bootstrap3.css" rel="stylesheet">        
    <link href="<?php echo base_url("public")?>/assets/css/select2.css" rel="stylesheet">
    
    <?php if(!empty($script)):?>
      <?php foreach($script as $s):?>
        <link href="<?php echo base_url("public")?>/assets/css/plugins/<?php echo $s?>.css" rel="stylesheet">    
      <?php endforeach; ?>
    <?php endif; ?>
    
    <script src="<?php echo base_url()?>public/assets/js/jquery.js"></script>
    
    <!--[if lt IE 9]>
      <script src="<?php echo base_url("public")?>/assets/js/html5shiv.js"></script>
      <script src="<?php echo base_url("public")?>/assets/js/respond.js"></script>
    <![endif]-->

  <script src="https://connect.facebook.net/en_US/all.js"></script>
  <script>
    FB.init(
            {
              appId: '<?php echo $this->facebook->getAppId();?>',
              status: true,
              cookie: true,
              xfbml: true,oauth : true
            }
    ); 
    function fbLogin() {
        FB.login(function(response) {

        FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {        
                    var acc = response.authResponse.accessToken;
                    window.location = "<?php echo base_url('auth/FBLogin');?>/?acc="+acc
                    // FB.api('/me', {fields: 'name,email,birthday,gender'}, function(response) {
                    //   showSignupForm(response);
                    // });

                }

                });   

        }, {scope:'email,publish_stream,read_friendlists,user_about_me,user_birthday'});
    }
  </script>

  </head>

  <body class="<?php echo @$bodyClass?>">
    <div id="pageloader">
      <img alt="" src="<?php echo base_url()?>public/assets/img/ajax-loader.gif">
    </div>
    <div class="hfeed" id="page">
      
      <!-- .site-header #masthead -->
        <header class="site-header <?php echo @$headerClass?> <?php if( isset($bodyClass) && $bodyClass == 'why-us' || $bodyClass == 'qa-transition') echo 'header-transparent'; ?>" id="masthead" role="banner">
        <div class="container">
          <div class="row">
            <div class="col-md-3 logo-wrap">
              <a class="logo logo-brand" href="<?php echo base_url()?>">
                <img alt="" src="<?php echo base_url("public")?>/assets/img/logo-pmj-old.png" style="height:48px;">
              </a>
            </div>
            <!-- end of .logo-wrap -->

            <div class="col-md-9 main-nav-wrap">
              <nav class="main-nav visible-lg visible-md">
                <ul class="nav navbar-right nav-front">
                  <li>
                    <a href="javascript:void(0);">SIGN UP</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);">HELP</a>
                  </li>
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
      <!-- end of #masthead.site-header -->
