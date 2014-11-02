      <div aria-hidden="true" class="popuser modal fade" id="popuser" role="dialog" tabindex="-1">
        <div class="popuser-dialog modal-dialog">
          <div class="popuser-content modal-content">
            <div class="popuser-body">
            
              <div class="popuser-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
                <div class="popup-bg">
                  <img alt="" class="avatar-bg" src="<?php echo base_url()?>/public/assets/img/dummy/bg-user-popup.jpg">
                </div>
                <div class="popuser-name-wrap">
                  <div class="popuser-avatar pull-left">
                    <img alt="" class="avatar" src="<?php echo base_url()?>/public/assets/img/dummy/user.jpg">
                  </div>
                  <div class="popuser-name white">
                    <h3 class="name"></h3>
                    <span class="age bio-age">28 years</span>
                    <span class="city">Jakarta</span>
                  </div>
                </div>
                
                <!-- end of .popuser-name -->
                <div class="popuser-action clearfix">
                  <ul class="user-action pull-left">
                    <li>
                      <a class="action-email" href="javascript:void(0);">
                        <i class="fa fa-envelope"></i>
                      </a>
                    </li>
                    <li>
                      <a class="action-message" href="javascript:void(0);">
                        <i class="fa fa-comment"></i>
                      </a>
                    </li>
                    <li>
                      <a class="action-favorite" href="javascript:void(0);">
                        <i class="fa fa-heart"></i>
                      </a>
                    </li>
                  </ul>
                  
                  <!-- end of .user-action -->
                  <a class="view-full-profile pull-right" href="#">View Full Profile</a>
                </div>
              </div>              
              <!-- end of .popuser-header -->

              <div class="popuser-profile-wrap clearfix">
                <dl class="dl-horizontal popuser-profile pull-right">                
                  <dt>Sex</dt>
                  <dd class='bio-sex'></dd>
                  <dt>Religion</dt>
                  <dd class='bio-religion'></dd>
                  <dt>Ethnicity</dt>
                  <dd class='bio-ethnicity'></dd>
                  <dt>Occupation</dt>
                  <dd class='bio-occupation'></dd>
                  <dt>Relationship Status</dt>
                  <dd class='bio-relation'></dd>
                  <dt>Kids</dt>
                  <dd class='bio-kids'></dd>
                </dl>
                
                <!-- end of .dl-horizontal.popuser-profile -->
              </div>
              
              <!-- end of .popuser-profile-wrap -->
              
            </div>
          </div>
        </div>
      </div>

      

      <!-- popup user profile -->
      <?php if($this->session->userdata("uid") > 0 && $this->uri->segment(1) != "question"):?>

      <!-- compose messages -->
      <form id="form-popup-compose" role="form" method="post">
        <div class="modal fade" id="myModalComposeMessages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Send Messages</h4>
              </div>
              <div class="modal-body modal-forgotPassword">
                <div id="errorMessage"></div>  
                <div class="form-group">
                  <label for="input-name">To</label><br>
                  <input type="text" id="msg-to"  style="width:300px">
                </div>
                <div class="form-group">
                  <label for="input-name">Subject</label><br>
                  <input type="text" id="msg-subject" placeholder='write email subject' style="width:300px">                
                </div>
                <div class="form-group">
                  <label for="input-name">Messages</label><br>
                  <textarea id="msg-content" cols="70" rows="5" placeholder="messages content"></textarea>              
                </div>
              </div>
              <div class="modal-footer">
                <div class="compose-popup-loading"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-signup msg-submitCompose" value="Submit">
                <div id="flash"></div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <!-- end of compose messages -->

      <?php if($this->session->userdata('login_mobile')!="true"): ?>
     <!--  <div class="chat-section">
        <div class="container">
          <div class="chat-list minimized chat-module">
            <div class="chat-module-header">
              <span class="chat-module-title">Chat List</span>
            </div>
            <div class="chat-module-content" id="chat-history">
              <ul>
                  
              </ul>
              <div class="loadingBox">
                <span>Please wait ...</span>
                <img src="<?php echo base_url("public")?>/assets/img/ajax-loader.gif">
              </div>
            </div>
          </div> -->
          <!-- end of .chat-list -->
          
          <!-- <div class="chatbox-list"></div> -->
          <!-- end of .chatbox-list -->
          
       <!--  </div>
      </div> -->
      <!-- end of .chat-section -->
    <?php endif; ?>

      
      <script id="chatbox-tpl" type="x-tmpl-mustache">
        <div class="chat-box chat-module" data-id="{{ id }}" id="chatbox_{{id}}">
          <div class="chat-module-inner">
            <div class="chat-module-header">
              <span class="chat-module-title">
                <a class="user-image show-user" data-user-id="{{ id }}" href="/profile/{{ id }}">
                  {{ display_name }}
                </a>
              </span>
              <span class="close">&times;</span>
            </div>
            <div class="chat-module-content">
              <ul></ul>
            </div>
            <div class="chat-module-footer">
              <textarea class="chatbox-textarea"></textarea>
            </div>
          </div>
        </div>
      </script>
      
      <!--<script id="chat-list-item" type="x-tmpl-mustache">
        <li class="user-list-item" data-id="{{ code_id }}">
          <img src="{{ filename_thumb }}">
          <div class="item-data">
            <div class="user-display-name">{{ code_id }}</div>
            <span class="user-status {{ status }}"></span>
          </div>
        </li> 
      </script>-->

      <script id="chat-list-item" type="x-tmpl-mustache">
        <li class="user-list-item" data-id="{{ code_id }}"> 
          <img class="avatar-chat-list" onerror="this.src='http://placehold.it/40x40&text=no+image';" src="{{ filename_thumb }}" >
          <div class="item-data">
            <div class="user-display-name"> {{ code_id }} </div>
            <span id="status-{{ code_id }}" class="user-status {{ status }}">{{ status }}</span>
            <div class="time-last-chat">notes<br/>
              <span id="time-chat-{{ code_id }}">{{ ts }}</span>
            </div>
          </div>
        </li>
      </script>
      
      <script id="chatbox-message" type="x-tmpl-mustache">
        <li id="message-item" class="{{ classname }}">
          <img src="{{ filename_thumb }}">
          <div class="message-content">
            <div class="message">{{ message }}</div>
            <div class="times"><span>{{ status }}</span> {{ ts }}</div>
          </div>
        </li>
      </script>

    <?php endif; ?>


      <footer class="site-footer cl" id="colophon" role="contentinfo">
                <div class="col-sm-6 left-menu-footer">
          <nav class="nav-menu-footer-left">
            <ul class="nav navbar-left">
              <li>
                <a href="<?php echo base_url("pages")?>/why_us#why_us">Why us</a>
              </li>
              <li>
                <a href="<?php echo base_url("pages")?>/why_us#about_us">About us</a>
              </li>
              <li>
                <a href="<?php echo base_url("pages")?>/why_us#contact_us">Contact</a>
              </li>
              <li>
                <a href="<?php echo base_url("pages")?>/why_us#safety_first">Privacy policy</a>
              </li>
              <li>
                <a href="<?php echo base_url("pages")?>/why_us#term_condition">Term & Condition</a>
              </li>
            </ul>
          </nav>
          
          <!-- end of .nav-menu-footer-left -->
        </div>
        <!-- end of .col-sm-8.left-menu-footer -->
        <div class="col-sm-6 right-menu-footer">
          <p class="text-right">
            Copyright &copy; 2014
            <a href="javascript:void(0);">PMJakarta</a>
            by
            <a href="javascript:void(0);">SBS Incubator.</a>
            All rights reserved.
          </p>
        </div>
        
        <!-- end of .col-sm-4.right-menu-footer -->
      </footer>

    <!--<script src="<?php echo base_url()?>public/assets/js/plugins.js"></script>-->
    <script src="<?php echo base_url()?>public/assets/js/firebase.js"></script> 
    <script src="http://assets.freshdesk.com/widget/freshwidget.js"></script>  
    <!--<script src="//cdn.firebase.com/v0/firebase.js"></script>-->


    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js"></script> 
    <script src="<?php echo base_url()?>public/assets/js/vendors/jquery.pjax.js"></script>    
    <script src="<?php echo base_url()?>public/assets/js/selectize.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/select2.js"></script>

    <script>

      var firebase_root = {
        userchat    : '<?php echo $this->config->item("user_chat") ?>',
        notify      : '<?php echo $this->config->item("notifications") ?>',
        mosaic_url  : '<?php echo $this->config->item("mosaic_url") ?>'
      };

      var current_user = {
        user_id       :'<?php echo $this->session->userdata("uid")?>',
        user_code_id  :'<?php echo getSessionCodeId()?>',
        user_name     :'<?php echo getAuthUsername()?>',
        user_gender   :'<?php echo getSessionGender()?>',
        display_name  :'<?php echo getAuthUsername()?>',
        thumb         :'<?php echo getAvatarPhoto($this->session->userdata("uid"))?>'
      };

      var root = {
        base_url: '<?php echo base_url()?>'
      };

      FreshWidget.init("", {
        "queryString": "&widgetType=popup&helpdesk_ticket[requester]=<?php echo getSessionEmail()?>", 
        "widgetType": "popup", 
        "buttonType": "text", 
        "buttonText": "Support", 
        "buttonColor": "black", 
        "buttonBg": "#59a2b3", 
        "alignment": "2", "offset": 
        "-1500px", "formHeight": "500px", 
        "url": "http://pmj.freshdesk.com"
      });
      
    </script>

    <script src="<?php echo base_url()?>public/assets/js/main.js"></script>
  
    <script>
      <?php if(!empty($qacategory)):?>
        var qacategory = <?php echo $qacategory ?>
      <?php else: ?>
        var qacategory = 1;
      <?php endif; ?>

      // getCount all question
      var question = {'total': 50}
    </script>


    <!-- inline javascript for chat app -->
    <?php if($this->session->userdata("uid") > 0):?>

    <!--<script src="<?php echo base_url()?>public/assets/js/chat_dev.js"></script>-->
    <script src="<?php echo base_url()?>public/assets/js/notify.js"></script>

    <?php endif;?>
    <?php $this->load->view("template/ga");?>
    </body>
</html>