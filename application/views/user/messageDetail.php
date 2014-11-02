<?php $this->load->view("template/header");?>
  <div class="site-main" id="main">
    <div class="container">
      <div class="row">
      
        <?php $this->load->view("template/left_nav_message");?>

        <!-- end of .left-content -->
                    <div class="col-md-9 right-content" id="right-content">
              <section class="user-messages" id="user-messages">
                <div class="panel panel-default panel-pmj panel-messages-list">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-md-6">
                        <form class="search-messages has-feedback search-messages-id">
                          <input class="form-control" type="text">
                          <span class="fa fa-search form-control-feedback"></span>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- end of .panel-heading -->
                  
                  <div class="panel-body">
                    <div class="message-detail-header">
                      <h4 class="message-detail-title"><?php echo $msg[0]->msg_subject?></h4>
                      <div class="message-detail-action">
                       <!--  <a href="#">Mark as spam</a> -->
                         <a href="#" id="delIdMessageButton">Delete</a>
                      </div>
                    </div>
                     <input class="subject-message" type="text" value="<?php echo $code; ?>" hidden>
                    <ul class="list-unstyled user-messages-list">
                      <?php foreach($msg as $m):?>                        
                      <li class="msg-<?php if(getSessionUser() == $m->msg_from){ echo "from"; } else { echo "to"; }?>" style="padding:10px">
                        <div class="row">
                           <div class="message-checkbox col-md-1">
                              <input type="checkbox" value="<?php echo $m->msg_id; ?>" name="delIdMessage[]" class="delIdMessage"/>
                           </div>

                          <div class="message-sender col-md-4">
                            <img alt="" onerror="this.src='http://placehold.it/241x241&text=no+image';" class="avatar" src="<?php echo getAvatarPhoto($m->msg_from)?>">
                            <div class="message-metadata">
                              <span class="message-sender-name"><?php echo $m->code_id?></span>
                              <time class="message-date" style='color:#73767B; font-size:11px;'><?php echo date("d M Y, h:m",strtotime($m->msg_date))?></time>
                            </div>
                          </div>
                          
                          <div class="message-text col-md-7">
                            <p><?php echo word_limiter($m->msg_content,140)?></p>
                          </div>

      
                        </div>
                       
                      </li>
                     <?php  endforeach; ?>
                    </ul>
                    <!-- end of .user-messages-list -->
                    <form class="send-message row" id="msg-formReply" method="post">
                      <div class="col-md-8 col-md-offset-4">
                        <label>Reply</label>                        
                        <input type="hidden" id="msg-to" value="<?php echo $to?>" name="msg-to">
                        <input type="hidden" id="msg-to-code" value="<?php echo $to_code_id?>" name="msg-to-code">
                        <input type="hidden" id="msg-subject" value="<?php echo $msg[0]->msg_subject?>" name="msg-subject">
                        
                        <textarea class="form-control" id="msg-content" rows="5" name="msg-content"></textarea>
                        <span id="message-loading"></span>
                        <input class="btn btn-green" type="submit" name="submit" value="Send">
                      </div>
                    </form>
                  </div>
                  
                </div>
              </section>
              <!-- end of #user-messages -->
            </div>


       
                
        <!-- end of .right-content -->
      </div>
    </div>
    
    <!-- end of .container -->
  </div>

  <div id='messageTemplate' style="display:none">
    <li style="padding:10px" >
      <div class="row">

        <div class="message-checkbox col-md-1">
        </div>
        
        <div class="message-sender col-md-4">
          <img alt="" onerror="this.src='http://placehold.it/241x241&text=no+image';" class="avatar" src="<?php echo getAvatarPhoto(getSessionUser())?>">
          <div class="message-metadata">
            <span class="message-sender-name"></span>
            <time class="message-date" style='color:#73767B; font-size:11px;'></time>
          </div>
        </div>
        
        <div class="message-text col-md-7">
          <p></p>
        </div>


      </div>
    </li>
    <!-- <li>
      <div class="row">
        <div class="message-sender col-md-4">                            
          <img class="message-avatar" src="#" alt="avatar" width=100 height=100>
          <div class="message-metadata">
            <span class="message-sender-name"></span>
            <time class="message-date"></time>
          </div>
        </div>        
        <div class="message-text col-md-8">
          <p></p>
        </div>
      </div>
    </li> -->
  </div>
<?php $this->load->view("template/modal_message");?>
<?php $this->load->view("template/footer");?>