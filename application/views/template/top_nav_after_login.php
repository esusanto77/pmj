      <header class="site-header <?php if( isset($bodyClass) && $bodyClass == 'why-us') echo 'header-transparent'; ?>" id="masthead" role="banner">
        <div class="container">
          <div class="row">
            <button class="user-menu-button visible-xs visible-sm">
              <span></span>
              <span></span>
              <span></span>
            </button>
            
            <!-- end of .user-menu -->
            <button class="user-right-button visible-xs visible-sm">
              <span></span>
              <span></span>
              <span></span>
            </button>
            <div class="col-md-2 logo-wrap">
              <a class="logo logo-brand" href="<?php echo base_url()?>" style="padding: 11px 0">
                  <img alt="" src="<?php echo base_url("public")?>/assets/img/logo-pmj.png">
              </a>
            </div>
            <div class="col-md-2 logo-wrap hidden-sm hidden-xs ">
              <a class="logo logo-brand" href="https://play.google.com/store/apps/details?id=com.dycode.pmjakarta" target='_blank' style="padding: 8px 0">
                  <img alt="Get it on Google Play" src="https://developer.android.com/images/brand/en_generic_rgb_wo_45.png" />
              </a>
            </div>
            <!-- end of .logo-wrap -->
            <div class="col-md-8 main-nav-wrap">
              <nav class="main-nav visible-lg visible-md" style="margin: 6px 0;">
                <ul class="nav navbar-right">
                  <li>
                    <a href="<?php echo base_url()?>" class='pjax_' data-pjax='#right-content'>
                      <!-- <i class="fa fa-home"></i> -->
                      <img src="<?php echo base_url()?>public/assets/img/iconHome.png">
                    </a>
                  </li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                      <!-- <i class="fa fa-comment"></i> -->
                      <img src="<?php echo base_url()?>public/assets/img/IconChat.png">
                      <span class="notify-chat">
                        <!-- <span class="badge">2</span> -->
                      </span>
                    </a>
                    <ul class="dropdown-menu arrow_top notification-messages-wrap">
                      <li class="header">
                        <h3 class="header-notify">New Chat ( <span class="number chat-num">0</span> )</h3>
                      </li>
                      <li class="list-chat-wrap">
                        <ul class="list-chat-notify">

                          <div class="loadingTopBoxChat">
                            <span>Please wait ...</span>
                            <img src="<?php echo base_url("public")?>/assets/img/ajax-loader.gif">
                          </div>

                        </ul>
                      </li>
                      <li class="footer">
                        <a class="see-all" href="<?php echo base_url()?>recent_chat">See All</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                      <!-- <i class="fa fa-envelope"></i> -->
                      <img src="<?php echo base_url()?>public/assets/img/IconMsg.png">
                      <span class="notify-message">
                        <!-- <span class="badge">21</span> -->
                      </span>
                    </a>
                    <ul class="dropdown-menu arrow_top notification-messages-wrap">
                      <li class="header">
                        <h3 class="header-notify">New Messages ( <span class="number message-num">0</span> )</h3>
                      </li>
                      <li class="list-messages-wrap">
                        <ul class="list-messages">

                        <div class="loadingTopBox">
                          <span>Please wait ...</span>
                          <img src="<?php echo base_url("public")?>/assets/img/ajax-loader.gif">
                        </div>

                        </ul>
                      </li>
                      <li class="footer">
                        <a class="see-all" href="<?php echo base_url()?>message">See All</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                      <!-- <i class="fa fa-exclamation-circle"></i> -->
                      <img src="<?php echo base_url()?>public/assets/img/IconNotification.png">
                      <span class="notify-activity">
                        <!-- <span class="badge">21</span> -->
                      </span>
                    </a>
                    <ul class="dropdown-menu arrow_top notification-messages-wrap">
                      <li class="header">
                        <h3 class="header-notify">New Notifications ( <span class="number notify-num">0</span> )</h3>
                      </li>
                      <li class="list-notify-wrap">
                        <ul class="list-notify">
                          <div class="loadingTopBoxActivity">
                            <span>Please wait ...</span>
                            <img src="<?php echo base_url("public")?>/assets/img/ajax-loader.gif">
                          </div>

                        </ul>
                      </li>
                      <li class="footer">
                        <a class="see-all" href="<?php echo base_url()?>activity">See All</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown profile">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                      <?php echo getAuthUsername() ?>
                      <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu arrow_top text-right">
                      <li>
                        <a href="<?php echo base_url()?>profile/edit">Edit Profile</a>
                      </li>
                      <li class="divider"></li>

                      <li style="color: #989999; font-size: 12px; padding-right:10px;">
                        <b>QA Complete &nbsp;&nbsp;<span id="compProf" style="color:#fd6ea4">0%</span></b>
                      </li>
                      
                      <li class="divider"></li>
                      <li>
                        <a href="<?php echo base_url()?>question?q=1">Starting Question</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url()?>question?q=2">Personal Assestment</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url()?>question?q=3">Interests</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url()?>question?q=4">Match Request</a>
                      </li>
                      <li class="divider"></li>
                      <!-- <li>
                        <a href="<?php echo base_url()?>profile">Setting Account</a>
                      </li>
                      <li>
                        <a href="javascript:void(0);">Invite Friends</a>
                      </li>
                      <li class="divider"></li> -->
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

