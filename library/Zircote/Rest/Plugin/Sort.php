<?php
/**
 *
 * @author zircote
 * @version
 */
class Zircote_Rest_Plugin_Sort extends Zircote_Rest_Plugin_RestAbstract
{
    /**
     *
     * @var string
     */
    const APP_NAMESPACE = 'ZREST_SORT';
    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';
    /**
     * (non-PHPdoc)
     * @see Zircote_Rest_Plugin_RestAbstract::setOptions()
     */
    public function setOptions($options)
    {
        if(isset($options['storage_namespace'])){
            $this->_namespace = $options['storage_namespace'];
        }
        if(isset($options['defaults'])){
            $options = $options['defaults'];
        }
        $this->_options = $options;
        return $this;
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Plugin_Abstract::postDispatch()
     */
    public function preDispatch($request)
    {
        if(null !== ($sort = $this->getRequest()->getParam('sort', null))){
            $data = Zend_Registry::get(self::GLOBAL_NAMESPACE);
            $data[self::APP_NAMESPACE]= array(
                'sort' => $this->_getSort($sort)
            );
            Zend_Registry::set(self::GLOBAL_NAMESPACE, $data);
        }
    }
    protected function _getSort($data)
    {
        $result = array();
        foreach (explode(',',$data) as $value) {
            $result[] = str_ireplace(
                array('(asc)','(desc)'), array(' ASC',' DESC'), $value
            );
        }
        return $result;
    }
}