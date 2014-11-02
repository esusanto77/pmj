(function($){

"use strict";

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
  QA Section
=================================================================== */
var qaSection = {
  el: {},
  totalQuestions: 0,
  totalSlides: 0,
  questions: [],
  loadedSlides: 0,
  // answeredQuestions: [],
  baseUrl: 'questions-ajax/question',
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

    this.el.$questionList = $('.qa-question-list');
    this.el.$questionLabel = $('.qa-question-label');
    this.el.$questionTitle = $('.qa-question-title');
    this.el.$questionChoice = $('.qa-choice');

    this.el.$qaNavNext = $('.qa-section-nav .next');
    this.el.$qaNavPrev = $('.qa-section-nav .prev');

    this.el.qaTemplate = $('#qa-question-template').html();
  },

  /**
   * Load Questions
   */
  loadQuestions: function( url, isPreload ) {
    var self = this,
        questionItem = $('<div class="qa-question-item loading"></div>').appendTo( self.el.$questionList );

    var ajax = $.get( url )

    // On Error
    .error(function(){
      questionItem.remove();
    })

    // On Success
    .success(function( data ) {
      // Count totalnumber of slides loaded
      self.loadedSlides++;
      data.questionNumber = self.loadedSlides;

      var rendered = Mustache.render( self.el.qaTemplate, data );
      questionItem
        .html( rendered )
        .removeClass('loading');

      // Create custom radio button
      self.customRadioButton( questionItem.find(':radio') );

      // Set total questions
      if( self.totalSlides == 0 ) {
        self.totalSlides = parseInt( data.total_slides, 10);
      }

      // If this is preloaded, hide question immediately
      if( isPreload ) {
        questionItem.hide();
      }

      self.questions.push( data );
    });

    return ajax;
  },

  /**
   * Event Binding
   */
  eventBinding: function() {
    this.el.$questionList.on('change', ':radio', $.proxy(this.radioChanged, this));
    this.el.$qaNavNext.on('click', $.proxy(this.showNext, this));
    this.el.$qaNavPrev.on('click', $.proxy(this.showPrev, this));
    this.el.$body.on('question:next question:prev', $.proxy(this.navStatus, this));
    this.el.$body.on('question:next question:prev', $.proxy(this.progressBarStatus, this));
    this.el.$body.on('question:next', $.proxy(this.preloadQuestions, this));
  },

  /**
   * On radio changed
   */
  radioChanged: function(event) {
    var $radio = $(event.currentTarget);
    if( $radio.is(':checked') ) {
      $radio.closest('label').addClass('checked').siblings('label').removeClass('checked');
    }
  },

  /**
   * Check answered questions
   */
  getAnswered: function() {
    return this.el.$questionList.find(':radio:checked').length;
  },

  /**
   * Show next question
   */
  showNext: function(event) {
    event.preventDefault();

    // Prevent user from click the button harshly
    if( this.isSliding == true ) return;
    this.isSliding = true;

    var self = this,
        $buttonNext = $(event.currentTarget),
        $currentQuestion = this.el.$questionList.children(':visible'),
        width = $currentQuestion.outerWidth(true),
        containerWidth = width * 2;

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
    if( ($currentQuestion.index() + 1) == this.totalSlides ) {
      this.el.$qaNavNext.text('Done');
    } else {
      this.el.$qaNavNext.text('Next');
    }
  },

  /**
   * Change progress bar status
   */
  progressBarStatus: function() {
    var answered = this.getAnswered(),
        percentage = Math.floor( ( answered / this.totalSlides ) * 100 );
    console.log(answered + " " + this.totalSlides);

    this.el.$progressPercent.text( percentage + '%' );
    this.el.$progressBar.find('div').css('width', percentage + '%');

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
   * Preload questions
   */
  preloadQuestions: function() {
    // If there are still questions remaining
    if( this.loadedSlides < this.totalSlides ) {
      this.loadQuestions( this.baseUrl + (this.loadedSlides+1) + '.json', true );
    }
  },

  /**
   * Initialization
   */
  init: function() {
    var self = this;

    this.setupElements();
    this.eventBinding();
    this.supportTrans = this.checkSupport('transition');

    // Let's load the first three questions
    $.when(
      this.loadQuestions( 'questions-ajax/question1.json' ),
      this.loadQuestions( 'questions-ajax/question2.json' ),
      this.loadQuestions( 'questions-ajax/question3.json' )
    ).always(function(){
      // After all four questions loaded
      self.el.$questionList.children().not(':first').hide();
    });
  }
};

/* ===================================================================
  Document Ready
=================================================================== */
$ = $.noConflict();

$(document)
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
    	// 	console.log(u);
    	// e.pjax.click(t, {
    	// 	url: u,
    	// 	container: n,
    	// 	fragment: r,
    	// 	scrollTo: !1
    	// }),
    	// e.ajax({
    	// 	url: u,
    	// 	complete: function(r) {

    	// 	}
    	// })
        // $("html").addClass("js"),
		$("#popuser")
			.modal("toggle"),
  		t.preventDefault()
    })
    .on("pjax:beforeSend", function (t) {})
    .on("pjax:complete", function (t) {});

  $(document)
    .on("pjax:beforeSend", "#right-content", function (t) {
    	$("html").addClass("js")
    })
    .on("pjax:complete", "#right-content", function (t) {
    	setTimeout(function () {
        $("html").removeClass("js")
      }, 1000)
    })
    .on('ready', function(){
      // Mobilemenu init
      mobileMenu.init();

      // QA Section
      qaSection.init();

      // Selectbox replacement
      $('#dash-browse select').selectbox({
        arrow: 'arrow-down'
      });
    });


  $(function() {


      // function pu() {
      //     $(document)
      //         .on("click", ".popuser-close", function (t) {
      //             $(".popuser")
      //                 .hasClass("open")
      //         }), 
      //     $(document)
      //         .keyup(function (t) {
      //             t.keyCode === 27 && $(".popuser")
      //                 .hasClass("open") && $(".popuser-close")
      //                 .trigger("click")
      //         }), 
      //     $(document)
      //         .on("click", ".popuser", function (t) {
      //             $(this)
      //                 .hasClass("open") && $(".popuser, .popuser-content")
      //                 .is(t.target) && e(".popuser-close")
      //                 .trigger("click")
      //         })
      // }
  })
	
})(jQuery);