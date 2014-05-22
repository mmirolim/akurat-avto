<?php




class MaintenanceSchedule extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $_id;
     
    /**
     *
     * @var integer
     */
    protected $_modelId;
     
    /**
     *
     * @var string
     */
    protected $_conf;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => '_id',
            'model_id' => '_modelId',
            'configuration' => '_conf'
        );
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setModelId($id)
    {
        $this->_modelId = $id;
    }

    public function getModelId()
    {
        return $this->_modelId;
    }
    //TODO set proper var type and description
    public function setConf($conf)
    {
        $this->_conf = $conf;
    }

    public function getConf()
    {
        return $this->_conf;
    }


}
