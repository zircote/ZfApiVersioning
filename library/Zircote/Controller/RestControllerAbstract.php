<?php
/**
 *
 *
 * @author Robert Allen <rallen@ifbyphone.com>
 * @package
 * @subpackage
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
    public $contexts = array(
        'index'  => array('json','xml'),
        'get'    => array('json','xml'),
        'post'   => array('json','xml'),
        'put'    => array('json','xml'),
        'delete' => array('json','xml')
    );
    public function preDispatch ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }
    public function init ()
    {
        $this->_helper->contextSwitch()->initContext();
        $this->_helper->contextSwitch()->setAutoJsonSerialization(false);
    }
    abstract public function indexAction ();
    abstract public function getAction ();
    abstract public function postAction ();
    abstract public function putAction ();
    abstract public function deleteAction ();
}



