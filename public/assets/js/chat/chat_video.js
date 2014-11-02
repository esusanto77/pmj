(function($){

var chatVideo = {
  el: {},

  onload: function() { 
    setTimeout(function(){
      $(".loadingPop").html('<span>No Chats</span>');
    },5000)
  },

  checkFirst : function(){
    var file = $('#file-video').val();
    var from = $('#sender-video').val();
    var ext = file.split('.').slice(1,2).join('');

    console.log(ext);
    //$('#source-video').attr('src', root.base_url+'public/upload/chat/video/'+from+'/'+file);
    $('#source-video').attr('src', 'http://pmjstorage.blob.core.windows.net/chat/video/'+from+'/'+file);
    $('#source-video').attr('type', 'video/'+ext);

    $('.video-title').html(file);
   
  },

  init: function() {
    this.checkFirst();
  }

};

$(document).ready(function(){
  chatVideo.init();

  var video = projekktor('#player_a', {
    volume: 0.5,
    ratio: 16/9,
    volume: 0.5,
    controls: true,
    autoplay: true,
    platforms: ['browser', 'ios', 'native', 'flash'],
    playerFlashMP4: root.base_url + 'public/assets/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf',
    playerFlashMP3: root.base_url + 'public/assets/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf'
  });


});

})(jQuery);