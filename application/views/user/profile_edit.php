<?php $this->load->view("template/header");?>
      <div class="site-main" id="main">
        <div class="container">
          <div class="row">
            <div class="col-md-3 left-content visible-lg visible-md">
              <div class="panel panel-default panel-pmj panel-user-photo">
                <div class="panel-heading">
                  <h3 class="panel-title"><?php echo $user->name?></h3>
                </div>
                
                 <div class="panel-body">
                  <div class="user-photo">
                    <a href="javascript:void(0);">
                      <img alt="" class="avatar" onerror="this.src='http://placehold.it/241x241&text=no+image';" src="<?php echo getAvatarPhoto($user->id)?>">
                      <?php if($user->id == getSessionUser()):?>
                      <span  class="metode-upload-photo">
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
              </div>
              <!-- end of .panel-user-photo -->
              
              <?php $this->load->view('template/left_nav_myprofile');?>
            </div>
            
            <!-- end of .left-content -->
            <div class="col-md-9 right-content" id="right-content">
              <section class="edit-profile" id="edit-profile">
                <div class="row">
                  <div class="col-sm-8">
                    <?php if(!empty($sukses)):?>
                         <div class="alert alert-success"><?php echo $sukses?></div>
                    <?php endif; ?>
                    <?php if(!empty($notif)):?>
                          <div class="alert alert-danger"><?php echo $notif?></div>
                    <?php endif; ?>
                    <form method="post">
                      <div class="panel panel-default panel-pmj panel-edit-profile">
                        <div class="panel-heading">
                          <h3 class="panel-title">Edit Profile</h3>
                        </div>
                        
                        <div class="panel-body">
                          <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" placeholder="Enter Your Name" type="text" value="<?php echo $user->name?>" name="name">
                          </div>
                          
                          <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" placeholder="Enter Your Email" type="email" value="<?php echo $user->email?>" name="email">
                          </div>
                          
                          <div class="form-group">
                            <label>Birth of Date</label>
                            <input type="text" name="birth" class="form-control input-birth datepicker" data-date-format="yyyy-mm-dd" data-date-viewmode="years" value="<?php echo $user->birthday?>">
                            <!-- <input class="form-control" placeholder="Enter Your Birth of Date" type="text" value="<?php echo $user->birthday?>" name="birth"> -->
                          </div>
                          
                          <div class="form-group">
                            <label>Gender</label>
                            <?php if($user->gender != ""){
                              if($user->gender == "Male" || $user->gender == "male"){
                                $male = "checked";
                              } else if ($user->gender == "Female" || $user->gender == "female") {
                                $female = "checked";
                              }
                            }
                            ?>
                            <p>
                              <label class="radio-inline">
                                <input type="radio" <?php echo @$male?> value='Male' name='gender' style="display: inline !important;">
                                Male
                              </label>
                              <label class="radio-inline">
                                <input type="radio" <?php echo @$female?> value='Female' name='gender' style="display: inline !important;">
                                Female
                              </label>
                            </p>
                          </div>

                          <div class="form-group">
                            <label>City</label> <br>
                            <select id="area-range" name="city">
                            <?php 
                              if($user->city != ""){
                                foreach (getCity() as $key => $value) {
                                  echo "<option value='$value->city_name' ".(($user->city=="$value->city_name")? 'selected':"").">$value->city_name</option>";
                                }
                              }
                            ?>
                            </select>
                          </div>
                          
                        </div>
                      </div>
                      <!-- end of .panel-edit-profile -->
                      
                      <div class="panel panel-default panel-pmj panel-edit-password">
                        <?php if($this->session->userdata('login_third_party')!="true"): ?>
                        <div class="panel-heading">
                          <h3 class="panel-title">Change Password</h3>                          
                        </div>
                         <?php endif; ?>
                        <!-- <p class="alert alert-error">fill only if you want to change your password</p> -->
                        <div class="panel-body">
                          <?php if($this->session->userdata('login_third_party')!="true"): ?>
                          <div class="form-group">
                            <label>Current Password</label>
                            <input class="form-control" placeholder="Enter Your Password" type="password" name="current_password">
                          </div>
                          
                          <div class="form-group">
                            <label>New Password</label>
                            <input class="form-control" placeholder="Enter Your Password" type="password" name="new_password">
                          </div>
                          
                          <div class="form-group">
                            <label>Confirm Password</label>
                            <input class="form-control" placeholder="Enter Your Password" type="password" name="confirm_password">
                          </div>
                          <?php endif; ?>
                          <input class="btn" type="submit" value="Save" name='submit'>
                        </div>
                        <div class="delete-account">
                          <a href="#">Delete Account</a>
                        </div>
                      </div>
                   
                      <!-- end of .panel-edit-password -->
                    </form>
                    <!-- end of form -->
                  </div>
                </div>
              </section>
              <!-- end of .edit-profile -->
            </div>
            
            <!-- end of .right-content -->
          </div>
        </div>
        
        <!-- end of .container -->
      </div>
     <?php $this->load->view("template/modal_upload_photo");?>
     <?php $this->load->view("template/footer");?>