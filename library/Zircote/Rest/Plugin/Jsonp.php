<?php
/**
 *
 * @author zircote
 * @version
 */
class Zircote_Rest_Plugin_Jsonp extends Zircote_Rest_Plugin_RestAbstract
{
    public function setOptions($options)
    {
        $this->_options = $options;
        return $this;
    }
    /**
     * @return array|null
     */
    public function postDispatch($request)
    {
        if($callback = $this->getRequest()->getParam('callback', false)){
            $this->getResponse()->setHeader('Last-Updated', date(DATE_ISO8601));
            $this->getResponse()->setHeader('Content-Type', 'application/json-p');
            $content = $this->getResponse()->getBody();
            $this->getResponse()->setBody(sprintf('%s(%s)',$callback,$content));
        }
    }
}