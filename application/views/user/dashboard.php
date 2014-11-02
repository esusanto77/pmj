<?php $this->load->view("template/header");?>
      <div class="site-main" id="main">
        <div class="container">
          <div class="row">

            <?php $this->load->view("template/left_nav");?>

            <!-- end of .left-content -->
            <div class="col-md-9 right-content" id="right-content">

            <?php $this->load->view("user/announcement"); ?>

              <!-- end of .alert-wrapper -->
              <?php if($totalMatch > 0):?>
              <section class="match-wrapper" id="best-matches">
                <div class="panel panel-default panel-pmj panel-match">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      Best Matches
                    </h3>
                  </div>
                  <div class="panel-body">
                    <div class="row match-row">

                      <?php $limit= 0; foreach($match as $i => $u):?>
                          <div class="col-sm-5ths col-xs-6 user-match">
                            <a class="user-image show-user" data-user-id="<?php echo $u["id"]?>" href="<?php echo base_url();?>profile/<?php echo $u["code_id"]; ?>">
                              <img alt="" onerror="this.src='http://placehold.it/241x241&text=no+image';" class="avatar" src="<?php echo getAvatarPhoto($u["id"])?>">
                              <h4 class="user-name">
                                <span class="user-status status_<?php echo $u["code_id"]; ?>"></span>
                                <span class="display-name"><?php echo trim($u["code_id"])?></span>

                              </h4>
                            </a>

                            <!-- end of .user-image -->
                            <div class="user-profile">
                              <p><?php echo $u["_80"]?></p>
                              <hr>
                              <ul class="user-action">
                                <li>
                                  <!-- <?php echo base_url('message/to/'.$u["code_id"])?> -->
                                  <a class="action-email" href="javascript:void(0);" data-id="<?php echo $u["code_id"]?>" data-pjax='#right-content'>
                                    <i class="fa fa-envelope"></i>
                                  </a>
                                </li>
                                <li class="btn-chat" data-id="<?php echo $u["code_id"]?>">
                                  <a class="action-message" href="javascript:void(0);">
                                    <i class="fa fa-comment"></i>
                                  </a>
                                </li>
                                <li>
                                  <a class="action-favorite <?php if(checkActivity(getSessionUser(), $u["id"]) == 1){ echo "active";} ?> user_fav_<?php echo $u["id"]?>" href="javascript:void(0);" data-id="<?php echo $u["id"]?>" data-code="<?php echo $u["code_id"]?>">
                                    <i class="fa fa-heart"></i>
                                  </a>
                                </li>
                              </ul>

                              <!-- end of .user-action -->
                            </div>

                            <!-- end of .user-profile -->
                          </div>
                      <?php if($limit++ >= 4) break;  endforeach; ?>
                      <!-- end of .col-sm-3.col-xs-6.user-match -->
                    </div>

                    <!-- end of .row.match-row -->
                    <!-- <a class="view-all pull-right pjax" data-pjax="#right-content" href="<?php echo base_url();?>matches/best">View all</a> -->
                  </div>
                </div>

                <!-- end of .panel.panel-default.panel-pmj.panel-match -->
              </section>
                <?php else: ?>
              <section class="match-wrapper" id="best-matches">
                <div class="panel panel-default panel-pmj panel-match">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                     Best Matches
                    </h3>
                  </div>
                  <div class="panel-body">
                    <div class="row match-row">
                      <div class="col-sm-12 col-xs-12 user-match">
                        <div class="alert alert-warning">
                         <p>You will begin to receive your matches upon the completion of your match reference analysis.</p></div>
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
              <section class="bottom-area-wrapper">
                <div class="row">
                  <div class="col-sm-7 recent-activity-wrapper">
                    <div class="panel panel-default panel-pmj panel-recent-activity">
                      <div class="panel-heading">
                        <h3 class="panel-title">
                          Recent Activity
                        </h3>
                      </div>
                      <div class="panel-body clearfix">

                        <?php if(!empty($act)):?>
                          <ul class="list-activities">
                          <?php foreach($act as $a):?>
                            <li class="clearfix">
                              <div class="user-image pull-left">
                                <a class="user-image show-user" data-user-id="<?php echo getSessionUser()?>" href="<?php echo base_url();?>profile/<?php echo getSessionUser(); ?>">
                                  <img alt="" onerror="this.src='http://placehold.it/241x241&text=no+image';"  class="avatar" src="<?php echo getAvatarPhoto(getSessionUser()); ?>">
                                </a>
                              </div>
                              <div class="user-activity">
                                <span class="time"><?php echo timeago($a->act_date) ?></span>
                                <p>
                                  <a class="show-user" data-user-id="<?php echo getSessionUser()?>" href="<?php echo base_url();?>profile/<?php echo getSessionUser(); ?>">You</a>
                                  <?php echo getActivityLabel($a->act_label); ?>
                                  <a class="user-image show-user" data-user-id="<?php echo $a->id?>" href="javascript:void(0);"><?php echo $a->code_id?></a>

                                </p>
                              </div>
                            </li>
                          <?php endforeach; ?>
                          </ul>
                        <?php else: ?>
                            <p>no data</p>
                          <?php endif; ?>

                        <!-- end of .list-activities -->
                        <?php if(!empty($act)):?>
                        <a class="view-all pull-right pjax" data-pjax="#right-content" href="<?php echo base_url()?>activity">View all</a>
                      <?php endif; ?>
                      </div>
                    </div>

                    <!-- end of .panel.panel-default.panel-pmj.panel-recent-activity -->
                  </div>
                  <div class="col-sm-5 last-viewed-wrapper">
                    <div class="panel panel-default panel-pmj panel-last-viewed">
                      <div class="panel-heading">
                        <h3 class="panel-title">
                          Last Viewed Me
                        </h3>
                      </div>
                      <div class="panel-body">

                        <?php if(!empty($viewed)):?>
                          <ul class="users-viewed clearfix">
                            <?php foreach($viewed as $i => $u):?>
                            <li class="user">
                              <a class="user-image show-user" data-user-id="<?php echo $u->id?>" href="<?php echo base_url(); ?>profile/<?php echo $u->code_id; ?>">
                                <img alt="" class="avatar" onerror="this.src='http://placehold.it/241x241&text=no+image';" src="<?php echo getAvatarPhoto($u->id); ?>">
                                <h4 class="user-name">
                                  <span class="user-status status_<?php echo $u->code_id?>"></span>
                                  <span class="display-name"><?php echo $u->code_id?></span>
                                </h4>
                              </a>
                            </li>
                            <?php endforeach;?>
                            <!-- end of .user -->
                          </ul>

                          <?php else: ?>
                            <p>no data</p>
                          <?php endif; ?>


                          <!-- end of .users-viewed -->
                          <?php if(!empty($viewed)):?>

                          <hr>
                          <a class="view-all pull-right pjax" data-pjax="#right-content" href="<?php echo base_url(); ?>viewed/me">View all</a>
                        <?php endif; ?>
                      </div>
                    </div>

                    <!-- end of .panel.panel-default.panel-pmj.panel-recent-activity -->
                  </div>
                </div>
              </section>

              <!-- end of .bottom-area-wrapper -->
            </div>

            <!-- end of .right-content -->
          </div>
        </div>

        <!-- end of .container -->
      </div>

<?php $this->load->view("template/footer");?>