<?php
/**
 * Gebruiker Container Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace Model;

/**
 * Gebruiker Container Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class GebruikerContainer extends \KoolDevelop\Model\ContainerModel
{
    
    /**
     * Database table to use
     * @var string
     */
    protected $DatabaseTable = 'gebruikers';

    /**
     * Database configuration to use
     * @var string
     */
    protected $DatabaseConfiguration = 'default';

    /**
     * Model to use
     * @var string
     */
    protected $Model = '\\Model\\Gebruiker';

    /**
     * Cache voor huidige gebruiker
     * @var \Model\Gebruiker
     */
    protected static $HuidigeGebruikerCache = null;
    
    /**
     * Field used as Primary Key
     * @var string 
     */
    protected $PrimaryKeyField = 'id';
    
    /**
     * Convert Model to Database Row
     *
     * @param \KoolDevelop\Model\Model  $model        Model
     * @param \KoolDevelop\Database\Row $database_row Database Row
     *
     * @return void
     */
    protected function _ModelToDatabase(\KoolDevelop\Model\Model &$model, \KoolDevelop\Database\Row &$database_row) {
        /* @var $model \Model\Gebruiker */
        $database_row->id = $model->getId();
        $database_row->gebruikersnaam = $model->getGebruikersnaam();
        $database_row->naam = $model->getNaam();
        $database_row->wachtwoord_hash = $model->getWachtwoordHash();
        $database_row->laatste_keer_aangemeld = $model->getLaatsteKeerAangemeld();
        $database_row->moet_wachtwoord_wijzigen = $model->getMoetWachtwoordWijzigen();
    }

    /**
     * Convert Database Row to Model
     *
     * @param \KoolDevelop\Database\Row $database_row Database Row
     * @param \KoolDevelop\Model\Model  $model        Model
     *
     * return void
     */
    protected function _DatabaseToModel(\KoolDevelop\Database\Row &$database_row, \KoolDevelop\Model\Model &$model) {
        /* @var $model \Model\Gebruiker */
        $model->setId($database_row->id);
        $model->setGebruikersnaam($database_row->gebruikersnaam);
        $model->setNaam($database_row->naam);
        $model->setWachtwoordHash($database_row->wachtwoord_hash);
        $model->setLaatsteKeerAangemeld($database_row->laatste_keer_aangemeld);
        $model->setMoetWachtwoordWijzigen($database_row->moet_wachtwoord_wijzigen);
    }

    /**
     * Get Primary Key value from Model
     *
     * @return mixed Value
     */
    protected function getPrimaryKey(\KoolDevelop\Model\Model &$model) {
        /* @var $model \Model\Gebruiker */
        return $model->getId();
    }

    /**
     * Get Primary Key value from Model
     *
     * @param $value mixed Value
     *
     * @return void
     */
    protected function setPrimaryKey(\KoolDevelop\Model\Model &$model, $value) {
        if ($value != 0) {
            $model->setId($value);
        }
    }

    /**
     * Proces Conditions into Query
     *
     * @param mixed[]                     $conditions Conditons
     * @param \KoolDevelop\Database\Query $query      Prepared Query
     *
     * @return void
     */
    protected function _ProcesConditions($conditions, \KoolDevelop\Database\Query &$query) {

        foreach($conditions as $conditie => $waarde) {        
            
            // Primary Key
            if ($conditie == 'id') {
                $query->where('id = ?', $waarde);
                
            // Gebruikersnaam
            } else if ($conditie == 'gebruikersnaam') {
                $query->where('gebruikersnaam = ?', $waarde);                
                
            // Zoeken op naam
            } elseif (($conditie == 'zoektekst') AND ($waarde != '')) {
                $query->where('naam LIKE ?', '%' . $waarde . '%');
            }
            
        }
        
    }
    
    
    /**
     * Laad huidig ingelogd gebruiker
     * 
     * Geeft null terug indien er geen gebruiker is ingelogd
     * 
     * @return \Model\Gebruiker Huidige gebruiker
     */
    public function getHuidigeGebruiker() {
    
        if (null !== ($gebruiker = self::$HuidigeGebruikerCache)) {
            return $gebruiker;
        }
        
        $sessie = \KoolDevelop\Session\Session::getInstance();
        if (!$sessie->exists('huidige_gebruiker')) {
            return null;
        }
        
        return self::$HuidigeGebruikerCache = $this->first(array(
            'id' => $sessie->get('huidige_gebruiker')
        ));
        
    }
    
    /**
     * Stel huidige gebruiker in
     * 
     * @param int $id Gebruiker ID
     * 
     * @return void
     */
    private function _setHuidigeGebruiker($id) {
        $sessie = \KoolDevelop\Session\Session::getInstance();
        $sessie->set('huidige_gebruiker', $id);
        self::$HuidigeGebruikerCache = null;        
    }
    
    /**
     * Log huidige gebruiker uit
     * 
     * @return void
     */
    public function logout() {
        $sessie = \KoolDevelop\Session\Session::getInstance();
        $sessie->del('huidige_gebruiker');
        self::$HuidigeGebruikerCache = null;
    }
    
    /**
     * Login met gebruikersnaam en wachtwoord
     * 
     * @param string $gebruikersnaam Gebruikersnaam
     * @param string $wachtwoord     Wachtwoord
     * 
     * @return boolean Inlog succesvol
     */    
    public function login($gebruikersnaam, $wachtwoord) {
        
        if (null === ($gebruiker = $this->first(array('gebruikersnaam' => $gebruikersnaam)))) {
            return false;
        }
        /* @var $gebruiker \Model\Gebruiker */
        
        // Kijk of wachtwoord ook echt als hash opgeslagen is
        // zo kan een beheerder eventueel in de database een wachtwoord 
        // invullen
        if ((strpos($gebruiker->getWachtwoordHash(), ':') === false)) {
            if (\KoolDevelop\Configuration::getInstance('app')->get('gebruiker.automatische_hash', false)) {
                $hash = $this->genereerHash($gebruiker->getWachtwoordHash());
                $gebruiker->setWachtwoordHash($hash);
                $this->save($gebruiker);            
            }
        }

        // Bepaal peper, salt en hash
        $peper = \KoolDevelop\Configuration::getInstance('app')->get('gebruiker.peper', 'koolfaq');
        list($hash, $salt) = explode(':', $gebruiker->getWachtwoordHash());

        // Controleer hash
        if (sha1($wachtwoord . $peper . $salt) != $hash) {
            return false;
        }
        
        $gebruiker->setLaatsteKeerAangemeld(date('Y-m-d H:i:s'));
        $this->save($gebruiker);
        
        
        $this->_setHuidigeGebruiker($gebruiker->getId());        
        return true;
        
    }
        
    
    /**
     * Genereer een unieke Hash voor een wachtwoord
     * 
     * @param string $wachtwoord Wachtwoord
     * 
     * @return string Hash
     */
    public function genereerHash($wachtwoord) {
        
        // Bepaal peper en salt
        $peper = \KoolDevelop\Configuration::getInstance('app')->get('gebruiker.peper', 'koolfaq');
        $salt = mt_rand();
        
        $hash = sha1($wachtwoord . $peper . $salt) . ':' . $salt;
        
        return $hash;
        
    }
    
    
}