(function($) {
   $(function() {
      $.fn.wptuts = function(options) {
         var selector = $(this).selector; // Get the selector
         // Set default options
         var defaults = {
            'preview' : '.preview-upload',
            'text'    : '.text-upload',
            'button'  : '.button-upload',
         };
         var options  = $.extend(defaults, options);
 
         var _custom_media = true;
         var _orig_send_attachment = wp.media.editor.send.attachment;
 
          // When the Button is clicked...
         $(options.button).click(function() {
            // Get the Text element.
            var button = $(this);
            var text = $(this).siblings(options.text);
            var send_attachment_bkp = wp.media.editor.send.attachment;
 
            _custom_media = true;
 
            wp.media.editor.send.attachment = function(props, attachment) {
               if(_custom_media) {
                  // Get the URL of the new image
                  text.val(attachment.url).trigger('change');
               } else {
                  return _orig_send_attachment.apply(this, [props, attachment]);
               };
            }
 
            wp.media.editor.open(button);
 
            return false;
         });
 
         $('.add_media').on('click', function() {
           _custom_media = false;
         });
 
         $(options.text).bind('change', function() {
            // Get the value of current object
            var url = this.value;
            // Determine the Preview field
            var preview = $(this).siblings(options.preview);
            // Bind the value to Preview field
            $(preview).attr('src', url);
         });
      }
 
      // Usage
      $('.upload').wptuts(); // Use as default option.
   });
}(jQuery));