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
                          Recent Chat
                        </h3>                        
                      </div>
                      <div class="panel-body clearfix">
                        <ul class="list-activities" id="recent-chat-content">
                          
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

      <script id="recent-chat-item" type="x-tmpl-mustache">
        <li class="recent-list" data-id="{{ partner_id }}" id="chat-recent-{{ partner_id }}" data-date="{{ ts }}">
          <div class="user-image pull-left">
            <a class="user-image show-user" data-user-id="{{ id }}" href="<?php echo base_url() ?>profile/{{ partner_id }}">
              <img alt="" class="avatar" onerror="this.src='http://placehold.it/241x241&text=no+image';" src="{{ thumbnail }}">
            </a>
          </div>
          <div class="user-activity">
            <span class="pull-left">{{ partner_id }}</span>
            <span class="pull-right" style="font-size: 11px;">{{ timestamp }}</span>
          </div><br/>
          <div>
            <p class="btn-chat">{{ chats }}</p>
          </div>
        </li> 
      </script>

      <script src="<?php echo base_url()?>public/assets/js/chat/chat_recent.js"></script>

<?php $this->load->view("template/footer");?>