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
 * Tag Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * @subpackage Model
 **/
class Tag extends \Model
{
    private $Id;
    private $AntwoordId;
    private $Tag;
    
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
     * Get Antwoord ID
     *
     * @return int Antwoord ID
     **/
    public function getAntwoordId() {
        return $this->AntwoordId;
    }

    /**
     * Set Antwoord ID
     *
     * @param int $AntwoordId Antwoord ID
     *
     * @return void
     **/
    public function setAntwoordId($AntwoordId) {
        $this->AntwoordId = $AntwoordId;
    }


    /**
     * Get Tag
     *
     * @return string Tag
     **/
    public function getTag() {
        return $this->Tag;
    }

    /**
     * Set Tag
     *
     * @param string $Tag Tag
     *
     * @return void
     **/
    public function setTag($Tag) {
        $this->Tag = $Tag;
    }


    

}