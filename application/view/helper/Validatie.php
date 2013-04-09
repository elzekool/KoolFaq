<?php
/**
 * Validatie Helper
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace View\Helper;

/**
 * Validation Helper
 * 
 * Wordt gebruikt voor het valideren van user input. Word samen met 
 * validatie.js gebruikt.
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class Validatie extends \Helper
{
    /**
     * Validators
     * 
     * Array key is field name, waarde is een array met daarin de validators.
     * Per validator de volgende keys:
     * - validator: validator functie
     * - setting: Optie specifiek voor validator
     * - bericht: Melding die getoond word
     * - stop: Rest van de validators niet uitvoeren
     *   
     * @var mixed[][][]
     */
    protected $validators = array();
    
    /**
     * Formulieren die gevalideerd moeten worden. Iedere rij bevat de volgen keys:
     * - selector: form selector
     * - opties: extra js opties
     * 
     * @var mixed[][]
     */
    protected $forms = array();
    
    /**
     * Beschrikbare validators
     * 
     * @var string[]
     */
    protected $available = array(
        'RegEx', 'MatchField', 'Required'
    );
    
    /**
     * Waarden vanuit formulier
     * @var string
     */
    protected $values = array();
    
    /**
     * Validatie door middel van regex functie    
     * 
     * @param mixed[] $value   Waarde
     * @param string  $setting Instelling
     * 
     * @return boolean Voldoet aan validatie
     */
    protected function validateRegEx($value, $setting) {
        
        if ($value === null) {
            return true;
        }        
        
        if (is_array($value)) {
            $value = join(' ', $value);
        }
        
        if (preg_match('/' . $setting . '/', $value) == 0) {
            return false;
        } else {
            return true;
        }
        
    }
    
    /**
     * Controleerd of waarde van veld overeenkomt met ander veld
     * 
     * @param mixed[] $value   Waarde
     * @param string  $setting Instelling
     * 
     * @return boolean Voldoet aan validatie
     */
    protected function validateMatchField($value, $setting) {
        
        if ($value === null) {
            return true;
        }
        
        if ($value === @$this->values[$setting]) {
            return true;
        } else {
            return false;
        }
        
    }
    
    /**
     * Controleerd of een veld opgegeven is
     * 
     * @param mixed[] $value   Waarde
     * @param string  $setting Instelling
     * 
     * @return boolean Voldoet aan validatie
     */
    protected function validateRequired($value, $setting) {        
        return ($value !== null);
    }
    
    /**
     * Nieuwe validator toevoegen
     * 
     * @param string|string[]  $fields    Veldnam(en)
     * @param string           $validator Validator  
     * @param string           $setting   Instelling voor validator
     * @param string           $bericht   Bericht indien validatie mislukt
     * @param boolean          $stop      Stoppen met valideren (rest van berichten niet tonen)
     * 
     * @return \View\Helper\Validatie Self
     */
    public function add($fields, $validator, $setting, $bericht, $stop = true) {
        
        if (!in_array($validator, $this->available)) {
            throw new \InvalidArgumentException(__f('Ongeldige validator opgegeven', 'exception'));
        }
        
        if (!is_array($fields)) {
            $fields = array($fields);
        }
        
        foreach($fields as $field) {
            
            if (!isset($this->validators[$field])) {
                $this->validators[$field] = array();
            }

            $this->validators[$field][] = array(
                'validator' => $validator,
                'setting'   => $setting,
                'bericht'   => $bericht,
                'stop'      => $stop
            );
        }
        
        return $this;
    }
    
    /**
     * Voeg formulier toe om te valideren
     * 
     * @param string $selector Selector
     * @param string $opties   Eventuele extra opties (voor JS validator)
     * 
     * @return \View\Helper\Validatie Self
     */
    public function form($selector, $opties = array()) {
        $this->forms[] = array(
            'selector' => $selector,
            'opties' => $opties
        );
        return $this;
    }
    
    /**
     * Voer validatie uit
     * 
     * @param mixed[]  Formulier data
     * @param string[] $velden Indien opgegeven alleen deze velden controleren
     * 
     * @return string[]|boolean True indien succesvol gevalideerd, anders validatieberichten
     */
    public function valideer($data, $velden = null) {        
        $velden = ($velden === null) ? array_keys($this->validators) : $velden;
        
        $this->values = $data;
        $berichten = array();
       
        foreach($velden as $veld) {            

            if (!array_key_exists($veld, $this->validators)) {
                continue;
            }
            
            foreach($this->validators[$veld] as $validator) {
                $validator_fn = 'validate' . $validator['validator'];
                $val = array_key_exists($veld, $data) ? $data[$veld] : null;
                if (!$this->$validator_fn($val, $validator['setting'])) {
                    $berichten[] = $validator['bericht'];
                    if ($validator['stop']) {
                        break;
                    }
                }
            }
            
        }
        
        if (count($berichten) == 0) {
            return true;
        } else {
            return $berichten;
        }
        
    }
    
    
    /**
     * Schrijf Javascript output
     * 
     * @return void
     */
    public function writeJs() {
        $assets = $this->getView()->helper('Assets');
        /* @var $assets \View\Helper\Assets */        
        $js  = 'var KoolFAQ = KoolFAQ || {}; KoolFAQ.Validator = KoolFAQ.Validator || {};';
        $js .= 'KoolFAQ.Validator.validators = ' . json_encode($this->validators) . ';';
        $js .= 'KoolFAQ.Validator.forms = ' . json_encode($this->forms) . ';';
        $assets->inlineScript($js);
        $assets->script(r()->getBase() . __min('/js/validatie.js'));        
    }
    
    
}