<?php
/**
 * Inlogpagina
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

$this->helper('Validatie')->form('#inlogform')->writeJs();
        
$assets = $this->helper('Assets');        
/* @var $assets \View\Helper\Assets */
$assets->inlineScript('(function($) { $(document).ready(function() { $("#inputGebruikersnaam").focus(); }); })(jQuery);');

?>

<form id="inlogform" method="POST" action="gebruiker/inloggen" class="form-vertical" >

    <div class="control-group">
        <label class="control-label" for="inputGebruikersnaam"><?php __w('Gebruikersnaam', 'beheer'); ?></label>
        <div class="controls">
            <input type="text" class="span6" name="form[gebruikersnaam]" id="inputGebruikersnaam" placeholder="<?php __w('Gebruikersnaam', 'beheer'); ?>">           
            <div class="validatie-berichten"></div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputWachtwoord"><?php __w('Wachtwoord', 'beheer'); ?></label>
        <div class="controls">
            <input type="password" class="span6" name="form[wachtwoord]" id="inputWachtwoord" placeholder="<?php __w('Wachtwoord', 'beheer'); ?>">
            <div class="validatie-berichten"></div>
        </div>
    </div>

    <br />
    <button type="submit" class="btn btn-large btn-primary"><?php __w('Inloggen', 'beheer'); ?></button>    
</form>