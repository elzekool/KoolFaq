(function($) {
    
    $(document).ready(function() {
        jQuery.support.placeholder = false;
	test = document.createElement('input');
	if('placeholder' in test) jQuery.support.placeholder = true;
        
        if (!jQuery.support.placeholder) {
            $('[placeholder]').focus(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                  input.val('');
                  input.removeClass('placeholder');
                }
            }).blur(function() {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                  input.addClass('placeholder');
                  input.val(input.attr('placeholder'));
                }
            }).blur();
        }
    });
    
})(jQuery);

