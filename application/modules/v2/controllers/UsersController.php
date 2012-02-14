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
    /**
     * (non-PHPdoc)
     * @see Zircote_Controller_RestControllerAbstract::init()
     */
    public function init()
    {
        $this->_service = new V2_Service_User();
        $this->_service->setLog($this->getLog())
            ->setCache($this->getCache());
        $this->_helper->viewRenderer->setNoRender(true);
        parent::init();
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::indexAction()
     *
     * @authRequired true
     * @limit accountId
     */
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
     *
     *
     * @authRequired true
     * @limit accountId
     */
    public function getAction ()
    {
        $user = $this->_service
            ->fetchUserById($this->getRequest()->getUserParam('id'));
        $this->result = $user;
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::putAction()
     *
     * @authRequired true
     * @limit accountId
     */
    public function putAction ()
    {
        if ($this->_request->isPost()) {
            if(!$this->getRequest()->getUserParam('id', false)){
                $this->getResponse()->setHttpResponseCode(405);
            } else{
                $user = new Application_Model_User(
                    $this->getRequest()->getParams()
                );
                $this->result = $this->_service->saveUser($user);
                $this->getResponse()->setHttpResponseCode(201);
            }
        } else {
            $this->error = "Invalid Request";
            $this->getResponse()->setHttpResponseCode(400);
        }
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::postAction()
     *
     * @authRequired true
     * @limit accountId
     */
    public function postAction ()
    {
        if ($this->_request->isPut()) {
            if($this->getRequest()->getUserParam('id', false)){
                $this->getResponse()->setHttpResponseCode(405);
            } else{
                $user = new Application_Model_User(
                    $this->getRequest()->getParams()
                );
                $user = $this->_service->createUser($user);
                $url = $this->view->url($this->getRequest()->getUserParams())
                    ."/{$user->getId()}";
                $this->getRedirector()->setCode(201)->gotoUrlAndExit($url);
            }
        } else {
            $this->view->error = "Invalid Request";
            $this->getResponse()->setHttpResponseCode(400);
        }
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Rest_Controller::deleteAction()
     *
     * @authRequired true
     * @limit accountId
     */
    public function deleteAction ()
    {
        if($this->_request->isDelete()){
            if(!$this->getRequest()->getUserParam('id', false)){
                $this->getResponse()->setHttpResponseCode(405);
            } else{
                $user = new Application_Model_User(array('id' => $this->_getParam('id')));
                if($this->_service->deleteUser($user)){
                    $this->result = array('success');
                    $this->getResponse()->setHttpResponseCode(204);
                }
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



