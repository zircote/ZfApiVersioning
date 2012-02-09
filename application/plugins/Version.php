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
class Application_Plugin_Version extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch($request)
    {
        /* @var $bootstrap Zend_Application_Bootstrap_Bootstrap */
        if($request->getModuleName() == 'default' && ! $request->getControllerName() == 'error'  && ($request->getControllerName() != 'index')){
            $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
            $defaultVersion = $bootstrap->getOption('defaultVersion');
            $apiVersion = (string) $request->getParam('version', $defaultVersion);
            $request->setModuleName($apiVersion)
                ->setControllerName($request->getControllerName())
                ->setActionName($request->getActionName())
                ->setDispatched(false);
        }
    }
}