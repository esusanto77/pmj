<?php $this->load->view("template/header");?>
<link rel="stylesheet" href="<?php echo base_url("public");?>/assets/css/jquery.fancybox.css" media="screen">
<script src="<?php echo base_url("public");?>/assets/js/jquery.fancybox.js"></script>
<div class="site-main" id="main">
	<div class="container">
   <div class="row">

    <div class="col-md-3 left-content visible-lg visible-md">
      <div class="panel panel-default panel-pmj panel-user-photo">
        <div class="panel-heading">
          <h3 class="panel-title">
            <?php if( $user->id == getSessionUser()):
            echo $user->name;
            else:
              echo $user->code_id;
            endif;
            ?>
          </div>
          <div class="panel-body">
            <div class="user-photo">
              <a href="javascript:void(0);">
                <img alt="" onerror="this.src='http://placehold.it/241x241&text=no+image';" class="avatar" src="<?php echo getAvatarPhoto($user->id)?>">
                <?php if($user->id == getSessionUser()):?>
                <span class="metode-upload-photo">
                  <i class="fa fa-gear"></i>
                  Change photo
                </span>
              <?php endif; ?>
            </a>
          </div>

          <div class="ribbon-badge">
            <span class="ribbon-badge-span">
              Subscription:
              <strong><?php echo getUserSubscription(getSessionCodeId(),$this->uri->segment(3)); ?></strong>
            </span>
            <span class="ribbon-badge-span">
              <strong><?php echo checkExpiredUserSubscription(getSessionCodeId(),$this->uri->segment(3)); ?></strong>
            </span>
          </div>
        </div>
      </div>
      <!-- end of .panel-user-photo -->

      <?php if($user->id == getSessionUser()): $this->load->view('template/left_nav_myprofile'); endif;?>
      <!-- end of .user-profile-links -->
    </div>
    <!-- end of .left-content -->
    <div class="col-md-9 right-content" id="right-content">

      <!-- end of .alert-wrapper -->
      <?php if(count($matches) > 0):?>
      <section class="match-wrapper <?php if( isset($class) ) echo $class; ?>" id="view-matches">
        <div class="panel panel-default panel-pmj panel-match">
          <div class="panel-heading clearfix">
            <h3 class="panel-title">
              <?php echo $pageTitle ?>
            </h3>
            <?php echo @$pagination; ?>
          </div>
          <div class="panel-body">
            <div class="row match-row">

              <?php foreach($matches as $i => $u):
                if($u->avatar=="1"){
                 $photo = $u->filename_thumb;
                 $photoFancy = $u->filename;
               }else{
                 $photo = $u->filename_thumb;
                 $photoFancy = $u->filename;
               }
              ?>                        
             <div class="col-sm-3 col-xs-6 user-match">
               <a class="fancybox" rel="ligthbox" href="<?php echo $photoFancy;?>" title="<?php echo $u->filename_ori; ?>">
                <img alt="<?php echo $u->filename_ori; ?>" class="img-thumbnail avatar" src="<?php echo $photo;?>" onerror='this.src="http://placehold.it/241x241&text=no+image";'>
              </a>
              <?php if($this->uri->segment(3)==getSessionUser() or $this->uri->segment(3)==""): ?>
              <h4 class="user-name custom-photo-list">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-gear fa-gear-white"></i>
                </a>
                <ul class="dropdown-menu arrow-photo-edit-view-photo-all dropdown-menu-size-view-photo-all" role="menu">
                 <li><a href="<?php echo base_url("photo").'/delPhoto/'.$u->id; ?>/viewAllPhoto">Delete Photo</a></li>
                 <li><a href="<?php echo base_url("photo").'/changeAvatar/'.$u->id; ?>/viewAllPhoto">Make Profile</a></li>
               </ul>
             </h4>
           <?php endif; ?>                          
           <!-- end of .user-image -->

           <!-- end of .user-profile -->
         </div>
       <?php endforeach; ?>

       <!-- end of .col-sm-3.col-xs-6.user-match -->
     </div>
     <div style="margin-top:20px;">
      <?php echo @$pagination; ?>
    </div>
    <!-- end of .row.match-row -->
    <!-- <a class="view-all pull-right pjax" data-pjax="javascript:void(0);right-content" href="matches.html">View all</a> -->
  </div>
</div>

<!-- end of .panel.panel-default.panel-pmj.panel-match -->
</section>
<?php else: ?>
  <section class="match-wrapper" id="best-matches">
    <div class="panel panel-default panel-pmj panel-match">
      <div class="panel-heading">
        <h3 class="panel-title">
          <?php echo $pageTitle ?>
        </h3>
      </div>
      <div class="panel-body">
        <div class="row match-row">
          <div class="col-sm-3 col-xs-6 user-match">
            Empty Data
          </div>
          <!-- end of .col-sm-3.col-xs-6.user-match -->
        </div>

        <!-- end of .row.match-row -->
        <!-- <a class="view-all pull-right pjax" data-pjax="javascript:void(0);right-content" href="matches.html">View all</a> -->
      </div>
    </div>

    <!-- end of .panel.panel-default.panel-pmj.panel-match -->
  </section>


<?php endif; ?>

<!-- end of .bottom-area-wrapper -->
</div>

<!-- end of .right-content -->
</div>
</div>
<!-- end of .container -->
</div>

<?php $this->load->view("template/modal_upload_photo");?>	
<?php $this->load->view("template/footer");?>

<script type="text/javascript">
jQuery.noConflict()(function ($) {
  $(document).ready(function () {
    /* Fancybox */
    $(".fancybox").fancybox({
      openEffect: "none",
      closeEffect: "none"
    });
  });
});
</script>
