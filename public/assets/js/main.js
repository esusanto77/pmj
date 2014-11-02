(function($){

"use strict";

/* ===================================================================
  Root URL Setting
=================================================================== */

var rootUrl = window.location.hostname;
var rootPushNotify = firebase_root.mosaic_url;
rootUrl = root.base_url.substring(0, root.base_url.length - 1);


/* ===================================================================
  Frontend Parallax Background
=================================================================== */

// Request animation frame polyfill
(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] 
                                   || window[vendors[x]+'CancelRequestAnimationFrame'];
    }
 
    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); }, 
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
 
    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());


/* ===================================================================
  Welcome Parallax
=================================================================== */

var welcomeParallax = {
  el: {},
  scrollIntervalID: 0,
  scrollTop: 0,
  parallaxSpeed: 2,
  elementsPosition: [],

  /**
   * Update Page
   */
  updatePage: function() {
    var self = this;

    // Do not animate when on small viewport
    if( this.el.$window.width() > 767 ) {
      window.requestAnimationFrame(function(){
        self.setScrollTops();
        self.animateElements();
      });
    }
  },

  setScrollTops: function() {
    this.scrollTop = this.el.$window.scrollTop();
    // this.windowHeight = this.el.$window.height();
    // this.viewport = this.windowHeight + this.scrollTop;
  },

  animateElements: function() {
    if( $('.anystretch:in-viewport').length > 0 ) {
      var self = this,
          $el = $('.anystretch:in-viewport'),
          scrollTop = this.scrollTop - $el.offset().top;

      $el.find('img').css( 'y', scrollTop / this.parallaxSpeed );
    }
  },

  /**
   * Initialization
   */
  init: function() {

    // Check if on why us page
    if( !$('.section-main').length ) return;

    this.el.$window = $(window);
    this.el.$body = $('body');

    this.scrollIntervalID = setInterval($.proxy(this.updatePage, this), 10);
  }
};


/* ===================================================================
  Mobile Menu
=================================================================== */
var mobileMenu = {
  el: {},

  eventBinding: {
    dashboardPage: function( context ) {
      // left button
      context.el.$userMenuButton.on('click', function(event){
        event.preventDefault();
        context.el.dashboardLeftContent.trigger('open');
      });

      // Right button
      context.el.$userRightButton.on('click', function(event){
        event.preventDefault();
        context.el.dashboardRightContent.trigger('open');
      });
    }
  },

  dashboardPageMenuLeft: function() {
    this.el.$userMenuButton = $('.user-menu-button');
    this.el.$userRightButton = $('.user-right-button');

    var leftContentClone = $('.left-content').clone();

    // Clone left content section
    leftContentClone
      .removeClass('visible-lg visible-md')
      .addClass('visible-sm visible-xs');

    // Wrap Left Content
    this.el.dashboardLeftContent = $('<div id="leftbox" class="leftbox-mobile"></div>');
    this.el.dashboardLeftContent
      .append( leftContentClone )
      .appendTo( this.el.$body )
      .mmenu({
        position  : 'left',
        zposition : 'front',
      }); 
  },

  dashboardPageMenuRight: function() {
    var rightContentClone = $('.main-nav-wrap').clone();

    // Clone right menu
    rightContentClone.find('.main-nav')
      .addClass('visible-xs visible-sm')
      .removeClass('visible-lg main-nav');

    // Modify the dropdown structure


    this.el.dashboardRightContent = $('<div id="rightbox" class="rightbox-mobile"></div>');
    this.el.dashboardRightContent
      .append( rightContentClone )
      .appendTo( this.el.$body )
      .mmenu({
        position  : 'right',
        zposition : 'front',
        // isMenu: false,
        // panelClass: '.visible-md',
        // listClass: '.dropdown-menu'
      });

    this.el.dashboardRightContent.find('b.caret').remove();
    
  },

  dashboardPage: function() {
    // if( this.el.$body.hasClass('dashboard') ) {
      this.dashboardPageMenuLeft();
      this.dashboardPageMenuRight();

      // Event binding on dashboard page
      this.eventBinding.dashboardPage( this );
    // }
  },

  init: function() {
    this.el.$body = $('body');

    // Create menu on Dashboard page
    this.dashboardPage();
  }
};


