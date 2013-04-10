<?php
/**
 * Frontend Layout
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * */
/* @var $this \View */


$assets = $this->helper('Assets');
/* @var $assets \View\Helper\Assets */

$baseurl = r()->getBase();

/* @var $assets \View\Helper\Assets */
$assets->css('http://fonts.googleapis.com/css?family=Droid+Serif:700');
$assets->css('http://fonts.googleapis.com/css?family=Open+Sans:400,700');
$assets->css('external/font-awesome/css/font-awesome.css');
$assets->css('css/frontend.css');

?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo _h($page_title); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="<?php echo $baseurl; ?>" id="base"/>

        <?php $assets->outputStyle(); ?>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body class="frontend">
        
        
        <?php echo $this->element('frontend/menu'); ?>

        <div class="sidebar-container">

            <div class="side">
                <div class="container-fluid">
                    <?php echo $this->placeholder('sidebar'); ?>
                </div>                    
            </div>

            <div class="content">

                <div class="container-fluid">

                    <div class="row-fluid">
                                                
                        <div class="span12">
                            
                            <h1 class="gekleurd"><?php echo _h($page_title); ?></h1>

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
                        
                        <?php echo $view_content; ?>

                    </div>


                </div>

            </div>



        </div>

        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="external/bootstrap/js/bootstrap.aangepast.min.js"></script>
        <script type="text/javascript" src="js/jquery.koolmodal.js"></script>

        <?php $assets->outputScript(); ?>
        
        
<!-- 
<?php foreach(\KoolDevelop\Log\Logger::getInstance()->getMessages() as $message) echo $message . "\n"; ?>
-->

        

    </body>

</html>