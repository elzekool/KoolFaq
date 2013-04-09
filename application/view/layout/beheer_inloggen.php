<?php
/**
 * Beheer Inloggen Layout
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

/* @var $this \View */


$assets = $this->helper('Assets');
/* @var $assets \View\Helper\Assets */

$baseurl = r()->getBase();

/* @var $assets \View\Helper\Assets */
$assets->css('http://fonts.googleapis.com/css?family=Droid+Serif:700');
$assets->css('http://fonts.googleapis.com/css?family=Open+Sans:400,700');
$assets->css('css/beheer.css');

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

		<!--[if lt IE 8]>
			<link href="less/beheer/font-awesome-ie7.css" rel="stylesheet">
        <![endif]-->
        
    </head>

    <body class="beheer_inloggen">
        
        <div class="container">
            
            <h1><?php echo _h($page_title); ?></h1>
            
            <br />
            
            
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
                
            <?php
               echo $view_content;
            ?>
 
        </div>
        
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <?php $assets->outputScript(); ?>
        
    </body>
    
</html>

