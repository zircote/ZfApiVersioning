<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package ZfApiVersion
 * @subpackage V1
 *
 *
 */
class V1_UsersController extends Zircote_Controller_RestControllerAbstract
{
    /**
     *
     * @var Application_Model_Mapper_Users
     */
    protected $_mapper;
    public function init()
    {
        $this->_mapper = new Application_Model_Mapper_Users();
        parent::init();
    }
    public function indexAction ()
    {
        $this->view->result = $this->_mapper->getUsers();
    }
    /**
     * <code>
     * {"error":null,"result":{"id":"3","email":"zircote@gmail.com","firstname":"Robert","lastname":"Allen"}}
     * </code>
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::getAction()
     */
    public function getAction ()
    {
        $user = new Application_Model_User(array('id' => $this->getRequest()->getParam('id')));
        $user = $this->_mapper->getUserById($user);
        $this->view->result = $user->toArray();
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::postAction()
     */
    public function postAction ()
    {
        if ($this->_request->isPost()) {
            $user = new Application_Model_User($this->getRequest()->getParams());
            $user = $this->_mapper->updateUser($user);
            $this->getResponse()->setRedirect(
                $this->view->url($this->getRequest()->getUserParams()),201
            );
        } else {
            $this->view->error = "Invalid Request";
            $this->getResponse()->setHttpResponseCode(400);
        }
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::putAction()
     */
    public function putAction ()
    {
        if ($this->_request->isPut()) {
            $user = new Application_Model_User($this->getRequest()->getParams());
            $user = $this->_mapper->addUser($user);
            $url = $this->view->url($this->getRequest()->getUserParams());
            $this->getResponse()->setRedirect(
                $this->view->url($this->getRequest()->getUserParams()),201
            );
        } else {
            $this->view->error = "Invalid Request";
            $this->getResponse()->setHttpResponseCode(400);
        }
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::deleteAction()
     */
    public function deleteAction ()
    {
        if($this->_request->isDelete()){
            $user = new Application_Model_User(array('id' => $this->_getParam('id')));
            if($this->view->result = $this->_mapper->deleteUser($user)){
                $this->getResponse()->setHttpResponseCode(202);
            }
        }
    }
}



