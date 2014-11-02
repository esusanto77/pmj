/*
 * Say Cheese!
 * Lee Machin, 2012
 * http://leemach.in, http://new-bamboo.co.uk
 *
 * Minimal javascript library for integrating a webcam and snapshots into your app.
 *
 * Handles starting up the webcam and rendering the element, and also capturing shots
 * in a separate canvas element.
 *
 * Depends on video and canvas, and of course, getUserMedia. It's unlikely to work
 * on anything but the newest browsers.
 */


 jQuery.noConflict()(function ($) {
  $(document).ready(function () {

    var verification = { 
      el: {},

      /**
       * Cache element variable
       */
       setupElements: function() {
        this.el.$buttonWebcam1 = $('#buttonWebcam1');
        this.el.$pictPhoto1 = $('#photo1');  
        this.el.$buttonVerificationPhoto1 = $('#verification-photo1');
        this.el.$labelAlertPhoto1 = $('#alert-photo-1'); 
        this.el.$buttonCaptureWebcam1 = $('#capture-webcam1'); 
        this.el.$formWebcam1 = $('#webcam1');

        this.el.$buttonWebcam2 = $('#buttonWebcam2');
        this.el.$pictPhoto2 = $('#photo2');  
        this.el.$buttonVerificationPhoto2 = $('#verification-photo2');
        this.el.$labelAlertPhoto2 = $('#alert-photo-2'); 
        this.el.$buttonCaptureWebcam2 = $('#capture-webcam2'); 
        this.el.$formWebcam2 = $('#webcam2'); 

        this.el.$buttonFormVerificationPhoto = $('#verificationPhoto');
        this.el.$buttonSubmitVerification = $('#submit-verification');
        this.el.$loaderSubmit = $('#animation-loading-upload-verification');
      },

      /**
       * Event Binding
       */
       eventBinding: function() {
        this.el.$buttonWebcam1.on('click', '', $.proxy(this.openWebcam, this,'1','#webcam1'));
        this.el.$buttonVerificationPhoto1.on('change', '', $.proxy(this.verificationPhoto, this,'1','#webcam1'));

        this.el.$buttonWebcam2.on('click', '', $.proxy(this.openWebcam, this,'2','#webcam2'));
        this.el.$buttonVerificationPhoto2.on('change', '', $.proxy(this.verificationPhoto, this,'2','#webcam2'));

        this.el.$buttonSubmitVerification.on('click', '', $.proxy(this.submitForm, this));
      },

      /* Open Web Cam */
      openWebcam: function(id,webcam){
        var self = this;
        $('#capture-webcam'+id).css({'display':'inline'});
        $('#buttonWebcam'+id).css({'display':'none'});

        var sayCheese = new SayCheese(''+webcam+'', { audio: false });
        
        sayCheese.start(''+webcam+'');

        sayCheese.on('start', function() {
         $('#capture-webcam'+id).on('click', function(evt) {
          sayCheese.takeSnapshot(400,300);
        });
       });

        sayCheese.on('error', function(error) {
          $('#capture-webcam'+id).css({'display':'none'});
          $('#buttonWebcam'+id).css({'display':'inline'});

          if (error === 'NOT_SUPPORTED') {
           $('#alert-photo-'+id).html("<strong>:(</strong> Your browser doesn't support video yet!");
         } else if (error === 'AUDIO_NOT_SUPPORTED') {
           $('#alert-photo-'+id).html("<strong>:(</strong> Your browser doesn't support audio yet!");
         } else {
           $('#alert-photo-'+id).html("<strong>:(</strong> You have to click 'allow' to try me out!");
         }

         $('#alert-photo-'+id).css({'display':'block'});
         $('#alert-photo-'+id).show().delay(500).fadeOut();

       });

        sayCheese.on('snapshot', function(snapshot) {
          $('#capture-webcam'+id).css({'display':'none'});
          $('#buttonWebcam'+id).css({'display':'inline'});

          var img = document.createElement('img');

          $(img).on('load', function() {
            $('#webcam'+id).html(img);
          });
          img.setAttribute('class', 'img-thumbnail avatar'); 
          img.id = "photo"+id;
          img.src = snapshot.toDataURL('image/jpeg');

          sayCheese.stop();
        });

      },
      
      /* Validasi Photo */
      verificationPhoto: function(id,webcam){
        var val =  $('#verification-photo'+id).val();
        var self = this;
        $('#capture-webcam'+id).css({'display':'none'});
        $('#buttonWebcam'+id).css({'display':'inline'});

        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
          case 'jpg': 
          var files = !!$('#verification-photo'+id)[0].files ? $('#verification-photo'+id)[0].files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                  $('#webcam'+id).html('<img src='+this.result+' class="img-thumbnail avatar" alt="Responsive image" id="photo'+id+'">');
                }
              }
              break;
              default:
                $('#verification-photo'+id).val('');
                $('#alert-photo-'+id).html("The filetype you are attempting to upload is not allowed.");
                $('#alert-photo-'+id).css({'display':'block'});
                $('#alert-photo-'+id).show().delay(500).fadeOut();
              break;
            }
          },

          /* Submit Form */
          submitForm: function(){
            var self = this;

            if($('#photo1').length <= 0){
              $('#alert-photo-1').html("You did not select a file to upload.");
              $('#alert-photo-1').css({'display':'block'});
              $('#alert-photo-1').show().delay(500).fadeOut();
            }
            else if($('#photo2').length <= 0){
              $('#alert-photo-2').html("You did not select a file to upload.");
              $('#alert-photo-2').css({'display':'block'});
              $('#alert-photo-2').show().delay(500).fadeOut();
            }else{
            self.el.$loaderSubmit.css({'display':'inline'});
            self.el.$buttonSubmitVerification.attr("disabled", true);
            self.el.$loaderSubmit.html('Please Wait . . .');

             $.ajax({
              type: "POST",
              url: "./photo/photoVerification",
              data: {photo1:  $('#photo1').attr('src'),photo2: $('#photo2').attr('src')},
              contentType: "application/x-www-form-urlencoded;charset=UTF-8",
              success: function(data){
                //console.log('DATA : ', data);
                if(data==="true"){
                  verification.callBackPhoto('Call Back Photo', function(){
                  });
                }else{
                  alert("error, please upload again");
                  location.reload();
                }
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) { 
                alert("Status: " + textStatus); alert("Error: " + errorThrown); 

                self.el.$loaderSubmit.css({'display':'none'});
                self.el.$buttonSubmitVerification.attr("disabled", false);
                self.el.$loaderSubmit.html('Request Verification');
              } 
            }); 
           }

           return false;
         },

         callBackPhoto: function(param, callback){
          $('.panel').css({'text-align':'center'});
          $('.header-verification').css({'padding-top':'25px','padding-bottom':'25px','margin-top':'60px','margin-bottom':'50px'});
          $('.header-verification').html("<h4>Thank you<br><br>  You will receive an email notification within 48 hours </h4>");
          $('#form-panel').html('<a href="./welcome"><button class="btn btn-lg btn-primary" style="margin-bottom:30px;">Continue</button></a>');
          $('#form-photo-1').css({'display':'none'});
          $('#form-photo-2').css({'display':'none'});
          $('.panel-footer').css({'display':'none'});

          if(callback && typeof(callback) === "function"){
            callback();
          }
        },

        /* Example Verification */
        exampleVerification: function(){
          var self = this;

          self.el.$modalVerification.on('show.bs.modal', verification.centerModal);

          $(window).on("resize", function () {
            $('#myModalExampleVerification:visible').each(verification.centerModal);
          });
          self.el.$modalVerification.modal();

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


    var SayCheese = (function() {

      var SayCheese;

      navigator.getUserMedia = (navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia ||
        false);

      window.AudioContext = (window.AudioContext ||
       window.webkitAudioContext);

      window.URL = (window.URL ||
        window.webkitURL);

      SayCheese = function SayCheese(element, options) {
        this.snapshots = [],
        this.video = null,
        this.events = {},
        this.stream = null,
        this.options = {
          snapshots: true,
          audio: false
        };

        this.setOptions(options);
        this.element = document.querySelector(element);
        return this;
      };

      SayCheese.prototype.on = function on(evt, handler) {
        if (this.events.hasOwnProperty(evt) === false) {
          this.events[evt] = [];
        }

        this.events[evt].push(handler)
      };

      SayCheese.prototype.off = function off(evt, handler) {
        this.events[evt] = this.events[evt].filter(function(h) {
          return h !== handler;
        });
      };

      SayCheese.prototype.trigger = function trigger(evt, data) {
        if (this.events.hasOwnProperty(evt) === false) {
          return false;
        }

        this.events[evt].forEach(function(handler) {
          handler.call(this, data);
        }.bind(this));
      };

      SayCheese.prototype.setOptions = function setOptions(options) {
    // just use naïve, shallow cloning
    for (var opt in options) {
      this.options[opt] = options[opt];
    }
  }

  SayCheese.prototype.getStreamUrl = function getStreamUrl() {
    if (window.URL && window.URL.createObjectURL) {
      return window.URL.createObjectURL(this.stream);
    } else {
      return this.stream;
    }
  };

  SayCheese.prototype.createVideo = function createVideo() {
    var width     = 320,
    height    = 0,
    streaming = false;


    this.video = document.createElement('video');
    this.video.setAttribute('width', '400px'); 
    this.video.setAttribute('height', '300px'); 
    this.video.setAttribute('class', 'img-thumbnail avatar'); 

    this.video.addEventListener('canplay', function() {
      if (!streaming) {
        height = this.video.videoHeight / (this.video.videoWidth / width);
        this.video.style.width = width;
        this.video.style.height = height;
        streaming = true;
        return this.trigger('start');
      }
    }.bind(this), false);
  };

  SayCheese.prototype.linkAudio = function linkAudio() {
    this.audioCtx = new window.AudioContext();
    this.audioStream = this.audioCtx.createMediaStreamSource(this.stream);

    var biquadFilter = this.audioCtx.createBiquadFilter();

    this.audioStream.connect(biquadFilter);
    biquadFilter.connect(this.audioCtx.destination);
  };

  SayCheese.prototype.takeSnapshot = function takeSnapshot(width, height) {
    if (this.options.snapshots === false) {
      return false;
    }

    width  = width || this.video.videoWidth;
    height = height || this.video.videoHeight;

    var snapshot = document.createElement('canvas'),
    ctx      = snapshot.getContext('2d');

    snapshot.width  = width;
    snapshot.height = height;

    ctx.drawImage(this.video, 0, 0, width, height);

    this.snapshots.push(snapshot);
    this.trigger('snapshot', snapshot);

    ctx = null;
  };

  /* Start up the stream, if possible */
  SayCheese.prototype.start = function start(id) {

    // fail fast and softly if browser not supported
    if (navigator.getUserMedia === false) {
      this.trigger('error', 'NOT_SUPPORTED');
      return false    }

      var success = function success(stream) {
        this.stream = stream;
        this.createVideo();


        if (navigator.mozGetUserMedia) {
          this.video.mozSrcObject = stream;
        } else {
          this.video.src = this.getStreamUrl();
        }

        if (this.options.audio === true) {
          try {
            this.linkAudio();
          } catch(e) {
            this.trigger('error', 'AUDIO_NOT_SUPPORTED');
          }
        }

      // this.element.appendChild(this.video);
      $(id).html(this.video);
      this.video.play();
    }.bind(this);

    /* error is also called when someone denies access */
    var error = function error(error) {
      this.trigger('error', error);
    }.bind(this);

    return navigator.getUserMedia({ video: true, audio: this.options.audio }, success, error);
  };

  SayCheese.prototype.stop = function stop() {
    this.stream.stop();
    if (window.URL && window.URL.revokeObjectURL) {
      window.URL.revokeObjectURL(this.video.src);
    }



    return this.trigger('stop');
  };

  return SayCheese;

})();

verification.init();

});
}); 