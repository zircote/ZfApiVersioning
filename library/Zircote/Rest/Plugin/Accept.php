<?php
/**
 *
 * @author zircote
 * @version
 *
 * <code>
 * resources.restendpoint.plugin.accept.enabled = true
 * resources.restendpoint.plugin.accept.adapter = accept
 * resources.restendpoint.plugin.accept.options.params.json.type = "application/json"
 * resources.restendpoint.plugin.accept.options.params.json.params[] = "level=1"
 * resources.restendpoint.plugin.accept.options.params.json.params[] = "q=0.8"
 * resources.restendpoint.plugin.accept.options.params.xml.type = "application/xml"
 * </code>
 * Yields: Accept: application/json;level=1;q=0.8,application/xml
 */
class Zircote_Rest_Plugin_Accept extends Zircote_Rest_Plugin_RestAbstract
{
    /**
     *
     * @var string
     */
    const APP_NAMESPACE = 'ZREST_ACCEPT';
    /**
     *
     * @var string
     */
    protected $_accept = 'application/json;level=1';
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
    public function postDispatch($request)
    {
        $this->getResponse()->setHeader(
            'Accept', $this->_parseTypes($this->_options['params'])
        );
    }
    /**
     *
     * @param array $types
     */
    protected function _parseTypes($types)
    {
        $result = array();
        foreach ($types as $type) {
            $result[] = $this->_parseType($type);
        }
        return implode(',', $result);
    }
    /**
     *
     * @param string $type
     */
    protected function _parseType($type)
    {
        $result = $type['type'];
        if(isset($type['params']) && is_array($type['params'])){
            $result .= ';' . implode(';', $type['params']);
        }
        return $result;
    }
}