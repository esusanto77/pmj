<?php $this->load->view("template/header");?>
      <div class="site-main" id="main">
        <div class="container">
          <div class="row">
          
          	<?php $this->load->view("template/left_nav");?>

            <div class="col-md-9 right-content" id="right-content">
          
                  <div class="recent-activity-wrapper">
                    <div class="panel panel-default panel-pmj panel-recent-activity">
                      <div class="panel-heading">
                        <h3 class="panel-title">
                          Recent Activity
                        </h3>                        
                      </div>

                      <div class="panel-body clearfix">
                        <ul class="list-activities">
                        <?php if(!empty($act)):?>
                        <?php foreach($act as $a):?>
                          <li class="clearfix">
                            <div class="user-image pull-left">
                              <a class="user-image show-user" data-user-id="<?php echo getSessionUser()?>" href="/profile/<?php echo getSessionUser(); ?>">
                                <img alt="" class="avatar" onerror="this.src='http://placehold.it/241x241&text=no+image';" src="<?php echo getAvatarPhoto(getSessionUser()); ?>">
                              </a>
                            </div>
                            <div class="user-activity">
                              <span class="time"><?php echo timeago($a->act_date) ?></span>
                              <p>
                                <a class="show-user" data-user-id="<?php echo getSessionUser()?>" href="/profile/<?php echo getSessionUser(); ?>">You</a>
                                <?php echo getActivityLabel($a->act_label); ?>
                                <a class="user-image show-user" data-user-id="<?php echo $a->id?>" href="/profile/<?php echo $a->id; ?>"><?php echo $a->code_id?></a>
                                
                              </p>
                            </div>
                          </li>
                        <?php endforeach; ?>

                      <?php endif; ?>
                          
                        </ul>
                        <?php echo $pagination; ?>
                      </div>
                    </div>
                  </div>

              </div>
            </div>
            
          <!-- end of .right-content -->
        </div>
      </div>
        
        <!-- end of .container -->
   



     



<?php $this->load->view("template/footer");?>