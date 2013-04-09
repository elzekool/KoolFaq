<?php
/**
 * Application Controller
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 */

/**
 * Application Controller
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 */
class Controller extends \KoolDevelop\Controller\Controller
{
    

    const MELDING_SUCCES = 'succes';
    const MELDING_FOUT = 'fout';
    const MELDING_INFO = 'info';
    
    /**
     * Callback ($model, $data) nadat waarden uit model zijn geladen 
     * 
     * @param \Model  $model Model
     * @param mixed[] $data  Formulier data
     * 
     * @return void
     */
    public function addedit_loaded(\Model &$model, &$data) {
        
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
        
    }
    
    /**
     * Callback ($model, $data) nadat waarden in model zijn geladen.
     * Deze callback kan door middel van het teruggeven van false het verdere
     * opslaan stoppen (b.v. voor custom validatie)
     * 
     * @param \Model  $model Model
     * @param mixed[] $data  Formulier data
     * 
     * @return boolean Verder met opslaan
     */
    public function addedit_saved(\Model &$model, &$data) {
        return true;        
    }

    /**
     * Toevoegen/Wijzigen Formulier functionaliteit
     * 
     * @param \Model                             $model     Te bewerken model
     * @param string[]
     * @param \KoolDevelop\Model\IArrayConverter $converter Converter
     * @param mixed[]                            $defaults  Standaard waarden
     * 
     * @return boolean Model kan opgeslagen worden
     */    
    public function addedit(\Model &$model, $velden, \KoolDevelop\Model\IArrayConverter $converter, $defaults = array()) {
       
        $form = array();
        if (count($defaults) > 0) {
            foreach($velden as $veld) {
                $form[$veld] = (isset($defaults[$veld]) ? $defaults[$veld] : '');
            }
        } else {
            $model_data = $converter->convertModelToArray($model);
            foreach($velden as $veld) {
                if (array_key_exists($veld, $model_data)) {
                    $form[$veld] = $model_data[$veld];
                }
            }
        }
        
        $this->addedit_loaded($model, $form);
                
        if (!empty($_POST['form'])) {
            
            $validator = $this->View->helper('Validatie');
            /* @var $validator \View\Helper\Validatie */
            
            $form = array_merge($form, $_POST['form']);            
            $this->addedit_saving($model, $form);
            
            if (true !== ($berichten = $validator->valideer($_POST['form']))) {
                
                if (!$this->isAjax()) {
                    $this->setMelding(
                        self::MELDING_FOUT, 
                        sprintf(__('Er zijn fouten opgetreden tijdens het valideren: %s', 'beheer'), "\n-" . join("\n-", $berichten))
                    );
                }
                
                $this->View->set('form', $form);
                return false;
                
            } else {

                $converter->convertArrayToModel($form, $model);

                $result = $this->addedit_saved($model, $form);
                $this->View->set('form', $form);
                
                return $result;
            }
        }
        
        $this->View->set('form', $form);
        return false;
    }
    
    /**
     * Call set Action
     *
     * @return void
     */
    public function runAction() {

        // Kijk of een beheer functie, dan gebruiker verplict
        if (preg_match('/^beheer_(.*)/', $this->getAction()) != 0) {            
            $this->View->set('huidige_gebruiker', $this->getHuidigeGebruiker(true));
        }
        
        return parent::runAction();
        
    }

    /**
     * Laad huidige gebruiker
     *
     * @param $verplicht Gebruiker moet verplicht ingelogd zijn
     *
     * @return \Model\Gebruiker Huidige gebruiker
     */
    protected function getHuidigeGebruiker($verplicht = false) {
        $gebruiker_container = new \Model\GebruikerContainer();

        if (null === $gebruiker = $gebruiker_container->getHuidigeGebruiker()) {
            if ($verplicht) {
                $this->redirect('gebruiker/inloggen');
            }
            return null;
        }

        if ($gebruiker->getMoetWachtwoordWijzigen()) {
            if ($this->getAction() !== 'wachtwoord_wijzigen') {
                $this->redirect('gebruiker/wachtwoord_wijzigen');
            }
        }

        return $gebruiker;
    }
    
    /**
     * Redirect naar een andere paging
     *
     * @param string $url
     *
     * @return void
     */
    protected function redirect($url) {

        if (preg_match('/^http(s?):/', $url) == 0) {
            $url = r()->getBase() . $url;
        }

//        echo "<pre>";
//        print_r(\KoolDevelop\Database\Query::$ProfileLog);
//        echo "</pre>";
//        echo '<a href="' . _h($url) . '">' . _h($url) . '</a>';
//        die();

        if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
            header('HTTP/1.0 303 See Other');
        } else {
            header('HTTP/1.0 302 Found');
        }

        header('Location: ' . $url);
        exit();
    }
    
    /**
     * Stel melding in
     *
     * Een melding wordt bij de volgende pagina weergave weergegeven
     *
     * @param string $type    Type (MELDING_*)
     * @param string $melding Melding
     */
    protected function setMelding($type, $melding) {

        if (!in_array($type, array(self::MELDING_SUCCES, self::MELDING_FOUT, self::MELDING_INFO))) {
            throw new \KoolDevelop\Exception(__f('Verkeerde melding type meegegeven', 'exception'));
        }

        $sessie = KoolDevelop\Session\Session::getInstance();
        $sessie->set('melding_' . $type, $melding);
    }
 
    /**
     * Controleer of request een AJAX request is
     * 
     * @return boolean Is AJAX
     */
    protected function isAjax() {
        if(
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            return true;
        }
        return false;
    }

}