/* ===================================================================
  QA Section Version 2
=================================================================== */
var qaSection = {

  el: {},
  //totalQuestions: 74,
  currentQuestion: 0,
  supportTrans: false,
  transitionEnd: 'webkitTransitionEnd transitionend OTransitionEnd',
  isSliding: false,


  /**
   * Check CSS3 Support
   */
  checkSupport : function( prop ) {
    var div = document.createElement('div'),
        vendors = 'Khtml Ms O Moz Webkit'.split(' '),
        len = vendors.length;
      
    if ( prop in div.style ) return true;

    prop = prop.replace(/^[a-z]/, function(val) {
      return val.toUpperCase();
    });

    while(len--) {
      if ( vendors[len] + prop in div.style ) {
        // browser supports box-shadow. Do what you need.
        // Or use a bang (!) to test if the browser doesn't.
        return true;
      }
    }
    return false;
  },

  /**
   * Cache variable
   */
  setupElements: function() {
    this.el.$body = $('body');
    this.el.$progressPercent = $('.qa-section-progress span');
    this.el.$progressBar = $('.qa-section-progress .progress-bar');
    this.el.$currentProgress = $('#currentProgress');
    this.el.$currentQategory = $('#currentCategory');

    this.el.$textPercentTrans = $('.qa-progress-heading span');

    this.el.$questionList = $('.qa-question-list');
    this.el.$qaItem = $('.qa-question-item');

    this.el.$qaNavNext = $('.qa-section-nav .next');
    this.el.$qaNavPrev = $('.qa-section-nav .prev');

    //set default progress bar
    var check = $('#currentCounter').val();
    if (check < '0') {
      this.el.$textPercentCheck = $('#currentCounter').val('0');
      $('.qa-section-progress').find('span').text('0%');
    }


    this.el.$checkbox = $('.qa-choice input');
    this.el.$country = $('.country');
    this.el.$ethnic = $('.ethnic-choice');

  },

  /**
   * Event Binding
   */
  eventBinding: function() {
    this.el.$questionList.on('change', '.form-choice', $.proxy(this.radioChanged, this));
    this.el.$questionList.on('ifChecked', '.form-checkbox', $.proxy(this.inputChanged, this));
    this.el.$questionList.on('keyup', '.form-text', $.proxy(this.inputChanged, this));
    this.el.$questionList.on('change', '.form-list', $.proxy(this.inputChanged, this));
    this.el.$questionList.on('change', '.form-country', $.proxy(this.inputChanged, this));
    this.el.$questionList.on('change', '.form-country', $.proxy(this.changeEthnic, this));
    this.el.$questionList.on('mouseout', '.form-datepicker', $.proxy(this.inputChanged, this));
    this.el.$questionList.on('keyup', '.form-1value,.form-2value,.form-3value', $.proxy(this.input3TextChanged, this));
    this.el.$qaNavNext.on('click', $.proxy(this.progressBarStatus, this));
    this.el.$qaNavNext.on('click', $.proxy(this.showNext, this));
    this.el.$qaNavPrev.on('click', $.proxy(this.showPrev, this));
    this.el.$body.on('question:next question:prev', $.proxy(this.navStatus, this));
    // this.el.$body.on('question:next question:prev', $.proxy(this.progressBarStatus, this));
    // this.el.$questionList.on('change', ':radio', $.proxy(this.progressBarStatus, this));
    // this.el.$body.on('question:next', $.proxy(this.preloadQuestions, this));
  },

  changeEthnic: function(e){
    var self = this;
    self.el.$ethnic.addClass('hide');
    $('.ethnic-'+e.val).each(function(){
      $(this).removeClass('hide');
    });
  },

  loadEthnic: function(id){
    var self = this;
    self.el.$ethnic.addClass('hide');
    $('.ethnic-'+id).each(function(){
      $(this).removeClass('hide');
    });
  },

  input3TextChanged: function(event){
    var $input = $(event.currentTarget),
        $subQuestion = $input.closest('.qa-sub-question'),
        $questionItem = $subQuestion.closest('.qa-question-item'),
        $textValue = $subQuestion.find('.form-3text'),
        $1textValue = $subQuestion.find('.form-1value'),
        $2textValue = $subQuestion.find('.form-2value'),
        $3textValue = $subQuestion.find('.form-3value');


    // Update the custom scrollbar
    // $questionItem.mCustomScrollbar('update');

    // Check if there are prerequisite sub questions
    if( $subQuestion.next('.qa-sub-question.disabled').length > 0 ) {
      if( $1textValue.val() !== '' && $2textValue.val() !== '' && $3textValue.val() !== ''){
        $textValue.val( $1textValue.val() +','+ $2textValue.val() +','+ $3textValue.val() );
        $subQuestion.next('.qa-sub-question').removeClass('disabled');
      }
    } else {
      if( $1textValue.val() !== '' && $2textValue.val() !== '' && $3textValue.val() !== ''){
        $textValue.val( $1textValue.val() +','+ $2textValue.val() +','+ $3textValue.val() );
        this.el.$qaNavNext.removeClass('disabled');
      }
    }
  },

  /**
   * On radio changed
   */
  radioChanged: function(event) {
    var $radio = $(event.currentTarget),
        $subQuestion = $radio.closest('.qa-sub-question'),
        $questionItem = $subQuestion.closest('.qa-question-item');

    if( $radio.is(':checked') ) {
      $radio.closest('label').addClass('checked').siblings('label').removeClass('checked');

      // Check if there are prerequisite sub questions
      if( $subQuestion.next('.qa-sub-question.disabled').length > 0 ) {
        $subQuestion.next('.qa-sub-question').removeClass('disabled');
      } else {
        this.el.$qaNavNext.removeClass('disabled');
      }
    }
  },

  /**
   * On input changed
   */
  inputChanged: function(event) {
    var $input = $(event.currentTarget),
        $subQuestion = $input.closest('.qa-sub-question'),
        $questionItem = $subQuestion.closest('.qa-question-item');


    // Update the custom scrollbar
    $questionItem.mCustomScrollbar('update');

    // Check if there are prerequisite sub questions
    if( $subQuestion.next('.qa-sub-question.disabled').length > 0 ) {
      $subQuestion.next('.qa-sub-question').removeClass('disabled');
    } else {
      this.el.$qaNavNext.removeClass('disabled');
    }
  },

  setCurrentProgressBar: function(){
    var self = this;
    $.ajax({
        url: rootUrl + '/api/get_totalAnswer',
        contentType: 'application/json',
        type: 'GET',
        success: function (answer) {
          $.ajax({
              url: rootUrl + '/api/get_totalQuestion',
              contentType: 'application/json',
              type: 'GET',
              success: function (question) {
                var totalQuestions = question[0].total; 
                var count = answer[0].total;
                var total = Math.floor( ( count/totalQuestions ) * 100 );
                var precentage = total;

                self.el.$progressBar.find('div').css('width', precentage+'%');  
                //console.log(totalQuestions, count, precentage);
              }
          });
        }
    });
    
  },


  /**
   * Check answered questions
   */
  getAnswered: function() {

    var checkedRadio = this.el.$questionList.find(':radio:checked').length,
        checkedCheckbox = this.el.$questionList.find(':checkbox:checked').length,
        filledTextInput = 0;

    this.el.$questionList.find(':text').each(function(){
      if( $(this).val() != '' ) {
        filledTextInput++;
      }
    });

    return checkedRadio + checkedCheckbox + filledTextInput;
  },

  getAnsweredMember: function(){
    var self = this;
    var numberCategory = $('#currentCategory').val();

    $.ajax({
      url: rootUrl + '/api/get_answer_by_category/'+numberCategory,
      type: 'get',
      success: function (data) {
        var i = 0;
        while(i<data.length){
          if (data[i].quiz_type == 'choices'){
            $('.qa-choice').find('#'+data[i].answer_choice).addClass('checked');
            $('.qa-sub-question').removeClass('disabled');
            self.el.$qaNavNext.removeClass('disabled');
          }
          else if(data[i].quiz_type == 'checkbox'){
            var x = 0;
            var choices = (data[i].answer_choice).split(',');
            
            while(x < choices.length){
              if (choices[x] == '') {
                console.log('no data');
              } else {
                $('.qa-choice').find('#'+choices[x]+'>div').addClass('checked');
              }
              x++;
            }
          } 
          else if (data[i].quiz_type == 'text') {
            $('.qa-choice').find('.form-text').text(data[i].answer_choice);
          }
          else if (data[i].quiz_type === '3text') {
            var answerText = (data[i].answer_choice).split(',');
            
            $('.form-1value').val(answerText[0]);
            $('.form-2value').val(answerText[1]);
            $('.form-3value').val(answerText[2]);

            $('.form-3text').val(data[i].answer_choice);
            
          }
          else if (data[i].quiz_type === 'country') {
            var contentId = $('#s2id_autogen1');
            var valueCountry = data[i].answer_choice;

            contentId.select2('val', valueCountry);
            self.loadEthnic(valueCountry);
          }
          else if (data[i].quiz_type === 'ethnic') {
            $('.qa-choice').find('#'+data[i].answer_choice).addClass('checked');
            $('.qa-sub-question').removeClass('disabled');
            self.el.$qaNavNext.removeClass('disabled');
          };
          i++;
        }
      }

    });
  },

  /**
   * Change progress bar status
   */
  progressBarStatus: function() {
    var self = this, 
        cat = this.el.$currentQategory.val(); 

    var $form = $(".form-qa");
    $form.submit();

    $.ajax({
      url: rootUrl + '/api/get_answer_by_category/'+cat,
      type: 'get',
      success: function (data) {
        if (data == '') {
          self.checkStatusAnswer();
        } else {
          
        }
      }
    });

  },


  checkStatusAnswer: function(){
    var answered = this.getAnswered(),
       count = $('#currentCounter').val();

    var a = parseFloat(answered),
        b = parseFloat(count),
        counter = a+b;

    this.el.$progressPercent.text( counter + '%' );
    this.el.$currentProgress.val( counter );
    this.el.$progressBar.find('div').css('width', counter + '%');
    // Trigger progress bar event
    this.el.$body.trigger('progressBar:changed');
  },


  /**
   * Create custom radio button
   */
  customRadioButton: function( $radio ) {
    var self = this;

    $radio.each(function(index){
      var $radioButton = $(this),
          $label = $radioButton.parent('label');

      $radioButton.hide();
      $('<span class="circle"><i class="fa fa-check"></span>').prependTo( $label );

      if( $radioButton.is(':checked') ) {
        $label.addClass('checked');
      }
    });
  },

  /**
   * Create custom checkbox button
   */
  customCheckboxButton: function() {
    this.el.$checkbox.iCheck({
      checkboxClass: 'icheckbox_square-pink',
      radioClass: 'iradio_square-pink',
      increaseArea: '20%', // optional
      handle: 'checkbox'
    });
  },


  /**
   * Show next question
   */
  showNext: function(event) {
    $
    event.preventDefault();
    // Prevent user from click the button harshly
    if( this.isSliding == true ) return;
    this.isSliding = true;

    var self = this,
        $buttonNext = $(event.currentTarget),
        $currentQuestion = this.el.$questionList.children(':visible'),
        //$form = $currentQuestion.closest('form'),
        $form = $(".form-qa"),
        width = $currentQuestion.outerWidth(true),
        containerWidth = width * 2;

    // Send ajax in the background
    $form.addClass('loading');

    // Check if there is still question 
    if( $currentQuestion.next().length > 0 ) {

      // If support CSS3 transition, use CSS transition
      if( this.supportTrans ) {
        // Do the slide
        $currentQuestion.next().show();
        this.el.$questionList
          .addClass('animate')
          .width( containerWidth )
          .children().width( width )
          .end()
          .css('margin-left', -width);

        // On transition end
        this.el.$questionList.one( this.transitionEnd, function(e){
          self.el.$questionList
            .removeClass('animate')
            .removeAttr('style')
            .children().width('100%');

          $currentQuestion.hide();

          // Trigger question next event
          self.el.$body.trigger('question:next', [ $currentQuestion.next() ]);
          self.isSliding = false;
        });
      }

      // Not support CSS3 transition
      else {
        $currentQuestion
          .hide()
          .next().fadeIn();

        this.el.$body.trigger('question:next', [ $currentQuestion.next() ]);
        self.isSliding = false;
      }
    }

    // submit form if text is Done
    if( self.el.$qaNavNext.val() === 'Done' ) {
      $form.submit();
    }
    
    $form.removeClass('loading');
  },


  /**
   * Show previous question
   */
  showPrev: function(event) {
    event.preventDefault();

    // Prevent user from click the button harshly
    if( this.isSliding == true ) return;
    this.isSliding = true;

    var self = this,
        $currentQuestion = this.el.$questionList.children(':visible'),
        width = $currentQuestion.outerWidth(true),
        containerWidth = width * 2;

    // Check if there is still question 
    if( $currentQuestion.prev().length > 0 ) {

      // If support CSS3 transition, use CSS transition
      if( this.supportTrans ) {
        // Do the slide
        $currentQuestion.prev().show();
        this.el.$questionList
          .width( containerWidth )
          .css('margin-left', -width)
          .children().width( width )
          .end()
          .addClass('animate')
          .css('margin-left', 0);

        // On transition end
        this.el.$questionList.one( this.transitionEnd, function(e){
          self.el.$questionList
            .removeClass('animate')
            .removeAttr('style')
            .children().width('100%');

          $currentQuestion.hide();

          // Trigger question next event
          self.el.$body.trigger('question:prev', [ $currentQuestion.prev() ]);
          self.isSliding = false;
        });
      }

      // Not support CSS3 transition
      else {
        $currentQuestion
          .hide()
          .prev().fadeIn();

        this.el.$body.trigger('question:prev', [ $currentQuestion.prev() ]);
        self.isSliding = false;
      }
    }

    this.el.$qaNavNext.removeClass('disabled');
    this.el.$qaNavPrev.removeClass('disabled');
  },

  /**
   * Determine nav status, is it disabled or not
   */
  navStatus: function(event, $currentQuestion) {
    if( $currentQuestion.next().length == 0 ) {
      this.el.$qaNavNext.addClass('disabled');
    } else {
      this.el.$qaNavNext.removeClass('disabled');
    }

    if( $currentQuestion.prev().length == 0 ) {
      this.el.$qaNavPrev.addClass('disabled');
    } else {
      this.el.$qaNavPrev.removeClass('disabled');
    }

    // If on the end of the slides, change the text into Done
    if( ($currentQuestion.index() + 1) == this.el.$qaItem.length ) {
      this.el.$qaNavNext.val('Done');
    } else {
      this.el.$qaNavNext.val('Next');
    }

    // Check if there are unanswered questions
    if( ($currentQuestion.find(':radio').length && !$currentQuestion.find(':radio:checked').length) ||
        ($currentQuestion.find(':checkbox').length && !$currentQuestion.find(':checkbox:checked').length) ||
        ($currentQuestion.find('.form-text').length && !$currentQuestion.find('.form-text').val() === '') ||
        ($currentQuestion.find('.form-birthday').length && !$currentQuestion.find('.form-birthday').val() === '') ) {
        this.el.$qaNavNext.addClass('disabled');
    } 

    //Enable next and question when answered
    if($currentQuestion.find('.checked').length !== 0) {
      //console.log($currentQuestion.find('.checked').length);
      this.el.$qaNavNext.removeClass('disabled');
      $('.qa-sub-question').removeClass('disabled');
    } else {
      this.el.$qaNavNext.addClass('disabled');
    }

    if ($('.qa-choice').find('.form-text').text() !== '') {
      this.el.$qaNavNext.removeClass('disabled');
      
    };

  },


  /**
   * Initialization
   */
  init: function() {
    var self = this;

    if( !$('.qa-question-list-wrapper').length ) return;

    this.setupElements();
    this.eventBinding();
    this.supportTrans = this.checkSupport('transition');

    this.customRadioButton($(':radio'));

    this.getAnsweredMember();
    this.customCheckboxButton();
    this.setCurrentProgressBar();


    self.el.$country.select2({
        placeholder: "Select a Country"
    });

    self.el.$qaItem.not(':first').hide();
    self.el.$qaItem.each(function(){
      $(this).find('.qa-sub-question').not(':first').addClass('disabled');
    });
  }
};


