<?php $this->load->view("template/header");?>
<div class="site-main" id="main">
  <div class="container">
    <div class="row">
      <div class="col-md-3 left-content visible-lg visible-md">
        <div class="panel panel-default panel-pmj panel-user-photo">
          <div class="panel-heading">
            <h3 class="panel-title">
              <?php if($user->id == getSessionUser()):
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
              <strong><?php echo getUserSubscription(getSessionCodeId(),$this->uri->segment(2)); ?></strong>
            </span>
            <span class="ribbon-badge-span">
              <strong><?php echo checkExpiredUserSubscription(getSessionCodeId(),$this->uri->segment(2)); ?></strong>
            </span>
          </div>
        </div>
        <?php if($user->id != getSessionUser()): ?>
        <div class="form-report">
           <button class="btn btn-primary btn-file" data-toggle="modal" data-target="#reportUser" style="width:100%;">Report <?php echo $this->uri->segment(2); ?> </button>
        </div>
        <?php endif;?>
      </div>

      <!-- end of .panel-user-photo -->

      <?php if($user->id == getSessionUser()): $this->load->view('template/left_nav_myprofile'); endif;?>
      <!-- end of .user-profile-links -->
    </div>
    <!-- end of .left-content -->

    <div class="col-md-9 right-content" id="right-content">
      <section class="user-profile-data" id="user-profile-data">
        <div class="row">
          <div class="col-md-6">
            <div class="panel panel-default panel-pmj panel-user-data">
              <div class="panel-heading">
                <h3 class="panel-title">Basic Information</h3>
              </div>

              <div class="panel-body">
                <ul class="list-data list-unstyled">
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Subscription</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getUserSubscription(getSessionCodeId(),$this->uri->segment(2)); ?>
                   </strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Age</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo get_age($user->birthday);?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Sex</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo $user->gender ? $user->gender : "-" ?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Religion</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id, "WhatReligion")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Ethnicity</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id, "WhatEthnicity")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Occupation</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id, "WhatOccupation")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Relationship Status</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id, "RelationshipStatus")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Kids</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id, "HaveChildren")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Interest</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"PersonalInterests")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Drinking</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"HowOftenDrink")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Smoking</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"HowOftenSmoke")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">3 Passionate Things</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"DescribePassionate")?></strong>
                  </li>
                </ul>
              </div>
            </div>

            <!-- end of .panel-user-data -->
          </div>

          <div class="col-md-6">
            <div class="panel panel-default panel-pmj panel-user-match">
              <div class="panel-heading">
                <h3 class="panel-title">Match Reference</h3>
              </div>

              <div class="panel-body">
                <ul class="list-data list-unstyled">
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Sex</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo $gender ?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Match's Age</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"ImportantMatchAge")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Match's Education</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"ImportantMatchEducation")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Match's Income</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"ImportantMatchIncome")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Match's Religion</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"MatchReligion")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Kids</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id, "OpenToChildren")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Drinking</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"MatchToDrink")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Smoking</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"MatchToSmoke")?></strong>
                  </li>
                  <li class="row">
                    <span class="label col-md-6 col-sm-6 col-xs-12">Long Term Relationship</span>
                    <strong class="data col-md-6 col-sm-6 col-xs-12"><?php echo getAnswerWithKey($user->id,"LongTermMarriage")?></strong>
                  </li>
                </ul>
              </div>
            </div>
            <!-- end of .panel-user-match -->
          </div>
        </div>

        <div class="panel panel-default panel-pmj panel-user-photos">
          <div class="panel-heading">
            <h3 class="panel-title">Photos</h3>
          </div>

          <div class="panel-body">
           <link rel="stylesheet" href="<?php echo base_url("public");?>/assets/css/jquery.fancybox.css" media="screen">
            <script src="<?php echo base_url("public");?>/assets/js/jquery.fancybox.js"></script>
            <ul class="user-photo-list list-unstyled row" >
              <div class="col-md-12  panel-match" id="album_photo">
                <!--  Loading Image if image not complete load -->
                <span id="loading">
                  <img src="<?php echo base_url("public")."/assets/img/ajax-loader.gif"; ?>" class="center-block">
                </span>
              </div>
              
            </ul>
            <!-- end of  .user-photo-list -->

            <a class="view-all-photos" href="<?php echo base_url('photo');?>/viewAllPhoto<?php echo '/'.$this->uri->segment(2); ?>" id="view-all-photo">View all</a>
          </div>
        </div>

        <!-- end of .panel-user-photos -->
      </section>
      <!-- end of .user-profile-data -->
    </div>
    <!-- end of .right-content -->

  </div>
</div>
<!-- end of .container -->
</div>

<!-- Modal -->
<div class="modal fade" id="reportUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Form Report</h4>
      </div>
      <div class="modal-body">
      <form role="form" method="post" >
      <input type="text" id="code-id-report" value="<?php echo $this->uri->segment(2); ?>" hidden>
      <div class="form-group">
        <label for="message-report">Message</label>
        <div class="alert alert-danger hidden-alert-verification" id="alert-message"></div>
         <select class="form-control" id="message-report">
          <option value="Offensive">Offensive</option>
          <option value="Inappropriate">Inappropriate</option>
          <option value="Fraud">Fraud</option>
          <option value="Other">Other</option>
        </select>
      </div>
       <div class="form-group" id="other-form" style="display:none;">
         <div class="alert alert-danger hidden-alert-verification" id="alert-message-report-other"></div>
        <textarea class="form-control" rows="3" id="message-other" name="message-other"></textarea>
      </div>
      <div class="alert alert-success hidden-alert-verification" id="information-report"></div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="send-report">Send</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view("template/modal_upload_photo");?>

<?php $this->load->view("template/footer");?>
<script src="<?php echo base_url()?>public/assets/js/contact.js"></script>
<script type="text/javascript">
jQuery.noConflict()(function ($) {
  $(document).ready(function () {

    /*
      Load Image   
      Choose Metode Upload Photo 
    */
    $.ajax({
      url: "<?php echo base_url();?>photo/getPhoto/<?php echo $user->id; ?>",
      type: "POST",
      contentType: false,
      cache: false,
      processData:false,
      success: function(data)
      {
        $('#album_photo').html(data);
        $(".add-photo").on("click",function(){
        $("#myModalMetodeUploadPhoto").modal();
      });
      }
    });
  });
  
  /* Fancybox */
  $(".fancybox").fancybox({
      openEffect: "none",
      closeEffect: "none"
  });

   $("#view-all-photo").on("click",function(){
     $('#pageloader').show();
   });
});
</script>