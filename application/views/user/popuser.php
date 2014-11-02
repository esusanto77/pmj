<div  class="popuser modal fade" id="popuser" role="dialog" tabindex="-1">      
<div class="popuser-dialog modal-dialog">
          <div class="popuser-content modal-content">
            <div class="popuser-body">
            
              <div class="popuser-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
                <div class="popup-bg">
                  <img alt="" class="avatar-bg" src="<?php echo base_url()?>/public/assets/img/dummy/bg-user-popup.jpg">
                </div>
                <div class="popuser-name-wrap">
                  <div class="popuser-avatar pull-left">
                    <img alt="" class="avatar" src="<?php echo base_url()?>/public/assets/img/dummy/user.jpg">
                  </div>
                  <div class="popuser-name white">
                    <h3 class="name"></h3>
                    <span class="age">28 years</span>
                    <span class="city">Jakarta</span>
                  </div>
                </div>
                
                <!-- end of .popuser-name -->
                <div class="popuser-action clearfix">
                  <ul class="user-action pull-left">
                    <li>
                      <a class="action-email" href="#">
                        <i class="fa fa-envelope"></i>
                      </a>
                    </li>
                    <li>
                      <a class="action-message" href="#">
                        <i class="fa fa-comment"></i>
                      </a>
                    </li>
                    <li>
                      <a class="action-favorite" href="#">
                        <i class="fa fa-heart"></i>
                      </a>
                    </li>
                  </ul>
                  
                  <!-- end of .user-action -->
                  <a class="view-full-profile pull-right" href="#">View Full Profile</a>
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


<script>
  $("#popuser").modal("toggle");  
</script>