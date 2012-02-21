<?php
/**
 *
 * @author zircote
 * @version
 */
class Zircote_Rest_Plugin_Paging extends Zircote_Rest_Plugin_RestAbstract
{
    /**
     *
     * @var int
     */
    protected $_limit = 10;
    /**
     *
     * @var int
     */
    protected $_offset = 0;
    /**
     * (non-PHPdoc)
     * @see Zircote_Rest_Plugin_RestAbstract::setOptions()
     */
    public function setOptions($options)
    {
        if(isset($options['defaults'])){
            $options = $options['defaults'];
            if(isset($options['limit'])){
                $this->_limit = $options['limit'];
            }
            if(isset($options['offset'])){
                $this->_limit = $options['offset'];
            }
        }
        return $this;
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Plugin_Abstract::preDispatch()
     */
    public function preDispatch()
    {
        $data = array(
            'request' => array(
                'offset' => $this->getRequest()->getParam('offset', $this->_offset),
                'limit' => $this->getRequest()->getParam('limit', $this->_limit)
            )
        );
        Zircote_Rest_DbRegister::getInstance()->set(
            Zircote_Rest_DbRegister::PAGING, $data
        );
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Plugin_Abstract::postDispatch()
     *
     */
    public function postDispatch($request)
    {
        if(!$this->getResponse()->isException()){
            $data = Zircote_Rest_DbRegister::getInstance()
                ->get(Zircote_Rest_DbRegister::PAGING);
            if(isset($data['response'])){
                $count = $limit = $offset = 0;
                extract($data['response']);
                if(($offset+$limit)){
                $this->getResponse()
                    ->setHeader(
                        'Range', sprintf('%s-%s/%s',($offset+1),($offset+$limit),$count)
                    )->setHttpResponseCode(206);
                }
            }
        }
    }
};