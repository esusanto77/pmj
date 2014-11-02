jQuery.noConflict()(function ($) {
  $(document).ready(function () {

    var contact = { 
      el: {},

      /**
       * Cache element variable
       */
       setupElements: function() {
        this.el.$buttonEmail = $('#send-email-admin');
        this.el.$labelAlert = $('#alert-message');
        this.el.$formMessage = $('#message-admin');
        this.el.$labelInformation = $('#information-message');
      },

      /**
       * Event Binding
       */
       eventBinding: function() {
        this.el.$buttonEmail.on('click', '', $.proxy(this.submitForm, this));
      },

      /* Submit Form */
      submitForm: function(){
        var self = this;

        $.ajax({
          url: root.base_url+"verification/formContactAdmin",
          type: "POST",
          data: {from:  self.el.$formMessage.val()},
          success: function(data)
          {
            if(data.info==='failed'){
               self.el.$labelAlert.html("Message required");
               self.el.$labelAlert.css({'display':'block'});
               self.el.$labelAlert.show().delay(500).fadeOut();
             }else if(data.info==='success'){
               self.el.$labelInformation.html("Message Send");
               self.el.$labelInformation.css({'display':'block'});
             }
          }        
        });
        return false;
      },

      callBackPhoto: function(param, callback){
        $('.panel').css({'text-align':'center'});
        $('.header-verification').css({'padding-top':'25px','padding-bottom':'25px','margin-top':'60px','margin-bottom':'50px'});
        $('.header-verification').html("<h4>Thank you<br><br>  You will receive an email notification within 48 hours</h4>");
        $('#form-panel').html('<a href="./welcome"><button class="btn btn-lg btn-primary" style="margin-bottom:30px;">Continue</button></a>');
        $('#form-photo-1').css({'display':'none'});
        $('#form-photo-2').css({'display':'none'});
        $('.panel-footer').css({'display':'none'});

        if(callback && typeof(callback) === "function"){
          callback();
        }
      },

      /**
       * Initialization
       */
       init: function() {
        this.setupElements();
        this.eventBinding();
      }


    };

    var report = { 
      el: {},

      /**
       * Cache element variable
       */
       setupElements: function() {
        this.el.$dropDown = $('#message-report');
        this.el.$otherForm = $('#other-form');
        this.el.$btnFormSend = $('#send-report');
        this.el.$txtOther =  $('#message-other');
        this.el.$lblAlertMessageOther =  $('#alert-message-report-other');
        this.el.$txtCodeIdReport =  $('#code-id-report');
        this.el.$lblSuccessReport = $('#information-report');
        this.el.$modalReport = $('#reportUser');
      },

      /**
       * Event Binding
       */
       eventBinding: function() {
        this.el.$dropDown.on('change', '', $.proxy(this.changeDropDown, this));
        this.el.$btnFormSend.on('click', '', $.proxy(this.submitForm, this));
        this.el.$modalReport.on('hidden.bs.modal', '', $.proxy(this.clearModal, this));
      },

      // Clear Modal
      clearModal: function(){
         var self=this;

          self.el.$otherForm.css({'display':'none'});
          self.el.$dropDown.val("Offensive");
          self.el.$lblAlertMessageOther.css({'display':'none'});
          self.el.$lblSuccessReport.css({'display':'none'});
          self.el.$dropDown.prop("disabled", false);
          self.el.$txtOther.prop("disabled", false);
          self.el.$txtOther.val('');
      },

      // Cek dropdown
      changeDropDown: function(){
        var self=this;

        if(self.el.$dropDown.val()==='Other'){
          $(self.el.$otherForm).css({'display':'block'});
        }else{
          $(self.el.$otherForm).css({'display':'none'});
        }
      },

      /* Submit Form */
      submitForm: function(){
          var self = this;
          var message;

          if(self.el.$dropDown.val()==='Other'){
            if(self.el.$txtOther.val()==='' || self.el.$txtOther.val()===null){
               self.el.$lblAlertMessageOther.html("Message required");
               self.el.$lblAlertMessageOther.css({'display':'block'});
               self.el.$lblAlertMessageOther.show().delay(500).fadeOut();
            }else{
              message = self.el.$txtOther.val();
              self.el.$dropDown.prop("disabled", true);
              self.el.$txtOther.prop("disabled", true);
            }
          }else{
              message = self.el.$dropDown.val();
              self.el.$dropDown.prop("disabled", true);
          }

          $.ajax({
            url: root.base_url+"api_login/sendReportUser",
            type: "POST",
            data: {textMessage:  message,userReportCodeId : self.el.$txtCodeIdReport.val()},
            success: function(data)
            {
              console.log(data.info);
              if(data.info==='success'){
                 self.el.$lblSuccessReport.html("Report Send");
                 self.el.$lblSuccessReport.css({'display':'block'});
                 self.el.$lblSuccessReport.show().delay(500).fadeOut();
                 self.el.$dropDown.prop("disabled", false);
                 self.el.$txtOther.prop("disabled", false);
                 self.el.$txtOther.val('');
               }
            }        
          });

          return false;
      },

      /**
       * Initialization
       */
       init: function() {
        this.setupElements();
        this.eventBinding();
      }


    };

    contact.init();
    report.init();
  });
});