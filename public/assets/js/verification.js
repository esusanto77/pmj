jQuery.noConflict()(function ($) {
$(document).ready(function () {

webcam.set_api_url('./photo/imageWebcam');
webcam.set_quality(90); // JPEG quality (1 - 100)
webcam.set_shutter_sound(true); // play shutter click sound


var verification = { 
  el: {},

  /**
   * Cache element variable
   */
  setupElements: function() {
    this.el.$buttonWebcam = $('#buttonWebcam');
    this.el.$buttonFormVerificationPhoto = $('#verificationPhoto');
    this.el.$buttonVerificationPhoto1 = $('#verification-photo1');
    this.el.$labelAlertPhoto1 = $('#alert-photo-1'); 
    this.el.$pictPhoto1 = $('#photo1');  
    this.el.$buttonVerificationPhoto2 = $('#verification-photo2'); 
    this.el.$labelAlertPhoto2 = $('#alert-photo-2'); 
    this.el.$pictPhoto2 = $('#photo2'); 
   	this.el.$buttonConfigureWebcam = $('#configure-webcam'); 
  	this.el.$buttonCaptureWebcam = $('#capture-webcam'); 
  	this.el.$buttonResetWebcam = $('#reset-webcam'); 
  	this.el.$buttonSubmitVerification = $('#submit-verification');
    this.el.$loaderSubmit = $('#animation-loading-upload-verification');
    this.el.$formWebcam = $('#webcam');
  },

  /**
   * Event Binding
   */
  eventBinding: function() {
    this.el.$buttonWebcam.on('click', '', $.proxy(this.openWebcam, this));
    this.el.$buttonVerificationPhoto1.on('change', '', $.proxy(this.verificationPhoto1, this));
    this.el.$buttonVerificationPhoto2.on('change', '', $.proxy(this.verificationPhoto2, this));
    this.el.$buttonFormVerificationPhoto.on('submit', '', $.proxy(this.submitForm, this));
    this.el.$buttonCaptureWebcam.on('click', '', $.proxy(this.webcamCapture, this));
    this.el.$buttonResetWebcam.on('click', '', $.proxy(this.buttonResetWebcam, this));
  },

  /* Open Web Cam */
  openWebcam: function(){
    webcam.get_html(300, 300);
    this.el.$buttonConfigureWebcam.css({'display':'inline'});
  	this.el.$buttonCaptureWebcam.css({'display':'inline'});
  	this.el.$buttonResetWebcam.css({'display':'inline'});
  	this.el.$buttonCaptureWebcam.css({'display':'inline'});
  	this.el.$buttonSubmitVerification.attr("disabled", true);
  },

   /* Capture Webcam */
  webcamCapture: function(){
   	webcam.freeze();
   	this.el.$buttonSubmitVerification.attr("disabled", false);
  },

  /* Button Reset Webcam */
   buttonResetWebcam: function(){
    this.el.$buttonSubmitVerification.attr("disabled", true);
  },

  /* Validasi Photo 1 */
  verificationPhoto1: function(){
      this.el.$buttonSubmitVerification.attr("disabled", false);
  	  this.el.$buttonConfigureWebcam.css({'display':'none'});
  	  this.el.$buttonCaptureWebcam.css({'display':'none'});
	    this.el.$buttonResetWebcam.css({'display':'none'});
      var val =  this.el.$buttonVerificationPhoto1.val();
      var self = this;

      switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
        case 'jpg': 
            var files = !!this.el.$buttonVerificationPhoto1[0].files ? this.el.$buttonVerificationPhoto1[0].files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function(){ // set image data as background of div
                  self.el.$formWebcam.html('<img src='+this.result+' class="avatar" alt="Responsive image" id="photo1">');
            }
        }
            break;
        default:
            this.el.$buttonVerificationPhoto1.val('');
            this.el.$labelAlertPhoto1.html("The filetype you are attempting to upload is not allowed.");
            this.el.$labelAlertPhoto1.css({'display':'block'});
            this.el.$labelAlertPhoto1.show().delay(500).fadeOut();
            break;
      }
  },

  /* Validasi Photo 2 */
  verificationPhoto2: function(){
      var val =  this.el.$buttonVerificationPhoto2.val();
      var self = this;

      switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
        case 'jpg': 
            var files = !!this.el.$buttonVerificationPhoto2[0].files ? this.el.$buttonVerificationPhoto2[0].files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function(){ // set image data as background of div
                 self.el.$pictPhoto2.attr("src", ""+this.result+"");
            }
        }
            break;
        default:
            this.el.$buttonVerificationPhoto2.val('');
            this.el.$labelAlertPhoto2.html("The filetype you are attempting to upload is not allowed.");
            this.el.$labelAlertPhoto2.css({'display':'block'});
            this.el.$labelAlertPhoto2.show().delay(500).fadeOut();
            break;
      }
  },

   /* Submit Form */
  submitForm: function(){
    var self = this;
    var formData = new FormData(this.el.$buttonFormVerificationPhoto[0]);
    this.el.$loaderSubmit.css({'display':'inline'});
    this.el.$buttonSubmitVerification.attr("disabled", true);

    if((this.el.$buttonVerificationPhoto1.val()==="") && (this.el.$buttonResetWebcam.css('display') === 'none')){
    	this.el.$labelAlertPhoto1.html("You did not select a file to upload.");
  		this.el.$labelAlertPhoto1.css({'display':'block'});
  		this.el.$labelAlertPhoto1.show().delay(500).fadeOut();
	  }else if((this.el.$buttonVerificationPhoto2.val()==="")){
  		this.el.$labelAlertPhoto2.html("You did not select a file to upload.");
  		this.el.$labelAlertPhoto2.css({'display':'block'});
  		this.el.$labelAlertPhoto2.show().delay(500).fadeOut();
    }else{
          $.ajax({
          url: "./photo/verificationPhoto",
          type: "POST",
          data:  formData,
          contentType: false,
          cache: false,
          processData:false,
          success: function(data)
          {
            if(data.info===1){
              callbackWebcam('Call Back Webcam', function(){
                 webcam.upload();
              })

            }else{
              callbackWebcam('Call Back Webcam', function(){

              })
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
              alert("Status: " + textStatus); alert("Error: " + errorThrown); 
          } 
        }); 	
      }

      self.el.$loaderSubmit.css({'display':'none'});
      self.el.$buttonSubmitVerification.attr("disabled", false);
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


 verification.init();

  function callbackWebcam(param, callback){
      $('#form-photo-1').css({'display':'none'});
      $('#form-photo-2').css({'display':'none'});
      $('.panel-footer').css({'display':'none'});
      $('#form-panel').append('Success');

      if(callback && typeof(callback) === "function"){
          callback();
      }
    }
    
});
});