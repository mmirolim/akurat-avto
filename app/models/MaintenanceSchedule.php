<?php




class MaintenanceSchedule extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var integer
     */
    public $modelId;
     
    /**
     *
     * @var string
     */
    public $conf;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'model_id' => 'modelId',
            'configuration' => 'conf'
        );
    }

}
