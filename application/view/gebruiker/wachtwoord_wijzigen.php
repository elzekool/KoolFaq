<?php
/**
 * Wachtwoord wijzigen
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/


$this->helper('Validatie')->form('#wachtwoord_wijzigen_form')->writeJs();

?>
<p><?php echo _h(sprintf(__('Beste %s. De beheerder heeft aangegeven dat u het wachtwoord moet wijzigen. Vul hieronder een nieuw wachtwoord in.', 'beheer'), $gebruiker->getNaam())); ?></p>
<br />

<form id="wachtwoord_wijzigen_form" method="POST" action="gebruiker/wachtwoord_wijzigen" class="form-vertical" >

    
    <div class="control-group">
        <label class="control-label" for="inputWachtwoord"><?php __w('Wachtwoord', 'beheer'); ?></label>
        <div class="controls">
            <input type="password" class="span6" name="form[wachtwoord]" id="inputWachtwoord" placeholder="<?php __w('Wachtwoord', 'beheer'); ?>">
            <div class="validatie-berichten"></div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputHerhaalWachtwoord"><?php __w('Herhaal wachtwoord', 'beheer'); ?></label>
        <div class="controls">
            <input type="password" class="span6" name="form[herhaal_wachtwoord]" id="inputHerhaalWachtwoord" placeholder="<?php __w('Herhaal wachtwoord', 'beheer'); ?>">
            <div class="validatie-berichten"></div>
        </div>
    </div>

    <br />
    <button type="submit" class="btn btn-large btn-primary"><?php __w('Wachtwoord wijzigen', 'beheer'); ?></button>    
</form>