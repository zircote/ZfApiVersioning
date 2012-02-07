<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package ZfApiVersion
 * @subpackage V2
 *
 *
 */
class V2_Service_User extends Zircote_Service_ServiceAbstract
{
    /**
     *
     * @var Application_Model_Mapper_Users
     */
    protected $_mapper;
    /**
     *
     * @param array|Zend_Config $options
     */
    public function __construct($options = array())
    {
        $this->_mapper = new Application_Model_Mapper_Users();
        parent::__construct($options);
    }
    /**
     *
     * @return Application_Model_UserCollection
     */
    public function fetchAllUsers()
    {
        if(!$this->getCache()->load(__METHOD__)){
            $data = $this->_mapper->getUsers();
            $this->getCache()->save($data, __METHOD__);
        }
        return $data;
    }
    /**
     *
     * @param integer $id
     * @return Application_Model_User
     */
    public function fetchUserById($id)
    {
        $key = str_replace('::', '_', __METHOD__ . "_{$id}");
        if(!$this->getCache()->load($key)){
            $user = new Application_Model_User(array('id' => $id));
            $data = $this->_mapper->getUserById($user);
            $this->getCache()->save($data, $key);
        }
        return $data;
    }
    /**
     *
     * @param Application_Model_User $user
     * @return Application_Model_User
     */
    public function saveUser(Application_Model_User $user)
    {
        return $this->_mapper->updateUser($user);
    }
    /**
     *
     * @param Applicaiton_Model_User $user
     * @return Application_Model_User
     */
    public function createUser(Applicaiton_Model_User $user)
    {
        return $this->_mapper->addUser($user);
    }
    /**
     *
     * @param Application_Model_User $user
     * @return Ambigous <number, number>
     */
    public function deleteUser(Application_Model_User $user)
    {
        return $this->_mapper->deleteUser($user);
    }
}