/* ===================================================================
  Message js function
=================================================================== */

var message = {

  el: {},

  /**
   * Cache variable
   */
  setupElements: function() {
    this.el.$body = $('body');
    this.el.$resendEmail = $('.resend-email');
    //this.el.$btnReply = $('#msg-formReply');
    this.el.$formReply = $('#msg-formReply');
    this.el.$formCompose = $('#msg-formCompose');
    this.el.$selectUser = $('.select-user_');
    this.el.$messageBtn = $('.action-email');
  },

  /**
   * Event Binding
   */
  eventBinding: function() {
    this.el.$resendEmail.on('click', $.proxy(this.resendEmail, this));
    //this.el.$btnReply.on('click', $.proxy(this.clickReply, this));
    this.el.$formReply.on('submit', $.proxy(this.formReply, this));
    this.el.$formCompose.on('submit', $.proxy(this.formCompose, this));

    
  },

  checkSubs: function(){
    this.el.$messageBtn.on('click', function(e){
      var self = this,
        $msg = $(e.currentTarget),
        partnerId = $msg.data('id');

      if (current_user.subscription == 'false' && config_settings.message==='false') {
        $('#warning').modal('toggle');
        $('#popuser').modal('hide');
      } else {
        window.location.href = rootUrl + "/message/to/"+partnerId;
      }
    });
  },


  /**
   * Resend Email
   */
  resendEmail: function() {
    var self = this;

    $.ajax({
      url: rootUrl + '/api/post_sendemail',
      type: 'post',
      data: {action: "signup", param: current_user.user_id},
      success: function (data) {
        self.el.$resendEmail.html(" email sent ");
      }
    });
  },

  /**
   * Form Reply a message
   */
  formReply: function() { 
    var from = current_user.user_id,
        to = $("#msg-to").val(),
        content = $("#msg-content").val(),
        subject = $("#msg-subject").val();

    var from_notify = current_user.user_code_id;
    var to_notify = $("#msg-to-code").val();

        if(content==="" || content===null){
          $('#message-loading').html('<span class="alert alert-danger" style="padding:5px;font-size:14px;">Message must be filled<span>');
          $('#message-loading').show().delay(500).fadeOut();
        }else{ 
            if(current_user.subscription == 'true' || config_settings.message==='true'){
               $("#message-loading").css({"display":"block"}); 
               $("#message-loading").html("<img src='"+rootUrl+"/public/assets/img/ajax-loader.gif'>");    
           
                $.ajax({
                url: rootUrl + "/api/post_message/",
                type: 'post',
                data: {to: to, content: content, subject:subject},
                success: function (data) {
                  pushMessageNotify(to_notify, from_notify, subject, content, 'send', 'message', data.msg_code, function(error, status){

                    if (status.status == 'OK') {
                      console.log("Success Send Notify : ", status);
                      var avatar = $(".msg-from .message-avatar").attr("src");
                      var code_id = $(".msg-from .message-sender-name").html();
                      $("#messageTemplate .message-avatar").attr("src",(avatar));
                      $("#messageTemplate .message-sender-name").html(current_user.user_code_id);
                      $("#messageTemplate .message-date").html("just now");
                      $("#messageTemplate .message-text").html("<p>" + content + "</p>");
                      $("#messageTemplate .message-checkbox").html("<input type='checkbox' value='"+data.msg_id+"' name='delIdMessage[]'' class='delIdMessage'/>");
                                
                      $(".user-messages-list").append($("#messageTemplate").html());

                      $('#message-loading').html(function(){
                        $("#msg-content").val('');
                        $('#message-loading').html('<span class="alert alert-success" style="padding:5px;font-size:14px;">Message sent<span>');
                        $('#message-loading').show().delay(2000).fadeOut();
                      });
                    } else {
                      console.log("Error Send Notify : ", error);
                      var avatar = $(".msg-from .message-avatar").attr("src");
                      var code_id = $(".msg-from .message-sender-name").html();
                      $("#messageTemplate .message-avatar").attr("src",(avatar));
                      $("#messageTemplate .message-sender-name").html(current_user.user_code_id);
                      $("#messageTemplate .message-date").html("just now");
                      $("#messageTemplate .message-text").html("<p>" + content + "</p>");
                      $("#messageTemplate .message-checkbox").html("<input type='checkbox' value='"+data.msg_id+"' name='delIdMessage[]'' class='delIdMessage'/>");
                                
                      $(".user-messages-list").append($("#messageTemplate").html());

                      $('#message-loading').html(function(){
                        $("#msg-content").val('');
                        $('#message-loading').html('<span class="alert alert-success" style="padding:5px;font-size:14px;">Message sent<span>');
                        $('#message-loading').show().delay(2000).fadeOut();
                      });
                    }

                  });
                }
              }); 
            }else{
             $('#warning').modal('toggle');
            }
            
        }

         return false;

  },

  /**
   * Form compose a message
   */
  formCompose: function() {    
    var from = current_user.user_id;
    var to = $("#msgToId").val();

    var from_notify = current_user.user_code_id;
    var to_notify = $("#msgToCodeId").val();

    var content = $("#msg-content").val();
    var subject = $("#msg-subject").val();

    var to_error =  $('.create-message-to-error'),
        subject_error =  $('.create-message-subject-error'),
        content_error = $('.create-message-content-error');

    if(to==="" || to===null){
      to_error.html('<span class="alert alert-danger" style="padding:5px;font-size:14px;">To must be filled<span>');
      to_error.show().delay(500).fadeOut();
    } else if(subject==="" || subject===null){
      subject_error.html('<span class="alert alert-danger" style="padding:5px;font-size:14px;">Subject must be filled<span>');
      subject_error.show().delay(500).fadeOut();
    }else if(content==="" || content===null){
      content_error .html('<span class="alert alert-danger" style="padding:5px;font-size:14px;">Message must be filled<span>');
      content_error .show().delay(500).fadeOut();
    }else{
      if(current_user.subscription == 'true' || config_settings.message==='true'){
         $("#message-loading").css({"display":"block"}); 
         $("#msg-loading").html("<img src='"+rootUrl+"/public/assets/img/ajax-loader.gif'>");

          $.ajax({
          url: rootUrl + "/api/post_message/",
          type: 'post',
          data: {to: to, content: content, subject:subject},
          success: function (data) {
            pushMessageNotify(to_notify, from_notify, subject, content, 'send', 'message', data.msg_code, function(error, status){
              if (status.status == 'OK') {
                console.log("Success Send Notify : ", status);
                window.location.href = rootUrl + "/message/sent";
              } else {
                console.log("Error Send Notify : ", error);
                window.location.href = rootUrl + "/message/sent";
              }
            });
          }
        }); 
      }else{
         $('#warning').modal('toggle');
      }

    }
    return false;
  },

  /**
   * Binding all user
   */
  bindUser: function() {
    var self = this;

    if( this.el.$selectUser.length )
      this.el.$selectUser.selectize({
        valueField: 'title',
        labelField: 'title',
        searchField: 'title',
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                var actors = [];
                for (var i = 0, n = item.abridged_cast.length; i < n; i++) {
                    actors.push('<span>' + escape(item.abridged_cast[i].name) + '</span>');
                }

                return '<div>' +
                    '<b>tes</b>' +
                    
                '</div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: rootUrl + "/API/get_searchUser/",
                type: 'GET',
                dataType: 'jsonp',
                data: {
                    q: query,
                    page_limit: 10,
                    apikey: '3qqmdwbuswut94jv4eua3j85'
                },
                error: function() {
                    callback();
                },
                success: function(res) {
                    callback(res.suggestions);
                    
                }
            });
        }
      });

  },

  /**
   * Initialization
   */
  init: function() {
    var self = this;

    this.setupElements();
    this.eventBinding();
    this.bindUser();
    this.checkSubs();

  }
};

