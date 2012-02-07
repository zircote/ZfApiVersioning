<?php
/**
 *
 *
 * @author Robert Allen <rallen@ifbyphone.com>
 * @package
 * @subpackage
 *
 * Method	URI	Module_Controller::action
 * - GET	/product/ratings/                   Api_UsersController::indexAction()
 * - GET	/product/ratings/:id                Api_UsersController::getAction()
 * - POST	/product/ratings                    Api_UsersController::postAction()
 * - PUT	/product/ratings/:id	            Api_UsersController::putAction()
 * - DELETE	/product/ratings/:id	            Api_UsersController::deleteAction()
 * - POST	/product/ratings/:id?_method=PUT    Api_UsersController::putAction()
 * - POST	/product/ratings/:id?_method=DELETE Api_UsersController::deleteAction()
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



