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
class Zircote_Rest_Plugin_RequestLogging extends Zircote_Rest_Plugin_RestAbstract
{
    /**
     *
     * @var Zend_Log
     */
    protected $_log;
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
    public function preDispatch($request)
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
            array($request->getMethod(), $request->getPathInfo(),
                $filter->filter(print_r($request->getUserParams(), true))),
            $format
        );
        $this->getLog()->info($message);
    }
}