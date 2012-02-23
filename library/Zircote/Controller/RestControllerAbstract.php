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
     * @var string
     */
    protected $_accept = 'application/json;level=1';
    protected $_allow = array('GET','POST','PUT','DELETE','OPTIONS','TRACE');
    const SORT_ASCENDING = 'ASC';
    const SORT_DESCENDING = 'DESC';
    /**
     *
     * @var Zend_Log
     */
    protected $_log;
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
    public function init ()
    {
        
    }
    public function preDispatch()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_enforceTrailingSlashPreDispatch()
            ->_fieldsPreDispatch()
            ->_pagingPreDispatch()
            ->_searchPreDispatch()
            ->_loggingPreDispatch()
            ->_sortPreDispatch();
    }
    public function postDispatch()
    {
        $this->acceptPostDispatch()
            ->_allowPostDispatch()
            ->_pagingPostDispatch()
            ->_jsonpPostDispatch()
            ->_lastUpdatedPostDispatch();
    }
    /**
     *
     * @return Zend_Log
     */
    public function getLog()
    {
        if(!$this->_log){
            /* @var $bootstrap Zend_Zircote_Rest_Bootstrap_Bootstrap */
            $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
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
    
    public function notAllowedAction() {
        // Set Allow header and 405 Code
        $this->getResponse()->setHeader('Allow', $this->allow);
        $this->getResponse()->setHttpResponseCode(405);
    }
    
    public final function indexAction() {
        return $this->__call('index',null);
    }
    
    public function getAction() {
        $this->notAllowedAction();
    }
    
    public function putAction() {
        $this->notAllowedAction();
    }
    
    public function postAction() {
        $this->notAllowedAction();
    }
    
    public function deleteAction() {
        $this->notAllowedAction();
    }
    
    public function headAction() {
        $this->notAllowedAction();
    }
    
    public function optionsAction() {
        $this->notAllowedAction();
    }
    
    public function __call($method, $args = array())
    {
        $reflected = new ReflectionClass($this);
        $method = strtolower($this->getRequest()->getMethod()) . 'Action';
        if ($reflected->hasMethod($method)) {
            return $reflected->getMethod($method)->invokeArgs($args);
        }
        $this->notAllowedAction();
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    public function acceptPostDispatch()
    {
        $this->getResponse()->setHeader(
            'Accept', $this->_parseTypes($this->_options['accept']['params'])
        );
        return $this;
    }
    /**
     *
     * @param array $types
     */
    protected function _parseAcceptTypes($types)
    {
        $result = array();
        foreach ($types as $type) {
            $result[] = $this->_parseType($type);
        }
        return implode(',', $result);
    }
    /**
     *
     * @param string $type
     */
    protected function _parseAcceptType($type)
    {
        $result = $type['type'];
        if(isset($type['params']) && is_array($type['params'])){
            $result .= ';' . implode(';', $type['params']);
        }
        return $result;
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _allowPostDispatch()
    {
        if(!$this->getResponse()->isException()){
            $this->getResponse()
                ->setHeader('Allow', implode(', ', $this->_allow));
        }
        return $this;
    }
    /**
     * 
     * Here we will enforce the trailing / is not present in get requests in the
     * event it is we will forward to its operational counterpart with a 301
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _enforceTrailingSlashPreDispatch()
    {
        if($this->getRequest()->isGet()){
            if(preg_match('/.+\/$/', $this->getRequest()->getPathInfo())){
                $filter = new Zend_Filter_PregReplace(
                    array('match' => '/\/$/','replace' => '')
                );
                $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
                $redirector->setCode(301)
                ->gotoUrl($filter->filter($this->getRequest()->getPathInfo()))
                ->redirectAndExit();
            }
        }
        return $this;
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _fieldsPreDispatch()
    {
        if($result = $this->getRequest()->getParam('fields', null)){
            $this->_fields = explode(',',$result);
        }
        return $this;
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _pagingPreDispatch()
    {
        $this->_paging['request'] = array(
            'offset' => $this->getRequest()->getParam('offset', $this->_offset),
            'limit' => $this->getRequest()->getParam('limit', $this->_limit)
        );
        return $this;
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _pagingPostDispatch()
    {
        if(isset($this->_paging['response'])){
            $count = $limit = $offset = 0;
            extract($this->_paging['response']);
            if(($offset+$limit)){
            $this->getResponse()->setHeader(
                'Range', sprintf('%s-%s/%s',($offset+1),($offset+$limit),$count)
            )->setHttpResponseCode(206);
            }
        }
        return $this;
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _searchPreDispatch()
    {
        $this->_q = $this->getRequest()->getParam($this->_queryKey, null);
        return $this;
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _sortPreDispatch()
    {
        if(null !== ($sort = $this->getRequest()->getParam('sort', null))){
            $this->_sort = $this->_getSort($sort);
        }
        return $this;
    }
    /**
     * 
     * @param array $data
     */
    protected function _getSort($data)
    {
        $result = array();
        foreach (explode(',',$data) as $value) {
            $result[] = str_ireplace(
                array('(asc)','(desc)'), array(' ASC',' DESC'), $value
            );
        }
        return $result;
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _jsonpPostDispatch()
    {
        if($callback = $this->getRequest()->getParam('callback', false)){
            $this->getResponse()->setHeader('Content-Type', 'application/json-p');
            $content = $this->getResponse()->getBody();
            $this->getResponse()->setBody(sprintf('%s(%s)',$callback,$content));
        }
        return $this;
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _lastUpdatedPostDispatch()
    {
        if($lastUpdated = $this->_getParam('last_updated',null)){
            $this->getResponse()->setHeader('Last-Updated', $lastUpdated);
        }
        return $this;
    }
    /**
     * 
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _loggingPreDispatch()
    {
        $filter = new Zend_Filter();
        $filter->addFilter(new Zend_Filter_StripNewlines())
            ->addFilter(
                new Zend_Filter_PregReplace(
                    array('match' => '/\s\s+/', 'replace' => '')
                )
            );
        $format = "METHOD:[%%METHOD%%] PATHINFO:[%%PATHINFO%%] PARAMS:[%%PARAMS%%]";
        $message = str_replace(
            array('%%METHOD%%','%%PATHINFO%%','%%PARAMS%%'),
            array($this->getRequest()->getMethod(), $this->getRequest()->getPathInfo(),
                $filter->filter(print_r($this->getRequest()->getUserParams(), true))),
            $format
        );
        $this->getLog()->info($message);
        return $this;
    }
}


