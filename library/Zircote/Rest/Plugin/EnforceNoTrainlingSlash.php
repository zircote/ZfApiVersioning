<?php
/**
 *
 *
 * @author Robert Allen <rallen@ifbyphone.com>
 * @package ZfApiVersioning
 * @subpackage
 *
 *
 */
class Zircote_Rest_Plugin_EnforceNoTrainlingSlash extends Zircote_Rest_Plugin_RestAbstract
{
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Plugin_Abstract::preDispatch()
     *
     * Here we will enforce the trailing / is not present in get requests in the
     * event it is we will forward to its operational counterpart with a 301
     *
     */
    public function preDispatch($request)
    {
        if($request->isGet()){
            if(preg_match('/.+\/$/', $request->getPathInfo())){
                $filter = new Zend_Filter_PregReplace(
                    array('match' => '/\/$/','replace' => '')
                );
                $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
                $redirector->setCode(301)
                    ->gotoUrl($filter->filter($request->getPathInfo()))
                    ->redirectAndExit();
            }
        }
    }
}
