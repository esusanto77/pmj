<?php $this->load->view("template/header");?>
      <div class="site-main" id="main">
        <div class="container">
          <div class="row">
          
          	<?php $this->load->view("template/left_nav");?>
            
            <!-- end of .left-content -->
           <div class="col-md-9 right-content" id="right-content">
              
            
              
              <!-- end of .alert-wrapper -->
              <?php if(count($matches) > 0):?>
              <section class="search-result-list" id="search-result-list">
                <div class="panel panel-default panel-pmj panel-search-result panel-match">
                  <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left">
                      <?php echo $pageTitle ?>
                    </h3>
                    <?php echo @$pagination; ?>
                  </div>
                  <div class="panel-body">
                    <div class="row match-row">

                      <?php foreach($matches as $i => $u):?>                        
		                      <div class="col-sm-3 col-xs-6 user-match box-<?php echo $u->id; ?>">
		                        <a class="user-image show-user" data-user-id="<?php echo $u->id?>" href="<?php echo base_url(); ?>profile/<?php echo $u->code_id; ?>">
		                          <img alt="" class="avatar" onerror="this.src='http://placehold.it/241x241&text=no+image';" src="<?php echo getAvatarPhoto($u->id)?>">
		                          <h4 class="user-name">
		                            <span class="user-status"></span>
		                            <?php echo trim($u->code_id)?>
		                          </h4>
		                        </a>
		                        
		                        <!-- end of .user-image -->
		                        <div class="user-profile">
		                          <p><?php echo $u->_80?></p>
		                          <hr>
		                          <ul class="user-action">
		                            <li>
		                              <a class="action-email " href="<?php echo base_url()?>message/to/<?php echo $u->code_id ?>" data-pjax='#right-content'>
		                                <i class="fa fa-envelope"></i>
		                              </a>
		                            </li>
		                            <li class="btn-chat" data-id="<?php echo $u->code_id?>" data-display-name="<?php echo $u->code_id?>">
		                              <a class="action-message" href="javascript:void(0);">
		                                <i class="fa fa-comment"></i>
		                              </a>
		                            </li>
		                            <li>
		                              <a class="action-favorite <?php if(checkActivity(getSessionUser(), $u->id) == 1){ echo "active";} ?> user_fav_<?php echo $u->id?>" href="javascript:void(0);" data-id="<?php echo $u->id?>" data-code="<?php echo $u->code_id?>">
		                                <i class="fa fa-heart"></i>
		                              </a>
		                            </li>
		                          </ul>
		                          
		                          <!-- end of .user-action -->
		                        </div>
		                        
		                        <!-- end of .user-profile -->
		                      </div>
                  		<?php endforeach; ?>
                      

                      <!-- end of .col-sm-3.col-xs-6.user-match -->
                    </div>
                    
                    <!-- end of .row.match-row -->
                    <!-- <a class="view-all pull-right pjax" data-pjax="javascript:void(0);right-content" href="matches.html">View all</a> -->
                    <div style="margin-top:20px;">
                      <?php echo @$pagination; ?>
                    </div>
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



    


<?php $this->load->view("template/footer");?>