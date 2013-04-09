<?php
/**
 * Standaard (Front-end) Layout
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

$assets = $this->helper('Assets');
/* @var $assets \View\Helper\Assets */

$baseurl = r()->getBase();

$assets->css('http://fonts.googleapis.com/css?family=Ubuntu');
$assets->css('external/font-awesome/css/font-awesome.css');
$assets->css('css/frontend.css');

$config = \KoolDevelop\Configuration::getInstance('app');

$prefix = $config->get('webshop.titel_prefix');
$postfix = $config->get('webshop.titel_postfix');

if (KoolDevelop\Configuration::getInstance('app')->get('solr.actief', 0) == 1) {
    $assets->inlineScript('(function($) { $(document).ready(function() { $("input.zoektips").popover(); }); })(jQuery);');
}

header('Content-Type: text/html; charset=UTF-8');

?><!DOCTYPE html>
<html>
    <head>
        <title><?php echo _h($prefix . $page_title . $postfix); ?></title>
        <base href="<?php echo $baseurl; ?>" id="base" />        
        <?php $assets->outputStyle(); ?>
        <!--[if lt IE 8]>
            <link rel="stylesheet" type="text/css" href="external/font-awesome/css/font-awesome-ie7.min.css" />
            <link rel="stylesheet" type="text/css" href="css/ie7.css" />
        <![endif]-->
        <!--[if lte IE 8]>
            <style type="text/css">
                input { font-family: Arial; }
            </style>
        <![endif]-->
    </head>
    <body>
        
        
        <?php $this->element('frontend/menu'); ?>

        <div class="inhoud">
            <div class="container">

                <?php $this->element('frontend/info'); ?>

                <div class="row">
                    <div class="span12">

                        <div class="melding_container">

                            <?php if (!empty($melding_succes)) : ?>
                                <p class="alert alert-success"><?php echo nl2br(_h($melding_succes)); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($melding_fout)) : ?>
                                <p class="alert alert-error"><?php echo nl2br(_h($melding_fout)); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($melding_info)) : ?>
                                <p class="alert alert-info"><?php echo nl2br(_h($melding_info)); ?></p>
                            <?php endif; ?>                            

                        </div>


                    </div>
                </div>

                <?php echo $view_content; ?>
    
            </div>
        </div>
        
        <div id="footer">
            <div class="container">
                
                <div class="row">
                    <div class="span3">
                        <?php $this->helper('Module')->positie('footer-1'); ?>
                    </div>

                    <div class="span3">
                        <?php $this->helper('Module')->positie('footer-2'); ?>
                    </div>

                    
                    <div class="span3">
                        <?php $this->helper('Module')->positie('footer-3'); ?>
                    </div>
                    
                    
                    <div class="span3">
                        <?php $this->helper('Module')->positie('footer-4'); ?>
                    </div>

                </div>
                
            </div>
        </div>
        
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="external/bootstrap/js/bootstrap.aangepast.min.js"></script>
        <script type="text/javascript" src="js/jquery.koolmodal.js"></script>
        <script type="text/javascript" src="<?php echo r()->getBase() . __min('js/jquery.placeholder.js'); ?>"></script>
        
        <?php $assets->outputScript(); ?>
        
<!-- 
<?php foreach(\KoolDevelop\Log\Logger::getInstance()->getMessages() as $message) echo $message . "\n"; ?>

<?php foreach(\KoolDevelop\Database\Query::$ProfileLog as $sql) echo $sql['Time'] . "\n" . $sql['SQL'] . "\n\n"; ?>
-->

    </body>
</html>
