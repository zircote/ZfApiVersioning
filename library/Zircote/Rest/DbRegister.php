<?php
class Zircote_Rest_DbRegister
{
    const SORT   = 'SORT';
    const SEARCH = 'SEARCH';
    const PAGING = 'PAGING';
    const FIELDS = 'FIELDS';
    const ALLOW = 'ALLOW';
    /**
     *
     * @var Zircote_Rest_DbRegister
     */
    protected static $_instance;
    /**
     *
     * @var Zend_Db_Table_Select
     */
    protected $_select;
    /**
     *
     * @var array
     */
    protected $_config;
    protected function __construct ()
    {}
    /**
     *
     * @return Zircote_Rest_DbRegister
     */
    static public function getInstance ()
    {
        if (! self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     *
     * @param $key string
     * @param $value mixed
     * @return Zircote_Rest_DbRegister
     */
    public function set ($key, $value)
    {
        $this->_config[$key] = $value;
        return $this;
    }
    /**
     *
     * @param $key mixed
     */
    public function get ($key)
    {
        return @$this->_config[$key] ?  : false;
    }
    /**
     *
     * @return multitype:
     */
    public function getConfig()
    {
        return $this->_config;
    }
    /**
     *
     * @return Zend_Db_Table_Select
     */
    public function getSelect()
    {
        if(!$this->_select){
            $this->_select = new Zend_Db_Table_Select(
                Zend_Db_Table_Abstract::getDefaultAdapter()
            );
        }
        return $this->_select;
    }
    public function setSelect($select)
    {
        $this->_select = $select;
        return $this;
    }
    /**
     *
     * @return Zircote_Rest_DbRegister
     */
    public function prepareSort()
    {
        if(isset($this->_config[self::SORT])){
            foreach ($this->_config[self::SORT] as $sort) {
                $this->_select->order($sort);
            }
        }
        return $this;
    }
    /**
     *
     * @param  int $count
     * @param  int $limit
     * @param  int $offset
     * @return Zircote_Rest_DbRegister
     */
    public function setPaging($count)
    {
        $paging = $this->_config[self::PAGING]['request'];
        $this->_config[self::PAGING]['response'] = array(
            'count' => $count,
            'limit' => $paging['limit'],
            'offset' => $paging['offset']
        );
        return $this;
    }
    /**
     *
     * @return string
     */
    public function getSearch()
    {
        return $this->_config['search'];
    }
    /**
     *
     * @return Zircote_Rest_DbRegister
     */
    public function prepareFields()
    {
        if(isset($this->_config[self::FIELDS])){
            $this->_select->columns($this->_config[self::FIELDS]);
        } else {
            $this->_select->columns('*');
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Rest_DbRegister
     */
    public function preparePaging()
    {
        if(isset($this->_config[self::PAGING]['request'])){
            $paging = $this->_config[self::PAGING]['request'];
            $this->_select->limit($paging['limit'],$paging['offset']);
        }
        return $this;
    }
}