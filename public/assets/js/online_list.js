(function($){

var OnlineList = {
  el: {},
  ref: {},

  onload: function() { 
    setTimeout(function(){
      $(".loadingUserOnline").html('<span>No Online User</span>');
    },5000)
  },

  setupFirebaseRef: function() {
    this.ref.main = new Firebase( firebase_root.userchat );
    this.ref.userList = this.ref.main.child('users');
    this.ref.userCurrent = this.ref.userList.child(current_user.user_code_id);
    this.ref.userChannelList = this.ref.userCurrent.child('channel');
    this.ref.myUser = this.ref.userCurrent.child('profile');
    //console.log(current_user.subscription);

  },

  setupElements: function() {
    //console.log("online_list.js :", root.base_url);
    this.el.$userOnlinelist = $('#online-user');
    this.el.$userOnlineBoxTpl = $('#user-box-tpl').html();
    this.el.$messageBtn = $('.action-email');
  },

  eventBinding: function() {
    this.el.$userOnlinelist.on('click', 'li.btn-chat', $.proxy(this.setupChatChannel, this));
  },

  checkSubscript: function(verb){
    //console.log("your subscription : ", current_user.subscription)

    if(verb==='message'){
      if ((current_user.subscription == 'false' || current_user.subscription == '') && config_settings.message==='false') {
        $('#warning').modal('toggle');
      }
    }else{  
      if ((current_user.subscription == 'false' || current_user.subscription == '') && config_settings.chat==='false') {
        $('#warning').modal('toggle');
      }
    }
  },

  setupChatChannel: function(e) {    
    e.preventDefault();
    var self = this,
        $chatitem = $(e.currentTarget),
        partnerId = $chatitem.data('id'),
        senderChannel = self.ref.userChannelList.child(partnerId),
        partnerChannel = self.ref.userList.child(partnerId).child('channel').child(current_user.user_code_id);
        

    if (current_user.subscription == 'false'  && config_settings.chat==='false') {
      $('#warning').modal('toggle');
    } else {
      senderChannel.once("value", function(snapshot){
        var data = snapshot.val();
        if (!data) {
          senderChannel.set({
            box_chat: 'open',
            to: partnerId,
            ts: self.getTimeStamp()
          });
          console.log("no channel sender (create)");
        }else{
          if (data.box_chat == 'popup') {
            console.log("ALREADY POPUP :", partnerId);
            window.open(root.base_url + 'chat/popup/'+partnerId, 'win_'+partnerId).focus();
            /*senderChannel.set({
              box_chat: 'open',
              to: partnerId,
              ts: self.getTimeStamp()
            });*/
          } else {
            senderChannel.set({
              box_chat: 'open',
              to: partnerId,
              ts: self.getTimeStamp()
            });
            // console.log("OPEN CHATBOX :", partnerId);
          };
        };
      });
    }
  },

  checkUserOnline: function() {
    var self = this;
    
    // On child added
    self.ref.userList.on('child_added', function(snapshot) {
      var dataUser = snapshot.val()
      var user = dataUser.profile;

      if (user==undefined) return false;
      if(user.status === 'online' ||  user.status === 'idle' || user.status === 'away'){
        if (current_user.user_gender !== user.gender && current_user.user_gender!=='' && current_user.user_gender!==null && user.gender!=='' && user.gender!==null) {
          self.updateUserOnline( user );
          self.checkFav(user);
          self.checkWord(user);

          $('.action-email').on('click', function(){
            self.checkSubscript('message');
          });
          //console.log("added : ", user.code_id, user.status);
        };
      } else {
        $('#box-'+ user.code_id).remove();
      }

    });

    // On child changed
    self.ref.userList.on('child_changed', function(snapshot) {
      var dataUser = snapshot.val()
      var user = dataUser.profile;

      if (user==undefined) return false;
      if(user.status === 'online' || user.status === 'idle' || user.status === 'away'){
         if (current_user.user_gender !== user.gender && current_user.user_gender!=='' && current_user.user_gender!==null && user.gender!=='' && user.gender!==null) {
          self.updateUserOnline( user );
          self.checkFav(user);
          self.checkWord(user);

          $('.action-email').on('click', function(){
            self.checkSubscript('message');
          });
          
          //console.log("change : ", user.code_id, user.status);
        }
      } else {
        $('#box-'+ user.code_id).remove();
      }


    });

    // On child removed
    self.ref.userList.on('child_removed', function(snapshot) {
      var dataUser = snapshot.val()
      var user = dataUser.profile;

      if (user==undefined) return false;
      $('#box-'+ user.code_id).remove();
    });

  },
 
  checkFav: function(dataUser){
    $.ajax({
      url: root.base_url + 'api/get_activity/'+dataUser.id+'/'+'favorite',
      type: 'get',
      success: function (data) {
        //console.log(data);
        if (data == 'favorite') {
          $('#box-'+dataUser.code_id).find('.action-favorite').addClass('active');
        } else {
          $('#box-'+dataUser.code_id).find('.action-favorite').removeClass('active');
        };
      }
    });
  },

  checkWord: function(dataUser){
    $.ajax({
      url: root.base_url + 'api/get_profileUser/'+dataUser.id,
      type: 'get',
      success: function (data) {
        if(!data){
          console.log('not found in database');
        }else{
          var words = data._80;
          if (words == '') {
            $('#box-'+data.code_id+' .user-profile').find('p').html('<center>No another info</center>');
          }else{
            $('#box-'+data.code_id+' .user-profile').find('p').text(words.length>=40 ? words.substr(0, 40)+". . ." : words);
            //console.log("3 things : ", words);
          };
        }  
      }
    });
  },

  updateUserOnline: function(user) {
    if( user ) {

      if (current_user.subscription == 'false' && config_settings.message==='false') {
        user.link = 'javascript:void(0);';
      } else {
        user.link = root.base_url + "message/to/"+user.code_id;
      }

      if( user.code_id == current_user.user_code_id ) return;

      if (user.filename_thumb == ''){
        user.filename_thumb = 'http://placehold.it/138x138&text=no+image';
      } else if(user.filename_thumb == 'null') {
        user.filename_thumb = 'http://placehold.it/138x138&text=no+image';
      } else {;
        user.filename_thumb = user.filename_thumb;
      }
      
      var userItem = Mustache.render( this.el.$userOnlineBoxTpl, user );
          $userItem = $(userItem.trim());


      $userItem.data( 'user_data', user );


      if( this.el.$userOnlinelist.find('#box-'+user.code_id).length > 0 ) {
        this.el.$userOnlinelist.find('#box-'+user.code_id).replaceWith( $userItem );
        $('.loadingUserOnline').hide();
      } else {
        this.el.$userOnlinelist.find('#online-list-content').prepend( $userItem );
        $('.loadingUserOnline').hide();
      }

    }
  },

  getTimeStamp: function() {
    return Math.round( new Date().getTime() / 1000 );
  },

  init: function() {
    // Check if chat section exists or Firebase not loaded
    if( !$('.chat-section').length || typeof Firebase == 'undefined' || typeof current_user == 'undefined' ) {
      return;
    }
    
    this.onload();
    this.setupFirebaseRef();
    this.setupElements();
    this.eventBinding();
    this.checkUserOnline();

  }

};

$(document).ready(function(){
  OnlineList.init();
});

})(jQuery);