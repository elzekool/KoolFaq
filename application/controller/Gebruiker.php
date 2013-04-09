<?php
/**
 * Gebruiker Controller
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace Controller;

/**
 * Gebruiker Controller
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class Gebruiker extends \Controller
{
    /**
     * Overzicht van gebruikers weergeven
     *
     * @ViewConfig({AutoRender = true, View = "gebruiker/beheer_index"})
     * @ViewConfig({Layout = "beheer" })
     * 
     * @return void
     */
    public function beheer_index() {
        
        $pagination = $this->View->helper('Pagination');
        /* @var $pagination \View\Helper\Pagination */

        
        $pagination
            ->setSessionStorage('GebruikerIndex', array('sort', 'direction', 'zoektekst'))
            ->setPageSize(25)
            ->setSearchConditions(array(
                'zoektekst' => $pagination->getParameter('zoektekst', '')
            ))
            ->setBaseParameters(array(
                'zoektekst' => $pagination->getParameter('zoektekst', '')
            ))            
            ->setDefaultBaseUrl(r()->getBase() . '/beheer/gebruiker/index')
            ->setAllowedSortingFields(array('gebruikersnaam', 'naam'))
            ->setContainerModel(new \Model\GebruikerContainer())
            ->paginate();

        $this->View->setTitle(__('Gebruikers beheren', 'beheer'));
        
    }
    
    /**
     * Gegevens voor gebruiker tonen
     * 
     * @ViewConfig({AutoRender = true, View = "gebruiker/beheer_view"})
     * @ViewConfig({Layout = "beheer" })
     * 
     * @param int $id Gebruiker Id
     * 
     * return void
     */
    public function beheer_view($id) {
        
        $gebruiker_container = new \Model\GebruikerContainer();
        if (null === ($gebruiker = $gebruiker_container->first(array('id' => $id)))) {
            throw new \KoolDevelop\Exception\NotFoundException(__f('Gebruiker niet gevonden', 'exception'));
        }

        $this->View->set('gebruiker', $gebruiker);
        $this->View->setTitle(sprintf(__('Gebruiker "%s"', 'beheer'), $gebruiker->getNaam()));

    }
    
    /**
     * Callback ($model, $data) voordat waarden in model zijn geladen 
     * 
     * @param \Model  $model Model
     * @param mixed[] $data  Formulier data
     * 
     * @return void
     */
    public function addedit_saving(\Model &$model, &$data) {
        if (!empty($_POST['form']['wachtwoord'])) {
            $gebruiker_container = new \Model\GebruikerContainer();
            $hash = $gebruiker_container->genereerHash($_POST['form']['wachtwoord']);
            $model->setWachtwoordHash($hash);
        }
    }
    
    /**
     * Gebruiker toevoegen
     * 
     * @ViewConfig({AutoRender = true, View = "gebruiker/beheer_add"})
     * @ViewConfig({Layout = "beheer" })
     * 
     * @return void
     */
    public function beheer_add() {
        
        if ($this->getHuidigeGebruiker()->getRol() != \Model\Gebruiker::ROL_BEHEERDER) {
            $this->setMelding(self::MELDING_FOUT, __('U heeft onvoldoende rechten voor deze actie', 'beheer'));
            $this->redirect('/beheer/');
        }
        
        $gebruiker_container = new \Model\GebruikerContainer();
        $gebruiker = $gebruiker_container->newObject();
        
        $velden = array('gebruikersnaam', 'naam', 'moet_wachtwoord_wijzigen');        
        $converter = new \KoolDevelop\Model\SimpleArrayConverter($velden);
        
        $validator = $this->View->helper('Validatie');
        /* @var $validator \View\Helper\Validatie */
        
        // Stel validatie regels in
        $validator
            ->add(array('gebruikersnaam', 'wachtwoord', 'naam'), 'Required', '', __('Dit is een verplicht veld', 'beheer'), true)
            ->add('gebruikersnaam', 'RegEx', '.{4,}', __('Vul een unieke gebruikersnaam van minimaal 4 tekens in', 'beheer'))
            ->add('wachtwoord', 'RegEx', '.{4,}', __('Vul een wachtwoord van minimaal 4 tekens in', 'beheer'))
            ->add('naam', 'RegEx', '.{2,}', __('Vul een naam in', 'beheer'));            
        
        if ($this->addedit($gebruiker, $velden, $converter, array('moet_wachtwoord_wijzigen' => 1))) {
            $gebruiker_container->save($gebruiker);
            $this->setMelding(self::MELDING_SUCCES, __('Gebruiker succesvol opgeslagen', 'beheer'));
            $this->redirect('/beheer/gebruiker/view/' . $gebruiker->getId());            
        }
        
        $this->View->set('gebruiker', $gebruiker);
        $this->View->setTitle(__('Gebruiker toevoegen', 'beheer'));

    }
    
    
    /**
     * Gebruiker wijzigen
     * 
     * @ViewConfig({AutoRender = true, View = "gebruiker/beheer_edit"})
     * @ViewConfig({Layout = "beheer" })
     * 
     * @param int $id Gebruiker Id
     * 
     * return void
     */
    public function beheer_edit($id) {
                
        $gebruiker_container = new \Model\GebruikerContainer();
        if (null === ($gebruiker = $gebruiker_container->first(array('id' => $id)))) {
            throw new \KoolDevelop\Exception\NotFoundException(__f('Gebruiker niet gevonden', 'exception'));
        }
        
        $velden = array('gebruikersnaam', 'naam', 'moet_wachtwoord_wijzigen');        
        $converter = new \KoolDevelop\Model\SimpleArrayConverter($velden);
        
        $validator = $this->View->helper('Validatie');
        /* @var $validator \View\Helper\Validatie */
        
        // Stel validatie regels in
        $validator
            ->add(array('gebruikersnaam', 'wachtwoord', 'naam'), 'Required', '', __('Dit is een verplicht veld', 'beheer'), true)
            ->add('gebruikersnaam', 'RegEx', '.{4,}', __('Vul een unieke gebruikersnaam van minimaal 4 tekens in', 'beheer'))
            ->add('wachtwoord', 'RegEx', '(^$|.{4,})', __('Vul een wachtwoord van minimaal 4 tekens in of laat leeg', 'beheer'))
            ->add('naam', 'RegEx', '.{2,}', __('Vul een naam in', 'beheer'));
                
        if ($this->addedit($gebruiker, $velden, $converter, array())) {
            $gebruiker_container->save($gebruiker);
            $this->setMelding(self::MELDING_SUCCES, __('Gebruiker succesvol opgeslagen', 'beheer'));
            $this->redirect('/beheer/gebruiker/view/' . $gebruiker->getId());            
        }
        
        $this->View->set('gebruiker', $gebruiker);
        $this->View->setTitle(sprintf(__('Gebruiker "%s" wijzigen', 'beheer'), $gebruiker->getNaam()));
        
    }
    
    /**
     * Gebruiker wissen
     * 
     * @param int $id Gebruiker Id
     * 
     * return void
     */
    public function beheer_delete($id) {      
        
        $gebruiker_container = new \Model\GebruikerContainer();
        if (null === ($gebruiker = $gebruiker_container->first(array('id' => $id)))) {
            throw new \KoolDevelop\Exception\NotFoundException(__f('Gebruiker niet gevonden', 'exception'));
        }
        
        if ($gebruiker->getGebruikersnaam() == $this->getHuidigeGebruiker()->getGebruikersnaam()) {
            $this->setMelding(self::MELDING_FOUT, __('Kan de huidig ingelogde gebruiker niet wissen', 'beheer'));
            $this->redirect('beheer/gebruiker/view/' . $gebruiker->getId());
        }
        
        try {
            $gebruiker_container->delete(array('id' => $id));
        } catch(\KoolDevelop\Exception\DatabaseException $e) {
            $this->setMelding(self::MELDING_FOUT, __('Kan Gebruiker niet wissen. Er zijn één of meerdere items aan gekoppeld. Verwijder deze eerst.', 'beheer'));
            $this->redirect('/beheer/gebruiker/view/' . $gebruiker->getId());        
        }
        
        
        $this->setMelding(self::MELDING_SUCCES, __('Gebruiker succesvol gewist', 'beheer'));
        $this->redirect('beheer/gebruiker/index');
        
    }   
    
    
    /**
     * Gebruiker inloggen
     * 
     * @ViewConfig({AutoRender = true, View = "gebruiker/inloggen"})
     * @ViewConfig({Layout = "beheer_inloggen" })
     * 
     * @return void
     */
    public function inloggen() {
    
        // Kijk of er al iemand is ingelogd
        if (null !== $this->getHuidigeGebruiker()) {
            $this->redirect('beheer');
        }
        
        $validator = $this->View->helper('Validatie');
        /* @var $validator \View\Helper\Validatie */
        
        // Stel validatie regels in
        $validator
            ->add('gebruikersnaam', 'RegEx', '.{2,}', __('Vul een gebruikersnaam in', 'beheer'))
            ->add('wachtwoord', 'RegEx', '.{2,3}', __('Vul een wachtwoord in', 'beheer'));
        
        
        if (!empty($_POST['form'])) {           
            if (true === ($berichten = $validator->valideer($_POST['form']))) {
                
                $gebruikersnaam = filter_var(@$_POST['form']['gebruikersnaam'], FILTER_UNSAFE_RAW);
                $wachtwoord = filter_var(@$_POST['form']['wachtwoord'], FILTER_UNSAFE_RAW);

                $gebruiker_container = new \Model\GebruikerContainer();
                if (false === $gebruiker_container->login($gebruikersnaam, $wachtwoord)) {
                    $this->setMelding(self::MELDING_FOUT, __('Fout bij inloggen, ongeldige gebruikersnaam en/of wachtwoord', 'beheer'));
                    $this->redirect('gebruiker/inloggen');
                }
                
                // Ga naar de beheer omgeving, succesvol ingelogd
                $this->redirect('beheer/');            
            } else {
                $this->setMelding(
                    self::MELDING_FOUT, 
                    sprintf(__('Er zijn fouten opgetreden tijdens het valideren: %s', 'beheer'), "\n-" . join("\n-", $berichten))
                );     
            }
            
        }
        
        $this->View->setTitle(__('U dient in te loggen', 'beheer'));
        
    }
    
    
    /**
     * Gebruiker wachtwoord laten wijzigen
     * 
     * @ViewConfig({AutoRender = true, View = "gebruiker/wachtwoord_wijzigen"})
     * @ViewConfig({Layout = "beheer_inloggen" })
     * 
     * @return void
     */
    public function wachtwoord_wijzigen() {
        
        // We kunnen hier niet $this->getHuidigeGebruiker() gebruiken want
        // deze controleerd of het wachtwoord moet wijzigen en dan komen we
        // in een loop.. dat zou jammer zijn
        $gebruiker_container = new \Model\GebruikerContainer();
        if (null === $gebruiker = $gebruiker_container->getHuidigeGebruiker()) {
            $this->redirect('gebruiker/inloggen/');
        }
        
        if ($gebruiker->getMoetWachtwoordWijzigen() == false) {
            $this->redirect('beheer/');
        }
        
        $validator = $this->View->helper('Validatie');
        /* @var $validator \View\Helper\Validatie */
        
        // Stel validatie regels in
        $validator
            ->add('wachtwoord', 'RegEx', '.{2,}', __('Vul een wachtwoord in', 'beheer'), true)
            ->add('wachtwoord', 'RegEx', '.{4,}', __('Vul een wachtwoord in van minimaal 4 tekens', 'beheer'))
            ->add('herhaal_wachtwoord', 'MatchField', 'wachtwoord', __('Vul hetzelfde wachtwoord nogmaals in.', 'beheer'));

        
        if (!empty($_POST['form'])) {
           
            if (true === ($berichten = $validator->valideer($_POST['form']))) {
            
                $wachtwoord = filter_var(@$_POST['form']['wachtwoord'], FILTER_UNSAFE_RAW);
                $herhaal_wachtwoord = filter_var(@$_POST['form']['herhaal_wachtwoord'], FILTER_UNSAFE_RAW);

                if ($wachtwoord != $herhaal_wachtwoord) {
                    $this->setMelding(self::MELDING_FOUT, __('Fout bij wijzigen wachtwoord, wachtwoord en herhaal wachtwoord niet hetzelfde', 'beheer'));
                    $this->redirect('gebruiker/wachtwoord_wijzigen');
                }

                $gebruiker->setWachtwoordHash($gebruiker_container->genereerHash($wachtwoord));
                $gebruiker->setMoetWachtwoordWijzigen(0);
                $gebruiker_container->save($gebruiker);
                $this->redirect('beheer/');
                
            } else {                
                $this->setMelding(
                    self::MELDING_FOUT, 
                    sprintf(__('Er zijn fouten opgetreden tijdens het valideren: %s', 'beheer'), "\n-" . join("\n-", $berichten))
                );                
            }
            
        }
        
        $this->View->set('gebruiker', $gebruiker);
        $this->View->setTitle(__('U dient uw wachtwoord te wijzigen', 'beheer'));
    }
        
    
    /**
     * Gebruiker uitloggen
     * 
     * @return void
     */
    public function uitloggen() {
        $gebruiker_container = new \Model\GebruikerContainer();
        $gebruiker_container->logout();
        $this->redirect('gebruiker/inloggen/');
    }
    
}