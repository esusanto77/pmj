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
	<link href="<?php echo base_url("public")?>/assets/css/custom-chat.css" rel="stylesheet">
	<link href="<?php echo base_url("public")?>/assets/css/main.css" rel="stylesheet">
	<link href="<?php echo base_url("public")?>/assets/css/themes/maccaco/projekktor.style.css" rel="stylesheet">
	
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
	<div class="hfeed" id="page-video">
		<div class="chat-section chat-popup">
			<div class="chatbox-list">
				<div class="chat-box chat-module" style="display: block;">
					<div class="chat-module-inner">
						<div class="chat-module-content">
							<div class="navbar-fixed-top" style="background-color: #27c4ac; padding: 8px; height: 30px;">
								<h3 class="panel-title video-title" style="color: #fff; font-size: 12px;"></h3>
								<input type="hidden" id="sender-video" value="<?php echo $id; ?>">
								<input type="hidden" id="file-video" value="<?php echo $file; ?>">
								<span class="pop-in-chat pull-right" style="cursor:pointer; margin-top: -15px; font-size: 12px; font-weight: bold;"><i class="fa fa-external-link"></i></span>
						  	</div>
						  	<video id="player_a" class="projekktor video-content" poster="intro.png" title="this is projekktor" width="640" height="360" controls>
							    <source id="source-video"/>
							</video>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>

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

    <script src="<?php echo base_url()?>public/assets/js/projekktor-1.3.09.min.js"></script>
    <script src="<?php echo base_url()?>public/assets/js/chat/chat_video.js"></script>
    
</body>