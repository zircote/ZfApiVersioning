<?php
/**
 *
 * @author zircote
 * @version
 */
class Zircote_Rest_Plugin_RestAbstract extends Zend_Controller_Plugin_Abstract
{
    protected $_options;
    const GLOBAL_NAMESPACE = '__ZIRCOTE_REST__';
    /**
     *
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;
    /**
     * Constructor: initialize plugin loader
     *
     * @return void
     */
    public function __construct ()
    {
        $this->pluginLoader = new Zend_Loader_PluginLoader();
    }
    /**
     *
     * @param array $options
     * @return Zircote_Rest_Plugin_RestAbstract
     */
    public function setOptions($options = array())
    {
        $this->_options = $options;
        return $this;
    }
}