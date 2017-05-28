(function() {
    tinymce.create('tinymce.plugins.Wptuts', {
        init : function(ed, url) {
            ed.addButton('av-shortcodes', {
                title : 'Shortcodes Manager',
                cmd : 'av-shortcodes',
                image : url + '/../../images/shortcode-icon.png'
            });

            ed.addCommand('av-shortcodes', function() {
                jQuery('.shortcode-input').val('');
                var overlay = document.querySelector( '.md-overlay' );
                var modal = document.querySelector( '#shortcodes-modal' )
                var effect = 'md-effect-slip-from-top';
                classie.add( modal, 'md-show' );                
            });

            jQuery('.insert-shortcode').click(function(){
                var shortcode = '';
                var parent = jQuery(this).parent().parent();
                var tag_name = parent.attr('id');
                shortcode = shortcode+'['+tag_name;
                jQuery('#'+tag_name).find('.shortcode-input').each(function(){
                    var attr_name = jQuery(this).attr('name');
                    var attr_value = jQuery(this).val();
                    shortcode = shortcode+' '+attr_name+'="'+attr_value+'"';
                });
                if ( jQuery('#'+tag_name+' .shortcode-input-content').length > 0 ) {
                    shortcode = shortcode+']'+jQuery('#'+tag_name+' .shortcode-input-content').val()+'[/'+tag_name+']';
                }else{
                    shortcode = shortcode+'][/'+tag_name+']';
                }
                ed.execCommand('mceInsertContent', 0, shortcode);
                jQuery('#shortcodes-modal').removeClass('md-show');
            });

        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'avstudio', tinymce.plugins.Wptuts );
})();