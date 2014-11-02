(function($){

var FirebaseChatPopUp = {
  currentStatus: 'online',
  el: {},
  ref: {},


  // global refs for channels and chats
  userChattingPop:{},
  definitionEmo : {smile:{title:"Smile",codes:[":)",":=)",":-)"]},"sad-smile":{title:"Sad Smile",codes:[":(",":=(",":-("]},"big-smile":{title:"Big Smile",codes:[":D",":=D",":-D",":d",":=d",":-d"]},cool:{title:"Cool",codes:["8)","8=)","8-)","B)","B=)","B-)","(cool)"]},surprised:{title:"Surprised",codes:[":o",":=o",":-o",":O",":=O",":-O"]},wink:{title:"Wink",codes:[";)",";=)",";-)",";)",";=)",";-)"]},crying:{title:"Crying",codes:[";(",";-(",";=("]},sweating:{title:"Sweating",codes:["(sweat)","(:|"]},speechless:{title:"Speechless",codes:[":|",":=|",":-|"]},kiss:{title:"Kiss",codes:[":*",":=*",":-*"]},"tongue-out":{title:"Tongue Out",codes:[":P",":=P",":-P",":p",":=p",":-p"]},blush:{title:"Blush",codes:["(blush)",":$",":-$",":=$",':">']},wondering:{title:"Wondering",codes:[":^)"]},sleepy:{title:"Sleepy",codes:["|-)","I-)","I=)","(snooze)"]},dull:{title:"Dull",codes:["|(","|-(","|=("]},"in-love":{title:"In love",codes:["(inlove)"]},"evil-grin":{title:"Evil grin",codes:["]:)",">:)","(grin)"]},talking:{title:"Talking",codes:["(talk)"]},yawn:{title:"Yawn",codes:["(yawn)","|-()"]},puke:{title:"Puke",codes:["(puke)",":&",":-&",":=&"]},"doh!":{title:"Doh!",codes:["(doh)"]},angry:{title:"Angry",codes:[":@",":-@",":=@","x(","x-(","x=(","X(","X-(","X=("]},"it-wasnt-me":{title:"It wasn't me",codes:["(wasntme)"]},party:{title:"Party!!!",codes:["(party)"]},worried:{title:"Worried",codes:[":S",":-S",":=S",":s",":-s",":=s"]},mmm:{title:"Mmm...",codes:["(mm)"]},nerd:{title:"Nerd",codes:["8-|","B-|","8|","B|","8=|","B=|","(nerd)"]},"lips-sealed":{title:"Lips Sealed",codes:[":x",":-x",":X",":-X",":#",":-#",":=x",":=X",":=#"]},hi:{title:"Hi",codes:["(hi)"]},call:{title:"Call",codes:["(call)"]},devil:{title:"Devil",codes:["(devil)"]},angel:{title:"Angel",codes:["(angel)"]},envy:{title:"Envy",codes:["(envy)"]},wait:{title:"Wait",codes:["(wait)"]},bear:{title:"Bear",codes:["(bear)","(hug)"]},"make-up":{title:"Make-up",codes:["(makeup)","(kate)"]},"covered-laugh":{title:"Covered Laugh",codes:["(giggle)","(chuckle)"]},"clapping-hands":{title:"Clapping Hands",codes:["(clap)"]},thinking:{title:"Thinking",codes:["(think)",":?",":-?",":=?"]},bow:{title:"Bow",codes:["(bow)"]},rofl:{title:"Rolling on the floor laughing",codes:["(rofl)"]},whew:{title:"Whew",codes:["(whew)"]},happy:{title:"Happy",codes:["(happy)"]},smirking:{title:"Smirking",codes:["(smirk)"]},nodding:{title:"Nodding",codes:["(nod)"]},shaking:{title:"Shaking",codes:["(shake)"]},punch:{title:"Punch",codes:["(punch)"]},emo:{title:"Emo",codes:["(emo)"]},yes:{title:"Yes",codes:["(y)","(Y)","(ok)"]},no:{title:"No",codes:["(n)","(N)"]},handshake:{title:"Shaking Hands",codes:["(handshake)"]},skype:{title:"Skype",codes:["(skype)","(ss)"]},heart:{title:"Heart",codes:["(h)","<3","(H)","(l)","(L)"]},"broken-heart":{title:"Broken heart",codes:["(u)","(U)"]},mail:{title:"Mail",codes:["(e)","(m)"]},flower:{title:"Flower",codes:["(f)","(F)"]},rain:{title:"Rain",codes:["(rain)","(london)","(st)"]},sun:{title:"Sun",codes:["(sun)"]},time:{title:"Time",codes:["(o)","(O)","(time)"]},music:{title:"Music",codes:["(music)"]},movie:{title:"Movie",codes:["(~)","(film)","(movie)"]},phone:{title:"Phone",codes:["(mp)","(ph)"]},coffee:{title:"Coffee",codes:["(coffee)"]},pizza:{title:"Pizza",codes:["(pizza)","(pi)"]},cash:{title:"Cash",codes:["(cash)","(mo)","($)"]},muscle:{title:"Muscle",codes:["(muscle)","(flex)"]},cake:{title:"Cake",codes:["(^)","(cake)"]},beer:{title:"Beer",codes:["(beer)"]},drink:{title:"Drink",codes:["(d)","(D)"]},dance:{title:"Dance",codes:["(dance)","\\o/","\\:D/","\\:d/"]},ninja:{title:"Ninja",codes:["(ninja)"]},star:{title:"Star",codes:["(*)"]},mooning:{title:"Mooning",codes:["(mooning)"]},finger:{title:"Finger",codes:["(finger)"]},bandit:{title:"Bandit",codes:["(bandit)"]},drunk:{title:"Drunk",codes:["(drunk)"]},smoking:{title:"Smoking",codes:["(smoking)","(smoke)","(ci)"]},toivo:{title:"Toivo",codes:["(toivo)"]},rock:{title:"Rock",codes:["(rock)"]},headbang:{title:"Headbang",codes:["(headbang)","(banghead)"]},bug:{title:"Bug",codes:["(bug)"]},fubar:{title:"Fubar",codes:["(fubar)"]},poolparty:{title:"Poolparty",codes:["(poolparty)"]},swearing:{title:"Swearing",codes:["(swear)"]},tmi:{title:"TMI",codes:["(tmi)"]},heidy:{title:"Heidy",codes:["(heidy)"]},myspace:{title:"MySpace",codes:["(MySpace)"]},malthe:{title:"Malthe",codes:["(malthe)"]},tauri:{title:"Tauri",codes:["(tauri)"]},priidu:{title:"Priidu",codes:["(priidu)"]}},
  
  // Set idle and away timeout
  idleTimeout: 1 * 10 * 1000,
  awayTimeout: 10 * 60 * 1000,
  idleTimeoutID: null, 
  awayTimeoutID: null,

  // Month and days name
  myDays: ["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
  myMonth: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ],

  currentPartner: function(){
    var self = this;
    var url = document.URL;
    var partner = url.split('/').pop();

    return partner;
  },

  onload: function() { 
    setTimeout(function(){
      $(".loadingPop").html('<span>No Chats</span>');
    },5000)
  },

  /**
   * Setup Firebase Data Reference
   */
  setupFirebaseRef: function() {
    this.ref.main = new Firebase( firebase_root.userchat );
    this.ref.userList = this.ref.main.child('users');
    /*this.ref.userChannelList = this.ref.main.child('channel').child( current_user.user_code_id );
    this.ref.myUser = this.ref.userList.child( current_user.user_code_id );*/


    this.ref.userCurrent = this.ref.userList.child(current_user.user_code_id);
    this.ref.userProfile = this.ref.userCurrent.child('profile');
    this.ref.userChannelList = this.ref.userCurrent.child('channel');
    this.ref.userLastChat = this.ref.userCurrent.child('last_chat');
    this.ref.userNotification = this.ref.userCurrent.child('notification');
    this.ref.userLastNotification = this.ref.userCurrent.child('last-notification');

  },

  /**
   * Cache element variable
   */
  setupElements: function() {
    //console.log("chat_popup.js :", root.base_url);
    this.el.$chatboxlist = $('.chatbox-list');
    this.el.$chatMessageTpl = $('#chatboxpop-message').html();
    this.el.$imageMediaPopTpl = $('#image-media-tpl-pop').html();
    this.el.$closebtn = $('#closebtn');
    this.el.$chatSection = $('.chat-section');
    
  },

  /**
   * Event Binding
   */
  eventBinding: function() {
    this.el.$chatSection.on('click', '.chat-delete-pop', $.proxy(this.deleteChannel, this));
    this.el.$chatSection.on('click', '.chat-delete-item-pop', $.proxy(this.deleteChatItem, this));
    this.el.$chatSection.on('click', '.btn-emoticon-pop', $.proxy(this.showEmoticonPop, this));
    this.el.$chatSection.on('click', '.chat-image-pop', $.proxy(this.attachImage, this));
    this.el.$chatSection.on('click', '.chat-video-pop', $.proxy(this.attachVideo, this));

    this.el.$chatboxlist.on('keydown', '.chatbox-textarea-pop', $.proxy(this.sendChatMessagePop, this));
    this.el.$closebtn.on('click', $.proxy(this.closeCurrentWindow, this));
  },

  checkFirst : function(){
    var self = this;
    var partner = self.currentPartner();

    self.ref.userList.child(partner).once('value', function(snapshot){
      var dataUser = snapshot.val()
      var users = dataUser.profile;

      if (users.status == 'offline') {
        if (current_user.subscription == 'false' && config_settings.chat==='false') {
          $('.textarea_'+partner).attr('disabled', true);
          $('.textarea_'+partner).attr('placeholder', 'please upgrade subscription to continue chat');
        };
      };
    });

    self.ref.userList.on('child_changed', function(snapshot){
      var dataUser = snapshot.val()
      var users = dataUser.profile;

      if (users.status == 'offline') {
        if (current_user.subscription == 'false' && config_settings.chat==='false') {
          $('.textarea_'+partner).attr('disabled', true);
          $('.textarea_'+partner).attr('placeholder', 'please upgrade subscription to continue chat');
        };
      } else if (users.status == 'online') {
        $('.textarea_'+partner).attr('disabled', false);
        $('.textarea_'+partner).attr('placeholder', 'chat here');
      };
    });
  },

  showEmoticonPop: function(e){
    e.preventDefault();
    var self = this;
    $.emoticons.define(self.definitionEmo);
    var $chatbox = $(e.currentTarget).closest('.btn-emoticon-pop'),
        codeId = $chatbox.data('id');

    //console.log(codeId);

    var option = $('.emoticon-options-pop');
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

    self.hideEmoticon();

  },

  hideEmoticon: function(){
    var option = $('.emoticon-options-pop');
    $(document).click(function(event) { 
      if (event.target.className !== 'fa fa-smile-o' && event.target.className !== 'btn-emoticon-pop pull-left') {
        option.slideUp();
      };
    });
  },

  attachImage : function(e){
    //e.preventDefault();
    var $chatbox = $(e.currentTarget).closest('.chat-image-pop'),
        partner = $chatbox.data('id');

    $('#upload-content-pop-'+partner).toggle('fast');
    $('#upload-content-pop-'+partner).html('<div class="overlay-loading-image loading-img-pop-'+partner+'" style="font-size:12px;width: 258px;"><img src="'+ root.base_url +'public/assets/img/ajax-loader.gif"><p>Please wait, process upload image</p></div><form id="form-image-pop-'+partner+'" method="post">' +
      '<span type="button" class="btn-custom btn-file"> Choose From Device' +
      '<input type="file" class="file-load-pop" id="loader-pop-'+partner+'" name="image"></span>' +
      '<span class="avaliable-image" id="avaliable-image-pop-'+partner+'">Choose Avaliable Image</span>' +
      '<span class="info-upload-pop"><p class="default">Please Select Image First</p></span>' +
      '<input type="submit" class="send-image" name="send-image-pop-'+partner+'" value="SEND IMAGE">' +
      '<input type="button" class="cancel-image" name="cancel-image-pop-'+partner+'" value="CANCEL">' +
    '</form>');
    
    this.sendPicture(partner);
  },

  sendPicture: function(partner){
    $('#form-image-pop-'+partner).on('submit', function(event){
      $('.loading-img-pop-'+partner).show();
      //console.log(partner);
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
              url: root.base_url+'photo/postMediaChat',
              type: 'post',
              data: {from: current_user.user_code_id, to: partner, type:'image', filename: data.file_name},
              success: function(data){
                console.log('success');
                if (data == 1) {
                  var chat = refChatting.push();

                  var chat = self.ref.main.child('chat').child(partner).child(person[0] + '-' + person[1]);
                  var pushSelf = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

                  var timestampChat = Firebase.ServerValue.TIMESTAMP;
                  //console.log(timestampChat);

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
                    status: 'read',
                    ts: timestamp
                  };
                  
                  chat.push(chatData);
                  pushSelf.push(chatDataSelf);

                  $('#loader-pop-'+partner).replaceWith($('#loader-pop-'+partner).val('').clone(true));
                  $('#upload-content-pop-'+partner).toggle('hide');
                  $('#upload-content-pop-'+partner).html('');
                  $('.loading-img-pop-'+partner).hide();
                }else{
                  console.log('error');
                };
              }  
            });
          } else {
            $('.loading-img-pop-'+partner).show();
            $('.info-upload-pop').html(data.error);
          }
        }        
      });
      return false;
    });

    $('.file-load-pop').on('change', function(event){
      var fileName = event.target.value;
      //var split = fileName.split("\\").slice(2,3).join('');
      $('.info-upload-pop').html('<p>'+fileName+'</p>');
    });

    $('#avaliable-image-pop-'+partner).on('click', function(e){

      $('#send-chat-image-pop').removeClass('send-chat-image');
      $('#send-chat-image-pop').addClass('btn-image-disabled');
      $('#send-chat-image-pop').attr('disabled', true);
      $('#send-chat-image-pop').attr('data-id', partner);
      $('#media-image-pop').modal('toggle');

      var person = [current_user.user_code_id, partner].sort();
      var ref = new Firebase( firebase_root.userchat );
      var refChatting= ref.child('chat').child(person[0] + '-' + person[1]);
      $('#referensi-chat-pop').val(refChatting);

      //$('.info-upload').html('<p>Not Ready</p>');

      $.ajax({
          url: root.base_url+'chat/getMedia',
          success: function (data) {

            $.each( data, function( key, value ) {
              if (value.media_type == 'image') {
                var link_image = value.media_file_name;
                $('#media-image-pop').find('#content-chat-image-pop').prepend('<div class="image-chat-galery col-md-4" data-link="'+link_image+'"><img src="'+ link_image +'"></div>');
              };
            });

            //select image
            $( '.image-chat-galery > img' ).click(function(e) {
              e.preventDefault();

              var $imagebox = $(e.currentTarget).closest('.image-chat-galery'),
                  linkImage = $imagebox.data('link');

              $('#select-chat-image-pop').val(linkImage);

              if( $(this).is('.selected') ) {
                  $(this).removeClass( 'selected' );
                  $('#select-chat-image-pop').val('');
                  $('#send-chat-image-pop').removeClass('send-chat-image');
                  $('#send-chat-image-pop').attr('disabled', true);
                  $('#send-chat-image-pop').addClass('btn-image-disabled');
              }
              else {
                  $( 'img.selected' ).removeClass('selected');
                  $(this).addClass( 'selected' );
                  $('#send-chat-image-pop').addClass('send-chat-image');
                  $('#send-chat-image-pop').attr('disabled', false);
                  $('#send-chat-image-pop').removeClass('btn-image-disabled');
              }
              return false;
            });

            //send image 
            $('#send-chat-image-pop').on('click', function(e) {
              var $imagebox = $(e.currentTarget).closest('#send-chat-image-pop'),
                  partnerChat = $imagebox.data('id');

              var fileImageLink = $('#select-chat-image-pop').val();

              $.ajax({
                url: root.base_url+'chat/postMediaChatAvaliable',
                type: 'post',
                data: {from: current_user.user_code_id, to: partner, type:'image', filename: fileImageLink},
                success: function(dataImg){
                  
                  if (dataImg == 1) {
                    var varRef = $('#referensi-chat-pop').val();
                    var refer = new Firebase(varRef);
                    
                    var imageMessage = 'image='+fileImageLink;
                    var timestamp = Math.round( new Date().getTime() / 1000 );

                    var chatReferensiPush = refer.push();
                    var timestampChat = Firebase.ServerValue.TIMESTAMP;

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
                      to: partner,
                      message: imageMessage,
                      status: 'read',
                      ts: timestamp
                    };
                    
                    // chatReferensiPush.setWithPriority(chatData, timestampChat);
                    chat.push(chatData);
                    pushSelf.push(chatDataSelf);

                    $('#media-image-pop').modal('hide');
                    $('#upload-content-pop-'+partnerChat).toggle('hide');
                    $('#upload-content-pop-'+partnerChat).html('');
                  }else{
                    console.log('error');
                  };
                  
                }  
              });

            });

          }
      });

      //$('.info-upload-pop').html('<p>Not Ready</p>');
    });
    
     //when hidden
    $('#media-image-pop').on('hidden.bs.modal', function(e) { 
      $('#media-image-pop').find('#content-chat-image-pop').html('');
      $('#select-chat-image-pop').val('');
      $('#referensi-chat-pop').val('');
    });
    
    //cancel send from avaliable image
    $('.cancel-chat-image').on('click', function(){
      $('#media-image-pop').modal('hide');
      $('#media-image-pop').find('#content-chat-image-pop').html('');
      $('#select-chat-image-pop').val('');
      $('#referensi-chat-pop').val('');
    });

    $('.cancel-image').on('click', function(){
      $('#loader-pop-'+partner).replaceWith($('#loader-'+partner).val('').clone(true));
      $('#upload-content-pop-'+partner).toggle('hide');
      $('#upload-content-pop-'+partner).html('');
    });

  },

  attachVideo : function(e){
    //e.preventDefault();
    var $chatbox = $(e.currentTarget).closest('.chat-video-pop'),
        partner = $chatbox.data('id');

    $('#upload-content-video-pop-'+partner).toggle('fast');
    $('#upload-content-video-pop-'+partner).html('<div class="overlay-loading loading-vid-pop-'+partner+'" style="font-size:12px;width: 258px;"><img src="'+ root.base_url +'public/assets/img/ajax-loader.gif"><p>Please wait, process upload video</p></div>'+
      '<form id="form-video-pop-'+partner+'" method="post">' +
      '<span class="btn-custom btn-file"> Choose Video From Device' +
      '<input type="file" class="file-load-video" id="loader-video-pop-'+partner+'" name="video"></span>' +
      '<span class="avaliable-image" id="avaliable-video-pop-'+partner+'">Choose Avaliable Video</span>' +
      '<span class="info-upload"><p class="default">Please Select File Video First</p></span>' +
      '<input type="submit" class="send-image" name="send-video-pop-'+partner+'" value="SEND VIDEO">' +
      '<input type="button" class="cancel-image" name="cancel-video-pop-'+partner+'" value="CANCEL">' +
    '</form>');
    this.sendVideo(partner);
  },

  sendVideo: function(partner){
    var self = this;

    $('#form-video-pop-'+partner).on('submit', function(event){
      $('.loading-vid-pop-'+partner).show();
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
              url: root.base_url+'photo/postMediaChat',
              type: 'post',
              data: {from: current_user.user_code_id, to: partner, type:'video', filename: data.file_name},
              success: function(data){
                console.log('success');
                if (data == 1) {

                  var chat = refChatting.push();
                  var timestampChat = Firebase.ServerValue.TIMESTAMP;

                  var chat = self.ref.main.child('chat').child(partner).child(person[0] + '-' + person[1]);
                  var pushSelf = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);


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

                  $('#loader-video-pop-'+partner).replaceWith($('#loader-video-pop-'+partner).val('').clone(true));
                  $('#upload-content-video-pop-'+partner).toggle('hide');
                  $('#upload-content-video-pop-'+partner).html('');
                  $('.loading-vid-pop-'+partner).hide();
                }else{
                  console.log('error');
                };
              }  
            });
            //console.log("Data Sent :", data);
          } else {
            $('.loading-vid-pop-'+partner).hide();
            $('.info-upload').html(data.error);
            //console.log("Data Not Sent :", data);
          }
        }     

      });

      return false;
    });

    $('#loader-video-pop-'+partner).bind('change', function(event){
      var fileName = event.target.value;
      var files = this.files[0];

      /*$('.info-upload').html('<div class="progress">' +
        '<div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">' +
        '<span">upload progress</span>' +
        '</div></div>');*/

        var fileSize = 0;
        if (files.size > 1024 * 1024){
          fileSize = (Math.round(files.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
          
        } else {
          fileSize = (Math.round(files.size * 100 / 1024) / 100).toString() + 'KB';  
        }
        
        $('.info-upload').html('<p>'+fileName+'&nbsp; '+ fileSize+'</p>');
        //console.log(fileSize);
      
    });

    $('#avaliable-video-pop-'+partner).on('click', function(e){
      $('.info-upload').html('<p>Features not ready</p>');
      /*$('#send-chat-video-pop').removeClass('send-chat-video');
      $('#send-chat-video-pop').addClass('btn-video-disabled');
      $('#send-chat-video-pop').attr('disabled', true);
      $('#send-chat-video-pop').attr('data-id', partner);
      $('#media-video-pop').modal('toggle');*/
    });

    $('.cancel-image').on('click', function(){
      $('#loader-video-pop-'+partner).replaceWith($('#loader-video-pop-'+partner).val('').clone(true));
      $('#upload-content-video-pop-'+partner).toggle('hide');
      $('#upload-content-video-pop-'+partner).html('');
    });

  },

  deleteChannel: function(e){
    var self = this;
    var $chatbox = $(e.currentTarget).closest('.chat-box'),
        chatId = $chatbox.data('id');

     var person = [current_user.user_code_id, chatId].sort();
    
    lastChatSender = this.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

    $('#confirm-delete-chat-pop-'+chatId).toggle('fast');
    $('#confirm-delete-chat-pop-'+chatId).html('<span style="position: absolute; padding-top:10%;text-align:center;">Sure to delete your conversation with  ' + chatId + ' ? <br/><br/>' +
      '<input type="button" class="cancel-del-conver-pop" id="cancel-delete-'+chatId+'" value="Cancel">&nbsp;<input type="button" class="del-conver-pop" id="sure-delete-'+chatId+'" value="Delete">' +
      '</span>');

    $('#sure-delete-'+chatId).on('click', function(){
      lastChatSender.remove();
      window.close();

      $('#confirm-delete-chat-pop-'+chatId).toggle('hide');
    });

    $('#cancel-delete-'+chatId).on('click', function(){
      $('#confirm-delete-chat-pop-'+chatId).toggle('hide');
    });
    
    
  },

  deleteChatItem: function(e){
    var self = this;
    var $chatbox = $(e.currentTarget).closest('.chat-box'),
        partner = $chatbox.data('id');
        
    $chatbox.find('.option-item-chat-pop').toggle('fast');
    $chatbox.find('.option-chat-item-check').toggle('fast');

    $('.btn-cancel-delete-pop').on('click', function(){
      $('input:checkbox[name=checkbox-chat]').each(function(){ 
        this.checked = false; 
      }); 
      $chatbox.find('.option-item-chat-pop').hide('fast');
      $chatbox.find('.option-chat-item-check').hide('fast');

    });

    $('.btn-delete-item-chat-pop').on('click', function(){
      $("input:checkbox[name=checkbox-chat-pop]:checked").each(function(){
        var codeChat = $(this).val();
        var person = [current_user.user_code_id, partner].sort();
        var pushChatRef = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

        pushChatRef.child(codeChat).remove();
        $('li#'+codeChat).remove();

      });

      $chatbox.find('.option-item-chat-pop').hide('fast');
      $chatbox.find('.option-chat-item-check').hide('fast');
    });
  },

  monitorPopUp: function(){
    var self = this;
    var partner = self.currentPartner();

    var senderChannel = self.ref.userChannelList.child(partner);

    /*senderChannel.onDisconnect();*/
    /*senderChannel.onDisconnect().update({
      box_chat: 'ready',
    });*/
  },

  checkChating: function(){
    var self = this;

    var partner = self.currentPartner();
    var person = [current_user.user_code_id, partner].sort();

    self.userChattingPop[current_user.user_code_id] = self.ref.main.child('chat').child(current_user.user_code_id).child(person[0] + '-' + person[1]);

    $('.chat-popup').find('.chat-module-content').animate({scrollTop: $('.chat-popup').find('ul.chat-message-pop').height()});
    $('.navbar-fixed-top').find('.panel-title').html( partner );

    $('.chat-popup').find('.chat-box').attr('id', 'chatpop_'+partner);
    $('.chat-popup').find('.chat-box').attr('data-id', partner);
    $('.chat-popup').find('.chat-image-pop').attr('data-id', partner);
    $('.chat-popup').find('.chat-video-pop').attr('data-id', partner);
    $('.chat-popup').find('.upload-content-pop').attr('id', 'upload-content-pop-'+partner);
    $('.chat-popup').find('.upload-content-video-pop').attr('id', 'upload-content-video-pop-'+partner);
    $('.chat-popup').find('.emoticon-options-pop').attr('data-id', partner);
    $('.chat-popup').find('.btn-emoticon-pop').attr('data-id', partner);
    $('.chat-popup').find('.chatbox-textarea-pop').addClass('textarea_'+partner);
    $('.chat-popup').find('.confirm-delete-chat-pop').attr('id', 'confirm-delete-chat-pop-'+partner);

    $('#chatpop_' + partner).find('.chatbox-textarea-pop').focus();

    // var lastChatRef = self.ref.userLastChat.child(partner);
 
    // lastChatRef.once('value', function(snapshot) {
    //   //var lastStamp = snapshot.val().ts;
    //   var lastStamp = snapshot.getPriority();

    //   self.userChattingPop[partner].startAt(lastStamp).on('child_added', function(snapshot){
    //     var chat = snapshot.val();
    //     self.addMessageToChatbox(partner, chat, true );
    //   });

    // });

    var lastChatRef = self.userChattingPop[current_user.user_code_id];

    lastChatRef.on('child_added', function(snapshot){
      var chat = snapshot.val();
      var chatName = snapshot.name();
      self.addMessageToChatbox(partner, chat, chatName, true );
    });

    /* change read/unread */
    lastChatRef.on("child_changed", function(snapshot){
      var chats = snapshot.val();
      if(chats.status === 'read'){
        if(current_user.user_code_id == chats.from){
          $('#'+chats.ts).html('read');
        }
      } else {
        if(current_user.user_code_id == chats.from){
          $('#'+chats.ts).html('unread');
        }
      }

    });
   
  },

  addMessageToChatbox: function( partner, chat, chatName, scrollDown) {
    var self = this;

    chat.tsStat = chat.ts
    chat.ts = self.getConvertTimeChat(chat.ts);

    if( chat.from == current_user.user_code_id ) {
      chat.classname = 'self';
    } else {
      chat.status = '';
    }

    var chatMessage = Mustache.render( self.el.$chatMessageTpl, {
        code_id : chat.code_id,
        filename_thumb : chat.filename_thumb,
        classname : chat.classname,
        message : chat.message,
        status : chat.status,
        ts : chat.ts,
        tsStat : chat.tsStat,
        chat_id : chatName
    });

    var $chatbox = this.el.$chatboxlist.find('#chatpop_' + partner);

    $('.chat-popup').find('ul.chat-message-pop').append( chatMessage );
    $('.chat-module-content').perfectScrollbar();

    self.render(chat.from, chat.tsStat);
    $(".loadingPop").hide();
    if( scrollDown ) {
      $chatbox.find('.chat-module-content').animate(
        {scrollTop: $chatbox.find('ul.chat-message-pop').height()},
        50
      )
    }
  },

  render: function(from, ts){
    $.emoticons.define(this.definitionEmo); 
    var message = this.el.$chatboxlist.find('.msg_pop_'+ts);
    var chat = message[0].textContent;
    var chatingType = chat.split('=').slice(0,1).join('');
    var linkSource = chat.split('=').slice(1,2).join('');

    // set if emoticon
    var checking = $.emoticons.replace(chat);
    message.html(checking);

    //set if chat is image
    if(chatingType == 'image'){
      var chating = '<img src="'+ linkSource +'" class="image-chat">';
      console.log("ada");
      message.addClass('image-display');
      message.html(chating);
      message.attr('data-link', linkSource);
      message.attr('data-from', from);

      $('.image-display').on('click', function(e){
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

  sendChatMessagePop: function( e ) {
    if( e.keyCode == 13 && e.shiftKey == 0 ) {
      var self = this,
          $textarea = $(e.currentTarget),
          message = $textarea.val();

      var chatId = self.currentPartner();

      // Clean up message
      message = message.replace(/^\s+|\s+$/g,"");

      // Empty textarea
      $textarea.val('');

      // Push Chat
      if( message != '' ) {

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
        pushSelf.push(chatData);

        var userRef = self.ref.main.child( 'users' ).child( chatId ),/*
            senderChannel = this.ref.userChannelList.child( chatId ),
            partnerChannel = this.ref.main.child('channel').child( chatId ).child( current_user.user_code_id );*/
            senderChannel = self.ref.userChannelList.child(chatId),
            partnerChannel = self.ref.userList.child(chatId).child('channel').child(current_user.user_code_id);
            
            //lastChatSender = self.ref.userLastChat,
            //lastChatPartner = self.ref.userList.child(chatId).child('last_chat');

            partnerChannel.once("value", function(snapshot){
              var data = snapshot.val();

              if (!data) {
                console.log("create partner chat channel");
                partnerChannel.set({
                  box_chat: 'open',
                  from: current_user.user_code_id,
                  ts: self.getTimeStamp()
                });
              } else {
                if (data.box_chat === 'popup') {
                  console.log("POPUP : ", data);
                  $('.chat-popup').find('.chat-module-content').animate({scrollTop: $('.chat-popup').find('ul.chat-message-pop').height()});
                } else {
                  partnerChannel.set({
                    box_chat: 'open',
                    from: current_user.user_code_id,
                    ts: self.getTimeStamp()
                  });
                  $('.chat-popup').find('.chat-module-content').animate({scrollTop: $('.chat-popup').find('ul.chat-message-pop').height()});
                  $('#chatbox_'+chatId).find('.chat-module-content').animate({scrollTop:  $('#chatbox_'+chatId).find('ul.chat-message-pop').height()});
                  //console.log("OPEN : ", data);
                };
              };
              
            });
      }

      return false;
    }
  },

  closeCurrentWindow: function(e){
    var self = this;
    var chatId = self.currentPartner();
    
    var senderChannel = self.ref.userChannelList.child(chatId);

    //console.log(chatId);   
    senderChannel.update({
      box_chat: 'open'
    });
    window.close();
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

  getTimeStamp: function() {
    return Math.round( new Date().getTime() / 1000 );
  },
  
  /**
   * Initialization
   */
  init: function() {
    // Check if chat section exists or Firebase not loaded
    if( !$('.chat-section').length || typeof Firebase == 'undefined' || typeof current_user == 'undefined' ) {
      return;
    }

    this.setupFirebaseRef();
    this.setupElements();
    this.eventBinding();
    this.checkChating();
    this.monitorPopUp();
    this.onload();
    this.checkFirst();
    
  }



};

$(document).ready(function(){
  FirebaseChatPopUp.init();
});

})(jQuery);