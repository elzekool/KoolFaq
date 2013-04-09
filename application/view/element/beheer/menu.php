<?php
/**
 * Beheer Menu
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * */
/* @var $this \Element */


$huidige_gebruiker = $this->Parent->ViewVars['huidige_gebruiker']; 
/* @var $huidige_gebruiker \Model\Gebruiker */

?>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="sidebar-container w-margin">            
            <div class="side">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="beheer/"><?php __w('Vraag&Antwoord'); ?></a>
            </div>
            <div class="content">
                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li><a href="beheer/antwoord/index"><i class="icon icon-comments-alt"></i> <?php __w('Antwoorden', 'beheer'); ?></a></li>                        
                        
                    </ul>
                    
                    <div class="pull-right">
                        <p class="navbar-text pull-right">
                            &nbsp;|&nbsp;
                            <?php echo _h(sprintf(__('Ingelogd als %s', 'beheer'), $huidige_gebruiker->getNaam())); ?> |
                            <a class="navbar-text" href="gebruiker/uitloggen"><?php __w('Uitloggen', 'beheer'); ?></a>
                            &nbsp;&nbsp;
                        </p>
                    </div>
                    
                    
                    <ul class="nav pull-right">
                        <li><a href="beheer/gebruiker/index"><i class="icon icon-user"></i> <?php __w('Gebruikers beheren', 'beheer'); ?></a></li>                        
                    </ul>
                    
                    
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>
</div>