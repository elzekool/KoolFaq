<?php
/**
 * Antwoord Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * @subpackage Model
 **/

namespace Model;

/**
 * Antwoord Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * @subpackage Model
 **/
class Antwoord extends \Model
{

    private $Id;
    private $Aangemaakt;
    private $Titel;
    private $Vraag;
    private $Antwoord;
    private $Views = 0;
    private $RankingAvg = 0;
    
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
     * Get Aangemaakt
     *
     * @return string Aangemaakt
     **/
    public function getAangemaakt() {
        return $this->Aangemaakt;
    }

    /**
     * Set Aangemaakt
     *
     * @param string $Aangemaakt Aangemaakt
     *
     * @return void
     **/
    public function setAangemaakt($Aangemaakt) {
        $this->Aangemaakt = $Aangemaakt;
    }

    
    /**
     * Get Titel
     *
     * @return string Titel
     **/
    public function getTitel() {
        return $this->Titel;
    }

    /**
     * Set Titel
     *
     * @param string $Titel Titel
     *
     * @return void
     **/
    public function setTitel($Titel) {
        $this->Titel = $Titel;
    }


    /**
     * Get Vraag
     *
     * @return string Vraag
     **/
    public function getVraag() {
        return $this->Vraag;
    }

    /**
     * Set Vraag
     *
     * @param string $Vraag Vraag
     *
     * @return void
     **/
    public function setVraag($Vraag) {
        $this->Vraag = $Vraag;
    }


    /**
     * Get Antwoord
     *
     * @return sting Antwoord
     **/
    public function getAntwoord() {
        return $this->Antwoord;
    }

    /**
     * Set Antwoord
     *
     * @param sting $Antwoord Antwoord
     *
     * @return void
     **/
    public function setAntwoord($Antwoord) {
        $this->Antwoord = $Antwoord;
    }
    
    /**
     * Get Views
     *
     * @return int Views
     **/
    public function getViews() {
        return $this->Views;
    }

    /**
     * Set Views
     *
     * @param int $Views Views
     *
     * @return void
     **/
    public function setViews($Views) {
        $this->Views = $Views;
    }

    /**
     * Get RankingAvg
     *
     * @return float RankingAvg
     **/
    public function getRankingAvg() {
        return $this->RankingAvg;
    }

    /**
     * Set RankingAvg
     *
     * @param float $RankingAvg RankingAvg
     *
     * @return void
     **/
    public function setRankingAvg($RankingAvg) {
        $this->RankingAvg = $RankingAvg;
    }

    
    /**
     * Laad Tags a.d.v. Id
     * 
     * @return \Model\Tag[] Tags
     */
    public function getTags() {
        if ($this->getId() === null) {
            return array();
        }
        $tag_container = new \Model\TagContainer();
        return $tag_container->index(array('antwoord_id' => $this->getId()));
    }
    
    

    
    
}