/* ===================================================================
  Document Ready
=================================================================== */
$ = $.noConflict();

if( $(".select-user").length )
  $(".select-user").select2({
      placeholder: "Search for User",
      minimumInputLength: 1,
      ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
          url: rootUrl + "/api/get_searchUser/",        
          data: function (term, page) {
              return {
                  q: term, // search term
                  page_limit: 10,
                  apikey: "ju6z9mjyajq2djue3gbvv26t" // please do not use so this example keeps working
              };
          },
          results: function (data, page) { // parse the results into the format expected by Select2.
              // since we are using custom formatting functions we do not need to alter remote JSON data
              return {results: data};
          }
      },
      formatResult: formatSearchingUser, // omitted for brevity, see the source of this page
      formatSelection: formatSearchingSelect,  // omitted for brevity, see the source of this page
      dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
      escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
  });

function formatSearchingUser(item) {
    var originalOption = item.element;
    return "<div><img src=" + item.avatar + " width='50' style='margin-right:50px;'><b>"+item.code_id+"</b></div>";
}

function formatSearchingSelect(item){
  $('#msgToId').val(item.id);
  $('#msgToCodeId').val(item.code_id);
  return item.code_id;
}


function loadMessage (argument) {
  alert(argument);
}

function userResult(state) {
    return state.code_id
}

