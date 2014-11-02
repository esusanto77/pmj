(function($){

var Notifications = {
  el: {},
  ref: {},
  code: {},

  myDays: ["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
  myMonth: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ],

  onload: function() { 
    setTimeout(function(){
      $(".loadingTopBoxChat").html('<span>No Chat Avaliable</span>');
      $(".loadingTopBoxActivity").html('<span>No Activity Avaliable</span>');
      $(".loadingTopBox").html('<span>No Message Avaliable</span>');
    },8000)
  },
  
  setupFbRef: function() {
    this.ref.main = new Firebase( firebase_root.userchat );
    this.ref.userId= this.ref.main.child('users/'+current_user.user_code_id);
    this.ref.userNotify = this.ref.main.child('users/'+current_user.user_code_id+'/notifications/');
    this.ref.userLastNotify= this.ref.userId.child('last_notification');
  },

  setupEl: function() {
    //console.log("notify.js :", root.base_url);
    this.el.$contentNotify = $('.dropdown-toggle');

    this.el.$notifyList = $('.list-notify');
    this.el.$msgList = $('.list-messages');

    this.el.$notifyListMobile = $('.list-notify-mobile');

    this.el.$notifyHeader = $('.notify-num');
    this.el.$messageHeader = $('.message-num');
    this.el.$chatHeader = $('.chat-num');

    this.el.$notifyBoxTpl = $('#notify-box-tpl').html();
    this.el.$notifyMsgBoxTpl = $('#notify-message-box-tpl').html();

    this.el.$notifyBoxMobTpl = $('#notify-box-mobile-tpl').html();
    this.el.$notifyMsgBoxMobTpl = $('#notify-message-box-mobile-tpl').html();

    this.el.$badgeActContent = this.el.$contentNotify.find('.notify-activity');
    this.el.$badgeMsgContent = this.el.$contentNotify.find('.notify-message');

    this.el.$notifyMobile = $('#rightbox');
    this.el.$messageMobile = $('.list-messages-wrap');
    this.el.$notifyMobile = $('.list-notify-wrap');
    this.el.$chatMobile = $('.list-chat-wrap');

    this.el.$notifyMobileActivity = $('.list-messages-wrap');
  },

  eventBinding: function() {
    /*this.el.$notifyMobile.bind("mousewheel",function(ev, delta) {
        var scrollTop = $(this).scrollTop();
        $(this).scrollTop(scrollTop-Math.round(delta * 20));
    });*/
    //this.el.$notifyMobileActivity.on('click','.item-mesage-mobile', $.proxy(this.eventReadMessageMobile, this));

  },

  checkNotifications: function(){
    var self = this;

    /*self.ref.userNotify.once('value', function(snapshot){
      var data = snapshot.val();
      var num = snapshot.numChildren();

      console.log(num, data);
    })*/

    self.ref.userNotify.on('child_added', function(snapshot){
      var data = snapshot.val();
      var name = snapshot.name();

      if(data){
        if (data.verb == 'favorite' || data.verb == 'unfavorite' || data.verb == 'like' || data.verb == 'viewed' ) {
          self.updateNotify(data);
          self.countNotify(name, data);
          self.eventReadNotify(name, data);
        } 
        else if(data.object.objectType == 'message'){
          self.updateMessage(data);
          self.countMessage(name, data);
          self.eventReadMessage(name, data);

          if(self.checkLengthMesage() == 0){
            self.el.$contentNotify.find('.notify-message .badge').remove();
            $('#rightbox').find('.notify-message').find('.badge').remove();
          }
        } else {
          console.log('Notify "objectType" undefined :', name);
        };
      }else{
        console.log('no data notifications');
      }
      

    });

    self.ref.userNotify.on('child_changed', function(snapshot){
      var data = snapshot.val();
      var lengthAct = self.checkLengthNotify();
      var lengthMsg = self.checkLengthMesage();
      if (data) {
        if (data.verb == 'favorite' || data.verb == 'unfavorite' || data.verb == 'like' || data.verb == 'viewed' ) {
          if (data.read == false ) {

            $('#notify-'+data._id).removeClass('read').addClass('unread');
            self.el.$badgeActContent.html('<span class="badge">'+ (lengthAct+1) +'</span>');
            self.el.$notifyHeader.html(lengthAct);
            
          } else {
            self.el.$badgeActContent.html('<span class="badge">'+ lengthAct +'</span>');
            self.el.$notifyHeader.html(lengthAct);
            if(lengthAct == 0){
              self.el.$contentNotify.find('.notify-activity .badge').remove();
              $('#rightbox').find('.notify-activity').find('.badge').remove();
            }
          };
        }
        else if(data.object.objectType == 'message'){
          if(data.read == false ) {

            $('#message-'+data.actor.displayName).removeClass('read').addClass('unread');
            self.el.$badgeMsgContent.html('<span class="badge">'+ (lengthMsg+1) +'</span>');
            self.el.$messageHeader.html(lengthMsg);
            
          } else {
            self.el.$badgeMsgContent.html('<span class="badge">'+ lengthMsg +'</span>');
            self.el.$messageHeader.html(lengthMsg);
            if(lengthMsg == 0){
              self.el.$contentNotify.find('.notify-message .badge').remove();
              self.el.$notifyMobile.find('.notify-message .badge').remove();
            }
          }
        };
      } else{
        console.log('no data notify to change');
      };
      
    });

    self.ref.userNotify.on('child_removed', function(snapshot){
      var data = snapshot.val();
      var lengthAct = self.checkLengthNotify();
      var lengthMsg = self.checkLengthMesage();
      if (data) {
        $('#notify-'+data._id).remove();
        if(self.el.$notifyList.find('li').length == 0){
          $('.loadingTopBoxActivity').show();
          $('.loadingTopBoxActivity').html('<span>No Notification</span>');
        }
      } else{
        console.log('no data notify to change');
      };
      
    });

  },

  pushLastNotify: function(){
    var timestamp = Math.round( new Date().getTime() / 1000 );
    this.ref.userNotify.on('child_added', function(snapshot){
      var notification = snapshot.val();
      console.log(notification, timestamp);
    })
  },

  /* activity notify */
  updateNotify: function(data){
    var self = this;
    var idPartner = self.checkIdUser(data.actor.id);
    if(data){

      data.published = self.getConvertTime(data.published);
      data.actor.id = idPartner;
      data.object.id = current_user.user_id;

      if(data.read == true){
        data.read = 'read';
      } else {
        data.read = 'unread';
      } 

      var notifyItem = Mustache.render( self.el.$notifyBoxTpl, data );
          $notifyItem = $(notifyItem.trim());

      var notifyItemMobile = Mustache.render( self.el.$notifyBoxMobTpl, data );
          $notifyItemMobile = $(notifyItemMobile.trim());

      $notifyItem.data( 'user_data', data );
      $notifyItemMobile.data( 'user_data', data );

        if( self.el.$notifyList.find('#notify-'+data._id).length > 0 ) {
          self.el.$notifyList.find('#notify-'+data._id).replaceWith( $notifyItem );
        } 
        else {
          $('.loadingTopBoxActivity').hide();
          self.el.$notifyList.prepend( $notifyItem ); 
          $('#rightbox').find('.list-notify-wrap').prepend( $notifyItemMobile );
        }
      
    }
  },

  checkIdUser: function(partner){
    var self = this;
    var idUser = '';
    self.ref.main.child('users').child(partner).once('value', function(snapshot){
      var data = snapshot.val();
      if (data == null) {
        console.log('something wrong with id');
        return false;
      } else{
        idUser = data.profile.id;
      };
      
    });
    return idUser;
  },

  countNotify: function(name, data){
    var self = this;
    if (data.read == 'unread') {

      var menuRight = $('#rightbox').find('.notify-activity');
      menuRight.html('<span style="position:absolute;right: 20px" class="badge pull-right">'+ self.checkLengthNotify() +'</span>');
      
      self.el.$badgeActContent.html('<span class="badge">'+ self.checkLengthNotify() +'</span>');
      self.el.$notifyHeader.html(self.checkLengthNotify());
    }
  },

  eventReadNotify: function(name, data){
    var self = this;
    $('#notify-'+data._id).hover(function(){
      $('#notify-'+data._id).removeClass('unread').addClass('read');
      self.ref.userNotify.child(name).update({read:true});
    });

    $('#notify-mobile-'+data._id).hover(function(){
      $('#notify-mobile-'+data._id).removeClass('unread').addClass('read');
      self.ref.userNotify.child(name).update({read:true});
      $('#rightbox').find('.notify-activity .badge').html((self.checkLengthNotify()-1));
    });
  },

  checkLengthNotify: function(){
    var self = this;
    return self.el.$notifyList.find('.unread').length;
  },

 /* end activity */


/* message notify */
  updateMessage: function(data){
    if(data){

      data.published = this.getConvertTime(data.published);
      data.actor.id = (data.actor.id).split(':').slice(2).join(':');

      var finalText = "";
      var textOrigin = data.object.content.replace(/\s+/g, ' ');
      var textSplit = textOrigin.split(' ');
      var numberOfWords = textSplit.length;

      var i=0;
      var wordLimit = 12;
      if(numberOfWords > wordLimit){
        for(i=0; i<wordLimit; i++)
        finalText = finalText+" "+ textSplit[i]+" ";
        data.object.content = finalText+"...";
      } else{
        data.object.content = data.object.content;
      } 

      if(data.read == true){
        data.read = 'read';
      } else {
        data.read = 'unread';
      } 

      var msgItem = Mustache.render( this.el.$notifyMsgBoxTpl, data );
          $msgItem = $(msgItem.trim());


      var msgMobileItem = Mustache.render( this.el.$notifyMsgBoxMobTpl, {
        idNotif : data._id,
        read : data.read,
        displayName : data.actor.displayName,
        subject: data.object.subject,
        avatar: data.actor.image.url,
        url : data.object.url,
        published: data.published

      });

      $msgItem.data( 'message_data', data );
      
      if( this.el.$msgList.find('#message-'+data.actor.displayName).length > 0 ) {
        this.el.$msgList.find('#message-'+data.actor.displayName).replaceWith( $msgItem );

        if ($('#rightbox').find('[data-from="'+data.actor.displayName+'"]').length > 0) {
          $('#rightbox').find('[data-from="'+data.actor.displayName+'"]').replaceWith( msgMobileItem );
        };

      } 
      else {
        $('.loadingTopBox').hide();
        this.el.$msgList.prepend( $msgItem );  
        $('#rightbox').find('.list-messages-wrap').prepend( msgMobileItem );      
      }
    }
  },

  countMessage: function(name, data){
    var self = this;
    
    var menuRightMessage = $('#rightbox').find('.notify-message');
    menuRightMessage.html('<span style="position:absolute;right: 20px" class="badge pull-right">'+ self.checkLengthMesage() +'</span>');
    
    self.el.$badgeMsgContent.html('<span class="badge">'+ self.checkLengthMesage() +'</span>');
    self.el.$messageHeader.html(self.checkLengthMesage());

    //console.log(self.checkLengthNotifyMobile());
  },

  eventReadMessage: function(name, data){
    var self = this;
    var dataName = data.actor.displayName;

    self.ref.userNotify.on("child_added", function(snapshot){
        var notify = snapshot.val();
        var notifyID = snapshot.name();

        $('#message-'+dataName).click(function(e){
          var $listbox = $(e.currentTarget).closest('#message-'+dataName),
          linkMsg = $listbox.data('url');
          
          if(dataName == notify.actor.displayName){
            if (notify.object.objectType === 'message') {

              self.ref.userNotify.child(notifyID).update({read:true}, function(error, status){
                window.location.href = linkMsg;
              });

              $('#message-'+dataName).removeClass('unread').addClass('read');
            };
          }
        });

        $('[data-from="'+dataName+'"]').click(function(e){
          var $listbox = $(e.currentTarget).closest('.item-mesage-mobile'),
              linkMsg = $listbox.data('url');
              if (notify.read == false) {
                self.ref.userNotify.child(notifyID).update({read:true}, function(error, status){
                  window.location.href = linkMsg;
                });
              } else{
                window.location.href = linkMsg;
              };
        });
   });

  },

  checkLengthNotifyMobile: function() {
    var length = $('#rightbox').find('.unread').length;
    return length;
  },

  checkLengthMesage: function(){
    var self = this;
    return self.el.$msgList.find('.unread').length;
  },

/* end message */

/* tools */
  getConvertTime: function(ts){
    return moment.unix(ts).format('MMMM-D-YYYY, h:mm A');
  },


/* initialization */
  init: function() {
    this.setupFbRef();
    this.setupEl();
    this.eventBinding();
    this.onload();
    this.checkNotifications();
  }

};

/* when document ready */ //run init()
$(document).ready(function(){
  Notifications.init();
});

})(jQuery);
