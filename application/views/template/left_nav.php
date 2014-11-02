  <div class="col-md-3 left-content visible-lg visible-md">
              <section class="user-profile-wrapper clearfix">
                <div class="img-wrap pull-left">
                  <a href="<?php echo base_url()?>profile">
                      <img alt="" onerror="this.src='http://placehold.it/241x241&text=no+image';"  class="avatar" src="<?php echo getAvatarPhoto(getSessionUser()); ?>">
                  </a>
                </div>
                <div class="user-name">
                  <?php  checkExpiredUserSubscription(getSessionCodeId())=="" ? $bottom=20 : $bottom=5; ?>
                  <h3 class="name" style="margin-top:0px;margin-bottom:<?php echo $bottom; ?>px;"><?php echo getAuthUsername()?></h3>
                  <p class="subscribe-status">
                    <span>
                      Subscription:<br>
                      <strong><?php echo getUserSubscription(getSessionCodeId(),''); ?> </strong>
                    </span><br>
                      <span>
                      <strong><?php echo checkExpiredUserSubscription(getSessionCodeId()); ?></strong>
                    </span>
                  </p>
                  
                  <!-- end of .subscribe-status -->
                </div>
                
                <!-- end of .user-name -->
              </section>
              <section class="menu-left" id="dash-nav">
                <ul class="list-group">
                  <li class="list-group-item">
                    <a href="<?php echo base_url()?>profile" class='pjax_' data-pjax='#right-content'>
                      <i class="fa fa-user"></i>
                      Profile
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="<?php echo base_url()?>favorite" class='pjax' data-pjax='#right-content'>
                      <i class="fa fa-heart"></i>
                      Favorite
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="<?php echo base_url()?>message"  data-pjax='#right-content'>
                      <i class="fa fa-envelope"></i>
                      Message
                      <!-- <span class="badge pull-right">31</span> -->
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="<?php echo base_url()?>activity" class='pjax' data-pjax='#right-content'>
                      <i class="fa fa-list-ul"></i>
                      Activity
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="<?php echo base_url()?>favorite/me" class='pjax' data-pjax='#right-content'>
                      <i class="fa fa-star"></i>
                      Favorited Me
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="<?php echo base_url()?>viewed/me" class='pjax' data-pjax='#right-content'>
                      <i class="fa fa-eye"></i>
                      Viewed Me
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="<?php echo base_url()?>online" class='pjax' data-pjax='#right-content'>
                      <i class="fa"><img width="15" src="<?php echo base_url("public")?>/assets/img/icon-online-list.png" alt=""></i> 
                      Who's Online
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="<?php echo base_url()?>product/index/gift_code">
                      <i class="fa"><img width="15" src="<?php echo base_url("public")?>/assets/img/icon-gift-code.png" alt=""></i> 
                      Gift Code
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="<?php echo base_url()?>product">
                      <i class="fa"><img width="18" src="<?php echo base_url("public")?>/assets/img/Icon-upgrade.png" alt=""></i> 
                      Upgrade
                    </a>
                  </li>
                </ul>
                
                <!-- end of .list-group -->
              </section>
              
              <!-- end of #menu-dash.menu-left -->
              <section class="menu-left" id="dash-browse">
                <div class="panel panel-default panel-pmj">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <i class="fa fa-search fa-flip-horizontal"></i>
                      Browse
                    </h3>
                  </div>
                  <div class="panel-body">
                    <form class="form-horizontal" action="<?php echo base_url('browse')?>" role="form" method="get">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="gender">Gender</label>
                        <div class="col-sm-8">
                          <p>
                            <strong><?php $gender = getProfile(getSessionUser(),"gender"); echo ( $gender == "Male" || $gender == "male") ? "Female" : "Male" ?></strong>
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="Age">Age</label>
                        <div class="col-sm-8">
                          <select id="min-age" name="min-age">
                            <?php if($this->input->get("min-age") && ($this->input->get("min-age")!='-')): ?>
                              <?php for($x = 28; $x <= 90; $x++){?>
                              <option value="<?php echo $x?>" <?php if($this->input->get("min-age")==$x): echo "selected"; endif; ?>><?php echo $x?></option>
                              <?php } ?>  
                            <?php else: ?>
                              <option value="-">Min</option>
                              <?php for($x = 28; $x <= 90; $x++){?>
                              <option value="<?php echo $x?>"><?php echo $x?></option>
                              <?php } ?>  
                            <?php endif; ?>                       
                          </select>
                          <span>to</span>
                          <select id="max-age" name="max-age">
                            <?php if($this->input->get("max-age") && $this->input->get("max-age")!='-'): ?>
                               <?php for($x = 28; $x <= 90; $x++){?>
                              <option value="<?php echo $x?>"  <?php if($this->input->get("max-age")==$x): echo "selected"; endif; ?>><?php echo $x?></option>
                              <?php } ?>  
                            <?php else: ?>
                              <option value="-">Max</option>
                              <?php for($x = 28; $x <= 90; $x++){?>
                              <option value="<?php echo $x?>"><?php echo $x?></option>
                              <?php } ?>        
                            <?php endif; ?>                             
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="area-range">Area Range</label>
                        <div class="col-sm-8">
                          <select id="area-range" name="city">
                            <?php
                              foreach (getCity() as $key => $value) {
                                echo "<option value='$value->city_name' ".(($this->input->get("city")=="$value->city_name")? 'selected':"").">$value->city_name</option>";
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <hr>
                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                          <button class="btn btn-primary pull-right" type="submit">Search</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </section>
            </div>
