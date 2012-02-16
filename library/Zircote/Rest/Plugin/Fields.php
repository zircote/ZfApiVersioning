<?php
/**
 *
 * @author zircote
 * @version
 */
class Zircote_Rest_Plugin_Fields extends Zircote_Rest_Plugin_RestAbstract
{
    protected $_fields;
    const APP_NAMESPACE = 'ZREST_FIELDS';
    public function setOptions($options)
    {
        $this->_options = $options;
        if(isset($options['storage_namespace'])){
            $this->_namespace = $options['storage_namespace'];
        }
        return $this;
    }
    public function preDispatch()
    {
        $data = Zend_Registry::get(self::GLOBAL_NAMESPACE);
        if($fields = $this->_parseFields()){
            $data[self::APP_NAMESPACE]['fields'] = $fields;
            Zend_Registry::set(self::GLOBAL_NAMESPACE, $data);
        }
    }
    /**
     * @return array|null
     */
    protected function _parseFields()
    {
        if($result = $this->getRequest()->getParam('fields', null)){
            $result = explode(',',$result);
        }
        return $result;
    }
}