<?php
/**
 *
 *
 * @author Robert Allen <rallen@ifbyphone.com>
 * @package
 * @subpackage
 *
 *
 */
abstract class Zircote_Service_RestServiceAbstract extends Zircote_Service_ServiceAbstract
{
    /**
     * @return Zend_Controller_Request_Abstract
     */
    public function getRequest()
    {
        return Zend_Controller_Front::getInstance()->getRequest();
    }
    /**
     * @return Zend_Controller_Response_Abstract
     */
    public function getResponse()
    {
        return Zend_Controller_Front::getInstance()->getResponse();
    }
}