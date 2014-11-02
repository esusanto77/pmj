<?php $this->load->view("template/header");?>
      <div class="site-main" id="main">
        <div class="container">
          <div class="row">
          
          	<?php $this->load->view("template/left_nav");?>
            
         	 <div class="col-md-9 right-content" id="right-content">          

            <div class="chat-controll">
              <input type="hidden" class="chat-current-user">
              <input type="text" class='chat-name-from' placeholder="from"><br>
              <input type="text" class='chat-name-to' placeholder="to"><br>              
              <button class='btn-set-online'>sign in</button>
              <input type="text" class='chat-text' placeholder="text" style="display:none">
              <button class='btn-send-chat' style="display:none">send</button>
            </div>

            <div class="chat-list"></div>

            

            <!-- end of .right-content -->
          	</div>
        </div>
        
        <!-- end of .container -->
      </div>
    </div>
<?php $this->load->view("template/footer");?>