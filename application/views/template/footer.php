<div aria-hidden="true" class="popuser modal fade" id="popuser" role="dialog" tabindex="-1">
  <div class="popuser-dialog modal-dialog">
    <div class="popuser-content modal-content">
      <div class="popuser-body">
      
        <div class="popuser-header">
          <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
          <div class="popup-bg">
            <img alt="" class="avatar-bg" src="<?php echo base_url()?>public/assets/img/dummy/bg-user-popup.jpg">
          </div>
          <div class="popuser-name-wrap">
            <div class="popuser-avatar pull-left">
              <img alt="" class="avatar" src="<?php echo base_url()?>public/assets/img/dummy/user.jpg">
            </div>
            <div class="popuser-name white">
              <div class="display-info">
                <h3 class="name"></h3>
                <span class="age bio-age">28 years</span>
                <span class="city">Jakarta</span>
              </div>
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
              <li class="btn-chat">
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
            <a class="view-full-profile pull-right" href="javascript:void(0);">View Full Profile</a>
            <div class="loadingViewProfile" hidden="true">
              <img src="<?php echo base_url("public")?>/assets/img/ajax-loader.gif">
            </div>
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


<div aria-hidden="true" class="warning modal fade" id="warning" role="dialog" tabindex="-1">
  <div class="warning modal-dialog"> 
    <div class="alert alert-info" style="background-color: #def7f3;">
      <button type="button" class="close" data-dismiss="modal" style="margin-top: -15px; margin-right: -10px">
        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
      </button>
      Sorry, you must upgrade subscription to using this features
      <br/>
      <br/>
      <a href="<?php echo base_url()?>product"><input type="button" value="Upgrade Now"></a>
    </div> 
  </div>
</div>

<!-- image -->
<div aria-hidden="true" class="media-image modal fade" id="media-image" role="dialog" tabindex="-1">
  <div class="media-image modal-dialog"> 
      <div class="panel panel-default" style="overflow: auto; height: 400px">
        <div class="panel-heading">
          <h5>Your Recent Sent Image</h5>
        </div>
        <div class="panel-body">
          <div class="row-image-chat">
            <div class="row" id="content-chat-image" style="margin-bottom: 50px;"></div>
          </div>
        </div>
        <div class="panel-footer footer-image-chat">

        </div>
      </div>
  </div>
</div>
<!-- end image -->

<!-- video-->
<div aria-hidden="true" class="media-video modal fade" id="media-video" role="dialog" tabindex="-1">
  <div class="media-video modal-dialog"> 
      <div class="panel panel-default" style="overflow: auto; height: 400px">
        <div class="panel-heading">
          <h5>Your Recent Sent Video</h5>
        </div>
        <div class="panel-body">
          <div class="row-image-chat">
            <div class="row" id="content-chat-video" style="margin-bottom: 50px;"></div>
          </div>
        </div>
        <div class="panel-footer footer-image-chat">
            <!-- <input type="hidden" id="select-chat-video" style="font-size:8px">
            <input type="button" class="send-chat-video" id="send-chat-video" value="SEND VIDEO">
            <input type="button" class="cancel-chat-video" value="CANCEL"> -->
        </div>
      </div>
  </div>