function pushActivityStream(to, from, label, cb){
  var dataJson = {
      "notify": true,
      "title": current_user.user_code_id + ' ' +label+ ' ' +to,
      "actor": {
        "objectType": "user",
        "id": current_user.user_code_id,
        "displayName": current_user.user_code_id,
        "url": rootUrl+"/profile/"+current_user.user_code_id,
        "image": {
          "url": current_user.thumb
        }
      },
      "verb": label,
      "object": {
        "objectType": "user",
        "id": to,
        "displayName": to,
        "url": rootUrl+"/profile/"+to,
        "image": {
          "url": "http://example.org/user/thumbnail.jpg"
        }
      },
      "privacy":"private"
    } 
  
  $.ajax({
      url: rootPushNotify,
      contentType: 'application/json',
      type: 'POST',
      data: JSON.stringify(dataJson),
      success: function () {
        cb(null, 'OK');
      },
      error: function (xhr, ajaxOptions, thrownError) {
        cb('Error');
      }
  });
}

function pushMessageNotify(to, from, subject, content, label, type, idmsg, cb){
  var dataJson = {
    "notify": true,
    "title": current_user.user_code_id+ ' ' +label+ ' message to' +to,
    "actor": {
      "objectType": "user",
      "id": current_user.user_code_id,
      "displayName": from,
      "url": rootUrl+"/profile/"+current_user.user_code_id,
      "image": {
        "url": current_user.thumb
      }
    },
    "verb": label,
    "object": {
      "objectType": type,
      "id": "message:id:"+idmsg,
      "subject": subject,
      "content": content,
      "url": rootUrl + "/message/read/" + idmsg
    },
    "target" : {
      "objectType": "user",
      "id": to,
      "displayName": to,
      "url": rootUrl+"/profile/"+to,
      "image": {
        "url": "http://example.org/album/thumbnail.jpg"
      }
    },
    "privacy":"private"
  }
  
  $.ajax({
      url: rootPushNotify,
      contentType: 'application/json',
      type: 'POST',
      data: JSON.stringify(dataJson),
      success: function (obj) {
        cb('SUCCESS :', obj);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        cb('ERROR : ', xhr, ajaxOptions, thrownError);
      }
  });
}


