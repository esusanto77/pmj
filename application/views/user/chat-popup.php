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
		
		<link href="<?php echo base_url("public")?>/assets/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url("public")?>/assets/css/main.css" rel="stylesheet">
		<link href="<?php echo base_url("public")?>/assets/css/style.css" rel="stylesheet">

		<link href="<?php echo base_url("public")?>/assets/css/custom-chat.css" rel="stylesheet">
		<link href="<?php echo base_url("public")?>/assets/css/custom-online-list.css" rel="stylesheet">
		<link href="<?php echo base_url("public")?>/assets/css/custom-notify.css" rel="stylesheet">
		<link href="<?php echo base_url("public")?>/assets/css/perfect-scrollbar.css" rel="stylesheet">

		<!-- <link href="<?php echo base_url("public")?>/assets/css/extends.css" rel="stylesheet"> -->
		<link href="<?php echo base_url("public")?>/assets/css/plugins/mmenu/mmenu-all.css" rel="stylesheet">    
		<link href="<?php echo base_url("public")?>/assets/css/datepicker.css" rel="stylesheet">    
		<link href="<?php echo base_url("public")?>/assets/css/plugins/mmenu/mmenu-all.css" rel="stylesheet">        
		<link href="<?php echo base_url("public")?>/assets/css/plugins/selectize.bootstrap3.css" rel="stylesheet">        
		<link href="<?php echo base_url("public")?>/assets/css/select2.css" rel="stylesheet">
		<link href="<?php echo base_url("public")?>/assets/css/support/skype/emoticons.css" rel="stylesheet">
		
		<?php if(!empty($script)):?>
			<?php foreach($script as $s):?>
				<link href="<?php echo base_url("public")?>/assets/css/plugins/<?php echo $s?>.css" rel="stylesheet">    
			<?php endforeach; ?>
		<?php endif; ?>
		
		<script src="<?php echo base_url()?>public/assets/js/jquery.js"></script>

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
			<div class="chat-section chat-popup">
				<div class="chatbox-list">
					<div class="chat-box chat-module" style="display: block;">
						<div class="chat-module-inner">
							<div class="chat-module-content">
								<div class="navbar-fixed-top" style="background-color: #27c4ac; padding: 8px; height: 30px;">
									<span class="setting-chat-pop pull-left">
					                  <i class="fa fa-gear dropdown-toggle" data-toggle="dropdown"></i>
					                  <ul class="chat-setting-pop dropdown-menu" role="menu">
					                  	<li class="chat-image-pop">
					                      <span class="menu-image-chat-pop pull-left">
					                        <i class="fa fa-picture-o"></i> &nbsp; &nbsp;Send Images 
					                      </span>
					                    </li>
					                    <li class="chat-video-pop">
					                      <span class="menu-video-chat-pop pull-left">
					                        <i class="fa fa-video-camera"></i> &nbsp; &nbsp;Send Video 
					                      </span>
					                    </li>
					                    <li class="chat-delete-item-pop">
					                      <span class="menu-delete-chat-pop pull-left">
					                        <i class="fa fa-check-circle"></i> &nbsp; &nbsp;Delete Chats
					                      </span>
					                    </li>
					                    <li class="chat-delete-pop">
					                      <span class="menu-delete-chat-pop pull-left">
					                        <i class="fa fa-trash-o"></i> &nbsp; &nbsp;Delete Conversations
					                      </span>
					                    </li>
					                  </ul>
					                </span>
							    	<h3 class="panel-title" style="color: #fff; font-size: 13px;"></h3>
							    	<span class="pop-in-chat pull-right" style="cursor:pointer; margin-top: -15px; font-size: 12px; font-weight: bold;" id="closebtn"><i class="fa fa-external-link"></i></span>
							  	</div>
								<ul class="chat-message-pop" style="padding-top: 36px; padding-bottom: 36px;">
									<div class="loadingPop" style="position:fixed; left:45%; top:20%;">
		                            	<img src="<?php echo base_url("public")?>/assets/img/ajax-loader.gif">
	                          		</div>
								</ul>
							</div>

							<div class="emoticon-options-pop"></div>
							<div class="upload-content-pop"></div>
							<div class="upload-content-video-pop"></div>
							<div class="upload-content confirm-delete-chat-pop"></div>
							<div class="chat-module-footer" style="height: 36px;">
								<div class="option-item-chat-pop">
					              <span class="info" style="font-size:13px;">Select Chat to delete : </span>
					              <span class="nav-delete" style="font-size:12px;">
					                <input type="button" class="btn-cancel-delete-pop" value="Cancel">
					                <input type="button" class="btn-delete-item-chat-pop" value="Delete"> 
					              </span>
					            </div>
								<div class="row" style="width:100%;">
									<span class="btn-emoticon-pop pull-left">
										<i class="fa fa-smile-o"></i>
									</span>
									<span class="content-textarea-pop pull-right">
										<textarea class="chatbox-textarea-pop" placeholder="Chat here.."></textarea>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end of .chatbox-list -->

			</div>
			<!-- end of .chat-section -->

			<script id="chatboxpop-message" type="x-tmpl-mustache">
				<li id="{{ chat_id }}" class="{{ classname }}">
					<img onerror="src='http://placehold.it/40x40&text=no+image';" src="{{ filename_thumb }}">
					<div class="message-content">
						<span class="option-chat-item-check pull-right" style="display: none; margin-top:-5px;">
			              <input type="checkbox" value={{ chat_id }} name='checkbox-chat-pop'>
			            </span>
						<div class="message msg_pop_{{ tsStat }}">{{ message }}</div>
						<div class="times"><span id="{{ tsStat }}">{{ status }}</span> {{ ts }}</div>
					</div>
				</li>
			</script>

		</div>

	<div aria-hidden="true" class="media-image-pop modal fade" id="media-image-pop" role="dialog" tabindex="-1">
	  <div class="media-image-pop modal-dialog"> 
	      <div class="panel panel-default" style="overflow: auto; height: 400px">
	        <div class="panel-heading">
	          <h5>Your Recent Sent Image</h5>
	        </div>
	        <div class="panel-body">
	          <div class="row-image-chat">
	            <div class="row" id="content-chat-image-pop" style="margin-bottom: 50px;"></div>
	          </div>
	        </div>
	        <div class="panel-footer footer-image-chat">
	            <input type="hidden" id="select-chat-image-pop" style="font-size:8px">
	            <input type="button" class="send-chat-image" id="send-chat-image-pop" value="SEND IMAGE">
	            <input type="button" class="cancel-chat-image" value="CANCEL">
	            <input type="hidden" id="referensi-chat-pop">
	        </div>
	      </div>
	  </div>
	</div>	



    <script src="<?php echo base_url()?>public/assets/js/plugins.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/firebase.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/emoticons.js"></script>  
    <script src="<?php echo base_url()?>public/assets/js/jquery.mousewheel.min.js"></script> 
    <script src="<?php echo base_url()?>public/assets/scroll/perfect-scrollbar.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js"></script> 

    <!-- inline javascript for chat app -->
    <?php if(getSessionUser() > 0):?>
    <script>

      var firebase_root = {
        userchat  : '<?php echo $this->config->item("user_chat") ?>',
        notify    : '<?php echo $this->config->item("notifications") ?>'
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

    </script>
    <!--<script src="<?php echo base_url()?>public/assets/js/chat_dev.js"></script>-->
    <script src="<?php echo base_url()?>public/assets/js/chat/chat_popup.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/notify.js"></script>
    <?php endif;?>

		</body>
</html>