</div>
<!-- end video -->

      <!-- popup user profile -->
      <?php if(getSessionUser() > 0 && $this->uri->segment(1) != "question"):?>

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

      <!-- Chat Start -->
        <?php if($bodyClass !== 'verification' && $bodyClass !== 'waiting-verification' && $bodyClass !== 'suspend-account'): ?>
      <a href="javascript:void(0);" class="btn-chat-list">
        <!-- <div class="button-chat-list">Chat List</div> -->
        <img src="<?php echo base_url("public")?>/assets/img/btn-chat-list.png" alt="">
      </a>
      <div class="chat-section">
        <div class="container">
          <div class="chat-list chat-module" style="display:none;">
            <div class="chat-module-content" id="chat-history">
              <div class="loadingBox">
                <span>Please wait ...</span>
                <img src="<?php echo base_url("public")?>/assets/img/ajax-loader.gif">
              </div>
              <div class="box-notify">
                <ul id="chat-user-list">
                  
                </ul>
              </div>
              <div class="chatlist-module-footer">
                <div class="close-wrap pull-right">
                  <a href="javascript:void(0);" class="close-chatlist">
                    <i class="fa fa-sign-out"></i>
                  </a>
                </div>
                <div class="form-group pull-left">
                  <i class="fa fa-search"></i>
                  <input type="text" id="searchUser" class="input-rounded form-control" value="" placeholder="Looking for someone?">
                </div>
              </div>
            </div>
          </div>
          <!-- end of .chat-list -->
       
          
          <div class="chatbox-list"></div>
          <!-- end of .chatbox-list -->
        </div>
      
      </div>
      <!-- end of .chat-section -->
       <?php endif; ?>
      
      <script id="image-media-tpl" type="x-tmpl-mustache">
        <div class="image-chat-galery col-md-4" data-link="{{ link }}">
          <img onerror="src='http://placehold.it/241x241&text=no+image';" src="{{ link }}">
        </div>
      </script>

      <script id="video-media-tpl" type="x-tmpl-mustache">
        <div class="video-chat-galery col-md-4" data-link="{{ link }}">
          <img onerror="src='http://placehold.it/200x120&text=Video';" src="<?php echo base_url()?>public/assets/img/video-play-icon.jpg">
        </div>
      </script>

      <script id="chatlist-tpl" type="x-tmpl-mustache">
        <li data-id="{{ code_id }}">
          <img class="avatar-chat-list" onerror="src='http://placehold.it/40x40&text=no+image';" src="{{ filename_thumb }}">
          <div class="item-data">
            <div class="user-display-name">{{ code_id }}</div>
          </div>
        </li>
      </script>

      <script id="chatbox-tpl" type="x-tmpl-mustache">
        <div class="chat-box chat-module" data-id="{{ code_id }}" id="chatbox_{{code_id}}">
          <div class="chat-module-inner">
            <div class="chat-module-header">
              <span class="chat-module-title">
                <span class="setting-chat pull-left">
                  <i class="fa fa-gear dropdown-toggle" data-toggle="dropdown"></i>
                  <ul class="chat-setting dropdown-menu" role="menu">
                    <li class="chat-image" data-id="{{ code_id }}">
                      <span class="menu-image-chat pull-left">
                        <i class="fa fa-picture-o"></i> &nbsp;Send Images 
                      </span>
                    </li>
                    <li class="chat-video" data-id="{{ code_id }}">
                      <span class="menu-video-chat pull-left">
                        <i class="fa fa-video-camera"></i> &nbsp;Send Video 
                      </span>
                    </li>
                    <li class="chat-delete-item">
                      <span class="menu-delete-chat pull-left">
                        <i class="fa fa-check-circle"></i> &nbsp; Delete Chats
                      </span>
                    </li>
                    <li class="chat-delete">
                      <span class="menu-delete-chat pull-left">
                        <i class="fa fa-trash-o"></i> &nbsp; Delete Conversations
                      </span>
                    </li>
                  </ul>
                </span>
                <a class="user-image show-user" data-user-id="{{ id }}" href="<?php echo base_url()?>profile/{{ code_id }}">
                  {{ display_name }}
                </a>
              </span>
              <span class="close pull-right">&times;</span>
              <span class="popup pull-right pop-{{ code_id }}" id="popup-chat" onclick="window.open('<?php echo base_url() ?>chat/popup/{{ code_id }}', 'win_{{ code_id }}', 'toolbar=no, scrollbars=no, resizable=no, top=200, left=200, width=400, height=400').focus();"><i class="fa fa-external-link"></i></span>
              <span class="minimize pull-right">_</span>
            </div>
            <div class="upload-content" id="upload-content-{{code_id}}" ></div>
            <div class="upload-content" id="upload-content-video-{{code_id}}" ></div>
            <div class="content-confirm-delete" id="confirm-delete-chat-{{code_id}}" ></div>
            <div class="chat-module-content">
              <span class="separator-date" data-date="{{data_date}}" id="notify-delete"></span>
              <ul class="chat-message"></ul>
            </div>
            <div class="emoticon-options emo_{{ code_id }}"></div>
            <div class="chat-module-footer">
              <div class="option-item-chat" data-id="{{ code_id }}">
                <span class="info" style="font-size:12px; padding-left:10px;">Select chats to delete : </span>
                <span class="nav-delete">
                  <input type="button" class="btn-cancel-delete" value="Cancel">
                  <input type="button" class="btn-delete-item-chat" value="Delete"> 
                </span>
              </div>
              <span class="btn-emoticon pull-left" data-id="{{ code_id }}">
                <i class="fa fa-smile-o"></i>
              </span>
              <span class="pull-right" style="width:230px;">
                <textarea class="chatbox-textarea textarea_{{ code_id }}" placeholder="Chat here ..."></textarea>
              </span>
            </div>
          </div>
        </div>
      </script>

      <script id="chat-list-item" type="x-tmpl-mustache">
        <li class="user-list-item" data-id="{{ code_id }}"> 
          <img class="avatar-chat-list" onerror="this.src='http://placehold.it/40x40&text=no+image;" src="{{ filename_thumb }}" >
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
        <li id='{{ chat_id }}' class="{{ classname }}">
          <img onerror="src='http://placehold.it/40x40&text=no+image';" src="{{ filename_thumb }}">
          <div class="message-content">
            <span class="option-chat-item-check pull-right" style="display: none; margin-top:-5px;">
              <input type="checkbox" value={{ chat_id }} name='checkbox-chat'>
            </span>
            <div class="message msg_{{ tsStat }}">{{ message }}</div>
            <div class="times"><span  id="{{ tsStat }}">{{ status }}</span> {{ ts }}</div>
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
            <a href="<?php echo base_url()?>">PMJakarta</a>
            by
            <a href="javascript:void(0);">SBS Incubator.</a>
            All rights reserved.
          </p>
        </div>
        
        <!-- end of .col-sm-4.right-menu-footer -->
      </footer>


    <script src="<?php echo base_url()?>public/assets/js/plugins.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/firebase.js"></script> 
    <script src="<?php echo base_url()?>public/assets/js/emoticons.js"></script>   
    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
    <!--<script src="//cdn.firebase.com/v0/firebase.js"></script>-->

    <!--<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js"></script> -->
    <script src="<?php echo base_url()?>public/assets/js/vendors/jquery.pjax.js"></script> 
    <script src="<?php echo base_url()?>public/assets/js/moment.min.js"></script>    
    <script src="<?php echo base_url()?>public/assets/js/selectize.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/select2.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/jquery.mousewheel.min.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/jquery.quicksearch.js"></script>
    <script src="<?php echo base_url()?>public/assets/scroll/perfect-scrollbar.js"></script>
    

    <?php if(!empty($totalQuestion)):?>
      <script>
      var question = {
          total : "<?php echo $totalQuestion ?>",
          progress : "<?php echo $percent ?>",
          pervalue : "<?php echo $value ?>",          
      };
      var percentage = 0;            
      var qanumber = 1;
      </script>
    <?php endif; ?>


    <script>

      var firebase_root = {
        userchat    : '<?php echo $this->config->item("user_chat") ?>',
        notify      : '<?php echo $this->config->item("notifications") ?>',
        mosaic_url  : '<?php echo $this->config->item("mosaic_url") ?>'
      };

      var current_user = {
        user_id       :'<?php echo getSessionUser()?>',
        user_code_id  :'<?php echo getSessionCodeId()?>',
        user_name     :'<?php echo getAuthUsername()?>',
        user_gender   :'<?php echo getSessionGender()?>',
        display_name  :'<?php echo getAuthUsername()?>',
        thumb         :'<?php echo getAvatarPhoto(getSessionUser())?>',
        subscription  :'<?php echo getSessionSubscript()?>'
      };

      var root = {
        base_url: '<?php echo base_url()?>'
      };

      var config_settings = {
        chat: '<?php echo getSetting('5') ?>',
        message: '<?php echo getSetting('6') ?>',
        favorite: '<?php echo getSetting('7') ?>',
      };
    </script>

    <script src="<?php echo base_url()?>public/assets/js/main.js"></script>
  
    <script>
      <?php if(!empty($qacategory)):?>
        var qacategory = <?php echo $qacategory ?>
      <?php else: ?>
        var qacategory = 1;
      <?php endif; ?>                
    </script>

    <!-- inline javascript for chat app -->
    <?php if(getSessionUser() > 0):?>
    <!--<script src="http://assets.freshdesk.com/widget/freshwidget.js"></script> -->
    <script src="<?php echo base_url()?>public/assets/js/freshwidget.js"></script>
    <script>
      FreshWidget.init("", {
        "queryString": "&widgetType=popup&helpdesk_ticket[requester]=<?php echo getSessionEmail()?>", 
        "widgetType": "popup", 
        "buttonType": "text", 
        "buttonText": "Help & Support", 
        "buttonColor": "white", 
        "buttonBg": "#1ecbb8", 
        "alignment": "4", 
        "offset": "60%", 
        "formHeight": "500px", 
        "url": "http://pmj.freshdesk.com"
      });

    </script>
    </script>
    <!--<script src="<?php echo base_url()?>public/assets/js/chat/chat_dev.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/notify.js"></script>-->
    
    <script src="<?php echo base_url()?>public/assets/js/chat/chat_new.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/notify_new.js"></script>
     <script src="<?php echo base_url()?>public/assets/js/bootbox.min.js"></script>
    
    <script src="<?php echo base_url(); ?>public/assets/js/photo.js"></script>
    <script src="<?php echo base_url(); ?>public/assets/js/custom.js"></script>

    <?php endif;?>
    <?php $this->load->view("template/ga");?>

    </body>
</html>