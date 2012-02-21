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
    /**
     *
     * @var string
     */
    protected $_defaults;
    /**
     *
     * @var array
     */
    protected $_allowed = array('GET','POST','PUT','DELETE');
    /**
     * (non-PHPdoc)
     * @see Zircote_Rest_Plugin_RestAbstract::setOptions()
     */
    public function setOptions($options)
    {
        $this->_defaults = $options;
        if(isset($options['params'])){
            if(count($this->_defaults['params'])){
                $this->_allowed = array();
                foreach ($this->_defaults['params'] as $key => $value) {
                    $this->_allowed[] = strtoupper($key);
                }
            }
        }
        $data = $this->_allowed;
        Zircote_Rest_DbRegister::getInstance()
            ->set(Zircote_Rest_DbRegister::ALLOW, $data);
        return $this;
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Plugin_Abstract::postDispatch()
     */
    public function postDispatch($request)
    {
        if(!$this->getResponse()->isException()){
            $data = Zircote_Rest_DbRegister::getInstance()
                ->get(Zircote_Rest_DbRegister::ALLOW);
            $this->getResponse()
            ->setHeader(
                'Allow', implode(', ', $data)
            );
        }
    }
}