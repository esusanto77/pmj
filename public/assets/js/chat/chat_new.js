(function($){

var FirebaseChat = {

  currentStatus: 'online',
  el: {},
  ref: {},
  // global refs for channels and chats
  userChannels: {},
  userChats: {},
  userChatting:{},
  definition : {smile:{title:"Smile",codes:[":)",":=)",":-)"]},"sad-smile":{title:"Sad Smile",codes:[":(",":=(",":-("]},"big-smile":{title:"Big Smile",codes:[":D",":=D",":-D",":d",":=d",":-d"]},cool:{title:"Cool",codes:["8)","8=)","8-)","B)","B=)","B-)","(cool)"]},surprised:{title:"Surprised",codes:[":o",":=o",":-o",":O",":=O",":-O"]},wink:{title:"Wink",codes:[";)",";=)",";-)",";)",";=)",";-)"]},crying:{title:"Crying",codes:[";(",";-(",";=("]},sweating:{title:"Sweating",codes:["(sweat)","(:|"]},speechless:{title:"Speechless",codes:[":|",":=|",":-|"]},kiss:{title:"Kiss",codes:[":*",":=*",":-*"]},"tongue-out":{title:"Tongue Out",codes:[":P",":=P",":-P",":p",":=p",":-p"]},blush:{title:"Blush",codes:["(blush)",":$",":-$",":=$",':">']},wondering:{title:"Wondering",codes:[":^)"]},sleepy:{title:"Sleepy",codes:["|-)","I-)","I=)","(snooze)"]},dull:{title:"Dull",codes:["|(","|-(","|=("]},"in-love":{title:"In love",codes:["(inlove)"]},"evil-grin":{title:"Evil grin",codes:["]:)",">:)","(grin)"]},talking:{title:"Talking",codes:["(talk)"]},yawn:{title:"Yawn",codes:["(yawn)","|-()"]},puke:{title:"Puke",codes:["(puke)",":&",":-&",":=&"]},"doh!":{title:"Doh!",codes:["(doh)"]},angry:{title:"Angry",codes:[":@",":-@",":=@","x(","x-(","x=(","X(","X-(","X=("]},"it-wasnt-me":{title:"It wasn't me",codes:["(wasntme)"]},party:{title:"Party!!!",codes:["(party)"]},worried:{title:"Worried",codes:[":S",":-S",":=S",":s",":-s",":=s"]},mmm:{title:"Mmm...",codes:["(mm)"]},nerd:{title:"Nerd",codes:["8-|","B-|","8|","B|","8=|","B=|","(nerd)"]},"lips-sealed":{title:"Lips Sealed",codes:[":x",":-x",":X",":-X",":#",":-#",":=x",":=X",":=#"]},hi:{title:"Hi",codes:["(hi)"]},call:{title:"Call",codes:["(call)"]},devil:{title:"Devil",codes:["(devil)"]},angel:{title:"Angel",codes:["(angel)"]},envy:{title:"Envy",codes:["(envy)"]},wait:{title:"Wait",codes:["(wait)"]},bear:{title:"Bear",codes:["(bear)","(hug)"]},"make-up":{title:"Make-up",codes:["(makeup)","(kate)"]},"covered-laugh":{title:"Covered Laugh",codes:["(giggle)","(chuckle)"]},"clapping-hands":{title:"Clapping Hands",codes:["(clap)"]},thinking:{title:"Thinking",codes:["(think)",":?",":-?",":=?"]},bow:{title:"Bow",codes:["(bow)"]},rofl:{title:"Rolling on the floor laughing",codes:["(rofl)"]},whew:{title:"Whew",codes:["(whew)"]},happy:{title:"Happy",codes:["(happy)"]},smirking:{title:"Smirking",codes:["(smirk)"]},nodding:{title:"Nodding",codes:["(nod)"]},shaking:{title:"Shaking",codes:["(shake)"]},punch:{title:"Punch",codes:["(punch)"]},emo:{title:"Emo",codes:["(emo)"]},yes:{title:"Yes",codes:["(y)","(Y)","(ok)"]},no:{title:"No",codes:["(n)","(N)"]},handshake:{title:"Shaking Hands",codes:["(handshake)"]},skype:{title:"Skype",codes:["(skype)","(ss)"]},heart:{title:"Heart",codes:["(h)","<3","(H)","(l)","(L)"]},"broken-heart":{title:"Broken heart",codes:["(u)","(U)"]},mail:{title:"Mail",codes:["(e)","(m)"]},flower:{title:"Flower",codes:["(f)","(F)"]},rain:{title:"Rain",codes:["(rain)","(london)","(st)"]},sun:{title:"Sun",codes:["(sun)"]},time:{title:"Time",codes:["(o)","(O)","(time)"]},music:{title:"Music",codes:["(music)"]},movie:{title:"Movie",codes:["(~)","(film)","(movie)"]},phone:{title:"Phone",codes:["(mp)","(ph)"]},coffee:{title:"Coffee",codes:["(coffee)"]},pizza:{title:"Pizza",codes:["(pizza)","(pi)"]},cash:{title:"Cash",codes:["(cash)","(mo)","($)"]},muscle:{title:"Muscle",codes:["(muscle)","(flex)"]},cake:{title:"Cake",codes:["(^)","(cake)"]},beer:{title:"Beer",codes:["(beer)"]},drink:{title:"Drink",codes:["(d)","(D)"]},dance:{title:"Dance",codes:["(dance)","\\o/","\\:D/","\\:d/"]},ninja:{title:"Ninja",codes:["(ninja)"]},star:{title:"Star",codes:["(*)"]},mooning:{title:"Mooning",codes:["(mooning)"]},finger:{title:"Finger",codes:["(finger)"]},bandit:{title:"Bandit",codes:["(bandit)"]},drunk:{title:"Drunk",codes:["(drunk)"]},smoking:{title:"Smoking",codes:["(smoking)","(smoke)","(ci)"]},toivo:{title:"Toivo",codes:["(toivo)"]},rock:{title:"Rock",codes:["(rock)"]},headbang:{title:"Headbang",codes:["(headbang)","(banghead)"]},bug:{title:"Bug",codes:["(bug)"]},fubar:{title:"Fubar",codes:["(fubar)"]},poolparty:{title:"Poolparty",codes:["(poolparty)"]},swearing:{title:"Swearing",codes:["(swear)"]},tmi:{title:"TMI",codes:["(tmi)"]},heidy:{title:"Heidy",codes:["(heidy)"]},myspace:{title:"MySpace",codes:["(MySpace)"]},malthe:{title:"Malthe",codes:["(malthe)"]},tauri:{title:"Tauri",codes:["(tauri)"]},priidu:{title:"Priidu",codes:["(priidu)"]}},
  rootUrl: root.base_url,
  

  // Month and days name
  myDays: ["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
  myMonth: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ],

  onload: function() { 
    setTimeout(function(){
      $(".loadingBox").html('<span>No Online User</span>');
    },8000);

  },

  /**
   * Setup Firebase Data Reference
   */
  setupFirebaseRef: function() {
    this.ref.main = new Firebase( firebase_root.userchat );
    this.ref.userList = this.ref.main.child('users');
    this.ref.userCurrent = this.ref.userList.child(current_user.user_code_id);
    this.ref.userProfile = this.ref.userCurrent.child('profile');
    this.ref.userChannel = this.ref.userCurrent.child('channel');
    this.ref.userLastChat = this.ref.userCurrent.child('last_chat');
    this.ref.userNotification = this.ref.userCurrent.child('notification');
    this.ref.userLastNotification = this.ref.userCurrent.child('last-notification');
  },

  /**
   * Cache element variable
   */ 
  setupElements: function() {
    
    this.el.$notifications = $('.dropdown-toggle');
    this.el.$contentChat = $('.chat-module-content');

    this.el.$chatSection = $('.chat-section');
    this.el.$chatlist = $('.chat-list');
    this.el.$chatboxlist = $('.chatbox-list');
    this.el.$chatboxTpl = $('#chatbox-tpl').html();


    this.el.$chatListItemBox = $('.box-chat-list');
    this.el.$chatListItemTpl = $('#chatlist-tpl').html()

    this.el.$chatListNotify = $('.list-chat-notify');
    this.el.$chatNotifyTpl = $('#notify-chat-box-tpl').html();

    this.el.$chatMessageTpl = $('#chatbox-message').html();
    this.el.$badgeChatContent = this.el.$notifications.find('.notify-chat');

    this.el.$imageMediaTpl = $('#image-media-tpl').html();
    this.el.$videoMediaTpl = $('#video-media-tpl').html();

    // new chat look n feel
    this.el.$btnChatList = $('.btn-chat-list');
    this.el.$searchUser = $('#searchUser');
    this.el.$searchUserList = $('#chat-user-list');
    this.el.$closeChatlist = $('.close-chatlist');

    this.el.$recentListChat = $('.list-activities');
    this.el.$contentChatImage = $('#content-image');



  },

  /**
   * Event Binding
   */
  eventBinding: function() {
    
    this.el.$chatlist.on('click', 'li', $.proxy(this.setupChatChannel, this));
    this.el.$chatListNotify.on('click', 'li', $.proxy(this.setupChatChannel, this));
    this.el.$recentListChat.on('click', '.recent-list', $.proxy(this.setupChatChannel, this));

    this.el.$chatSection.on('click', '.minimize', $.proxy(this.toggleMinimized, this));
    this.el.$chatSection.on('click', '.chat-delete', $.proxy(this.deleteConversations, this));
    this.el.$chatSection.on('click', '.chat-delete-item', $.proxy(this.deleteChatItem, this));
    this.el.$chatSection.on('click', '.chat-image', $.proxy(this.attachImage, this));
    this.el.$chatSection.on('click', '.chat-video', $.proxy(this.attachVideo, this));
    this.el.$chatSection.on('click', '.btn-emoticon', $.proxy(this.showEmoticon, this));


    this.el.$chatboxlist.on('keydown', '.chatbox-textarea', $.proxy(this.sendChatMessage, this));
    this.el.$chatboxlist.on('click', '.chat-module-header .close', $.proxy(this.closeChatbox, this));

    this.el.$chatboxlist.on('click', '.chat-module-header #popup-chat', $.proxy(this.popupChat, this));
    // new chat 
    this.el.$btnChatList.on('click', $.proxy(this.toggleChatList, this));
    this.el.$closeChatlist.on('click', $.proxy(this.toggleChatList, this));

  },

  checkFirst: function(){
    if (current_user.subscription == 'false'  && config_settings.chat==='false') {
      this.ref.userChannelList.on('child_added', function(snapshot){
        var users = snapshot.val();
        var userCodeId = snapshot.name();
        if (users.box_chat == 'open') {
          $('.textarea_'+userCodeId).attr('disabled', true);
          $('.textarea_'+userCodeId).attr('placeholder', 'please upgrade subscription');
        };
      });
    };

  },

  popupChat: function(e){
    //e.preventDefault();
    var self = this;
    var $chatbox = $(e.currentTarget).closest('.chat-box'),
        chatId = $chatbox.data('id');

    var person = [current_user.user_code_id, chatId].sort();
    self.userChatting[chatId] = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

    var senderChannel = self.ref.userChannel.child(chatId);
    senderChannel.update({box_chat: 'popup'});

    $chatbox.hide();
  },

  deleteConversations: function(e){
    var self = this;
    var $chatbox = $(e.currentTarget).closest('.chat-box'),
        chatId = $chatbox.data('id');

    var person = [current_user.user_code_id, chatId].sort();
    var lastChatSender = this.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);
    
    lastChatSender.once('value', function(snapshot){
      var data = snapshot.val();
      if (data == null) {
        $('#notify-delete').html('<span style="top:40%; padding:5px; font-size:11px; position:absolute; width: 99.5%;text-align: center;">Sorry, No Conversations to Delete<span>');
        $('#notify-delete').fadeIn('slow').delay(1000).fadeOut();
      } else {
        $('#confirm-delete-chat-'+chatId).toggle('fast');
        $('#confirm-delete-chat-'+chatId).html('<center><span style="margin-top:150px;text-align:center;">Sure to delete your conversation with  ' + chatId +' ? </span><br/><br/>' +
          '<input type="button" class="cancel-del-conver" id="cancel-delete-'+chatId+'" value="Cancel">&nbsp;<input type="button" class="del-conver" id="sure-delete-'+chatId+'" value="Delete"></center>');

        $('#sure-delete-'+chatId).on('click', function(){

          lastChatSender.remove();
          $chatbox.hide();

          $('#confirm-delete-chat-'+chatId).toggle('hide');
          $('#chatbox_'+chatId).find('ul.chat-message').html('');
        });

        $('#cancel-delete-'+chatId).on('click', function(){
          $('#confirm-delete-chat-'+chatId).toggle('hide');
        });
      }

    });
    
    
  },

  deleteChatItem: function(e){
    var self = this;
    var $chatbox = $(e.currentTarget).closest('.chat-box'),
        partner = $chatbox.data('id');

    var person = [current_user.user_code_id, partner].sort();
    var pushChatRef = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);
    
    pushChatRef.once('value', function(snapshot){
      var data = snapshot.val();
      if (data == null) {
        $('#notify-delete').html('<span style="top:40%; padding:5px; font-size:11px; position:absolute; width: 99.5%;text-align: center;">Sorry, No Chat to Delete<span>');
        $('#notify-delete').fadeIn('slow').delay(1000).fadeOut();
      }else{
        $chatbox.find('.option-item-chat').toggle('fast');
        $chatbox.find('.option-chat-item-check').toggle('fast');

        $('.btn-cancel-delete').on('click', function(){
          $('input:checkbox[name=checkbox-chat]').each(function(){ 
            this.checked = false; 
          }); 
          $chatbox.find('.option-item-chat').hide('fast');
          $chatbox.find('.option-chat-item-check').hide('fast');

        });

        $('.btn-delete-item-chat').on('click', function(){
          $("input:checkbox[name=checkbox-chat]:checked").each(function(){
            var codeChat = $(this).val();

            pushChatRef.child(codeChat).remove();
            $('li#'+codeChat).remove();

          });

          $chatbox.find('.option-item-chat').hide('fast');
          $chatbox.find('.option-chat-item-check').hide('fast');
        })
      }
    });
    
  },



  showEmoticon: function(e){
    e.preventDefault();
    $.emoticons.define(this.definition);
    var $chatbox = $(e.currentTarget).closest('.chat-box'),
        codeId = $chatbox.data('id');

    var option = $('.emo_'+codeId);
    option.html($.emoticons.toString());
    option.toggle('fast');
    
    option.bind("mousewheel",function(ev, delta) {
        var scrollTop = $(this).scrollTop();
        $(this).scrollTop(scrollTop-Math.round(delta * 20));
    });

    option.find('.emoticon').on('click', function(event){
      var icon = $(event.target).context.textContent;
      var textContent = $('.textarea_'+codeId)
      var myvalue = textContent.val();
      if(myvalue.indexOf(icon+",")==-1){
        textContent.val(myvalue + icon + ' ');
        textContent.focus();
      } else {
        textContent.val(icon,' ');
        $textContent.focus();
      }

    });

    this.hideEmoticon();

  },

  hideEmoticon: function(){
    var option = $('.emoticon-options');
    $(document).click(function(event) { 
      if (event.target.className !== 'fa fa-smile-o' && event.target.className !== 'btn-emoticon pull-left') {
        option.slideUp('fast');
      };
    });
  },

  /**
   * Toggle new chat list
   */
  toggleChatList: function(e) {
    e.preventDefault();
    var $chatlist = $('.chat-list'),
        $chatboxlist = $('.chatbox-list');

    $chatlist.toggle(100);
  },

  /**
   * Toggle minimized mode
   */
  toggleMinimized: function(e) {
    e.preventDefault();
    var $chatModule = $(e.currentTarget).closest('.chat-module'),
        $chatlist = $('.chat-list'),
        $chatboxlist = $('.chatbox-list');

    $chatModule.toggleClass('minimized');

    // checking chat list minimize
    if( $chatlist.hasClass('minimized') ){
      $chatboxlist.removeAttr('style');
    } else {
      $chatboxlist.css('margin-right', '260px');
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
        senderChannel = this.ref.userChannel.child(partnerId);
        partnerChannel = this.ref.userList.child(partnerId).child('channel').child(current_user.user_code_id),
        lastChatSender = this.ref.userLastChat.child(partnerId),
        lastChatPartner = this.ref.userList.child(partnerId).child('last_chat').child(current_user.user_code_id);

    if (current_user.subscription == 'false'  && config_settings.chat==='false') {
      $('#warning').modal('toggle');
      self.eventReadChat(partnerId);
    } else {
      senderChannel.once("value", function(snapshot){
        var data = snapshot.val();
        var timestampChat = Firebase.ServerValue.TIMESTAMP;
        if (!data){
          self.ref.userList.child(partnerId).once('value', function(snapshot){
            var data = snapshot.val();
            if (data.last_chat == undefined) {

              //console.log("partner lastChat create");

              //lastChatSender.set({ts: Firebase.ServerValue.TIMESTAMP});
              //lastChatPartner.set({ts: Firebase.ServerValue.TIMESTAMP});

              //for correct
              lastChatSender.setWithPriority({ts: self.getTimeStamp()}, Firebase.ServerValue.TIMESTAMP);
              lastChatPartner.setWithPriority({ts: self.getTimeStamp()}, Firebase.ServerValue.TIMESTAMP);

            } else {
              //lastChatSender.set({ts: Firebase.ServerValue.TIMESTAMP});

              //for correct
              lastChatSender.setWithPriority({ts: self.getTimeStamp()}, Firebase.ServerValue.TIMESTAMP);
            }
          });

          senderChannel.set({
            box_chat: 'open',
            to: partnerId,
            ts: self.getTimeStamp()
          });

          $('#chatbox_'+partnerId).find('ul.chat-message').html('');

        } else {
          if (data.box_chat == 'popup') {

              window.open(self.rootUrl + 'chat/popup/'+partnerId, 'win_'+partnerId).focus();
              self.eventReadChat(partnerId);

          } else {

            self.ref.userCurrent.once('value', function(snapshot){
              var data = snapshot.val();
              if (data.last_chat == undefined) {
                //console.log("no lastChat");

                //for correct
                lastChatSender.setWithPriority({ts: self.getTimeStamp()}, Firebase.ServerValue.TIMESTAMP);

              }else {
                //console.log("lastChat ready");
              };
            });

            senderChannel.set({
              box_chat: 'open',
              to: partnerId,
              ts: self.getTimeStamp()
            });
            
            self.eventReadChat(partnerId);
          };
        }
      });
    };

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
    self.currentStatus = status;

    console.log('setUserStatus', status);

    var data = {
      id: current_user.user_id, 
      code_id: current_user.user_code_id,
      name: current_user.user_name,
      gender : current_user.user_gender, 
      filename_thumb : current_user.thumb,
      on: 'connect',
      status: self.currentStatus,
      ts: self.getTimeStamp()
    };

    //console.log(data);
    self.ref.userProfile.set( data );

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

  checkIndicatorStatus: function(){
    this.ref.userList.on('child_added', function(snapshot){
      var dataUser = snapshot.val();
      if (dataUser.status === 'online') {
        $('.status_'+dataUser.code_id).addClass('active');
      } else if(dataUser.status === 'offline'){
        $('.status_'+dataUser.code_id).removeClass('active');
      }
    }); 

    this.ref.userList.on('child_changed', function(snapshot){
      var dataUser = snapshot.val();
      if (dataUser.status === 'online') {
        $('.status_'+dataUser.code_id).addClass('active');
        //console.log("on", dataUser.code_id);
      } else if(dataUser.status === 'offline'){
        //console.log("off", dataUser.code_id);
        $('.status_'+dataUser.code_id).removeClass('active');
      }
    }); 
  },

  monitorChannelList: function() {
    var self = this;
    
    self.ref.userProfile.once('value', function(snapshot){
      if( snapshot.val() ) {
        // Disconnected from firebase
        self.ref.userProfile.onDisconnect().update({
          id: current_user.user_id, 
          code_id: current_user.user_code_id,
          name: current_user.user_name,
          gender : current_user.user_gender, 
          filename_thumb : current_user.thumb,
          on: 'disconnect',
          status: 'online',
          ts: self.getTimeStamp()
        });

        self.setUserStatus( 'online' );
      } else {
        self.setUserStatus( self.currentStatus );
      }
    });

    // On child added
    self.ref.userChannel.on('child_added', function(snapshot) {
      var name = snapshot.name();
    });

    // On child removed
    self.ref.userChannel.on('child_removed', function(snapshot) {
      var name = snapshot.name();
      $('#list-'+name).remove();
    });

    // On user child changed
    self.ref.userProfile.on('child_changed', function(snapshot) {
      var data = snapshot.val();
      $('#time-chat-'+data.code_id).html(self.getConvertTime(data.ts));
      self.changeChatList( data );
    });

  },

  /**
   * Check user channel
   */
  monitorUserChannel: function() {
    var self = this;

    // On child added
    self.ref.userChannel.on('child_added', function(snapshot) {
      var channel = snapshot.val(),
          partner = channel.from ? channel.from : channel.to;

      self.checkLastChat(partner);

      if( channel.box_chat == 'open' ) {
        self.openChatBox( partner, true );
      } 
      else if( channel.box_chat == 'close' ) {
        self.openChatBox( partner, false );
      } 
      else if (channel.box_chat == 'minimized') {
        self.openChatBox( partner, 'minimized' );
      } 
      else {
        console.log("No Box Chat");
      }

    });

    // on child changed
    self.ref.userChannel.on('child_changed', function(snapshot) {
      var channel = snapshot.val(),
          partner = channel.from ? channel.from : channel.to;

      if(channel.box_chat == 'open' ) {
        self.openChatBox( partner, true );
      }
      else if( channel.box_chat == 'close' ) {
        self.openChatBox( partner, false );
      } 
      else if (channel.box_chat == 'minimized') {
        self.openChatBox( partner, 'minimized' );
      }  
      else {
        console.log("ChatBox", partner, channel.box_chat);
      }

    });

    self.ref.userChannel.on("child_removed", function(snapshot){
      var name = snapshot.name();
      self.el.$chatListNotify.find('#chat-from-'+name).remove();

      if(self.el.$chatListNotify.find('li').length == 0){
        $('.loadingTopBoxChat').show();
        $('.loadingTopBoxChat').html('<span>No Chat Avaliable</span>');
      }

    });

  },

  /**
   * Update user list DOM
   */
  updateChatList: function() {
    var self = this

    self.ref.userList.on('child_added', function(snapshot){
      var user = snapshot.val();
      var data = user.profile;

      if (data == undefined) return false;

      if (data.code_id !== current_user.user_code_id && data.gender !== current_user.user_gender && data.status == 'online' && current_user.user_gender!=='' && current_user.user_gender!==null && data.gender!=='' && data.gender!==null) {
        $('.loadingBox').hide();
        var chatListItem = Mustache.render( self.el.$chatListItemTpl, {
            code_id : data.code_id,
            filename_thumb : data.filename_thumb
          });

        if( self.el.$searchUserList.find('li[data-id="'+ data.code_id +'"]').length > 0 ) {
            self.el.$searchUserList.find('li[data-id="'+ data.code_id +'"]').replaceWith( chatListItem );
          } 
          else {  
            self.el.$searchUserList.prepend(chatListItem); 
          }

        var qs = $('input#searchUser').quicksearch('ul#chat-user-list li');
        qs.cache();
        $('.box-notify').perfectScrollbar();
        
      } else {
        //console.log('no match :', data.code_id);
      }

    });

    self.ref.userList.on('child_changed', function(snapshot){
      var user = snapshot.val();
      var data = user.profile;
      var chatListItem = Mustache.render( self.el.$chatListItemTpl, {
            code_id : data.code_id,
            filename_thumb : data.filename_thumb
          }); 
      
      if (data.code_id !== current_user.user_code_id && data.gender !== current_user.user_gender && data.status == 'online' && current_user.user_gender!=='' && current_user.user_gender!==null && data.gender!=='' && data.gender!==null) {
        if( self.el.$searchUserList.find('li[data-id="'+ data.code_id +'"]').length > 0 ) {
            self.el.$searchUserList.find('li[data-id="'+ data.code_id +'"]').replaceWith( chatListItem );
        } 
        else {  
          $('.loadingBox').hide();
          self.el.$searchUserList.prepend(chatListItem); 

          if (current_user.subscription == 'false'  && config_settings.chat==='false') {
            $('.textarea_'+data.code_id).attr('disabled', false);
            $('.textarea_'+data.code_id).attr('placeholder', 'Chat here ...');
          };

          var qs = $('input#searchUser').quicksearch('ul#chat-user-list li');
          qs.cache();
          $('.box-notify').perfectScrollbar();
        }
      }
      else if(data.status == 'offline' ){
        self.el.$searchUserList.find('li[data-id="'+ data.code_id +'"]').remove();

        if (current_user.subscription == 'false'  && config_settings.chat==='false') {
          $('.textarea_'+data.code_id).attr('disabled', true);
          $('.textarea_'+data.code_id).attr('placeholder', 'please upgrade subscription');
        };

      }

    });
  },

  checkLastChat: function(partner){
    var self = this;

    var person = [current_user.user_code_id, partner].sort();
    self.userChatting[partner] = this.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

    self.userChatting[partner].on("child_added", function(snapshot){

      var chats = snapshot.val();

      var chatingType = chats.message.split('=').slice(0,1).join('');
      var typeChat = '';
      if(chatingType == 'image'){
        chats.message = '[ Send Image ]';
      }else if (chatingType == 'video'){
        chats.message = '[ Send Video ]';
      }else{
        chats.message = chats.message;
      };

      if(current_user.user_code_id !== chats.from){
          var chatNotifyItem = Mustache.render( self.el.$chatNotifyTpl, {
            partnerId : partner,
            from : chats.from,
            to : chats.to,
            message : chats.message,
            filename_thumb : chats.filename_thumb,
            ts : self.getConvertTimeChat(chats.ts),
            status : chats.status
          });

          if( self.el.$chatListNotify.find('li#chat-from-'+partner).length > 0 ) {
            self.el.$chatListNotify.find('li#chat-from-'+partner).replaceWith( chatNotifyItem );
            self.countNotifyChat();
          } 
          else {  
            self.el.$chatListNotify.prepend(chatNotifyItem); 
            $(".loadingTopBoxChat").hide();
            self.countNotifyChat();
          }
      }
    });
    
    self.userChatting[partner].on("child_changed", function(snapshot){
      var chats = snapshot.val();
      if(chats.status === 'read'){
        if(current_user.user_code_id == chats.from){
          $('#'+chats.ts).html('read');
        }
        $('#chat-from-'+ partner).removeClass('unread').addClass('read');
        self.el.$contentChat.find('')
        self.countNotifyChat();
      } else {
        if(current_user.user_code_id == chats.from){
          $('#'+chats.ts).html('unread');
        }
        $('#chat-from-'+ partner).removeClass('read').addClass('unread');
      }

    });
  },

  eventReadChat: function(partner){
    var self = this;
    var person = [current_user.user_code_id, partner].sort();
        self.userChatting[current_user.user_code_id] = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

    self.userChatting[current_user.user_code_id].on("child_added", function(snapshot){
      var chatData = snapshot.val();
      var chatName = snapshot.name();
      var box = self.el.$chatboxlist.find('#chatbox_' + partner);
      if(current_user.user_code_id !== chatData.from){
        if (chatData.status === 'unread') {
          self.userChatting[current_user.user_code_id].child(chatName).update({status: 'read'});
        }
      }
    });

    var partnerChat = self.ref.main.child('chat').child(partner).child(person[0] + '-' + person[1]);
    partnerChat.on("child_added", function(snapshot){
      var chatData = snapshot.val();
      var chatName = snapshot.name();
      var box = self.el.$chatboxlist.find('#chatbox_' + partner);
      if(current_user.user_code_id !== chatData.from){
        if (chatData.status === 'unread') {
          partnerChat.child(chatName).update({status: 'read'});
        }
      }
    });

   
  },

  changeChatList: function(data) {
    $('#status-'+data.code_id).attr('class', 'user-status '+data.status).html(data.status);
  },

  /**
   * Either create or use existing chatbox
   */
  openChatBox : function( partner, isMinimized ) {
    
    var party = [ current_user.user_code_id, partner ].sort(),
        self = this,
        previousChats;  
    var newItems = false;      

    // If reference to chat not exists
    if( !self.userChats[partner] ) {
      self.userChats[partner] = this.ref.main.child('chat').child(current_user.user_code_id).child(party[0] + '-' + party[1]);

      // On chat For Parter
      self.userChats[partner].on('child_added', function(snapshot){
        var dataChat = snapshot.val(),
            idChat = snapshot.name();

        if( !newItems ) return;

        self.addMessageToChatbox( partner, dataChat, idChat, true );
        self.countNotifyChat();

      });
    }


    var lastChatRef =  this.ref.main.child('chat').child(current_user.user_code_id).child(party[0] + '-' + party[1]);

    lastChatRef.once('value', function(snapshot){
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
              var nameChat = element.name();
              // If at the end of item, scroll down
              if( numOfChild == counter ) {
                self.addMessageToChatbox(partner, chating, nameChat, true);
              } else {
                self.addMessageToChatbox(partner, chating, nameChat, false);
              }
              counter++;
            });
          }

          else {
            //self.createChatBox( partner );
            $('#chatbox_' + partner).find('.chatbox-textarea').focus(); 
          }
          
          //set position box chat
          if( isMinimized == true) {
            self.createChatBox(partner);
            $('#chatbox_' + partner).removeClass('minimized');

          } else if(isMinimized == false) {
            $('#chatbox_' + partner).css('display', 'none');

          } else if(isMinimized == 'minimized'){
            self.createChatBox(partner);
            $('#chatbox_' + partner).addClass('minimized');
          }
        });
    
  },


  /**
   * Create Chat Box
   */
  createChatBox: function( partner ) {   
    // Check if chatbox exists

    if( $('#chatbox_' + partner).length > 0 ) {
      $('#chatbox_' + partner).css('display', 'block');
    }
    // chatbox not exists
    else {
      
      this.ref.userList.child(partner).once('value', function(snapshot){
          var users = snapshot.val();
          if (users == null) return;
          idUser = users.id;
      });
      var user_data = this.getUserData( partner ),
          chatbox = Mustache.render( this.el.$chatboxTpl, { 
            id: this.getUserOnRefUser(partner), //must be user registration_id
            filename_thumb: this.getThumbOnRefUser(partner), 
            code_id: partner, 
            display_name: partner,
            form: current_user.user_code_id
          });
      this.el.$chatboxlist.append( chatbox );

    }
  },

  getUserOnRefUser: function(partner){
    var idUser ='';
    var self = this;
    self.ref.userList.child(partner).child('profile').once('value', function(snapshot){
        var users = snapshot.val();
        if (users == null) return;
        idUser = users.id;
    });
    return idUser;
  }, 
  getThumbOnRefUser: function(partner){
    var thumb =''
    this.ref.userList.child(partner).once('value', function(snapshot){
        var users = snapshot.val();
        if (users == null) return;
        thumb = users.filename_thumb;
    });
    return thumb;
  },
  

  /**
   * Close Chatbox
   */
  closeChatbox: function( e ) {
    //e.preventDefault();
    var $chatbox = $(e.currentTarget).closest('.chat-box'),
        chatId = $chatbox.data('id');

    $chatbox.hide();
    this.ref.userChannel.child( chatId ).update({
      box_chat: 'close',
      ts: this.getTimeStamp()
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
        // var chat = this.userChats[chatId].push();
        // var pushSelf = this.userChats[current_user.user_code_id].push();
        var person = [current_user.user_code_id, chatId].sort();

        var chat = this.ref.main.child('chat').child(chatId).child(person[0] + '-' + person[1]);
        var pushSelf = this.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

        var timestampChat = Firebase.ServerValue.TIMESTAMP;

         var chatData = {
          filename_thumb: current_user.thumb,
          from: current_user.user_code_id,
          to: chatId,
          message: message,
          status: 'unread',
          ts: self.getTimeStamp()
        },
          chatDataSelf = {
          filename_thumb: current_user.thumb,
          from: current_user.user_code_id,
          to: chatId,
          message: message,
          status: 'unread',
          ts: self.getTimeStamp()
        };

        chat.push(chatData);
        pushSelf.push(chatDataSelf);


        var userRef = this.ref.main.child('users').child(chatId).child('profile'),
            senderChannel = this.ref.userChannel.child(chatId),
            partnerChannel = this.ref.userList.child(chatId).child('channel').child(current_user.user_code_id);
            
        //lastChatSender = this.ref.userLastChat.child(chatId),
        //lastChatPartner = this.ref.userList.child(chatId).child('last_chat').child(current_user.user_code_id);
    
        var $chatbox = this.el.$chatboxlist.find('#chatbox_' + chatId);

        userRef.once('value', function(snapshot){
          var users = snapshot.val();
          if(users.status === 'offline') {

            partnerChannel.set({
              box_chat: 'close',
              from: current_user.user_code_id,
              ts: self.getTimeStamp()
            });

            //lastChatPartner.set({ts: self.getTimeStamp()});
          } else {
            partnerChannel.once("value", function(snapshot){
              var data = snapshot.val();
              if (!data) {
                //console.log("create channel");
                partnerChannel.set({
                  box_chat: 'open',
                  from: current_user.user_code_id,
                  ts: self.getTimeStamp()
                });

                //lastChatPartner.set({ts: self.getTimeStamp()});

              } else {
                if (data.box_chat == 'popup') {
                  //return;
                  $('.chat-popup').find('.chat-module-content').animate({scrollTop: $('.chat-popup').find('ul.chat-message').height()});
                  //console.log("POPUP Partner ");
                } else {
                  partnerChannel.set({
                    box_chat: 'open',
                    from: current_user.user_code_id,
                    ts: self.getTimeStamp()
                  });

                  //lastChatPartner.set({ts: self.getTimeStamp()});

                  $chatbox.find('.chat-module-content').animate({scrollTop: $chatbox.find('ul.chat-message').height()});

                }; 
              };
            });

            senderChannel.once("value", function(snapshot){
              var data = snapshot.val();

              if (data.box_chat === 'popup') {
                //return;
                console.log("POPUP : ", data);
              } 
              else {
                senderChannel.set({
                  box_chat: 'open',
                  to: chatId,
                  ts: self.getTimeStamp()
                });

                $chatbox.find('.chat-module-content').animate({scrollTop: $chatbox.find('ul.chat-message').height()});
              }; 
            });

          }
        });
      }
      return false;
    }
  },

  attachImage : function(e){
    //e.preventDefault();
    var $chatbox = $(e.currentTarget).closest('.chat-image'),
        partner = $chatbox.data('id');

    $('#upload-content-'+partner).toggle('fast');
    $('#upload-content-'+partner).html('<div class="overlay-loading-image loading-img-'+partner+'"><img src="'+ root.base_url +'public/assets/img/ajax-loader.gif"><p>Please wait, process upload image</p></div><form id="form-image-'+partner+'" method="post">' +
      '<span class="btn-custom btn-file"> Choose From Device' +
      '<input type="file" class="file-load" id="loader-'+partner+'" name="image"></span>' +
      '<span class="avaliable-image" id="avaliable-image-'+partner+'">Choose Avaliable Image</span>' +
      '<span class="info-upload"><p class="default">Please Select Image First</p></span>' +
      '<input type="submit" class="send-image" name="send-image-'+partner+'" value="SEND IMAGE">' +
      '<input type="button" class="cancel-image" name="cancel-image-'+partner+'" value="CANCEL">' +
    '</form>');
    
    this.sendPicture(partner);
  },

  sendPicture: function(partner){
    var self = this;

    $('#form-image-'+partner).on('submit', function(event){
      $('.loading-img-'+partner).show();
      $.ajax({
        url: root.base_url+'chat/photoChatNew',
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
          if(data.info == 'true'){

            var timestamp = Math.round( new Date().getTime() / 1000 );
            //var imageMessage = 'image='+root.base_url+'public/upload/chat/image/'+current_user.user_code_id+'/'+data.file_name;
            var imageMessage = 'image='+data.link;
            var person = [current_user.user_code_id, partner].sort();
            var ref = new Firebase( firebase_root.userchat );
            var refChatting= ref.child('chat').child(person[0] + '-' + person[1]);

            
            $.ajax({
              url: root.base_url+'chat/postMediaChat',
              type: 'post',
              data: {from: current_user.user_code_id, to: partner, type:'image', filename: data.file_name},
              success: function(data){
                if (data == 1) {
                  var chat = self.ref.main.child('chat').child(partner).child(person[0] + '-' + person[1]);
                  var pushSelf = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

                  // var chat = self.userChats[partner].push();
                  var timestampChat = Firebase.ServerValue.TIMESTAMP;

                  var chatData = {
                    filename_thumb: current_user.thumb,
                    from: current_user.user_code_id,
                    to: partner,
                    message: imageMessage,
                    status: 'unread',
                    ts: timestamp
                  },
                    chatDataSelf = {
                    filename_thumb: current_user.thumb,
                    from: current_user.user_code_id,
                    to: partner,
                    message: imageMessage,
                    status: 'unread',
                    ts: timestamp
                  };

                  chat.push(chatData);
                  pushSelf.push(chatDataSelf);

                  $('#loader-'+partner).replaceWith($('#loader-'+partner).val('').clone(true));
                  $('#upload-content-'+partner).toggle('hide');
                  $('#upload-content-'+partner).html('');
                  $('.loading-img-'+partner).hide();
                }else{
                  console.log('error');
                };
              }  
            });
          } else {
            $('.loading-img-'+partner).hide();
            $('.info-upload').html(data.error);
          }
        }        
      });
      return false;
    });

    $('.file-load').on('change', function(event){
      var fileName = event.target.value;
      //var split = fileName.split("\\").slice(2,3).join('');
      $('.info-upload').html('<p>'+fileName+'</p>');
    });

    $('#avaliable-image-'+partner).on('click', function(e){

      $('#media-image').modal('toggle');
      $('#media-image').find('.footer-image-chat').html('<input type="hidden" id="select-chat-image" style="font-size:8px">' +
            '<input type="button" class="send-chat-image" id="send-chat-image" value="SEND IMAGE">' +
            '<input type="button" class="cancel-chat-image" value="CANCEL">');

      $('#send-chat-image').removeClass('send-chat-image');
      $('#send-chat-image').addClass('btn-image-disabled');
      $('#send-chat-image').attr('disabled', true);
      $('#send-chat-image').attr('data-id', partner);

      //cancel send from avaliable image
      $('.cancel-chat-image').on('click', function(){
        $('#media-image').modal('hide');
        $('#media-image').find('#content-chat-image').html('');
        $('#media-image').find('#select-chat-image').val('');
      });
      

      $.ajax({
          url: root.base_url+'chat/getMedia',
          success: function (data) {

            $.each( data, function( key, value ) {
              if (value.media_type == 'image') {
                var link_image = value.media_file_name;

                var imageTemplate = Mustache.render( self.el.$imageMediaTpl, {
                  link : link_image
                });

                $('#media-image').find('#content-chat-image').prepend(imageTemplate);
                
              };
            });

            //select image
            $( '.image-chat-galery > img' ).click(function(e) {
              e.preventDefault();

              var $imagebox = $(e.currentTarget).closest('.image-chat-galery'),
                  linkImage = $imagebox.data('link');

              $('#select-chat-image').val(linkImage);

              if( $(this).is('.selected') ) {
                  $(this).removeClass( 'selected' );
                  $('#select-chat-image').val('');
                  $('#send-chat-image').removeClass('send-chat-image');
                  $('#send-chat-image').attr('disabled', true);
                  $('#send-chat-image').addClass('btn-image-disabled');
              }
              else {
                  $( 'img.selected' ).removeClass('selected');
                  $(this).addClass( 'selected' );
                  $('#send-chat-image').addClass('send-chat-image');
                  $('#send-chat-image').attr('disabled', false);
                  $('#send-chat-image').removeClass('btn-image-disabled');
              }
              return false;
            });
            
            //send image 
            $('#send-chat-image').on('click', function(e) {
              var $imagebox = $(e.currentTarget).closest('#send-chat-image'),
                  partnerChat = $imagebox.data('id');

              var fileImageLink = $('#select-chat-image').val();

              $.ajax({
                url: root.base_url+'chat/postMediaChatAvaliable',
                type: 'post',
                data: {from: current_user.user_code_id, to: partner, type:'image', filename: fileImageLink},
                success: function(dataImg){
                  if (dataImg == 1) {
                    
                    var imageMessage = 'image='+fileImageLink;
                    var timestamp = Math.round( new Date().getTime() / 1000 );

                    var person = [current_user.user_code_id, partnerChat].sort();

                    var chat = self.ref.main.child('chat').child(partnerChat).child(person[0] + '-' + person[1]);
                    var pushSelf = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);


                    var chatData = {
                      filename_thumb: current_user.thumb,
                      from: current_user.user_code_id,
                      to: partnerChat,
                      message: imageMessage,
                      status: 'unread',
                      ts: timestamp
                    },
                     chatDataSelf = {
                      filename_thumb: current_user.thumb,
                      from: current_user.user_code_id,
                      to: partnerChat,
                      message: imageMessage,
                      status: 'unread',
                      ts: timestamp
                    };
                    
                    chat.push(chatData);
                    pushSelf.push(chatDataSelf);
                    
                    $('#media-image').modal('hide');
                  } else {
                    console.log('error');
                  }; 
                } 
              });
            });
          }
      });

    });

    //when hidden
    $('#media-image').on('hidden.bs.modal', function(e) { 
      $('#media-image').find('#content-chat-image').html('');
      $('#media-image').find('#select-chat-image').val('');
      $('#upload-content-'+partner).hide();
      $('#upload-content-'+partner).html('');
    });

    //cancel send image
    $('.cancel-image').on('click', function(){
      $('#loader-'+partner).replaceWith($('#loader-'+partner).val('').clone(true));
      $('#upload-content-'+partner).toggle('hide');
      $('#upload-content-'+partner).html('');
    });

  },

  attachVideo : function(e){
    //e.preventDefault();
    var $chatbox = $(e.currentTarget).closest('.chat-video'),
        partner = $chatbox.data('id');

    $('#upload-content-video-'+partner).toggle('fast');
    $('#upload-content-video-'+partner).html('<div class="overlay-loading loading-vid-'+partner+'"><img src="'+ root.base_url +'public/assets/img/ajax-loader.gif"><p>Please wait, process upload video</p></div><form id="form-video-'+partner+'" method="post">' +
      '<span class="btn-custom btn-file"> Choose Video From Device' +
      '<input type="file" class="file-load-video" id="loader-video-'+partner+'" name="video"></span>' +
      '<span class="avaliable-image" id="avaliable-video-'+partner+'">Choose Avaliable Video</span>' +
      '<span class="info-upload"><p class="default">Please Select File Video First</p></span>' +
      '<input type="submit" class="send-image" name="send-video-'+partner+'" value="SEND VIDEO">' +
      '<input type="button" class="cancel-image" name="cancel-video-'+partner+'" value="CANCEL">' +
    '</form>');
    
    this.sendVideo(partner);
  },

  sendVideo: function(partner){
    var self = this;

    $('#form-video-'+partner).on('submit', function(event){
      $('.loading-vid-'+partner).show();
      //event.preventDefault();

      $.ajax({
        url: root.base_url+'chat/videoChatNew',
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
          if(data.info == 'true'){
            //var messageVideo = 'video='+root.base_url+'public/upload/chat/video/'+current_user.user_code_id+'/'+data.file_name;
            var messageVideo = 'video='+data.link;
            var timestamp = Math.round( new Date().getTime() / 1000 );
            var person = [current_user.user_code_id, partner].sort();
            var ref = new Firebase( firebase_root.userchat );
            var refChatting= ref.child('chat').child(person[0] + '-' + person[1]);

            $.ajax({
              url: root.base_url+'chat/postMediaChat',
              type: 'post',
              data: {from: current_user.user_code_id, to: partner, type:'video', filename: data.file_name},
              success: function(data){

                if (data == 1) {
                  
                  var chat = self.ref.main.child('chat').child(partner).child(person[0] + '-' + person[1]);
                  var pushSelf = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

                  var timestampChat = Firebase.ServerValue.TIMESTAMP;

                  var chatData = {
                    filename_thumb: current_user.thumb,
                    from: current_user.user_code_id,
                    to: partner,
                    message: messageVideo,
                    status: 'unread',
                    ts: timestamp
                  },
                    chatDataSelf = {
                   filename_thumb: current_user.thumb,
                    from: current_user.user_code_id,
                    to: partner,
                    message: messageVideo,
                    status: 'unread',
                    ts: timestamp
                  };
                  
                  chat.push(chatData);
                  pushSelf.push(chatDataSelf);

                  $('#loader-video-'+partner).replaceWith($('#loader-video-'+partner).val('').clone(true));
                  $('#upload-content-video-'+partner).toggle('hide');
                  $('#upload-content-video-'+partner).html('');
                  $('.loading-vid-'+partner).hide();
                }else{
                  console.log('error');
                };
              }  
            });

          } else {
            $('.loading-vid-'+partner).hide();
            $('.info-upload').html(data.error);
          }
        }     

      });

      return false;
    });

    $('#loader-video-'+partner).bind('change', function(event){
      var fileName = event.target.value;
      var files = this.files[0];

        var fileSize = 0;
        if (files.size > 1024 * 1024){
          fileSize = (Math.round(files.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
          
        } else {
          fileSize = (Math.round(files.size * 100 / 1024) / 100).toString() + 'KB';  
        }
        
        $('.info-upload').html('<p>'+fileName+'&nbsp; '+ fileSize+'</p>');
      
    });

    $('#avaliable-video-'+partner).on('click', function(e){

      $('#media-video').modal('toggle');
      $('#media-video').find('.footer-image-chat').html('<input type="hidden" id="select-chat-video" style="font-size:8px">' +
            '<input type="button" class="send-chat-video" id="send-chat-video" value="SEND VIDEO">' +
            '<input type="button" class="cancel-chat-video" value="CANCEL">');

      $('#send-chat-video').removeClass('send-chat-video');
      $('#send-chat-video').addClass('btn-video-disabled');
      $('#send-chat-video').attr('disabled', true);
      $('#send-chat-video').attr('data-id', partner);

      //cancel send from avaliable video
      $('.cancel-chat-video').on('click', function(){
        $('#media-video').modal('hide');
        $('#media-video').find('#content-chat-video').html('');
        $('#select-chat-video').val('');
      });

      $.ajax({
          url: root.base_url+'chat/getMedia',
          success: function (data) {
            $.each( data, function( key, value ) {
              if (value.media_type == 'video') {
                var link_video = value.media_file_name;
                var videoTemplate = Mustache.render( self.el.$videoMediaTpl, {
                  link : link_video
                });

                $('#media-video').find('#content-chat-video').prepend(videoTemplate);
                
              };
            });

            //select video
            $('.video-chat-galery > img').click(function(e) {
              e.preventDefault();

              var $videobox = $(e.currentTarget).closest('.video-chat-galery'),
                  linkVideo = $videobox.data('link');

              $('#select-chat-video').val(linkVideo);

              if( $(this).is('.selected-video') ) {
                  $(this).removeClass( 'selected-video' );
                  $('#select-chat-video').val('');
                  $('#send-chat-video').removeClass('send-chat-video');
                  $('#send-chat-video').attr('disabled', true);
                  $('#send-chat-video').addClass('btn-video-disabled');
              }
              else {
                  $( 'img.selected-video' ).removeClass('selected-video');
                  $(this).addClass( 'selected-video' );
                  $('#send-chat-video').addClass('send-chat-video');
                  $('#send-chat-video').attr('disabled', false);
                  $('#send-chat-video').removeClass('btn-video-disabled');
              }
              return false;
            });
            

            //send video 
            $('#send-chat-video').on('click', function(e) {
              var $videobox = $(e.currentTarget).closest('#send-chat-video'),
                  partnerChat = $videobox.data('id');

              var fileVideoLink = $('#select-chat-video').val();
              //console.log(partnerChat);
              $.ajax({
                url: root.base_url+'chat/postMediaChatAvaliable',
                type: 'post',
                data: {from: current_user.user_code_id, to: partner, type:'video', filename: fileVideoLink},
                success: function(dataVideo){
                  if (dataVideo == 1) {
                    var videoMessage = 'video='+fileVideoLink;
                    var timestamp = Math.round( new Date().getTime() / 1000 );

                    var timestampChat = Firebase.ServerValue.TIMESTAMP;

                    var person = [current_user.user_code_id, partnerChat].sort();

                    var pushChatPartner = self.ref.main.child('chat').child(partnerChat).child(person[0] + '-' + person[1]);
                    var pushChatSelf = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);


                    var chatData = {
                      filename_thumb: current_user.thumb,
                      from: current_user.user_code_id,
                      to: partnerChat,
                      message: videoMessage,
                      status: 'unread',
                      ts: timestamp
                    },
                     chatDataSelf = {
                      filename_thumb: current_user.thumb,
                      from: current_user.user_code_id,
                      to: partnerChat,
                      message: videoMessage,
                      status: 'unread',
                      ts: timestamp
                    };
                    
                    pushChatPartner.push(chatData);
                    pushChatSelf.push(chatDataSelf);
                    
                    $('#media-video').modal('hide');
                    
                  } else {
                    console.log('error');
                  }; 
                } 
              });

            });
          }
      });
    });

    //when hidden
    $('#media-video').on('hidden.bs.modal', function(e) { 
      $('#media-video').find('#content-chat-video').html('');
      $('#media-video').find('#select-chat-video').val('');
      $('#upload-content-video-'+partner).html('');
      $('#upload-content-video-'+partner).hide();
    });

    $('.cancel-image').on('click', function(){
      $('#loader-video-'+partner).replaceWith($('#loader-video-'+partner).val('').clone(true));
      $('#upload-content-video-'+partner).toggle('hide');
      $('#upload-content-video-'+partner).html('');
    });

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
  addMessageToChatbox: function( partner, chat, nameChat, scrollDown ) {
    var self = this;
    chat.tsStat = chat.ts;
    chat.ts = self.getConvertTimeChat(chat.ts);
    var date = self.getConvertTime(chat.tsStat);
      // Change display name to me if chat from equal to current user id
    if( chat.from == current_user.user_code_id ) {
      chat.classname = 'self';
    } else {
      chat.status = '';
    }

    var $chatbox = this.el.$chatboxlist.find('#chatbox_' + partner);

    var chatMessage = Mustache.render( self.el.$chatMessageTpl, {
      tsStat : chat.tsStat,
      ts : chat.ts,
      classname : chat.classname,
      status : chat.status,
      message : chat.message,
      filename_thumb : chat.filename_thumb,
      data_date : date,
      chat_id : nameChat
    });


    $chatbox.find('ul.chat-message').append(chatMessage);

    self.render(chat.from, chat.tsStat, chat.message);


    $('.chat-module-content').perfectScrollbar();

    if( scrollDown ) {
      $chatbox.find('.chat-module-content').animate({scrollTop: $chatbox.find('ul.chat-message').height()});
    }

  },


  render: function(from, ts, chat){
    $.emoticons.define(this.definition); 
    var message = this.el.$chatboxlist.find('.msg_'+ts);
    var chat = message[0].textContent;
    var chatingType = chat.split('=').slice(0,1).join('');
    var linkSource = chat.split('=').slice(1,2).join('');

    //set if chat is emoticon
    var checking = $.emoticons.replace(chat);
    message.html(checking);

    //set if chat is image
    if(chatingType == 'image'){
      var chating = '<img src="'+ linkSource +'" class="image-chat">';

      message.addClass('image-display');
      message.html(chating);
      message.attr('data-link', linkSource);
      message.attr('data-from', from);

      $('.image-display > img').on('click', function(e){
        var $chatbox = $(e.currentTarget).closest('.image-display'),
        link = $chatbox.data('link'),
        senderImage = $chatbox.data('from');

        var fileImage = link.split('/').pop();
        var linkImage = root.base_url +'chat/popup_image/'+ senderImage+'/'+fileImage;

        window.open(linkImage, 'pic', 'toolbar=no, scrollbars=no, resizable=no, top=200, left=200, width=400, height=400').focus();
      });
    };
    
    //set if chat is video
    if(chatingType == 'video'){
      var videoDisplay = '<span class="video-thumb"><img src="'+root.base_url+'public/assets/img/video-thumbnail-play.png'+'"></span>';
      var fileVideo = linkSource;

      message.addClass('video-display');
      message.attr('data-file', fileVideo);
      message.attr('data-from', from);
      message.html(videoDisplay);

      $('.video-display').on('click', function(e){
        var $chatbox = $(e.currentTarget).closest('.video-display'),
         linkVideo = $chatbox.data('file'),
         senderVid = $chatbox.data('from');

        var fileVid = linkVideo.split('/').pop();
        var linkVid = root.base_url +'chat/popup_video/'+ senderVid+'/'+fileVid;

        window.open(linkVid, 'vid_'+fileVid, 'toolbar=no, scrollbars=no, resizable=no, top=200, left=200, width=400, height=400').focus();

      });
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

  countNotifyChat: function(){
    var lengthBadges = this.el.$chatListNotify.find('li.unread').length;

    if (lengthBadges == 0) {
      badgeCount =  this.el.$notifications.find('.notify-chat .badge').remove();
    } else {
      badgeCount = this.el.$badgeChatContent.html('<span class="badge">'+ lengthBadges +'</span>');
    }
    return badgeCount;
  },

  /**
   * Format Time
   */
  getConvertTime: function(data){
    var time = new Date(data*1000);
    var day = this.myDays[time.getDay()];
    var date = time.getDate();
    var month = this.myMonth[time.getMonth()];
    var years = time.getFullYear();
    var hours = time.getHours();
    var minutes = time.getMinutes();
    var seconds = time.getSeconds();

    hours = hours % 12;
    hours= hours ? hours : 12; // the hour '0' should be '12'
    var ampm=hours >= 12 ? 'PM' : 'AM';
    minutes = minutes < 10 ? '0'+minutes : minutes;
    seconds = seconds <10 ? '0'+seconds: seconds;

    return date+ ' ' +month+ ' ' +years;
    //return moment(time).format('MMMM Do YYYY, h:mm a');
  },

  getConvertTimeChat: function(data){
    var time = new Date(data*1000);
    var day = this.myDays[time.getDay()];
    var date = time.getDate();
    var month = this.myMonth[time.getMonth()];
    var years = time.getFullYear();
    var hours = time.getHours();
    var minutes = time.getMinutes();
    var seconds = time.getSeconds();

    hours = hours % 12;
    hours= hours ? hours : 12; // the hour '0' should be '12'
    var ampm=hours >= 12 ? 'pm' : 'am';
    minutes = minutes < 10 ? '0'+minutes : minutes;
    seconds = seconds <10 ? '0'+seconds: seconds;

    return hours+ ':' +minutes+ ' ' +ampm;
    //return moment(time).startOf('seconds').fromNow();

  },


  /**
   * Initialization
   */
  init: function() {
    // Check if chat section exists or Firebase not loaded
    if( !$('.chat-section').length || typeof Firebase == 'undefined' || typeof current_user == 'undefined' ) {
      return;
    }
    
    this.onload();
    this.setupFirebaseRef();
    this.setupElements();
    this.eventBinding();
    // this.checkIdleAwayStatus();
    this.monitorUserChannel();
    this.monitorChannelList();
    //this.checkIndicatorStatus();
    this.updateChatList();
  }



};

$(document).ready(function(){
  FirebaseChat.init();

  $(".btn-chat").on("click",function(e){
    FirebaseChat.setupChatChannel(e)
  });
});

})(jQuery);