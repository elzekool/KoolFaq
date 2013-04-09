<?php
/**
 * Gebruiker wijzigen
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

$this->helper('Validatie')->form('#addeditform')->writeJs();

?>

<div class="row-fluid">
    <div class="span12">
        <br />
        <form id="addeditform" method="POST" action="beheer/gebruiker/edit/<?php echo $gebruiker->getId(); ?>" class="form-horizontal">
            
            <div class="control-group">
                <label class="control-label"><?php __w('Gebruikersnaam', 'beheer'); ?></label>
                <div class="controls">
                    <input type="text" name="form[gebruikersnaam]" class="span5" value="<?php echo _h($form['gebruikersnaam']); ?>">
                    <div class="validatie-berichten"></div>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><?php __w('Naam', 'beheer'); ?></label>
                <div class="controls">
                    <input type="text" name="form[naam]" class="span5" value="<?php echo _h($form['naam']); ?>">
                    <div class="validatie-berichten"></div>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><?php __w('Wachtwoord', 'beheer'); ?></label>
                <div class="controls">
                    <input type="text" name="form[wachtwoord]" class="span5" value="" autocomplete="off">
                    <div class="validatie-berichten"></div>
                    <p class="help-inline">
                        <?php __w('Laat leeg om het wachtwoord ongewijzigd te laten', 'beheer'); ?>
                    </p>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><?php __w('Moet wachtwoord wijzigen', 'beheer'); ?></label>
                <div class="controls">
                    <select name="form[moet_wachtwoord_wijzigen]" class="span1">
                        <option <?php if ($form['moet_wachtwoord_wijzigen'] == 1) : ?>selected<?php endif; ?> value="1"><?php __w('Ja'); ?></option>
                        <option <?php if ($form['moet_wachtwoord_wijzigen'] == 0) : ?>selected<?php endif; ?> value="0"><?php __w('Nee'); ?></option>
                    </select>
                    <div class="validatie-berichten"></div>
                </div>
            </div>
                        
            <p>&nbsp;</p>
            <hr />
            
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-large"><?php __w('Opslaan','beheer'); ?></button>
                </div>
            </div>
            
            
        </form>
    </div>
</div>


<?php $this->placeholder('sidebar')->start(); ?>
    <div class="row-fluid">
        <div class="row-fluid">
            <div class="span12">
                
                <div class="navigatie">
                    <h3><i class="icon icon-user"></i> <?php __w('Gebruiker', 'beheer'); ?></h3>
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="beheer/gebruiker/index/"><i class="icon icon-arrow-left"></i> <?php __w('Terug naar overzicht', 'beheer'); ?></a></li>
                   </ul>
                </div>      
                
            </div>
        </div>
    </div>
<?php $this->placeholder('sidebar')->end(); ?>

