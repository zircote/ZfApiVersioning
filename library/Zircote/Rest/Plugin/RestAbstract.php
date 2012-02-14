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
        // TODO Auto-generated Constructor
        $this->pluginLoader = new Zend_Loader_PluginLoader();
        if(!Zend_Registry::isRegistered(self::GLOBAL_NAMESPACE)){
            Zend_Registry::set(self::GLOBAL_NAMESPACE,array());
        }
    }
    public function setOptions($options = array())
    {
        $this->_options = $options;
        return $this;
    }
}