<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package ZfApiVersion
 * @subpackage Application
 *
 *
 */
class Application_Model_Mapper_Users
{
    /**
     *
     * @var string
     */
    const TABLE_NAME = 'users';
    /**
     *
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;
    /**
     *
     */
    public function __construct()
    {
        $this->_db = Zend_Db_Table_Abstract::getDefaultAdapter();
    }
    /**
     *
     * @param Application_Model_User $user
     * @return Application_Model_User
     */
    public function addUser(Application_Model_User $user)
    {
        $bind = $user->toArray();
        unset($bind['id']);
        $this->_db->insert(self::TABLE_NAME, $bind);
        $user->setId($this->_db->lastInsertId(self::TABLE_NAME));
        return $this->getUserById($user);
    }
    /**
     *
     * @param Application_Model_User $user
     * @return Application_Model_User
     */
    public function getUserById(Application_Model_User $user)
    {
        $sql = $this->_db->select()
            ->from(self::TABLE_NAME, array_keys($user->toArray()))
            ->where('id = :id');
        $result = $this->_db->fetchRow($sql, array('id' => $user->getId()));
        $user->fromArray($result);
        return $user;
    }
    /**
     *
     * @param Application_Model_User $user
     * @return Application_Model_User
     */
    public function updateUser(Application_Model_User $user)
    {
        $this->_db->update(self::TABLE_NAME, $user->toArray(), 'id = :id');
        return $this->getUserById($user);
    }
    /**
     *
     * @param Application_Model_User $user
     * @return number
     */
    public function deleteUser(Application_Model_User $user)
    {
        $where = $this->_db
            ->quoteInto('id = :id', array('id' => $user->getId()));
        return $this->_db->delete(self::TABLE_NAME, $where);
    }
    /**
     *
     * @return Application_Model_UserCollection
     *
     */
    public function getUsers()
    {
        $sql = $this->_db->select()->from(self::TABLE_NAME);
        $users = $this->_db->fetchAll($sql);
        $result = new Application_Model_UserCollection;
        foreach ($users as $user) {
            $result->append(new Application_Model_User($user));
        }
        return $result;
    }
    /**
     *
     * @return number
     */
    public function count()
    {
        $sql = $this->_db->select()
            ->from(self::TABLE_NAME, new Zend_Db_Expr('count(*)'));
        return (int) $this->_db->fetchOne($sql);
    }
}