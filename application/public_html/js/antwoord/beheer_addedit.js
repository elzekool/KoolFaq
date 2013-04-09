/**
 * Antwoord bewerken
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/


(function($, undefined) {
    
    $(document).ready(function() {
        
        var tags = $('input[name="form[tags]"]');
        tags.select2({
           tags : JSON.parse(tags.attr('data-tags')),
           separator : '|'
        });
    });
    
    
})(jQuery);