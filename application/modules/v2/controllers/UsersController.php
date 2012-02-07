<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package ZfApiVersion
 * @subpackage V2
 *
 *
 */
class V2_UsersController extends Zircote_Controller_RestControllerAbstract
{
    public $result;
    /**
     *
     * @var V2_Service_User
     */
    protected $_service;
    public function init()
    {
        $this->_service = new V2_Service_User();
        $this->_service->setLog($this->getLog())
            ->setCache($this->getCache());
        $this->_helper->viewRenderer->setNoRender(true);
        parent::init();
    }
    public function indexAction ()
    {
        $this->result = $this->_service->fetchAllUsers();
    }
    /**
     * - http://api.local/v2/users/4?format=json
     * - http://api.local/v2/users/4
     * <code>
     * HTTP/1.1 200 OK
     * Date: Tue, 07 Feb 2012 15:05:56 GMT
     * Server: Apache/2.2.21 (Unix) PHP/5.3.9-ZS5.6.0 mod_ssl/2.2.21 OpenSSL/0.9.8o
     * X-Powered-By: PHP/5.3.9-ZS5.6.0 ZendServer/5.0
     * Content-Length: 78
     * Keep-Alive: timeout=5, max=100
     * Connection: Keep-Alive
     * Content-Type: application/json
     *
     * {"id":"4","email":"zircote@gmail.com","firstname":"Robert","lastname":"Allen"}
     * </code>
     *
     * - http://api.local/v2/users/4?format=xml
     * <code>
     * HTTP/1.1 200 OK
     * Date: Tue, 07 Feb 2012 15:06:46 GMT
     * Server: Apache/2.2.21 (Unix) PHP/5.3.9-ZS5.6.0 mod_ssl/2.2.21 OpenSSL/0.9.8o
     * X-Powered-By: PHP/5.3.9-ZS5.6.0 ZendServer/5.0
     * Content-Length: 133
     * Keep-Alive: timeout=5, max=100
     * Connection: Keep-Alive
     * Content-Type: application/xml
     *
     * <?xml version="1.0"?>
     * <user>
     *     <id>4</id>
     *     <email>zircote@gmail.com</email>
     *     <firstname>Robert</firstname>
     *     <lastname>Allen</lastname>
     * </user>
     * </code>
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::getAction()
     */
    public function getAction ()
    {
        $user = $this->_service
            ->fetchUserById($this->getRequest()->getUserParam('id'));
        $this->result = $user;
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::postAction()
     */
    public function postAction ()
    {
        if ($this->_request->isPost()) {
            $user = new Application_Model_User($this->getRequest()->getParams());
            $this->result = $this->_service->saveUser($user);
            $this->getResponse()->setRedirect(
                $this->view->url($this->getRequest()->getUserParams()),201
            );
        } else {
            $this->error = "Invalid Request";
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
            $user = $this->_service->createUser($user);
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
            if($this->result = $this->_service->deleteUser($user)){
                $this->getResponse()->setHttpResponseCode(202);
            }
        }
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::postDispatch()
     */
    public function postDispatch()
    {
        switch ($this->_helper->contextSwitch()->getCurrentContext()){
            case 'xml':
                $responseBody = $this->result->toXml()->asXML();
                break;
            case 'json':
            default:
                $responseBody =  Zend_Json::encode($this->result->toArray());
        }
        $this->getResponse()->appendBody($responseBody);
    }
}



