<?php
/**
 *
 * @author zircote
 * @version
 */
class Zircote_Rest_Plugin_ErrorCodeSuppression extends Zircote_Rest_Plugin_RestAbstract
{
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Plugin_Abstract::postDispatch()
     */
    public function postDispatch($request)
    {
        if($this->getResponse()->isException()){
            $haystack = array('true' => true, 'false' => false, '1' => true, '0' => false);
            $val = strtolower($this->getRequest()->getParam('suppress_error_codes', false));
            if(in_array($val, $haystack)){
                $val = $haystack[$val];
            }
            if((boolean)is_integer($val)?false:$val == 1){
                $this->getResponse()->setHttpResponseCode(200);
            }
        }
    }
}