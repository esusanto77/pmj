(function($){

var FirebaseChat = {
  firebaseRoot: 'https://blinding-fire-5604.firebaseio.com/chatapp/',
  currentStatus: 'online',
  el: {},
  
  // Set idle and away timeout
  idleTimeout: 1 * 10 * 1000,
  awayTimeout: 10 * 60 * 1000,
  idleTimeoutID: null, 
  awayTimeoutID: null,

  // Containt data reference for firebase
  ref: {},

  // global refs for channels and chats
  userChannels: {},
  userChats: {},

  // Month and days name
  myDays: ["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
  myMonth: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ],

  /**
   * Cache element variable
   */
  setupElements: function() {
    this.el.$chatSection = $('.chat-section');
    this.el.$chatlist = $('.chat-list');
    this.el.$chatboxlist = $('.chatbox-list');
    this.el.$chatboxTpl = $('#chatbox-tpl').html();
    this.el.$userListItemTpl = $('#user-list-item').html();
    this.el.$chatMessageTpl = $('#chatbox-message').html();
  },

  /**
   * Event Binding
   */
  eventBinding: function() {
    this.el.$chatSection.on('click', '.chat-module-header', $.proxy(this.toggleMinimized, this));
    this.el.$chatlist.on('click', 'li', $.proxy(this.setupChatChannel, this));
    this.el.$chatboxlist.on('keydown', '.chatbox-textarea', $.proxy(this.sendChatMessage, this));
    this.el.$chatboxlist.on('click', '.chat-module-header .close', $.proxy(this.closeChatbox, this));
  },

  /**
   * Toggle minimized mode
   */
  toggleMinimized: function(e) {
    e.preventDefault();
    var $chatModule = $(e.currentTarget).closest('.chat-module'),
        $chatlist = $('.chat-list')
        $chatboxlist = $('.chatbox-list');
    
    $chatModule.toggleClass('minimized');

    // checking chat list minimize
    if( $chatlist.hasClass('minimized') ){
      $chatboxlist.removeAttr('style');
    } else {
      $chatboxlist.css('margin-right', '260px');
    }

    // If chatbox
    if( $chatModule.hasClass('chat-box') ) {
      var chatId = $chatModule.data('id'),
          chatboxMode;

      if( $chatModule.hasClass('minimized') ) {
        chatboxMode = 'minimized';
      } else {
        chatboxMode = 'open';
      }
      this.ref.userChannelList.child( chatId ).update({
        box_chat: chatboxMode
      });
    }
  },

  /**
   * On chat list item clicked
   */
  setupChatChannel: function(e) {    
    e.preventDefault();
    var self = this,
        $chatitem = $(e.currentTarget),
        partnerId = $chatitem.data('id'),
        senderChannel = this.ref.userChannelList.child( partnerId );
        partnerChannel = this.ref.main.child('channel').child( partnerId ).child( current_user.user_id );

    senderChannel.set({
      box_chat: 'open',
      to: partnerId,
      ts: self.getTimeStamp()
    });

    partnerChannel.set({
      box_chat: 'ready',
      from: current_user.user_id,
      ts: self.getTimeStamp()
    });

    this.createOrUseChat( partnerId, false );
  },

  /**
   * Get current timestamp
   */
  getTimeStamp: function() {
    return Math.round( new Date().getTime() / 1000 );
  },

  /**
   * Set user status
   */
  setUserStatus: function( status ) {
    var self = this;
    this.currentStatus = status;

    var data = {
      id: current_user.user_id,
      status: self.currentStatus,
      ts: self.getTimeStamp(),
      username: current_user.user_name,
      display_name: current_user.display_name,
      on: 'connect',
      thumbnail: current_user.thumb
    };

    this.ref.myUser.set( data );
  },

  /**
   * Setup Firebase Data Reference
   */
  setupFirebaseRef: function() {
    this.ref.main = new Firebase( this.firebaseRoot );
    this.ref.userList = this.ref.main.child('users');
    this.ref.userChannelList = this.ref.main.child('channel').child( current_user.user_id );
    this.ref.myUser = this.ref.userList.child( current_user.user_id );
  },

  /**
   * Determine if user is away or idle
   */
  checkIdleAwayStatus: function() {
    var self = this;
    this.idleTimeoutID = setTimeout(function(){
      self.setUserStatus('away');
    }, self.idleTimeout);
  },

  /**
   * Check user list data
   */
  monitorUserList: function() {
    var self = this;

    // Only run this once, on connected and on disconnected
    this.ref.userList.once('value', function(snapshot){
      if( snapshot.val() ) {
        // Disconnected from firebase
        self.ref.myUser.onDisconnect().update({
          id: current_user.user_id,
          status: 'offline',
          ts: self.getTimeStamp(),
          username: current_user.user_name,
          display_name: current_user.display_name,
          on: 'connect',
          thumbnail: current_user.thumb
        });

        self.setUserStatus( 'online' );
      } else {
        self.setUserStatus( self.currentStatus );
      }
    });

    // On child added
    this.ref.userList.on('child_added', function(snapshot) {
      var user = snapshot.val();
      self.updateUserList( user );
    });

    // On child changed
    this.ref.userList.on('child_changed', function(snapshot) {
      var user = snapshot.val();
      self.updateUserList( user );
    });

    // On child removed
    this.ref.userList.on('child_removed', function(snapshot) {
      var user = snapshot.val();
      this.el.$chatlist.find('[data-id="'+ user.id +'"]').remove();
    });
  },

  /**
   * Check user channel
   */
  monitorUserChannel: function() {
    var self = this;

    // On child added
    this.ref.userChannelList.on('child_added', function(snapshot) {
      var channel = snapshot.val(),
          partner = channel.from ? channel.from : channel.to;

      if( channel.box_chat == 'open' ) {
        self.createOrUseChat( partner, false );
      } else if( channel.box_chat == 'minimized' ) {
        self.createOrUseChat( partner, true );
      }
    });

    // on child changed
    this.ref.userChannelList.on('child_changed', function(snapshot) {
      var channel = snapshot.val(),
          partner = channel.from ? channel.from : channel.to;

      if( channel.box_chat == 'open' ) {
        self.createOrUseChat( partner, false );
      }
    });
  },

  /**
   * Update user list DOM
   */
  updateUserList: function(user) {
    if( user ) {
      // Do not show if user.id is same with current_user.user_id
      if( user.id == current_user.user_id ) return;

      var userItem = Mustache.render( this.el.$userListItemTpl, user );
          $userItem = $(userItem.trim());

      $userItem.data( 'user_data', user );

      // Check if user list item already appended
      if( this.el.$chatlist.find('[data-id="'+ user.id +'"]').length > 0 ) {
        this.el.$chatlist.find('[data-id="'+ user.id +'"]').replaceWith( $userItem );
      }

      // not appended yet
      else {
        this.el.$chatlist.find('ul').prepend( $userItem );
      }
    }
  },

  /**
   * Either create or use existing chatbox
   */
  createOrUseChat: function( partner, isMinimized ) {
    var party = [ current_user.user_id, partner ].sort(),
        self = this,
        newItems = false,
        previousChats;        

    // If reference to chat not exists
    if( !this.userChats[partner] ) {
      this.userChats[partner] = this.ref.main.child('chat').child(party[0] + '-' + party[1]);

      // On chat
      this.userChats[partner].on('child_added', function(snapshot){
        var dataChat = snapshot.val(),
            idChat = snapshot.name();

        if( !newItems ) return;

        self.addMessageToChatbox( partner, dataChat, true );
      });
    }

    this.userChats[partner].once('value', function(snapshot){
      newItems = true;
      previousChats = snapshot;

      // If chatbox is not exists
      if( !self.isChatboxExists( partner ) ) {
        self.createChatBox( partner );
        $('#chatbox_' + partner).find('.chatbox-textarea').focus();

        var counter = 0,
            numOfChild = previousChats.numChildren() - 1;

        previousChats.forEach(function(element) {
          var chating = element.val();

          // If at the end of item, scroll down
          if( numOfChild == counter ) {
            self.addMessageToChatbox(partner, chating, true);
          } else {
            self.addMessageToChatbox(partner, chating, false);
          }
          counter++;
        });
      }

      else {
        self.createChatBox( partner );
        $('#chatbox_' + partner).find('.chatbox-textarea').focus(); 
      }
    
      // Is minimized
      if( isMinimized ) {
        $('#chatbox_' + partner).addClass('minimized');
      }

    });
  },

  /**
   * Create Chat Box
   */
  createChatBox: function( chatid, data ) {    
    // Check if chatbox exists
    if( $('#chatbox_' + chatid).length > 0 ) {
      $('#chatbox_' + chatid).show();
    }

    // chatbox not exists
    else {
      var user_data = this.getUserData( chatid ),
          chatbox = Mustache.render( this.el.$chatboxTpl, { 
            id: chatid, 
            display_name: user_data.display_name 
          });

      this.el.$chatboxlist.append( chatbox );
    }
  },

  /**
   * Close Chatbox
   */
  closeChatbox: function( e ) {
    e.preventDefault();
    var $chatbox = $(e.currentTarget).closest('.chat-box'),
        chatId = $chatbox.data('id');        

    $chatbox.hide();
    this.ref.userChannelList.child( chatId ).update({
      box_chat: 'close'
    });
  },

  /**
   * Send Chat Message
   */
  sendChatMessage: function( e ) {
    if( e.keyCode == 13 && e.shiftKey == 0 ) {
      var self = this,
          $textarea = $(e.currentTarget),
          message = $textarea.val(),
          chatId = $textarea.closest('.chat-box').data('id');

      // Clean up message
      message = message.replace(/^\s+|\s+$/g,"");

      // Empty textarea
      $textarea.val('');

      // Push Chat
      if( message != '' ) {
        this.userChats[chatId].push({
          thumbnail: current_user.thumb,
          from: current_user.user_id,
          to: chatId,
          message: message,
          ts: self.getTimeStamp(),
          display_name: current_user.display_name
        });

        var senderChannel = this.ref.userChannelList.child( chatId ),
            partnerChannel = this.ref.main.child('channel').child( chatId ).child( current_user.user_id );

        senderChannel.set({
          box_chat: 'open',
          to: chatId,
          ts: self.getTimeStamp()
        });

        partnerChannel.set({
          box_chat: 'open',
          from: current_user.user_id,
          ts: self.getTimeStamp()
        });
      }

      return false;
    }
  },

  /**
   * Check if chatbox exists
   */
  isChatboxExists: function( id ) {
    return $('#chatbox_' + id).length > 0;
  },

  /**
   * Add message to chatbox
   * @param Int partner     Partner ID
   * @param Object chat     Chat data object
   * @param Boolean scrollDown Make content animate scroll to the bottom?
   */
  addMessageToChatbox: function( partner, chat, scrollDown ) {
    // Change display name to me if chat from equal to current user id
    if( chat.from == current_user.user_id ) {
      chat.display_name = 'me';
      chat.classname = 'self';
    }

    var chatMessage = Mustache.render( this.el.$chatMessageTpl.trim(), chat ),
        $chatbox = this.el.$chatboxlist.find('#chatbox_' + partner);
    
    $chatbox.find('ul').append( chatMessage );

    if( scrollDown ) {
      $chatbox.find('.chat-module-content').animate({scrollTop: $chatbox.find('ul').height()});
    }
  },

  /**
   * Get user data
   */
  getUserData: function( id ) {
    if( this.el.$chatlist.find('[data-id="'+ id +'"]').length > 0 ) {
      return this.el.$chatlist.find('[data-id="'+ id +'"]').data('user_data');
    } else {
      return current_user;
    }
  },

  /**
   * Initialization
   */
  init: function() {
    // Check if chat section exists or Firebase not loaded
    if( !$('.chat-section').length || typeof Firebase == 'undefined' || typeof current_user == 'undefined' ) {
      return;
    }

    this.setupElements();
    this.eventBinding();
    this.setupFirebaseRef();
    // this.checkIdleAwayStatus();
    this.monitorUserList();
    this.monitorUserChannel();
  }
};

$(document).ready(function(){
  FirebaseChat.init();    

  $(".btn-chat").on("click",function(e){

    FirebaseChat.setupChatChannel(e)
  })
});

})(jQuery);
