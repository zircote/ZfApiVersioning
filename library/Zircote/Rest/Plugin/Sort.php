<?php
/**
 * ?limit=2&offset=0&fields=id,email&sort=id(desc)
 * @author zircote
 * @version
 */
class Zircote_Rest_Plugin_Sort extends Zircote_Rest_Plugin_RestAbstract
{
    /**
     *
     * @var string
     */
    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';
    /**
     * (non-PHPdoc)
     * @see Zircote_Rest_Plugin_RestAbstract::setOptions()
     */
    public function setOptions($options)
    {
        if(isset($options['defaults'])){
            $options = $options['defaults'];
        }
        $this->_options = $options;
        return $this;
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Plugin_Abstract::postDispatch()
     */
    public function preDispatch($request)
    {
        if(null !== ($sort = $this->getRequest()->getParam('sort', null))){
            $data = $this->_getSort($sort);
            Zircote_Rest_DbRegister::getInstance()->set(
                Zircote_Rest_DbRegister::SORT, $data
            );
        }
    }
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
}