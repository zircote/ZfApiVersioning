<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package ZfApiVersion
 * @subpackage Application
 *
 *
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initRestRoute ()
    {
        $this->bootstrap('frontController');
        $frontController = Zend_Controller_Front::getInstance();
        $restRoute = new Zend_Rest_Route($frontController, array(), array());
        $frontController->getRouter()->addRoute('default', $restRoute);
    }
}

