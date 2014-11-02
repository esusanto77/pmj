(function($){

var RecentChat = {
  el: {},
  ref: {},
  recentChatting:{},

  myDays: ["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
  myMonth: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ],

  setupFirebaseRef: function() {
    console.log("BISA");
    /*this.ref.main = new Firebase( firebase_root.userchat );
    this.ref.userChannelList = this.ref.main.child('channel').child( current_user.user_code_id );
    this.ref.userList = this.ref.main.child('users');*/

    this.ref.main = new Firebase( firebase_root.userchat );
    this.ref.userList = this.ref.main.child('users');
    this.ref.userCurrent = this.ref.userList.child(current_user.user_code_id);
    this.ref.userProfile = this.ref.userCurrent.child('profile');
    this.ref.userChannelList = this.ref.userCurrent.child('channel');
    this.ref.userLastChat = this.ref.userCurrent.child('last_chat');
  },

  setupElements: function() {
    this.el.$recentChatItemTpl = $('#recent-chat-item').html();
    this.el.$recentChatContent = $('#recent-chat-content');
  },


  checkChannel: function() {
    var self = this;

    // On child added
    this.ref.userChannelList.on('child_added', function(snapshot) {
      var channel = snapshot.val(),
          partner = channel.from ? channel.from : channel.to;
      //console.log(partner);
      self.checkLastChat(partner);

    });

    this.ref.userChannelList.on('child_removed', function(snapshot) {
      var channel = snapshot.val(),
          partner = channel.from ? channel.from : channel.to;
      console.log(partner);
      $('#chat-recent-'+partner).remove();

    });

  },

  checkLastChat: function(partner){
    //console.log(partner);
    var self = this;
    var person = [current_user.user_code_id, partner].sort();
    self.recentChatting[partner] = this.ref.main.child('chat').child(person[0] + '-' + person[1]);

    var avatar   = '';
    var idUser   = '';
    var lastChat = '';
    
    var lastChatRef = self.ref.userLastChat.child(partner);
    lastChatRef.once('value', function(snapshot) {
      var lastStamp = snapshot.getPriority();
      lastChat = lastStamp;

    });

    self.ref.userList.child(partner).once('value', function(snapshot){
      var data = snapshot.val();
      avatar = data.filename_thumb;
      idUser = data.id;
    });

    self.recentChatting[partner].on("child_added", function(snapshot){
      var chats = snapshot.val();
      self.setChatRecent(partner, chats, avatar, idUser);
      self.sortChat();
    });

    self.recentChatting[partner].on("child_changed", function(snapshot){
      var chats = snapshot.val();
      self.setChatRecent(partner, chats, avatar, idUser);
      self.sortChat();
    });

  },

  setChatRecent: function(partner, chats, avatar, idUser){
    var self = this;
    var chatRecentItem = Mustache.render( self.el.$recentChatItemTpl, {
        partner_id  : partner,
        timestamp   : self.getConvertTime(chats.ts),
        thumbnail   : avatar,
        id          : idUser,
        chats       : chats.message,
        ts          : chats.ts
      });

      if( self.el.$recentChatContent.find('li#chat-recent-'+partner).length > 0 ) {
        self.el.$recentChatContent.find('li#chat-recent-'+partner).replaceWith( chatRecentItem );
      } 
      else {  
        self.el.$recentChatContent.prepend(chatRecentItem);
      }
  },

  getConvertTime: function(ts){
    return moment.unix(ts).format('MMMM D YYYY, h:mm a');
  },

  sortChat: function(){
    var $wrapper = $('#recent-chat-content');
    $wrapper.find('.recent-list').sort(function (a, b) {
        return +b.getAttribute('data-date') - +a.getAttribute('data-date');
    }).appendTo( $wrapper );
  },

  init: function() {
    // Check if chat section exists or Firebase not loaded
    if( !$('.chat-section').length || typeof Firebase == 'undefined' || typeof current_user == 'undefined' ) {
      return;
    }
    
    this.setupFirebaseRef();
    this.setupElements();
    this.checkChannel();

  }

};

$(document).ready(function(){
  RecentChat.init();
});

})(jQuery);