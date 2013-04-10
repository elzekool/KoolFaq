<?php
/**
 * TagCloud
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * */
/* @var $this \Element */

$antwoord_container = new Model\AntwoordContainer();
$hoogst_beoordeeld = $antwoord_container->index(array(), array(array('ranking_avg', 'DESC')), 5);

?>

<?php if (count($hoogst_beoordeeld) != 0) : ?>
    <div class="navigatie">
        <h3><i class="icon icon-thumbs-up"></i> <?php __w('Best beoordeeld'); ?></h3>        
        <ul>            
            <?php foreach($hoogst_beoordeeld as $b_antwoord) : ?>
                <li>
                    <a href="antwoord/view/<?php echo $b_antwoord->getId(); ?>">
                        <?php echo _h($this->helper('Weergave')->limit($b_antwoord->getTitel(), 40)); ?>
                    </a>
                </li>
            <?php endforeach; ?>            
        </ul>
    </div>
<?php endif; ?>


