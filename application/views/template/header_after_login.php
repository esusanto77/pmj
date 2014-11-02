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
    
    <script src="<?php echo base_url()?>public/assets/js/jquery.js"></script>
    
    <!--[if lt IE 9]>
      <script src="<?php echo base_url("public")?>/assets/js/html5shiv.js"></script>
      <script src="<?php echo base_url("public")?>/assets/js/respond.js"></script>
    <![endif]-->
  </head>
  <body class="dashboard">
    <div id="pageloader">
      <img alt="" src="<?php echo base_url("public")?>/assets/img/ajax-loader.gif">
    </div>
    <div class="hfeed" id="page">
      
      <!-- .site-header #masthead -->
      <header class="site-header <?php if( isset($bodyClass) && $bodyClass == 'why-us') echo 'header-transparent'; ?>" id="masthead" role="banner">
        <div class="container">
          <div class="row">
            <div class="col-md-3 logo-wrap">
              <a class="logo logo-brand" href="/">
                <img alt="" src="<?php echo base_url("public")?>/assets/img/logo-pmj.png">
              </a>
            </div>
            
            <!-- end of .logo-wrap -->
            <div class="col-md-9 main-nav-wrap">
              <nav class="main-nav visible-lg visible-md">
                <ul class="nav navbar-right">
                  <li>
                    <a href="#">
                      <i class="fa fa-home"></i>
                    </a>
                  </li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="fa fa-comment"></i>
                      <span class="badge">2</span>
                    </a>
                    <ul class="dropdown-menu arrow_top notification-messages-wrap">
                      <li class="header">
                        <h3>Chat (<span class="number">2</span>)</h3>
                      </li>
                      <li class="list-messages-wrap">
                        <ul class="list-messages">
                          <li class="item clearfix unread">
                            <a href="#">
                              <div class="user-image pull-left">
                                <img alt="" class="avatar" src="<?php echo base_url("public")?>/assets/img/dummy/user.jpg">
                              </div>
                              <div class="user-activity">
                                <p class="name">James Patterson (2)</p>
                                <p class="message">Hi.. Are you busy?</p>
                                <span class="time">3:15pm</span>
                              </div>
                            </a>
                          </li>
                          <li class="item clearfix read">
                            <a href="#">
                              <div class="user-image pull-left">
                                <img alt="" class="avatar" src="<?php echo base_url("public")?>/assets/img/dummy/user.jpg">
                              </div>
                              <div class="user-activity">
                                <p class="name">James Patterson (2)</p>
                                <p class="message">Hi.. Are you busy?</p>
                                <span class="time">3:15pm</span>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="footer">
                        <a class="see-all" href="#">See All</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="fa fa-envelope"></i>
                      <span class="badge">21</span>
                    </a>
                    <ul class="dropdown-menu arrow_top notification-messages-wrap">
                      <li class="header">
                        <h3>Messages (<span class="number">21</span>)</h3>
                      </li>
                      <li class="list-messages-wrap">
                        <ul class="list-messages">
                          <li class="item clearfix unread">
                            <a href="#">
                              <div class="user-image pull-left">
                                <img alt="" class="avatar" src="<?php echo base_url("public")?>/assets/img/dummy/user.jpg">
                              </div>
                              <div class="user-activity">
                                <p class="name">James Patterson (2)</p>
                                <p class="message">Hi.. Are you busy?</p>
                                <span class="time">3:15pm</span>
                              </div>
                            </a>
                          </li>
                          <li class="item clearfix read">
                            <a href="#">
                              <div class="user-image pull-left">
                                <img alt="" class="avatar" src="<?php echo base_url("public")?>/assets/img/dummy/user.jpg">
                              </div>
                              <div class="user-activity">
                                <p class="name">James Patterson (2)</p>
                                <p class="message">Hi.. Are you busy?</p>
                                <span class="time">3:15pm</span>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="footer">
                        <a class="see-all" href="#">See All</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="fa fa-exclamation-circle"></i>
                      <span class="badge">12</span>
                    </a>
                    <ul class="dropdown-menu arrow_top notification-messages-wrap">
                      <li class="header">
                        <h3>Notifications (<span class="number">12</span>)</h3>
                      </li>
                      <li class="list-messages-wrap">
                        <ul class="list-messages">
                          <li class="item clearfix unread">
                            <a href="#">
                              <div class="user-image pull-left">
                                <img alt="" class="avatar" src="<?php echo base_url("public")?>/assets/img/dummy/user.jpg">
                              </div>
                              <div class="user-activity">
                                <p class="name">James Patterson (2)</p>
                                <p class="message">Hi.. Are you busy?</p>
                                <span class="time">3:15pm</span>
                              </div>
                            </a>
                          </li>
                          <li class="item clearfix read">
                            <a href="#">
                              <div class="user-image pull-left">
                                <img alt="" class="avatar" src="<?php echo base_url("public")?>/assets/img/dummy/user.jpg">
                              </div>
                              <div class="user-activity">
                                <p class="name">James Patterson (2)</p>
                                <p class="message">Hi.. Are you busy?</p>
                                <span class="time">3:15pm</span>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="footer">
                        <a class="see-all" href="#">See All</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown profile">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <?php echo getAuthUsername() ?>
                      <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu arrow_top text-right">
                      <li>
                        <a href="#">Edit Profile</a>
                      </li>
                      <li>
                        <a href="#">Setting Account</a>
                      </li>
                      <li>
                        <a href="#">Invite Friends</a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a href="<?php echo base_url('auth/logout')?>">Log out</a>
                      </li>
                    </ul>
                    
                    <!-- end of .dropdown-menu -->
                  </li>
                  
                  <!-- end of .dropdown -->
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