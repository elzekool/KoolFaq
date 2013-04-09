/**
 * Twitter Bootstrap alert/confirm/prompt replacements
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/


(function($, undefined) {

    // Default options
    var defaults = {
        
        // Title of the dialog, none if undefined
        'title' : undefined,
        
        // Message inside the dialog, none if undefined
        'message' : undefined,
        
        // Placeholder for input, none if undefined
        'placeholder' : undefined,
        
        // Default value for input
        'default_value' : '',
        
        // Backdrop (See Twitter Bootstrap Documentation)
        'backdrop' : true,
        
        // Keyboard setting (See Twitter Bootstrap Documentation)
        'keyboard' : true,
        
        // Defined buttons
        'buttons' : {
            'ok'     : 'Ok',
            'cancel' : 'Cancel',
            'yes'    : 'Yes',
            'no'     : 'No'
        },
    
        // Buttons displayed on alert dialog
        'alertButtons' : ['ok'],
        
        // Buttons displayed on confirm dialog
        'confirmButtons' : ['cancel', 'ok'],
        
        // Buttons displayed on prompt dialog
        'promptButtons' : ['cancel', 'ok'],
        
        // Set to false to disable closing the dialog with keyboard
        // and/or close button. If false, keyboard is also set to false
        'allowClose' : true,
        
        // Validator for input, allows checking the input value
        // just before the callback is triggered. Return string 
        // to display validation error
        'inputValidator' : function(btn, val) { return true; }
    
    };

    /**
     * Seperate function to add events to the created dialog
     * Called by createDialog
     * 
     * @param {Object}             options
     * @param {DOMElement}         dialog
     * @param {Function|undefined} callback
     */
    var addEvents = function(options, dialog, callback) {
        
        var triggered = false;
        
        var onCallback = function(result, already_hidden) {
            var close_dialog = true;     
            var input = dialog.find('input');
            var value = input.length === 0 ? null : input.val();    
            
            if (!already_hidden) {
                var validation = options.inputValidator(result, value);
                if (typeof validation === 'string' || validation instanceof String) {
                    input.parent().find('.validation-error').html($('<p class="help-block" />').text(validation));
                    input.parent().parent().addClass('error');
                    return;
                }
            }
            
            if (callback !== undefined) {
                        
                if (callback(result, value) === false) {
                    close_dialog = false;
                }
            }
            if (close_dialog) {
                if (!already_hidden) {
                    triggered = true;
                    dialog.modal('hide');                    
                }
            }            
        };
    
        // Add event handlers to the button
        dialog.find('button.btn').on('click', function() {
            var btn = $(this).attr('data-button');
            onCallback(btn, false);
            return false;
        });
    
        // Trigger primary button on pressing enter
        dialog.find('input').on('keypress', function(e) {
            if (e.which === 13) {
                dialog.find('button.btn-primary').trigger('click');
            }
            $(this).parent().parent().removeClass('error');
        });  
        
        
        // If hidden and event was not triggerd call event handler
        dialog.on('hide', function() {
            if (!triggered) {
                onCallback(null, true);
            }
        });
    
        // Remove dialog from DOM once hidden
        dialog.on('hidden', function() {
           dialog.remove(); 
        });
        
    };

    /**
     * Create and show dialog
     * 
     * @param {Object}             options    Options for dialog
     * @param {Array}              buttons    Buttons to show
     * @param {Boolean}            show_input Display input
     * @param {Function|undefined} callback   Callback to call on result
     */
    var createDialog = function(options, buttons, show_input, callback) {
        
        var dialog = $('<div class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" />');        
        
        // Dialog header
        if (options.title !== undefined) {
            var header = $('<div class="modal-header" />');
            if (options.allowClose) {
                header.append($('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'));                
            }
            header.append($('<h3 />').text(options.title));
            dialog.append(header);
        }

        // Dialog body
        var body = $('<div class="modal-body" />').text(options.message);
        if (show_input) {
            var input = $('<input type="text" class="input-xlarge" />');
            input.val(options.default_value);
            if (options.placeholder !== undefined) {
                input.attr('placeholder', $('<div />').text(options.placeholder).html());
            }
            var input_container = $('<div class="form-vertical"><br /><div class="control-group"><div class="controls"><div class="validation-error"></div></div></div></div>');
            body.append(input_container);
            
            input_container.find('.controls').prepend(input);
        }
        dialog.append(body);
        
        // Dialog footer
        if (buttons.length > 0) {
            var footer = $('<div class="modal-footer" />');
            $.each(buttons, function(i, btn) {
                var txt = btn;
                if (options.buttons[btn] !== undefined) {
                    txt = options.buttons[btn];
                }                
                var button = $('<button type="button" class="btn" />').text(txt);
                button.attr('data-button', $('<div />').text(btn).html());
                
                // Make last button primary
                if (i === buttons.length-1) {
                    button.addClass('btn-primary');
                }                
                footer.append(button);
            });
            dialog.append(footer);
        }
    
        $('body').prepend(dialog);
        
        // Add events to dialog
        addEvents(options, dialog, callback);
        
        // Show dialog
        dialog.modal({
            backdrop : options.allowClose === false ? 'static' : options.backdrop,
            keyboard : options.allowClose === false ? false : options.keyboard
        });
        
    };
    

    // Supported methods
    var methods = {
        
        // Dialog with only an ok button displaying a message
        'alert' : function(options, callback) {
            if (typeof options === 'string' || options instanceof String) {
                options = { 'message' : options };
            }
            options = $.extend(true, {}, defaults, options);
            createDialog(options, options.alertButtons, false, callback);
        },
            
        // Dialog with ok/cancel buttons displaying a message
        'confirm' : function(options, callback) {
            if (typeof options === 'string' || options instanceof String) {
                options = { 'message' : options };
            }
            options = $.extend(true, {}, defaults, options);
            createDialog(options, options.confirmButtons, false, callback);
        },
            
        // Dialog with input box and 
        'prompt' : function(options, callback) {
            if (typeof options === 'string' || options instanceof String) {
                options = { 'message' : options };
            }
            options = $.extend(true, {}, defaults, options);
            createDialog(options, options.promptButtons, true, callback);
        },
    
        // Update defaults        
        'defaults' : function(options) {
            if (options instanceof Object) {
                $.extend(true, defaults, options);
            }
        }
        
        
    };


    /**
     * koolModal Plugin
     * 
     * Twitter Bootstrap alert/confirm/prompt replacements
     * 
     * @param {String}                  method   Method to call
     * @param {String|Object|undefined} options  Options for method
     * @param {Function|undefined}      callback Callback
     */
    $.koolModal = function(method, options, callback) {
        if ( methods[method] ) {
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.koolModal' );
        }   
    };


})(jQuery);    