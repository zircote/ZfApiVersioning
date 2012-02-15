<?php
/**
 *
 * @author zircote
 * @version
 *
 * <code>
 * resources.restendpoint.plugin.allow.enabled = true
 * resources.restendpoint.plugin.allow.adapter = allow
 * resources.restendpoint.plugin.allow.options.params.get = true
 * resources.restendpoint.plugin.allow.options.params.post = true
 * resources.restendpoint.plugin.allow.options.params.put = true
 * resources.restendpoint.plugin.allow.options.params.delete = true
 * </code>
 * Yields: Allow: GET, POST, PUT, DELETE
 */
class Zircote_Rest_Plugin_Allow extends Zircote_Rest_Plugin_RestAbstract
{
    protected $_defaults;
    protected $_allowed = array(
        'GET','POST','PUT','DELETE','TRACE','UPDATE','HEAD','OPTIONS','CONNECT'
    );
    const APP_NAMESPACE = 'ZREST_ALLOW';
    public function setOptions($options)
    {
        $data = Zend_Registry::get(self::GLOBAL_NAMESPACE);
        if(isset($options['storage_namespace'])){
            $this->_namespace = $options['storage_namespace'];
        }
        $this->_defaults = $options;
        if(isset($options['params'])){
            if(count($this->_defaults['params'])){
                $this->_allowed = array();
                foreach ($this->_defaults['params'] as $key => $value) {
                    $this->_allowed[] = strtoupper($key);
                }
            }
        }
        $data[self::APP_NAMESPACE]['allow'] = $this->_allowed;
        Zend_Registry::set(self::GLOBAL_NAMESPACE, $data);
        return $this;
    }
    public function postDispatch($request)
    {
        if(!$this->getResponse()->isException()){
            $data = Zend_Registry::get(self::GLOBAL_NAMESPACE);
            $this->getResponse()
            ->setHeader(
                'Allow', implode(', ', $data[self::APP_NAMESPACE]['allow'])
            );
        }
    }
}