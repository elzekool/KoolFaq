<?php
/**
 * Antwoord Container Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace Model;

/**
 * Antwoord Container Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class AntwoordContainer extends \KoolDevelop\Model\ContainerModel
{
    
    /**
     * Database table to use
     * @var string
     */
    protected $DatabaseTable = 'antwoorden';

    /**
     * Database configuration to use
     * @var string
     */
    protected $DatabaseConfiguration = 'default';

    /**
     * Model to use
     * @var string
     */
    protected $Model = '\\Model\\Antwoord';
    
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
        /* @var $model \Model\Antwoord */
        $database_row->id = $model->getId();
        $database_row->aangemaakt = $model->getAangemaakt() === null ? date('Y-m-d H:i:s') : $model->getAangemaakt();
        $database_row->titel = $model->getTitel();
        $database_row->vraag = $model->getVraag();
        $database_row->antwoord = $model->getAntwoord();
        
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
        /* @var $model \Model\Antwoord */
        $model->setId($database_row->id);
        $model->setAangemaakt($database_row->aangemaakt);
        $model->setTitel($database_row->titel);
        $model->setVraag($database_row->vraag);
        $model->setAntwoord($database_row->antwoord);
        $model->setViews($database_row->views);
        $model->setRankingAvg($database_row->ranking_avg);
    }

    /**
     * Get Primary Key value from Model
     *
     * @return mixed Value
     */
    protected function getPrimaryKey(\KoolDevelop\Model\Model &$model) {
        /* @var $model \Model\Antwoord */
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
                
            // Zoeken op titel
            } elseif (($conditie == 'zoektekst') AND ($waarde != '')) {
                $query->where('titel LIKE ?', '%' . $waarde . '%');
                
            // Zoeken op tag
            } elseif (($conditie == 'tag') AND ($waarde != '')) {
                $query->where('id IN (SELECT antwoord_id FROM tags WHERE tag = ?)', $waarde);
            }
            
        }
        
    }
    
    
    
}