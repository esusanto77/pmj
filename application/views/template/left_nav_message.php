<div class="col-md-3 left-content visible-lg visible-md">
  <section class="user-profile-wrapper clearfix mb15">
    <a href="<?php echo base_url()?>message/create" data-pjax='#right-content' class="btn btn-primary btn-compose-message ">New Message</a>
  </section>
  <section class="menu-left" id="dash-nav">
    <ul class="list-group">
      <li class="list-group-item">
        <a href="<?php echo base_url()?>message" class="btn-message-inbox">Inbox 
        <?php if(getMessageCount(getSessionUser()) > 0):?>
          <span class="badge pull-right"><?php echo getMessageCount(getSessionUser()) ?></span>
        <?php endif; ?>
        </a>
      </li>
      <li class="list-group-item">
        <a href="<?php echo base_url()?>message/sent" class="btn-message-sent">Sent</a>
      </li>
      <!-- <li class="list-group-item">
        <a href="<?php echo base_url()?>message/archives" class="pjax" data-pjax='#right-content'>Archives</a>
      </li> -->
    </ul>
  </section>
</div>