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
$meest_gelezen = $antwoord_container->index(array(), array(array('views', 'DESC')), 5);

?>

<?php if (count($meest_gelezen) != 0) : ?>
    <div class="navigatie">
        <h3><i class="icon icon-eye-open"></i> <?php __w('Meest bekeken'); ?></h3>        
        <ul>            
            <?php foreach($meest_gelezen as $m_antwoord) : ?>
                <li>
                    <a href="antwoord/view/<?php echo $m_antwoord->getId(); ?>">
                        <?php echo _h($this->helper('Weergave')->limit($m_antwoord->getTitel(), 40)); ?>
                    </a>
                </li>
            <?php endforeach; ?>            
        </ul>
    </div>
<?php endif; ?>


