<?php
/**
 * Gebruiker Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * @subpackage Model
 **/

namespace Model;

/**
 * Gebruiker Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * @subpackage Model
 **/
class Gebruiker extends \Model
{
    
    private $Id;
    private $Gebruikersnaam;
    private $Naam;
    private $WachtwoordHash;
    private $LaatsteKeerAangemeld;
    private $MoetWachtwoordWijzigen;
    
    /**
     * Get Id
     *
     * @return int Id
     **/
    public function getId() {
        return $this->Id;
    }

    /**
     * Set Id
     *
     * @param int $Id Id
     *
     * @return void 
     **/
    public function setId($Id) {
        $this->Id = $Id;
    }

    /**
     * Get Gebruikersnaam
     *
     * @return string Gebruikersnaam
     **/
    public function getGebruikersnaam() {
        return $this->Gebruikersnaam;
    }

    /**
     * Set Gebruikersnaam
     *
     * @param string $Gebruikersnaam Gebruikersnaam
     *
     * @return void 
     **/
    public function setGebruikersnaam($Gebruikersnaam) {
        $this->Gebruikersnaam = $Gebruikersnaam;
    }
    
    /**
     * Get Naam
     *
     * @return string Naam
     **/
    public function getNaam() {
        return $this->Naam;
    }

    /**
     * Set Naam
     *
     * @param string $Naam Naam
     *
     * @return void 
     **/
    public function setNaam($Naam) {
        $this->Naam = $Naam;
    }

    
    /**
     * Get Wachtwoord hash
     *
     * @return string Wachtwoord hash
     **/
    public function getWachtwoordHash() {
        return $this->WachtwoordHash;
    }

    /**
     * Set Wachtwoord hash
     *
     * @param string $WachtwoordHash Wachtwoord hash
     *
     * @return void 
     **/
    public function setWachtwoordHash($WachtwoordHash) {
        $this->WachtwoordHash = $WachtwoordHash;
    }


    /**
     * Get Datum/Tijd laatste aanmelding
     *
     * @return string Datum/Tijd laatste aanmelding
     **/
    public function getLaatsteKeerAangemeld() {
        return $this->LaatsteKeerAangemeld;
    }

    /**
     * Set Datum/Tijd laatste aanmelding
     *
     * @param string $LaatsteKeerAangemeld Datum/Tijd laatste aanmelding
     *
     * @return void 
     **/
    public function setLaatsteKeerAangemeld($LaatsteKeerAangemeld) {
        $this->LaatsteKeerAangemeld = $LaatsteKeerAangemeld;
    }

    /**
     * Get Moet bij volgende keer inloggen wachtwoord wijzigen
     *
     * @return boolean Moet bij volgende keer inloggen wachtwoord wijzigen
     **/
    public function getMoetWachtwoordWijzigen() {
        return $this->MoetWachtwoordWijzigen;
    }

    /**
     * Set Moet bij volgende keer inloggen wachtwoord wijzigen
     *
     * @param boolean $MoetWachtwoordWijzigen Moet bij volgende keer inloggen wachtwoord wijzigen
     *
     * @return void 
     **/
    public function setMoetWachtwoordWijzigen($MoetWachtwoordWijzigen) {
        $this->MoetWachtwoordWijzigen = $MoetWachtwoordWijzigen;
    }
    
}