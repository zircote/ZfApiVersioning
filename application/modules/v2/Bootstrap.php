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
class V2_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initRestRoute ()
    {
        $this->bootstrap('frontController');
        $frontController = Zend_Controller_Front::getInstance();
        $restRoute = new Zend_Rest_Route($frontController, array(), array('v2'));
        $frontController->getRouter()->addRoute('v2', $restRoute);
    }
}