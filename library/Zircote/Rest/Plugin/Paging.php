<?php
/**
 *
 * @author zircote
 * @version
 */
class Zircote_Rest_Plugin_Paging extends Zircote_Rest_Plugin_RestAbstract
{
    protected $_limit = 10;
    protected $_offset = 0;
    const APP_NAMESPACE = 'ZREST_PAGING';
    public function setOptions($options)
    {
        if(isset($options['storage_namespace'])){
            $this->_namespace = $options['storage_namespace'];
        }
        if(isset($options['defaults'])){
            $options = $options['defaults'];
            if(isset($options['limit'])){
                $this->_limit = $options['limit'];
            }
            if(isset($options['offset'])){
                $this->_limit = $options['offset'];
            }
        }
        return $this;
    }
    public function preDispatch()
    {
        $data = Zend_Registry::get(self::GLOBAL_NAMESPACE);
        $data[self::APP_NAMESPACE]['request'] = array(
            'offset' => $this->getRequest()->getParam('offset', $this->_offset),
            'limit' => $this->getRequest()->getParam('limit', $this->_limit)
        );
        Zend_Registry::set(self::GLOBAL_NAMESPACE, $data);
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Plugin_Abstract::postDispatch()
     *
     * @todo add conditions for when it is not actually used;
     */
    public function postDispatch($request)
    {
        if(!$this->getResponse()->isException()){
            $data = Zend_Registry::get(self::GLOBAL_NAMESPACE);
            $data[self::APP_NAMESPACE]['response'] = array(
                'offset' => $this->getRequest()->getParam('offset', $this->_offset),
                'limit' => $this->getRequest()->getParam('limit', $this->_limit),
                'count' => 100
            );
            Zend_Registry::set(self::GLOBAL_NAMESPACE, $data);
            $count = $limit = $offset = 0;
            extract($data[self::APP_NAMESPACE]['response']);
            $this->getResponse()
                ->setHeader(
                    'Range', sprintf('%s-%s/%s',($offset * $limit),$limit,$count)
                )->setHttpResponseCode(206);
        }
    }
};