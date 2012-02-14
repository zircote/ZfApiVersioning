<?php
class Zircote_Db_RestAdapter
{
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;
    protected function __call($method_name, $param_arr)
    {
        if(method_exists($this->_db, $method_name)){
            return call_user_func_array(array($this->_db, $method_name), $param_arr);
        } else {
            throw new Exception(sprintf('method does not exist[%s]', $method_name));
        }
    }

    public static function __callStatic($method_name, $param_arr)
    {
        if(method_exists($this->_db, $method_name)){
            return forward_static_call_array(
                array($this->_db, $method_name), $param_arr
            );
        } else {
            throw new Exception(sprintf('method does not exist[%s]', $method_name));
        }
    }
}