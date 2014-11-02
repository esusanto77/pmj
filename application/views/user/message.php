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
                    <h3 class="panel-title"><?php echo $title; ?></h3>
                  </div>
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-md-6">
                        <form class="search-messages has-feedback  search-messages-subject">
                          <input class="form-control" type="text">
                          <span class="fa fa-search form-control-feedback"></span>
                        </form>
                      </div>
                      <div class="col-md-6">
                          <div class="message-index-header">
                          <div class="message-index-action">
                           <!--  <a href="#">Mark as spam</a> -->
                            <a href="#" id="delMessageSubjectButton">Delete</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end of .panel-heading -->
                  
                  <div class="panel-body">
                      <input class="subject-message-index" type="text" value="<?php echo $subjectFor; ?>" hidden>
                    <ul class="list-unstyled user-messages-list">
                      <?php  foreach($message as $m):?>
                      <li>
                        <div class="row"><div class="message-checkbox col-md-1">
                            <input type="checkbox" value="<?php echo $m->msg_code; ?>" name="delMessageSubject[]" class="delMessageSubject"/>
                          </div>
                          <div class="message-sender col-md-4">
                            <img alt="" onerror="this.src='http://placehold.it/241x241&text=no+image';" class="avatar" src="<?php echo getAvatarPhoto($m->msg_from)?>">
                            <div class="message-metadata">
                              <span class="message-sender-name"><?php echo $m->code_id?></span>
                              <time class="message-date" style='color:#73767B; font-size:11px;'><?php echo date("d M Y, h:m",strtotime($m->msg_date))?></time>
                            </div>
                          </div>
                          
                          <div class="message-text col-md-7">
                            <h4 class="message-title"><a href="<?php echo base_url('message/read/'.$m->msg_code)?>" class="click-detail-message"><?php echo $m->msg_subject?></a></h4>
                            <p><?php echo word_limiter($m->msg_content,140)?></p>
                          </div>

                          

                        </div>
                      </li>
                    <?php endforeach; ?>
                    </ul>
                    <!-- end of .user-messages-list -->
                  </div>
                  
                  <div class="clearfix">
                    <ul class="pagination">
                     <?php echo $pagination; ?>
                    </ul>
                  </div>
                </div>
              </section>
          <!-- end of .bottom-area-wrapper -->
        </div>
                
        <!-- end of .right-content -->
      </div>
    </div>
    <?php $this->load->view("template/modal_message");?>
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
        
        <div class="col-md-7">
           <h4 class="message-title"></h4>
           <div class="message-text"></div>
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
<?php $this->load->view("template/footer");?>