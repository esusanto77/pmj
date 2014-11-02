jQuery.noConflict()(function ($) {
  $(document).ready(function () {

    var messageCustom = { 
      el: {},

      /**
       * Cache element variable
       */
       setupElements: function() {
        this.el.$buttonDeleteMessageSubjectButton = $('#delMessageSubjectButton');
        this.el.$buttonDeleteMessageIdButton= $('#delIdMessageButton');
        this.el.$dialogErrorDelMessage = $("#errorDelMessage");
        this.el.$buttonDetailMessage = $(".click-detail-message");
        this.el.$buttonInboxMessage = $(".btn-message-inbox");
        this.el.$buttonSentMessage = $(".btn-message-sent");
      },

      /**
       * Event Binding
       */
       eventBinding: function() {
        this.el.$buttonDeleteMessageSubjectButton.on('click', '', $.proxy(this.deleteMessageSubject, this));
        this.el.$buttonDeleteMessageIdButton.on('click', '', $.proxy(this.deleteMessageId, this));
        this.el.$buttonDetailMessage.on('click', $.proxy(this.detailMessageLoad, this));
        this.el.$buttonInboxMessage.on('click', $.proxy(this.inboxMessageLoad, this));
        this.el.$buttonSentMessage.on('click', $.proxy(this.sentMessageLoad, this));
      },

      /*Detail Message*/
      detailMessageLoad: function(){
        $('#pageloader').show();
        //console.log('test');
      },

      /*Inbox Message*/
      inboxMessageLoad: function(){
        $('#pageloader').show();
        //console.log('test');
      },

      /*Sent Message*/
      sentMessageLoad: function(){
        $('#pageloader').show();
        //console.log('test');
      },

      /* Delete Message Subject */
      deleteMessageSubject: function(){
        var self = this;

        id_array=new Array()
        i=0;

        $("input.delMessageSubject:checked").each(function(){
          id_array[i]=$(this).val();
          i++;
        });

        if(i>0){
            bootbox.confirm("Are you sure want to delete?", function(result) {
              if(result===true){
                  $.ajax({
                  url: root.base_url+'message/delMessage',
                  data: {msg_code: id_array,info:"subject"}, 
                  type:"POST",
                  success:function(respon)
                  {
                    if(respon==1)
                    {
                        $("input.delMessageSubject:checked").each(function(){
                        $(this).prop('checked', false); 
                        $(this).parent().parent().parent().remove('.delMessageSubject').animate({ opacity: "hide" }, "slow");
                      });
                        i=0;
                        id_array.length = 0;
                    }else{

                    }
                  }
                });
              }
              
            });

        }else{
           self.el.$dialogErrorDelMessage.on('show.bs.modal', messageCustom.centerModal);

          $(window).on("resize", function () {
            $('#errorDelMessage:visible').each(messageCustom.centerModal);
          });

          self.el.$dialogErrorDelMessage.modal();
        }
      },

      /* Delete Message Id */
      deleteMessageId: function(){
        var self = this;

        id_array=new Array()
        i=0;

        $("input.delIdMessage:checked").each(function(){
          id_array[i]=$(this).val();
          i++;
        });

        if(i>0){
            bootbox.confirm("Are you sure want to delete?", function(result) {
              if(result===true){
                  $.ajax({
                  url: root.base_url+'message/delMessage',
                  data: {msg_id: id_array,info:"id"}, 
                  type:"POST",
                  success:function(respon)
                  {
                    if(respon==1)
                    {
                        $("input.delIdMessage:checked").each(function(){
                        $(this).prop('checked', false); 
                        $(this).parent().parent().parent().remove('.delIdMessage').animate({ opacity: "hide" }, "slow");
                      });
                        i=0;
                        id_array.length = 0;
                    }else{

                    }
                  }
                });
              }
              
            });

        }else{
          self.el.$dialogErrorDelMessage.on('show.bs.modal', messageCustom.centerModal);

          $(window).on("resize", function () {
            $('#errorDelMessage:visible').each(messageCustom.centerModal);
          });

          self.el.$dialogErrorDelMessage.modal();
        }
      },

       /* Center Modal */
      centerModal:function(){
        $(this).css('display', 'block');
        var $dialog = $(this).find(".modal-dialog");
        var offset = ($(window).height() - $dialog.height()) / 2;
          // Center modal vertically in window
          $dialog.css("margin-top", offset);
      },


      /**
       * Initialization
       */
       init: function() {
        this.setupElements();
        this.eventBinding();
      }


    };

    var searchMessage = {
      el: {},

      /**
       * Cache element variable
       */
       setupElements: function() {
        this.el.$searchFormMessageId = $('.search-messages-id');
        this.el.$searchFormMessageSubject = $('.search-messages-subject');
        this.el.$searchFormControl = $('.form-control');
        this.el.$subjectMessage = $('.subject-message');
        this.el.$subjectMessageIndex = $('.subject-message-index');
      },

       /**
       * Event Binding
       */
       eventBinding: function() {
        this.el.$searchFormMessageId.on('keyup', '', $.proxy(this.searchMessageByID,this,'id'));
        this.el.$searchFormMessageSubject.on('keyup', '', $.proxy(this.searchMessageByID,this,'subject'));
      },

      searchMessageByID: function(id){
        var self = this;
        
         $.ajax({
                  url: root.base_url+'message/searchMessage/',
                  data: {key: self.el.$searchFormControl.val(),msg_code: self.el.$subjectMessage.val(),info:id,subject_for: self.el.$subjectMessageIndex.val()}, 
                  type:"GET",
                  beforeSend: function () { 
                    $(".user-messages-list").html('<div class="loadingUserOnline" style="text-align: center; padding: 5% 0;"><span><img src="'+root.base_url+'/public/assets/img/ajax-loader.gif"></span></div>');
                  },
                  success:function(respon)
                  {
                   
                    if(respon.count > 0){
                        $(".user-messages-list").html('');
                        $(".pagination").html('');
                        for (i = 0; i < Object.keys(respon.user).length; i++) { 
                          $("#messageTemplate .message-sender .avatar").attr("src",respon.user[i].avatar_photo);
                          $("#messageTemplate .message-sender-name").html(respon.user[i].code_id);
                          $("#messageTemplate .message-date").html(respon.user[i].msg_date);
                          $("#messageTemplate .message-text").html("<p>"+respon.user[i].msg_content+"</p>");
                          $("#messageTemplate .message-checkbox").html("<input type='checkbox' value='"+respon.user[i].msg_id+"' name='delIdMessage[]'' class='delIdMessage'/>");
                          $("#messageTemplate .message-title").html('<a href="'+respon.user[i].url_message+'" class="click-detail-message">'+respon.user[i].msg_subject+'</a>');

                          $(".user-messages-list").append($("#messageTemplate").html());
                        }
                    }else{
                       $(".user-messages-list").html('<div class="loadingUserOnline" style="text-align: center; padding: 5% 0;"><span>Message Not Found</span></div>');
                    }  


                  }
                });

            
      },

        /**
       * Initialization
       */
       init: function() {
        this.setupElements();
        this.eventBinding();
      }

    };

    searchMessage.init();
    messageCustom.init();

  });
});