<script id="notify-chat-box-tpl" type="x-tmpl-mustache">
  <li class="list item clearfix {{ status }}" id="chat-from-{{ partnerId }}" data-date="{{ timestamp }}" data-id="{{ partnerId }}" data-display-name="{{ partnerId }}">
    <a href="javascript:void(0);">
      <div class="user-image pull-left">
        <img alt="" class="avatar" onerror="this.src='http://placehold.it/45x45&text=no+image';" src="{{ filename_thumb }}">
      </div>
      <div class="user-activity">
        <p class="name"><b> {{ partnerId }} </b></p>
        <p class="message"> {{ message }} </p>
        <span class="time"> {{ ts }} </span>
      </div>
    </a>
  </li>
</script>

<script id="notify-message-box-tpl" type="x-tmpl-mustache">
  <li class="item clearfix {{ read }}" id="message-{{ actor.displayName }}" data-id-msg="{{ _id }}" data-url="{{ object.url }}">
    <a class="mesage-list-item" href="javascript:void(0);">
      <div class="user-image pull-left">
        <img alt="" class="avatar-message-notify" onerror="this.src='http://placehold.it/45x45&text=no+image';" src="{{ actor.image.url }}">
      </div>
      <span class="time" style="float: right; font-size: 10px; font-weight: bold;">{{ published }}</span>
      <div class="user-activity">
        <p class="name"><b>{{ actor.displayName }} </b></p>
        <p class="message" style="font-size: 12px; margin-bottom: 5px; font-weight: bold;">{{ object.subject }}</p>
        <p class="message" style="font-size: 11px">{{ object.content }}</pre></p>
      </div>
    </a>
  </li>
</script>

<script id="notify-box-tpl" type="x-tmpl-mustache">
  <li class="item clearfix {{ read }}" id="notify-{{ _id }}">
    <a href="javascript:void(0);">
      <div class="user-image pull-left" style="width: 45px; height: 45px;">
        <a class="show-user" data-user-id="{{ actor.id }}" href="./profile/{{ actor.id }}"> 
          <img alt="" class="avatar" onerror="this.src='http://placehold.it/45x45&text=no+image';" src="{{ actor.image.url }}">
        </a>
      </div>
      <div class="user-activity">
        <p class="name">
          <a class="show-user" data-user-id="{{ actor.id }}" href="./profile/{{ actor.id }}"><b>{{ actor.displayName }}</b></a>
          <span style="color:#6D6D6D;">
            {{ verb }} 
          </span>
          <a class="show-user" data-user-id="{{ object.id }}" href="./profile/{{ object.id }}"><b>You</b></a>
        </p>
        <span class="time">{{ published }}</span>
      </div>
    </a>
  </li>
</script>

<!-- mobile version -->
<script id="notify-box-mobile-tpl" type="x-tmpl-mustache">
  <div class="item-notify-mobile {{ read }}" id="notify-mobile-{{ _id }}">
    <a href="javascript:void(0);">
      <div class="user-image pull-left" style="width: 35px; height: 35px;">
        <a class="show-user" data-user-id="{{ actor.id }}"> 
          <img alt="" class="avatar" onerror="this.src='http://placehold.it/45x45&text=no+image';" src="{{ actor.image.url }}">
        </a>
      </div>
      <div class="user-activity-mobile">
        <span class="name-mobile">
          <a class="show-user" data-user-id="{{ actor.id }}"><b>{{ actor.displayName }}</b></a>
          <span style="color:#6D6D6D;">
            {{ verb }} 
          </span>
          <a class="show-user" data-user-id="{{ object.id }}"><b>You</b></a>
        </span>
        <br/>
        <span class="time-mobile">{{ published }}</span>
      </div>
    </a>
  </div>
</script>

<script id="notify-message-box-mobile-tpl" type="x-tmpl-mustache">
  <div class="item-mesage-mobile {{ read }}" data-from="{{ displayName }}" data-id="{{ idNotif }}" data-url="{{ url }}">
      <div class="user-image pull-left" style="width: 35px; height: 35px;">
        <img alt="" class="avatar" onerror="this.src='http://placehold.it/45x45&text=no+image';" src="{{ avatar }}">
      </div>
      <div class="user-activity-mobile">
        <span class="name-mobile"><b style="color:#1ecbb8">{{ displayName }}</b></span><br/>
        <span class="message-mobile">{{ subject }}</span><br/>
        <span class="time-mobile">{{ published }}</span>
      </div>
  </div>
</script>

<script id="notify-chat-box-mobile-tpl" type="x-tmpl-mustache">
  <div class="item-chat-mobile {{ status }}" id="chat-from-mob-{{ partnerId }}" data-id="{{ partnerId }}">
      <div class="user-image pull-left" style="width: 35px; height: 35px;">
        <img alt="" class="avatar" onerror="this.src='http://placehold.it/45x45&text=no+image';" src="{{ filename_thumb }}">
      </div>
      <div class="user-activity-mobile">
        <span class="name-mobile"><b style="color:#1ecbb8">{{ partnerId }}</b></span><br/>
        <span class="message-mobile">{{ message }}</span><br/>
        <span class="time-mobile">{{ ts }}</span>
      </div>
  </div>
</script>