<?php
/**
 *
 *
 * @author Robert Allen <rallen@ifbyphone.com>
 * @package Zircote
 * @subpackage Service
 *
 *
 */
abstract class Zircote_Service_ServiceAbstract
{
    /**
     *
     * @var Zend_Cache_Core
     */
    protected $_cache;
    /**
     *
     * @var Zend_Log
     */
    protected $_log;

    /**
     *
     * @param array|Zend_Config $options
     */
    public function __construct($options = array())
    {
        $this->setOptions($options);
    }
    /**
     *
     * @param array|Zend_Config $options
     */
    public function setOptions($options)
    {
        if(isset($options['cache']) && $options['cache'] instanceof Zend_Cache_Core){
            $this->setCache($options['cache']);
        }
        if(isset($options['log']) && $options['log'] instanceof Zend_Log){
            $this->setLog($options['log']);
        }
    }
    /**
     *
     * @return Zend_Log
     */
    public function getLog()
    {
        return $this->_log;
    }
    /**
     *
     * @return Zend_Cache_Core
     */
    public function getCache()
    {
        return $this->_cache;
    }
    /**
     *
     * @param Zend_Log $log
     * @return Zircote_Service_RestServiceAbstract
     */
    public function setLog(Zend_Log $log)
    {
        $this->_log = $log;
        return $this;
    }
    /**
     *
     * @param Zend_Cache_Core $cache
     * @return Zircote_Service_RestServiceAbstract
     */
    public function setCache(Zend_Cache_Core $cache)
    {
        $this->_cache = $cache;
        return $this;
    }
    /**
     *
     * @param string $keyName
     * @returnstring
     */
    protected function _cacheKey($keyName){
        /* @todo this will need refactoring to a new place */
        $filter = new Zend_Filter_PregReplace(array(
            'match' => '/(\w+)::(\w+)/',
            'replace' => '$1_$2'
        ));
        return $filter->filter($keyName);
    }
}