function checkFavorite(id) {
  $.ajax({
    url: rootUrl + '/api/get_activity/'+id+'/'+'favorite',
    type: 'get',
    success: function (data) {
      
      if (data == 'favorite') {
        $('.popuser-dialog .action-favorite').addClass('active');
      } else {
        $('.popuser-dialog .action-favorite').removeClass('active');
      };
    }
  });
}

function createUserShowPopUp(dataUser, fuid){ 
  if (dataUser.id == current_user.user_id) {
    $('.popuser-dialog .user-action').attr('hidden', true);
  } else {
    $('.popuser-dialog .user-action').attr('hidden', false);
  }
  
  // set the data views, 
  $(".popuser-dialog .avatar").attr("src",dataUser.photo);
  $(".popuser-dialog .avatar").attr("onerror", 'src=\'http://placehold.it/241x241&text=no+image\';');            
  $(".popuser-dialog .avatar-bg").attr("src",dataUser.photo);
  $(".popuser-dialog .avatar-bg").attr("onerror", 'src=\'http://placehold.it/241x241&text=no+image\';');              
  $(".popuser-dialog .name").html(dataUser.code_id);              
  $(".popuser-dialog .bio-age").html(dataUser.age + " tahun");              
  $(".popuser-dialog .city").html(dataUser.city);   

  $(".popuser-dialog .bio-sex").html(dataUser.gender);              
  $(".popuser-dialog .bio-religion").html(dataUser.religion);              
  $(".popuser-dialog .bio-ethnicity").html(dataUser.ethnicity);              
  $(".popuser-dialog .bio-occupation").html(dataUser.occupation);              
  $(".popuser-dialog .bio-relation").html(dataUser.relationship);              
  $(".popuser-dialog .bio-kids").html(dataUser.kids);

  if (current_user.subscription == 'false' && config_settings.message==='false') {
    $('.popuser-dialog .action-email').attr('href', 'javascript:void(0)');
  } else {
    $('.popuser-dialog .action-email').attr('href', rootUrl + '/message/to/'+dataUser.code_id);
  };

  $('.popuser-dialog .action-favorite').addClass('user_fav_'+dataUser.id);
  $('.popuser-dialog .action-favorite').data('id', dataUser.id);
  $('.popuser-dialog .action-favorite').data('code', dataUser.code_id);

  $('.popuser-dialog .btn-chat').data('id', dataUser.code_id);
  
  $(".btn-chat").on("click", function(){
    $('#popuser').modal('hide');
  });

  $('#popuser').modal('toggle');

  $(".popuser-dialog .view-full-profile").on('click', function(){

    if (dataUser.id === current_user.user_id) {
      location.href=rootUrl + "/profile";  //If user is self go to profile
    } else {
      $('#popuser').modal('hide');
      $('#pageloader').show();
      $.ajax({
          url: rootUrl + '/api/post_viewed_user/' + fuid,
          type: 'post',
          data: {},
          success: function (data) {
            pushActivityStream(dataUser.code_id, current_user.user_id, 'viewed', function(err, status) {
              location.href=rootUrl + "/profile/" + dataUser.code_id;
              $('#pageloader').hide();
              //console.log('1');
            }); 
          }
      });
    }
  });
}

