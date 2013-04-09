<?php
/**
 * Gebruikers beheren
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

        <p><?php echo _h(sprintf(__('Er zijn %1$d gebruikers gevonden. Pagina %2$d van %3$d.', 'beheer'), $paginate_count, $paginate_page+1, $paginate_pages)); ?></p>
        <p>&nbsp;</p>
        
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><a href="<?php echo $pagination->getSortLink('gebruikersnaam', 'ASC'); ?>"><?php __w('Gebruikersnaam', 'beheer'); ?></a></th>
                    <th><a href="<?php echo $pagination->getSortLink('naam', 'ASC'); ?>"><?php __w('Naam', 'beheer'); ?></a></th>
                    <th><a href="<?php echo $pagination->getSortLink('laatste_keer_aangemeld', 'ASC'); ?>"><?php __w('Laatste keer aangemeld', 'beheer'); ?></a></th>
                    <th><?php __w('Acties', 'beheer'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($paginate_items as $gebruiker) : ?>
                    <?php /* @var $gebruiker \Model\Gebruiker */ ?>
                    <tr>
                        <td><?php echo _h($gebruiker->getGebruikersnaam()); ?></td>
                        <td><?php echo _h($gebruiker->getNaam()); ?></td>
                        <td><?php echo $this->helper('Weergave')->datumtijd($gebruiker->getLaatsteKeerAangemeld()); ?></td>
                        <td class="nowrap">
                            <a href="beheer/gebruiker/view/<?php echo $gebruiker->getId(); ?>"><?php __w('Details', 'beheer'); ?></a> |
                            <a href="beheer/gebruiker/edit/<?php echo $gebruiker->getId(); ?>"><?php __w('Wijzigen', 'beheer'); ?></a>
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
                    <form method="POST" action="beheer/gebruiker/index" class="form-vertical">
                        <input name="zoektekst" value="<?php echo _h($pagination->getParameter('zoektekst')); ?>" type="text" class="span12" placeholder="<?php __w('Zoek op naam…', 'beheer'); ?>" />
                        <button type="submit" class="btn btn-primary"><i class="icon icon-search"></i> <?php __w('Zoeken', 'beheer'); ?></button>
                        <a href="beheer/gebruiker/index/zoektekst:/" class="btn"><i class="icon icon-refresh"></i> <?php __w('Reset', 'beheer'); ?></a>
                    </form>        
                </div>

                <div class="navigatie">
                    <h3><i class="icon icon-user"></i> <?php __w('Gebruiker', 'beheer'); ?></h3>
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="beheer/gebruiker/add/"><i class="icon icon-plus-sign"></i> <?php __w('Toevoegen', 'beheer'); ?></a></li>
                   </ul>
                </div>     
                
                <div class="navigatie">
                    <h3><i class="icon icon-info-sign"></i> <?php __w('Informatie', 'beheer'); ?></h3>
                   <p>
                       <?php __w("Hier worden de gebruikers beheerd die in deze beheer omgeving kunnen werken. Er zijn twee soorten gebruikers: 'Normaal' en 'Beheerder'. De laatste heeft meer rechten en kan bijvoorbeeld ook gebruikers aanmaken en verwijderen.", 'beheer'); ?>
                   </p>
                </div> 
                
            </div>
        </div>
    </div>
<?php $this->placeholder('sidebar')->end(); ?>