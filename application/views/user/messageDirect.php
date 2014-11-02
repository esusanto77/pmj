<?php $this->load->view("template/header");?>
  <div class="site-main" id="main">
    <div class="container">
      <div class="row">
      
        <?php $this->load->view("template/left_nav_message");?>

        <!-- end of .left-content -->
        <div class="col-md-9 right-content" id="right-content">
          
          <form id="msg-formCompose" role="form" method="post">
              <div class="form-group clearfix">
                <!-- <select id="select-movie" class="select-user" placeholder="Find a movie...">
                  <option value="s">s</option>
                </select> -->
                <label for="to">To</label>
                <input type="text" width="100px" class="form-control" value="<?php echo $code_id ?>" disabled="true" style="width:120px">
                <input type="hidden" id="msgToId" value="<?php echo $to?>"> 
                <input type="hidden" id="msgToCodeId" value="<?php echo $to_code_id?>">            
                <input type="hidden" id="msg-from" value="<?php echo getSessionUser()?>">
              </div>
              <div class="form-group">
                <label for="subject">Subject</label><br>
                <input type="text" id="msg-subject" class="form-control" name="msg-subject">
              </div>
              <div class="form-group create-message-subject-error"></div>
              <div class="form-group">
                <label for="content">Message</label> <br>
                <textarea id="msg-content" cols="40" rows="5" class="form-control" name="msg-content"></textarea>              
              </div>
              <div class="form-group create-message-content-error"></div>
              <div class="form-group">
                <input type="submit" class="msg-submitCompose btn btn-primary" value="Send" name="submit">
                <span id='msg-loading'></span>
              </div>
          </form>


        </div>
                
        <!-- end of .right-content -->
      </div>
    </div>
    
    <!-- end of .container -->
  </div>
<?php $this->load->view("template/footer");?>