<?php
/**
 * Antwoord details
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
            
            <ul class="nav nav-tabs">
                <li class="active"><a href="#vraag" data-toggle="tab"><i class="icon icon-edit"></i> <?php __w('Vraag', 'beheer'); ?></a></li>
                <li><a href="#antwoord" data-toggle="tab"><i class="icon icon-comment"></i> <?php __w('Antwoord', 'beheer'); ?></a></li>
            </ul>
            
            <div class="tab-content">
                
                <div class="tab-pane active" id="vraag">
                    <div class="control-group">
                        <label class="control-label"><?php __w('Titel', 'beheer'); ?></label>
                        <div class="controls">
                            <div class="span5 uneditable-input"><?php echo _h($antwoord->getTitel()); ?></div>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"><?php __w('Tags', 'beheer'); ?></label>
                        <div class="controls">
                            <div class="span5 uneditable-input">
                                <?php foreach($antwoord->getTags() as $tag) : ?>
                                    <span class="badge badge-inverse"><?php echo _h($tag->getTag()); ?></span>
                                <?php endforeach; ?>
                            </div>    
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"><?php __w('Vraag', 'beheer'); ?></label>
                        <div class="controls">
                            <div class="span11 uneditable-input">
                                <?php echo $antwoord->getVraag(); ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="tab-pane" id="antwoord">
                    <div class="control-group">
                        <label class="control-label"><?php __w('Antwoord', 'beheer'); ?></label>
                        <div class="controls">
                            <div class="span11 uneditable-input">
                                <?php echo $antwoord->getAntwoord(); ?>
                            </div>
                        </div>
                    </div>
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
                    <h3><i class="icon icon-comments-alt"></i> <?php __w('Antwoord', 'beheer'); ?></h3>
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="beheer/antwoord/index/"><i class="icon icon-arrow-left"></i> <?php __w('Terug naar overzicht', 'beheer'); ?></a></li>
                        <li><a href="beheer/antwoord/edit/<?php echo $antwoord->getId(); ?>"><i class="icon icon-edit"></i> <?php __w('Wijzigen', 'beheer'); ?></a></li>
                        <li><a onclick="return confirm('Weet u zeker dat u dit antwoord wilt wissen?');" href="beheer/antwoord/delete/<?php echo $antwoord->getId(); ?>"><i class="icon icon-remove"></i> <?php __w('Wissen', 'beheer'); ?></a></li>
                   </ul>
                </div>      
                
            </div>
        </div>
    </div>
<?php $this->placeholder('sidebar')->end(); ?>

