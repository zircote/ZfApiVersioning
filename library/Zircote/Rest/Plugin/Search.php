<?php
/**
 *
 * @author zircote
 * @version
 *
 * <code>
 * resources.restendpoint.plugin.search.enabled = true
 * resources.restendpoint.plugin.search.adapter = search
 * resources.restendpoint.plugin.search.options.params.queryKey = 'q'
 * </code>
 */
class Zircote_Rest_Plugin_Search extends Zircote_Rest_Plugin_RestAbstract
{
    /**
     *
     * @var string
     */
    const APP_NAMESPACE = 'ZREST_SEARCH';
    protected $_queryKey = 'q';
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
        if(isset($options['params']['queryKey'])){
            $this->_queryKey = $options['params']['queryKey'];
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
        if(null !== ($q = $this->getRequest()->getParam($this->_queryKey, null))){
            $data = Zend_Registry::get(self::GLOBAL_NAMESPACE);
            $data[self::APP_NAMESPACE]= array(
                'query' => $q
            );
            Zend_Registry::set(self::GLOBAL_NAMESPACE, $data);
        }
    }
}