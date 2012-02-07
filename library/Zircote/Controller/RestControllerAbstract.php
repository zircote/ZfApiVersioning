<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package ZfApiVersion
 * @subpackage Zircote_Controller
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
     * @see Zend_Controller_Action::preDispatch()
     */
    public function preDispatch ()
    {
//         $this->_helper->viewRenderer->setNoRender(true);
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
    public function init ()
    {
        $this->_helper->contextSwitch()->initContext();
        $this->_helper->contextSwitch()->setAutoJsonSerialization(false);
    }
    /**
     *
     * @return Zend_Log
     */
    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            $writer = new Zend_Log_Writer_Null();
            $log = new Zend_Log();
            $log->addWriter($writer);
            return $log;
        }
        return $bootstrap->getResource('Log');
    }
}



