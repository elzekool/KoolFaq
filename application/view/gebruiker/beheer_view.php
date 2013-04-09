<?php
/**
 * Gebruiker details
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

?>

<div class="row-fluid">
    <div class="span12">
        <br />
        
        <div class="form-horizontal">
            
            <div class="control-group">
                <label class="control-label"><?php __w('Gebruikersnaam', 'beheer'); ?></label>
                <div class="controls">
                    <input type="text" class="span4 uneditable-input" value="<?php echo _h($gebruiker->getGebruikersnaam()); ?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><?php __w('Naam', 'beheer'); ?></label>
                <div class="controls">
                    <input type="text" class="span6 uneditable-input" value="<?php echo _h($gebruiker->getNaam()); ?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><?php __w('Moet wachtwoord wijzigen', 'beheer'); ?></label>
                <div class="controls">
                    <input type="text" class="span1 uneditable-input" value="<?php echo $gebruiker->getMoetWachtwoordWijzigen() ? __('Ja') : __('Nee'); ?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><?php __w('Laatste keer aangemeld', 'beheer'); ?></label>
                <div class="controls">
                    <input type="text" class="span3 uneditable-input" value="<?php echo $this->helper('Weergave')->datumtijd($gebruiker->getLaatsteKeerAangemeld()); ?>">
                </div>
            </div>
            
        </div>
        
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
                        <li><a href="beheer/gebruiker/edit/<?php echo $gebruiker->getId(); ?>"><i class="icon icon-pencil"></i> <?php __w('Wijzigen', 'beheer'); ?></a></li>
                        <li><a onclick="return confirm('<?php __w('Weet u het zeker?', 'beheer'); ?>');" href="beheer/gebruiker/delete/<?php echo $gebruiker->getId(); ?>"><i class="icon icon-remove"></i> <?php __w('Wissen', 'beheer'); ?></a></li>
                   </ul>
                </div>    
                
            </div>
        </div>
    </div>
<?php $this->placeholder('sidebar')->end(); ?>