$(document)
    // pjax area
    .on("click", ".pjax", function (t) {
        var n = $(this).data('pjax');
        $.pjax.click(t, {
            container: n,
            fragment: n,
            scrollTo: !1
        })
    })
    .on("click", ".pjax-popup-profile", function (t) {
      var u = $(this).data("pjax-url"),
        n = ".popuser-body",
        r = ".content";
      t.pjax.click(t, {
        url: u,
        container: n,
        fragment: r,
        scrollTo: !1
      }),
      t.ajax({
        url: u,
        complete: function(r) {

        }
      })
      $("html").addClass("js"),
      $("#popuser")
        .modal("toggle"),
      t.preventDefault()
    })
    .on("pjax:beforeSend", function (t) {})
    .on("pjax:complete", function (t) {})
    .on("pjax:beforeSend", "#right-content", function (t) {
      $("html").addClass("js")
    })
    .on("pjax:complete", "#right-content", function (t) {
      setTimeout(function () {
        $("html").removeClass("js")
      }, 1000)
    })


    // on .show-user is clicked
    .on("click", ".show-user", function(e){
        e.preventDefault();
        var fuid = $(this).attr("data-user-id"),
            $container = $(this).parent(),
            $favorite = $container.find(".action-favorite");

        if(fuid !== current_user.user_id){
          checkFavorite(fuid);
        }
        
        $.ajax({
          url: rootUrl + '/api/get_profileUser/' + fuid,
          type: 'get',
          dataUser: {},
          success: function (dataUser) {
            createUserShowPopUp(dataUser, fuid);
          }
        });

      })


    // on .action-favorite clicked
    .on("click", ".action-favorite", function(e){
      var to_user = $(this).data("id");
      var to_user_code = $(this).data("code");
      //console.log(to_user_code);
      var from_user = current_user.user_id;
      var label = "favorite"; 
      var fav_url = ""; 
      var active = "";
      //console.log("fav : ", to_user_code);
      if (current_user.subscription === 'false' && config_settings.favorite==='false') {
          $('#popuser').modal('hide');
          $('#warning').modal('toggle');
      } 
      else {
        if($(this).hasClass("active")){
          active = 1;
          fav_url =  rootUrl + '/api/del_activity/';
          label = "unfavorite"
       } else {
          fav_url =  rootUrl + '/api/post_activity/';
       }

       
       $.ajax({
           url: fav_url,
           type: 'post',
           data: {to_user: to_user, from_user: from_user, label: label},
           success: function () {
            
             if(active == 1){ 
                pushActivityStream(to_user_code, from_user, label, function(err, status) {
                  //console.log('2', to_user_code, from_user, label);
                });   
                $(".user_fav_" + to_user).removeClass("active");
                if( $(".favorite-wrapper").length )
                  $(".box-"+to_user).hide(500);     
                
             } else {
                pushActivityStream(to_user_code, from_user, label, function(err, status) { 
                  //console.log('3', to_user_code, from_user, label);
                });  
                $(".user_fav_" + to_user).addClass("active");
                
             }
           }
         });
      }
       
      e.preventDefault();
      return false;
    })


    // on window ready
    .on("ready", function(){

        // Mobilemenu init
        mobileMenu.init();

        // QA Section
        qaSection.init();

        // Message init
        message.init();

        // Selectbox replacement
        $('#dash-browse select').selectbox({
          arrow: 'arrow-down'
        });

        // datepicker plugin
        $('.datepicker').datepicker();

        // ddslick plugin
        function createDdSlick (el,repeat) {

          $(el).ddslick({
                onSelected: function(data){
                  
                  var selectedValue = data.selectedData.value;
                  var valueArray = selectedValue.split("_");

                  // if(repeat == 1){                    
                  //   $("#slickhtml-"+valueArray[0]).ddslick("destroy");
                    //$("#slickhtml-"+valueArray[0]).html($(".template-for-related-"+valueArray[0]).html());
                  
                  // }


                  // // set the value of container
                  // $("#listContainer-"+valueArray[0]).val(valueArray[1]);
                  // $("#listContainer-"+valueArray[0]).trigger('change');

                  // // remove option not related
                  // $(".slickhtml-"+valueArray[0]).each(function() {
                  //     $(this).unwrap();
                  // });

                  // $(".slickhtml-"+valueArray[0]+" option[value^='"+valueArray[1]+"_']").each(function() {
                  //     $(this).wrap("<span>");
                  // });

                  // //if(repeat == 1){                    
                  //  createDdSlick($("#slickhtml-"+valueArray[0]),1);                  
                  //}
                  //$("#datalist_"+selectedValue).show();
                }
            });
        }
        $("select.ddslick").each(function(){
            // createDdSlick($(this));
        });


        $(".forgot-password").on("click",function(){
          $("#myModalForgetPassword").modal();
        });

        $(".btn-forgotPassword").on("click",function(){
          $.ajax({
              url: rootUrl + '/auth/forgotPassword',
              type: 'post',
              data: {email : $(".input-email-forgot").val()},
              success: function (data) {
                $(".modal-forgotPassword").html("email sent");
              }
            });
        });

        //Set precentage on top nav
        $.ajax({
            url: rootUrl + '/api/get_precentage_answer',
            contentType: 'application/json',
            type: 'GET',
            success: function (data) {
              var topTotal = Math.round(data)+1;
              if (topTotal < '0') {
                $('span#compProf').html('0%');
              } 
              else if(topTotal == '100'){
                $('span#compProf').html('<span style="color:green;">'+topTotal+'%</span>');
              }
              else if(topTotal == '101'){
                $('span#compProf').html('<span style="color:green;">'+'100'+'%</span>');
              }
              else{
                $('span#compProf').html(topTotal+'%');
              };
              
            }
        });


        $(".btn-pre-signup").on("click",function(){
          var email = $(".pre-input-email").val();
          if(email.length == 0){
            $(".login-loading").html("<span class='error'>anda belum mengisi email</span>");
            return false;
          } else {

            $(".login-loading").html("<img src='"+rootUrl+"/public/assets/img/ajax-loader.gif'>");
            $.ajax({
                url: rootUrl + '/api/post_validUser',
                type: 'post',
                data: { email : email },
                success: function (data) {
                  if(data > 0){
                    $(".login-loading").html("<span class='error'>email sudah digunakan</span>");
                    return false;
                  } else {
                    //$("#form-register").submit();
                    $(".login-loading").html(" ");
                    $(".input-name").val($(".pre-input-name").val());
                    $(".input-email").val($(".pre-input-email").val());
                    $('#myModal').modal();
                  }
                }
              });
            return false;
          }
        });

        $(".btn-save-signup").on("click",function(){
          
          $(".signup-popup-loading").html("<img src='"+rootUrl+"/public/assets/img/ajax-loader.gif'>");
          $.ajax({
              url: rootUrl + '/api/post_validUser',
              type: 'post',
              data: { email : $(".input-email").val() },
              success: function (data) {
                if(data > 0){
                  $(".signup-popup-loading").html("<span class='error'>email sudah digunakan</span>");
                  return false;
                } else {
                  $("#form-popup-signup").submit();              
                }
              }
            });
          return false;
        });


        /* ===================================================================
          Accordion
        =================================================================== */

        $('.user-profile-links li').each(function(){
          // Check if have child
          if( $(this).find('ul').length > 0 ) {
            $(this).add( $(this).children('a') ).addClass('have-child');
          }

        });

        $('.user-profile-links').on('click', 'li.have-child a', function(e){
          //e.preventDefault();
          var $list = $(this).parent('li'),
              $panel = $list.children('ul');

          $list.closest('.user-profile-links').find('ul ul').slideUp();
          $panel.slideDown();
        });

        /* Background full
        ------------------------------------------------------------------- */
        $('.section-block-alt .section-block-content, .section-main, .front-content-bg').anystretch();
        welcomeParallax.init();

        if( $('.section-qa-progress').length > 0 ) {
          var full_bg_url = $('.section-qa-progress').data('stretch');
          $.anystretch( full_bg_url, {
            positionX: 'right'
          });
        }
      });
      
      //FEEDBACK
      $('.feedback').on('click', function(){
        FreshWidget.show();
        
      });

      //HELP
      $('.help').on('click', function(){
        FreshWidget.show();
        
      });
    

})(jQuery);