<?php
/**
 * Antwoord bekijken
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
        <h4 class="gekleurd"><?php __w('Vraag:'); ?></h4>
        <?php echo $antwoord->getVraag(); ?>
        
        <br />        
        <h4 class="gekleurd"><?php __w('Antwoord:'); ?></h4>
        <?php echo $antwoord->getAntwoord(); ?>    
        
        <br />        
        <h4 class="gekleurd"><?php __w('Steekwoorden:'); ?></h4>
        <p>
            <?php foreach($antwoord->getTags() as $tag) : ?>
                <a class="tag" href="antwoord/index/zoektekst:/tag:<?php echo _h(rawurlencode($tag->getTag())); ?>"><?php echo _h($tag->getTag()); ?></a>&nbsp; &nbsp;
            <?php endforeach; ?>
        </p> 
            
        <br />        
        <h4 class="gekleurd"><?php __w('Is dit antwoord nuttig?'); ?></h4>
        <p>
            <?php __w('Geef aan of je het antwoord nuttig vind. Zo help je ons, en anderen de antwoorden te verbeteren.'); ?>
        </p>
        <p>
            <?php if ($ranked == 1) : ?>
                <p class="alert alert-success"><?php __w('Dank u voor uw beoordeling'); ?></p>
            <?php else: ?>
                <a class="btn btn-success" href="antwoord/beoordeel/<?php echo $antwoord->getId(); ?>/1"><i class="icon icon-thumbs-up"></i> <?php __w('Ja'); ?></a>
                &nbsp; &nbsp;
                <a class="btn btn-danger" href="antwoord/beoordeel/<?php echo $antwoord->getId(); ?>/0"><i class="icon icon-thumbs-down"></i> <?php __w('Nee'); ?></a>
            <?php endif; ?>
        </p>
    </div>
</div>

<?php $this->placeholder('sidebar')->start(); ?>
    <div class="row-fluid">
        <div class="row-fluid">
            <div class="span12">
                
                <div class="navigatie">
                    <h3><i class="icon icon-comments-alt"></i> <?php __w('Antwoord', 'beheer'); ?></h3>
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="antwoord/index/"><i class="icon icon-arrow-left"></i> <?php __w('Terug naar overzicht', 'beheer'); ?></a></li>                        
                   </ul>
                </div>  
                
                <?php $this->element('frontend/meest_gelezen'); ?>
                <?php $this->element('frontend/best_beoordeeld'); ?>
                
            </div>
        </div>
    </div>
<?php $this->placeholder('sidebar')->end(); ?>

