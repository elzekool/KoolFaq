<?php
/**
 * Antwoorden beheren
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
        
        <div class="pagination">
            <ul>
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
        </div>

        <p><?php echo _h(sprintf(__('Er zijn %1$d antwoorden gevonden. Pagina %2$d van %3$d.', 'beheer'), $paginate_count, $paginate_page+1, $paginate_pages)); ?></p>
        <p>&nbsp;</p>
        
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><a href="<?php echo $pagination->getSortLink('id', 'DESC'); ?>"><?php __w('#', 'beheer'); ?></a></th>
                    <th><a href="<?php echo $pagination->getSortLink('aangemaakt', 'DESC'); ?>"><?php __w('Toegevoegd op', 'beheer'); ?></a></th>
                    <th><a href="<?php echo $pagination->getSortLink('titel', 'ASC'); ?>"><?php __w('Titel', 'beheer'); ?></a></th>
                    <th><a href="<?php echo $pagination->getSortLink('ranking_avg', 'ASC'); ?>"><?php __w('Beoordeling', 'beheer'); ?></a></th>
                    <th><a href="<?php echo $pagination->getSortLink('views', 'ASC'); ?>"><?php __w('Aantal keer bekeken', 'beheer'); ?></a></th>
                    <th><?php __w('Acties', 'beheer'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($paginate_items as $antwoord) : ?>
                    <?php /* @var $antwoord \Model\Antwoord */ ?>
                    <tr>
                        <td><?php echo _h($antwoord->getId()); ?></td>
                        <td><?php echo _h($this->helper('Weergave')->datumtijd($antwoord->getAangemaakt())); ?></td>
                        <td><?php echo _h($antwoord->getTitel()); ?></td>
                        <td><?php echo _h($antwoord->getRankingAvg()); ?></td>
                        <td><?php echo _h($antwoord->getViews()); ?></td>
                        <td class="nowrap">
                            <a href="beheer/antwoord/view/<?php echo $antwoord->getId(); ?>"><?php __w('Details', 'beheer'); ?></a> |
                            <a href="beheer/antwoord/edit/<?php echo $antwoord->getId(); ?>"><?php __w('Wijzigen', 'beheer'); ?></a>
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
                    <h3><i class="icon icon-search"></i> <?php __w('Zoeken', 'beheer'); ?></h3>
                    <form method="POST" action="beheer/antwoord/index" class="form-vertical">
                        <input name="zoektekst" value="<?php echo _h($pagination->getParameter('zoektekst')); ?>" type="text" class="span12" placeholder="<?php __w('Zoek op titel…', 'beheer'); ?>" />
                        <button type="submit" class="btn btn-primary"><i class="icon icon-search"></i> <?php __w('Zoeken', 'beheer'); ?></button>
                        <a href="beheer/antwoord/index/zoektekst:/" class="btn"><i class="icon icon-refresh"></i> <?php __w('Reset', 'beheer'); ?></a>
                    </form>        
                </div>

                <div class="navigatie">
                    <h3><i class="icon icon-comments-alt"></i> <?php __w('Antwoord', 'beheer'); ?></h3>
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="beheer/antwoord/add/"><i class="icon icon-plus-sign"></i> <?php __w('Toevoegen', 'beheer'); ?></a></li>
                   </ul>
                </div>     
                
                <div class="navigatie">
                    <h3><i class="icon icon-info-sign"></i> <?php __w('Informatie', 'beheer'); ?></h3>
                   <p>
                       <?php __w("Hier ziet u een overzicht van alle antwoorden die in het systeem staan. Klik op Details om het antwoord te bekijken en/of te wissen. Klik op Toevoegen om een nieuwe vraag/antwoord toe te voegen.", 'beheer'); ?>
                   </p>
                </div> 
                
            </div>
        </div>
    </div>
<?php $this->placeholder('sidebar')->end(); ?>