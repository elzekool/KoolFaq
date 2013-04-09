/**
 * WYSIWYG Lader
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/


(function($, undefined) {
    
    $(document).ready(function() {
        
        
        // Eerst kijken of CKEditor al geladen is
        if ($('script[src~="ckeditor.js"]').length === 0) { 
            window.CKEDITOR_BASEPATH = $('#base').attr('href') + "/external/ckeditor/";
            $('body').append('<script type="text/javascript" src="' + window.CKEDITOR_BASEPATH + '/ckeditor.js"></script>');
        }
    
        
        // Vervang alle textarea's
        $('textarea.wysiwyg[name]').each(function() {
            CKEDITOR.replace(this, {
                baseHref : $('#base').attr('href'),
                clipboard_defaultContentType : 'text',
                emailProtection : 'mt(NAME,DOMAIN,SUBJECT,BODY)',
                
                contentsCss : $('#base').attr('href') + '/css/frontend.css',
                bodyClass : 'wysiwyg_body',
                
                pasteFromWordRemoveFontStyles : true,
                pasteFromWordRemoveStyles : true,
                
                
                toolbar: [
                    [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ], 
                    [ 'Find','Replace','-','SelectAll'], [ 'Image', 'Link', 'Unlink', 'Table', 'Anchor' ], '/',
                    
                    [ 'Format', 'Bold', 'Italic', 'Underline', 'RemoveFormat' ],  [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent' ], 
                    [ 'Maximize', '|', 'ShowBlocks', 'Source', '-','About' ]
                    
                ],
            
                width : $(this).width(),
                height : 300
                
                
            });
        
        });
    
        // Ivm Tabs
        $('a[data-toggle="tab"]').on('shown', function (e) {                                 
            for (var key in CKEDITOR.instances) if (CKEDITOR.instances.hasOwnProperty(key)) {
                var instance = CKEDITOR.instances[key];
                var el = $('textarea[name="' + instance.name + '"]');
                if (el.length > 0) {
                    el.css({ 'display' : 'block', 'visibility' : 'visible' });             
                    CKEDITOR.instances[key].resize(el.width(), 300);
                    el.css({ 'display' : 'none', 'visibility' : 'hidden' });             
                    CKEDITOR.instances[key].updateElement(); 
                }                
            }
            
        });
        
        
    });
    
    
})(jQuery);