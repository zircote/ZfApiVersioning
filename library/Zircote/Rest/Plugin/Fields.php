<?php
/**
 *
 * @author zircote
 * @version
 */
class Zircote_Rest_Plugin_Fields extends Zircote_Rest_Plugin_RestAbstract
{
    public function setOptions($options)
    {
        $this->_options = $options;
        return $this;
    }
    public function preDispatch()
    {
        if($fields = $this->_parseFields()){
            Zircote_Rest_DbRegister::getInstance()->set(
                Zircote_Rest_DbRegister::FIELDS, $fields
            );
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