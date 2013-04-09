<?php
/**
 * Antwoord toevoegen
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

$this->helper('Validatie')->form('#addeditform')->writeJs();
$this->helper('Lader')->wysiwyg()->select2();
$this->helper('Assets')->script('js/antwoord/beheer_addedit.js');
        
?>
<div class="row-fluid">
    <div class="span12">
        <br />
        <form id="addeditform" method="POST" action="beheer/antwoord/add/" class="form-horizontal">
            
            <ul class="nav nav-tabs">
                <li class="active"><a href="#vraag" data-toggle="tab"><i class="icon icon-edit"></i> <?php __w('Vraag', 'beheer'); ?></a></li>
                <li><a href="#antwoord" data-toggle="tab"><i class="icon icon-comment"></i> <?php __w('Antwoord', 'beheer'); ?></a></li>
            </ul>
            
            <div class="tab-content">
                
                <div class="tab-pane active" id="vraag">
                    <div class="control-group">
                        <label class="control-label"><?php __w('Titel', 'beheer'); ?></label>
                        <div class="controls">
                            <input type="text" name="form[titel]" class="span5" value="<?php echo _h($form['titel']); ?>">
                            <div class="validatie-berichten"></div>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"><?php __w('Tags', 'beheer'); ?></label>
                        <div class="controls">
                            <input type="hidden" name="form[tags]" class="span11" multiple="multiple" value="<?php echo _h($form['tags']); ?>" data-tags="<?php echo _h(json_encode($tags)); ?>" />
                            <div class="validatie-berichten"></div>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"><?php __w('Vraag', 'beheer'); ?></label>
                        <div class="controls">
                            <textarea name="form[vraag]" class="wysiwyg span11" rows="15"><?php echo _h($form['vraag']); ?></textarea>
                            <div class="validatie-berichten"></div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="tab-pane" id="antwoord">
                    <div class="control-group">
                        <label class="control-label"><?php __w('Antwoord', 'beheer'); ?></label>
                        <div class="controls">
                            <textarea name="form[antwoord]" class="wysiwyg span11" rows="15"><?php echo _h($form['antwoord']); ?></textarea>
                            <div class="validatie-berichten"></div>
                        </div>
                    </div>
                </div>
                
            </div>
                        
            <p>&nbsp;</p>
            <hr />
            
            <div class="control-group">
                <div class="controls">
                    <button type="submit" id="opslaan" class="btn btn-large"><i class="icon icon-save"></i> <?php __w('Opslaan','beheer'); ?></button>
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
                    <h3><i class="icon icon-comments-alt"></i> <?php __w('Antwoord', 'beheer'); ?></h3>
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="beheer/antwoord/index/"><i class="icon icon-arrow-left"></i> <?php __w('Terug naar overzicht', 'beheer'); ?></a></li>
                        <li><a href="javascript:document.getElementById('opslaan').click();"><i class="icon icon-save"></i> <?php __w('Opslaan', 'beheer'); ?></a></li>
                   </ul>
                </div>      
                
            </div>
        </div>
    </div>
<?php $this->placeholder('sidebar')->end(); ?>

