<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package ZfApiVersion
 * @subpackage
 *
 *
 */
class V1_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initRestRoute ()
    {
        $this->bootstrap('frontController');
        $frontController = Zend_Controller_Front::getInstance();
        $restRoute = new Zend_Rest_Route($frontController, array(), array('v1'));
        $frontController->getRouter()->addRoute('v1', $restRoute);
    }
}