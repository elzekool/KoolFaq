/**
 * Validatie Helper, Javascript deel
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/


(function($, undefined) {
    
    /**
     * Validator constructor
     * 
     * @param form   Form element
     * @param opties Eventuele opties
     **/
    var validator = function(form, opties) {
        
        var self = this;
        
        var defaults = {              
            
            // Te valideren velden binnen form
            fields : undefined,
            
            // Classe die wordt toegevoegd aan invalide velden
            invalidCls : 'valideer_invalid',

			// Classe die wordt toegevoegd aan valide velden
            validCls : 'valideer_valid',
            
            // Classe voor berichtdiv
            berichtenCls : 'validatie-berichten',
                    
            // Formaat van veldnamen
            nameFormat : 'form[{{name}}]'
            
        };  
        
        var options = $.extend(defaults, opties);                
        if (options.fields === undefined) {
            options.fields = [];
            $.each(KoolFAQ.Validator.validators, function(field) {
                options.fields.push(field);
            });
        }
    
        // Bepaal naam van veld
        var getInputName = function(field) {
            return options.nameFormat.replace('{{name}}', field);
        };
                
        var fields = [];        
        $.each(options.fields, function() {
           var inpName = getInputName(this);
           
           var selector = 'input[name^="' + inpName + '"], textarea[name^="' + inpName + '"], select[name^="' + inpName + '"]'; 
           var field = form.find(selector);
           
           if (field.length > 0) {
               
               field.attr('data-validatie-key', this);
               fields.push(field);
           }
        });        
    
    
        
    
        fields = $(fields);        

        

        /**
        * Validatie door middel van regex functie    
        * 
        * @param value   Waarde
        * @param setting Instelling
        * 
        * @return boolean Voldoet aan validatie
        */
        this.validateRegEx = function(value, setting) {
            if (value === null) {
                return true;
            }
            var regex = new RegExp(setting);
            if (value.constructor == Array) {
                value = value.join(',');
            }
            return regex.test(value);            
        }
        
        /**
        * Controleerd of waarde van veld overeenkomt met ander veld
        * 
        * @param value   Waarde
        * @param setting Instelling
        * 
        * @return boolean Voldoet aan validatie
        */
        this.validateMatchField = function(value, setting) {
            if (value === null) {
                return true;
            }
            var inpName = getInputName(setting);
            var selector = 'input[name^="' + inpName + '"], textarea[name^="' + inpName + '"], select[name^="' + inpName + '"]';
            var field = form.find(selector).first();
            if (field.length == 0) {
                return false;
            }
            if (self.getFieldValue(field.attr('name')) == value) {
                return true;
            } else {
                return false;
            }
        }
        
        /**
        * Controleerd of een veld ook meegegeven is
        * 
        * @param value   Waarde
        * @param setting Instelling
        * 
        * @return boolean Voldoet aan validatie
        */
        this.validateRequired = function(value, setting) {
            return (value !== null);
        }

        /**
         * Veldwaarde ophalen voor een veld. Probeerd
         * de PHP manier van waarde bepalen te gebruiken
         * 
         * @param fieldname Veldwaarde
         * 
         * @return Veldwaarde
         */
        this.getFieldValue = function(fieldname) {
            
            var values = form.find(':not(.hasPlaceholder)').serializeArray();            
            var value = [];
            var found = false;
            
            $.each(values, function() {
                if (this.name == fieldname) {
                    value.push(this.value);
                    found = true;
                }                
            });
            
            if (found == false) {
                return null;
            } else if (value.length == 1) {
                value = value[0];                
            } else if (!/\[\]$/.test(fieldname)) {
                value = value[value.length-1];
            }
            
            return value;
        };
        
        /**
         * Markeer een veld als valide
         * 
         * @param field Veld dat valide is
         * 
         * @return void
         **/
        this.fieldValid = function(field) {
            field.addClass(options.validCls).removeClass(options.invalidCls);
            var controlgroup = field.parent().parent();
            if (controlgroup.parent().hasClass('control-group')) {
                controlgroup = controlgroup.parent();
            }
            if (controlgroup.hasClass('control-group')) {
                controlgroup.removeClass('error');
                controlgroup.find('.' + options.berichtenCls).empty();
            }  
        };
        
        /**
         * Markeer een veld als valide
         * 
         * @param field     Veld dat valide is
         * @param berichten Validatie berichten
         * 
         * @return void
         **/
        this.fieldInvalid = function(field, berichten) {
            field.addClass(options.invalidCls).removeClass(options.validCls);
            var controlgroup = field.parent().parent();
            if (controlgroup.parent().hasClass('control-group')) {
                controlgroup = controlgroup.parent();
            }
            if (controlgroup.hasClass('control-group')) {
                controlgroup.addClass('error');                
                var berichtendiv = controlgroup.find('.' + options.berichtenCls);
                berichtendiv.empty();         
                if (berichten.length > 1) {
                    $.each(berichten, function() {
                        berichtendiv.append($('<p class="help-block" />').text(this));
                    });                
                } else {
                    berichtendiv.append($('<p class="help-block" />').text(berichten[0]));
                }
                
            }
        };
        
        /**
         * Valideer een veld
         * 
         * @return boolean True
         */
        this.validateField = function() {
            var field = $(this).attr('data-validatie-key');
            var value = self.getFieldValue($(this).attr('name'));
            var berichten = [];
            var valide = true;
            
            if (KoolFAQ.Validator.validators[field] != undefined) {                
                $.each(KoolFAQ.Validator.validators[field], function() {                    
                    var validator = self['validate' + this.validator];                    
                    if (!validator(value, this.setting)) {
                        berichten.push(this.bericht);
                        valide = false;
                        if (this.stop) {
                            return false;
                        }
                    }                    
                    return true;                    
                });
            }
            
            if (valide) {
                self.fieldValid($(this));
            } else {
                self.fieldInvalid($(this), berichten);
            }
            
            return true;
        };
        
        /**
         * Valideer een formulier
         * 
         * @return boolean Form valide
         */
        this.validateForm = function() {
            fields.each(self.validateField);
            if (form.find('.' + options.invalidCls).length > 0) {
                return false;
            } else {
                return true;
            }
        };
        
                
        // Bind event handlers aan fields en form
        $.each(fields, function() {
            
            
            this
                .bind('blur', self.validateField)
                .bind('change', self.validateField)
                .bind('keypress', function() {
                    // Alleen bij keypress wanneer formulier verkeerd is
                    if ($(this).hasClass(options.invalidCls)) {
                       self.validateField.apply(this);
                    }
                })
                .bind('click', function() {
                    // Alleen bij click wanneer formulier verkeerd is
                    if ($(this).hasClass(options.invalidCls)) {
                        self.validateField.apply(this);
                    }
                });
        });

        form.bind('submit', this.validateForm);
        
    };
    
    
    $(document).ready(function() {
        
        if (KoolFAQ.Validator == undefined) {
            throw "Serverside validatie niet geladen!";
        }
        
        $.each(KoolFAQ.Validator.forms, function(frm) {    
            new validator($(this.selector), this.opties);
        })
        
    });
    
    
})(jQuery);

