<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package Zircote
 * @subpackage Controller
 *
 * - Method  URI              Module_Controller::action
 * - GET     /v{?}/users/      Api_UsersController::indexAction()
 * - GET     /v{?}/users/:id   Api_UsersController::getAction()
 * - POST    /v{?}/users       Api_UsersController::postAction()
 * - PUT     /v{?}/users/:id   Api_UsersController::putAction()
 * - DELETE  /v{?}/users/:id   Api_UsersController::deleteAction()
 */
abstract class Zircote_Controller_RestControllerAbstract extends Zend_Rest_Controller
{
    /**
     *
     * @var Zend_Log
     */
    protected $_log;
    /**
     *  Actions and contexts fpr contextSwitch helper
     * @var array
     */
    public $contexts = array(
        'index'  => array('json','xml'),
        'get'    => array('json','xml'),
        'post'   => array('json','xml'),
        'put'    => array('json','xml'),
        'delete' => array('json','xml')
    );
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
    public function init ()
    {
        /* @var $cs Zend_Controller_Action_Helper_ContextSwitch */
        $cs = $this->_helper->contextSwitch();
        $cs->initContext();
        $cs->initContext($cs->getCurrentContext() ?: 'json');
        $cs->setAutoJsonSerialization(false);
    }
    /**
     *
     * @return Zend_Controller_Action_Helper_Redirector
     */
    public function getRedirector()
    {
        return $this->_helper->redirector();
    }
    /**
     *
     * @return Zend_Log
     */
    public function getLog()
    {
        if(!$this->_log){
            /* @var $bootstrap Zend_Application_Bootstrap_Bootstrap */
            $bootstrap = $this->getInvokeArg('bootstrap');
            if (!$bootstrap->hasResource('Log')) {
                $writer = new Zend_Log_Writer_Null();
                $this->_log = new Zend_Log();
                $this->_log->addWriter($writer);
            } else {
                $this->_log = $bootstrap->getResource('Log')->getLog();
            }
        }
        return $this->_log;
    }
    /**
     * @return Zend_Cache_Core
     */
    public function getCache()
    {
        /* @var $bootstrap Zend_Application_Bootstrap_Bootstrap */
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Cache')) {
            $cache = new Zend_Cache_Core();
            $cache->setOption('automatic_serialization', true);
            $cache->setBackend(new Zend_Cache_Backend_BlackHole());
            return $cache;
        }
        return $bootstrap->getResource('Cache');
    }
}


