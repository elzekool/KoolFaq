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

$tag_container = new \Model\TagContainer();
$tagcloud = $tag_container->getTagCloud();

?>

<?php if (count($tagcloud) != 0) : ?>
    <div class="tagcloud clearfix">
        <?php $max = $tagcloud[0]['count']; ?>
        <?php shuffle($tagcloud); ?>
        <?php foreach($tagcloud as $tag) : ?>
            <a class="tag tagn<?php echo floor(($tag['count'] * 5) / $max); ?>" href="antwoord/index/zoektekst:/tag:<?php echo _h(rawurlencode($tag['tag'])); ?>"><?php echo _h($tag['tag']); ?></a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


