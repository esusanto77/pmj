    <script id="user-box-tpl" type="x-tmpl-mustache">
      <div class="col-sm-3 col-xs-6 user-online" id="box-{{ code_id }}">
        <a class="user-image show-user" data-user-id="{{ id }}" href="<?php echo base_url(); ?>profile/{{ code_id }}">
          <img alt="" class="avatar" onerror="this.src='http://placehold.it/138x138&text=no+image';" src="{{ filename_thumb }}">
          <h4 class="user-name">
            <span class="user-status active"></span>
            <span class="display-name">{{ code_id }}</span>
          </h4>
        </a>

        <div class="user-profile">
          <p style="height: 30px; margin-bottom: 5px;"></p>
          <hr>
          <ul class="user-action">
              <li>
                <a class="action-email" href="{{ link }}" data-id="{{ code_id}}">
                  <i class="fa fa-envelope"></i>
                </a>
              </li>
              <li class="btn-chat" data-id="{{ code_id }}" data-display-name="{{ code_id }}">
                <a class="action-message" href="javascript:void(0);">
                  <i class="fa fa-comment"></i>
                </a>
              </li>
              <li>
                <a class="action-favorite <?php if(checkActivity(getSessionUser(), $u->id) == 1){ echo "active";} ?> user_fav_{{id }}" href="javascript:void(0);" data-id="{{id }}">
                  <i class="fa fa-heart"></i>
                </a>
              </li>
            </ul>
        </div>
      </div>
    </script>