(function( $ ) {
    'use strict';

    jQuery(document).ready(function(){
            
        jQuery('#checkall').click(function(){
            var checked = jQuery(this).prop('checked');
            jQuery('#media_file_label_settings').find('input.removelabel').prop('checked', checked);
        });
          
        jQuery('#hideon').click(function(){
            var checked = jQuery(this).prop('checked');
            jQuery('#media_file_label_settings').find('input.hideonmedia').prop('checked', checked);
        });
          
    });
        
})( jQuery );
