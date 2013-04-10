<?php
/**
 * Tag Container Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace Model;

/**
 * Tag Container Model
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class TagContainer extends \KoolDevelop\Model\ContainerModel
{
    
    /**
     * Database table to use
     * @var string
     */
    protected $DatabaseTable = 'tags';

    /**
     * Database configuration to use
     * @var string
     */
    protected $DatabaseConfiguration = 'default';

    /**
     * Model to use
     * @var string
     */
    protected $Model = '\\Model\\Tag';
    
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
        /* @var $model \Model\Tag */
        $database_row->id = $model->getId();
        $database_row->antwoord_id = $model->getAntwoordId();
        $database_row->tag = $model->getTag();
        
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
        /* @var $model \Model\Tag */
        $model->setId($database_row->id);
        $model->setAntwoordId($database_row->antwoord_id);
        $model->setTag($database_row->tag);
    }

    /**
     * Get Primary Key value from Model
     *
     * @return mixed Value
     */
    protected function getPrimaryKey(\KoolDevelop\Model\Model &$model) {
        /* @var $model \Model\Tag */
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
                
            // Zoeken op antwoord
            } else if ($conditie == 'antwoord_id') {
                $query->where('antwoord_id = ?', $waarde);
            }
            
        }
        
    }
    
    /**
     * Laad Tags die op dit moment gebruikt worden
     * 
     * @return string[] Tags
     */
    public function getDistinctTags() {
        
        $database = \KoolDevelop\Database\Adaptor::getInstance($this->DatabaseConfiguration);
        $result = $database->newQuery()
            ->select('DISTINCT tag')
            ->from($this->DatabaseTable)
            ->execute();
        
        $tags = $result->fetchAll(\PDO::FETCH_COLUMN);
        
        return is_array($tags) ? $tags : array();
        
    }
    
    /**
     * Laad Tag Cloud
     * 
     * @return mixed[][] Tags met aantal
     */
    public function getTagCloud() {
        
        $database = \KoolDevelop\Database\Adaptor::getInstance($this->DatabaseConfiguration);
        $result = $database->newQuery()
            ->select('tag, COUNT(*) as count')
            ->from($this->DatabaseTable)
            ->groupby('tag')
            ->orderby('count', 'DESC')
            ->limit(15)
            ->execute();
        
        $tags = $result->fetchAll(\PDO::FETCH_ASSOC);
        
        return is_array($tags) ? $tags : array();
        
    }
    
    
    
}