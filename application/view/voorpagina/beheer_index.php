<?php
/**
 * Startscherm Beheer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

?>


<div class="row-fluid">
    <div class="span12">
        <p><?php __w('Welkom in de beheer omgeving. Met deze applicatie is het mogelijk om antwoorden op vragen op een georganiseerde manier weer te geven.'); ?></p>
        <p><?php __w('Deze antwoorden kunnen vervolgens door de gebruikers van de website bekeken en beoordeeld worden.'); ?></p>
    </div>
</div>

<?php $this->placeholder('sidebar')->start(); ?>
    <div class="row-fluid">
        <div class="row-fluid">
            <div class="span12">
                
                <div class="navigatie">
                    <h3><i class="icon icon-user"></i> <?php __w('Antwoorden', 'beheer'); ?></h3>
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="beheer/antwoord/index/"><i class="icon icon-table"></i> <?php __w('Overzicht', 'beheer'); ?></a></li>
                        <li><a href="beheer/antwoord/add/"><i class="icon icon-plus"></i> <?php __w('Toevoegen', 'beheer'); ?></a></li>
                   </ul>
                </div>      
                
            </div>
        </div>
    </div>
<?php $this->placeholder('sidebar')->end(); ?>

