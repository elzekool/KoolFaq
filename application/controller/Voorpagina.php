<?php
/**
 * Voorpagina Controller
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace Controller;

/**
 * Voorpagina Controller
 * 
 * Standaard Controleer. Geeft de startpagina's voor front-end en
 * backend weer
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class Voorpagina extends \Controller
{
    
    /**
     * Voorpagina Front-end
     * 
     * @ViewConfig({AutoRender = true, View = "voorpagina/index" })
     * @ViewConfig({Layout = "default"})
     * 
     * @return void
     */
    public function index() {
        
    }

        
    /**
     * Voorpagina Backend
     * 
     * @ViewConfig({AutoRender = true, View = "voorpagina/beheer_index" })
     * @ViewConfig({Layout = "beheer"})
     * 
     * @return void
     */
    public function beheer_index() {        
        $this->View->setTitle(__('Welkom in de beheer omgeving', 'beheer'));
    }
    
	
}