jQuery.noConflict()(function ($) {
$(document).ready(function () {
  var rootUrl = window.location.hostname;

  rootUrl = root.base_url.substring(0, root.base_url.length - 1);

  function centerModal() {
    $(this).css('display', 'block');
    var $dialog = $(this).find(".modal-dialog");
    var offset = ($(window).height() - $dialog.height()) / 2;
    var bottomMargin = $dialog.css('marginBottom');
    bottomMargin = parseInt(bottomMargin);
    if(offset < bottomMargin) offset = bottomMargin;
    $dialog.css("margin-top", offset);
  }

  function resize(nameModal){
    $(nameModal).on('show.bs.modal', centerModal);
    $(window).on("resize", function () {
      $(nameModal).each(centerModal);
    });
  }

  // Modal Contact Admin
  $("#button-contact-admin").on("click",function(){
    resize('#modalContactAdmin');
    $("#modalContactAdmin").modal();
  });

   // Choose Metode Upload Photo
   $(".metode-upload-photo").on("click",function(){
    resize('#myModalMetodeUploadPhoto');
    $("#myModalMetodeUploadPhoto").modal();
  });

  // Upload Photo
  $(".upload-photo").on("click",function(){
    resize('#myModalUploadPhoto');
    $("#myModalMetodeUploadPhoto").modal('hide');
    $("#myModalUploadPhoto").modal();
  });

  // Avalaible Photo
  $(".available-upload-photo").on("click",function(){
    resize('#myModalAvailableUploadPhoto');
    $("#myModalMetodeUploadPhoto").modal('hide');
    $("#myModalAvailableUploadPhoto").modal();
  });

  /* Jika tidak jadi upload photo*/
  $('#myModalAvailableUploadPhoto').on('hidden.bs.modal', function () {
    $(".error-image-from-avatar").empty();
  });

  $('#myModalMetodeUploadPhoto').on('hidden.bs.modal', function () {
    $('.error-image').empty();
    $('#image_real').css('display','block');
    $('#image').val("");
    $("#loading-upload-image").attr("disabled", false);
    $("#animation-loading-upload-image").css({'display':'none'});
    $('#loading-upload-image').html('Upload');
    $('#avatar-available-photo > img').css("boxShadow", "");
    $('#value-available-image').val('');
  });

  $('#myModalUploadPhoto').on('hidden.bs.modal', function () {
    $('#image_thumbnail_form').css('display','none');
  });

  // Choose Avatar
  $('.modal-profile-photo2-list-ava').click(function()
  {
    $('#avatar-available-photo  > img').css("boxShadow", "");
    $(this).css("box-shadow", "-3px 5px 20px #888888");
    $('#value-available-image').val(this.src);
  });

  /* Change Image From Avatar */
  $('#chooseImageFromAvatar').on('submit',function(){
    if ($('#value-available-image').val()==="" || $('#value-available-image').val()===null) {
        $('.error-image-from-avatar').html('<div class="alert alert-danger">Please select some photo</div>');
        $('.error-image-from-avatar').show().delay(500).fadeOut();
      return false;
    }
  });

  /* Upload Form */
  $("#uploadform").on('submit',(function() {
    $('#loading-upload-image').html('Please Wait');
    $("#loading-upload-image").attr("disabled", true);
    $("#animation-loading-upload-image").css({'display':'inline-block'});
    $('.animation-wait-image').css({'display':'block'});
   
    $.ajax({
      url: rootUrl+"/photo/uploadPhoto",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(data)
      {
        if(data.info=="false"){
          $('.error-image').html('<div class="alert alert-danger">'+data.error+'</div>');
          $('.error-image').show().delay(500).fadeOut();
          $('#loading-upload-image').html('Upload');
          $("#loading-upload-image").attr("disabled", false);
          $("#animation-loading-upload-image").css({'display':'none'});
        }else{
          $('#image_thumbnail_form').css('display','block');
          $('#image_real').css('display','none');
          $('#image_thumbnail').html(data.image);
          $('#file_name').val(data.file_name);
          $('#filename_ori').val(data.filename_ori);
          $('#filename').val(data.filename);
        }

      }        
    }).done(function(){
      $("#thumbnail").load(function(){
         $('.animation-wait-image').css({'display':'none'});
         $("#thumbnail").css({'opacity':'1'});
      });

      $('#loading-upload-image').html('Upload');
      $(function(){
      $('#thumbnail').Jcrop({
        aspectRatio: 1,
        onSelect: updateCoords,
        boxWidth: 560,
        boxHeight: 560
      });

    });

     function updateCoords(c)
     {
      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#w').val(c.w);
      $('#h').val(c.h);
    };

    function checkCoords()
    {
      if (parseInt($('#w').val())) return true;
      alert('Please select a crop region then press submit.');
      return false;
    };
  });
    return false;
  }));

  /* For Tab */
  $('#myTab a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
  })


});
});