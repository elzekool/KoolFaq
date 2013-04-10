<?php
/**
 * Antwoorden overzicht
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

$pagination = $this->helper('Pagination');
/* @var $pagination \View\Helper\Pagination */

?>


<div class="row-fluid">
    <div class="span12">

        <p>
            <?php __w('Hier zie je een overzicht van alle antwoorden. Klik op een antwoord om deze te openen. Heb je zelf een nieuwe vraag? Stuur deze dan naar:'); ?>
            <a href="mailto:">dtv@....</a>
        </p>
                
        <div class="pagination clearfix">
            <ul class="pull-left">
                <li <?php if ($paginate_page == 0) : ?>class="disabled"<?php endif; ?>>
                    <a href="<?php echo $pagination->getLink(array('page' => 0)); ?>">«</a>
                </li>
                <?php foreach($pagination->getPageNumbers() as $page) : ?>
                    <li <?php if ($page == $paginate_page) : ?>class="active"<?php endif; ?>>
                        <a href="<?php echo $pagination->getLink(array('page' => $page)); ?>"><?php echo $page+1; ?></a>
                    </li>
                <?php endforeach; ?>    
                <li <?php if ($paginate_page == ($paginate_pages-1)) : ?>class="disabled"<?php endif; ?>>
                    <a href="<?php echo $pagination->getLink(array('page' => $paginate_pages - 1)); ?>">»</a>
                </li>
            </ul>
            
            <p class="pull-left">&nbsp; &nbsp; <?php echo _h(sprintf(__('Er zijn %1$d antwoorden gevonden. Pagina %2$d/%3$d.'), $paginate_count, $paginate_page+1, $paginate_pages)); ?></p>
            
        </div>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><a href="<?php echo $pagination->getSortLink('aangemaakt', 'DESC'); ?>"><?php __w('Toegevoegd op', 'beheer'); ?></a></th>
                    <th style="width: 60%;"><a href="<?php echo $pagination->getSortLink('titel', 'ASC'); ?>"><?php __w('Titel', 'beheer'); ?></a></th>
                    <th><?php __w('Acties', 'beheer'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($paginate_items as $antwoord) : ?>
                    <?php /* @var $antwoord \Model\Antwoord */ ?>
                    <tr>
                        <td><?php echo _h($this->helper('Weergave')->datum($antwoord->getAangemaakt())); ?></td>
                        <td><a href="antwoord/view/<?php echo $antwoord->getId(); ?>"><?php echo _h($antwoord->getTitel()); ?></a></td>
                        <td class="nowrap">
                            <a class="btn btn-primary" href="antwoord/view/<?php echo $antwoord->getId(); ?>"><?php __w('Bekijken'); ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            
        </table>
    </div>
</div>


<?php $this->placeholder('sidebar')->start(); ?>
    <div class="row-fluid">
        <div class="row-fluid">
            <div class="span12">
                
                <div class="navigatie">
                    <h3><i class="icon icon-search"></i> <?php __w('Zoeken'); ?></h3>
                    <form method="POST" action="antwoord/index" class="form-vertical">
                        <input name="zoektekst" value="<?php echo _h($pagination->getParameter('zoektekst')); ?>" type="text" class="span12" placeholder="<?php __w('Zoek op titel…', 'beheer'); ?>" />
                        <button type="submit" class="btn btn-primary"><i class="icon icon-search"></i> <?php __w('Zoeken', 'beheer'); ?></button>                        
                        <a href="antwoord/index/zoektekst:/tag:/" class="btn"><i class="icon icon-refresh"></i> <?php __w('Reset', 'beheer'); ?></a>
                    </form>        
                </div>
                
                <div class="navigatie">
                    <h3><i class="icon icon-tags"></i> <?php __w('Steekwoorden'); ?></h3>
                    
                    <?php if ($pagination->getParameter('tag', '') == '') : ?>
                        <?php $this->element('frontend/tagcloud'); ?>
                    
                    <?php else: ?>
                        <p><?php echo _h(sprintf(__('Er worden alleen antwoorden weergegeven met steekwoord "%s"'), $pagination->getParameter('tag', ''))); ?></p>
                        <a href="antwoord/index/tag:/" class="btn"><i class="icon icon-remove"></i> <?php __w('Niet meer filteren', 'beheer'); ?></a>
                    <?php endif; ?>
                    
                </div>
                
                <?php $this->element('frontend/meest_gelezen'); ?>
                <?php $this->element('frontend/best_beoordeeld'); ?>
                    

            </div>
        </div>
    </div>
<?php $this->placeholder('sidebar')->end(); ?>