/* 
 * jQuery Select element replacement
 * by @mambows
 */
(function($){
  $.fn.selectbox = function(opts) {
    var defaults = {
      theme: 'default-theme',
      arrow: 'icon-arrow-down'
    },
    options = $.extend(defaults, opts);

    return this.each(function(){
      var $el = $(this),
          val = $el.find(':selected').text(),
          $text;

      // Build Elements
      $el.wrap('<div class="select-wrapper '+ options.theme +'"></div>');
      $('<div class="select-text">'+ val +'</div><i class="'+ options.arrow +'"></i>').insertBefore( $el );
      $text = $el.prevAll('.select-text');

      // onChange Event
      $el.bind('change', function(){ 
        $text.text( $el.find(':selected').text() );
      });

    });
  };
})(jQuery);