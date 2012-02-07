<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package Zircote
 * @subpackage Controller
 *
 * - Method  URI              Module_Controller::action
 * - GET     /api/users/      Api_UsersController::indexAction()
 * - GET     /api/users/:id   Api_UsersController::getAction()
 * - POST    /api/users       Api_UsersController::postAction()
 * - PUT     /api/users/:id   Api_UsersController::putAction()
 * - DELETE  /api/users/:id   Api_UsersController::deleteAction()
 */
abstract class Zircote_Controller_RestControllerAbstract extends Zend_Rest_Controller
{
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
     * @return Zend_Log
     */
    public function getLog()
    {
        /* @var $bootstrap Zend_Application_Bootstrap_Bootstrap */
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            $writer = new Zend_Log_Writer_Null();
            $log = new Zend_Log();
            $log->addWriter($writer);
            return $log;
        }
        return $bootstrap->getResource('Log');
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


