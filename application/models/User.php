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
class Application_Model_User
{
    /**
     *
     * @var int
     */
    protected $_id;
    /**
     *
     * @var string
     */
    protected $_email;
    /**
     *
     * @var string
     */
    protected $_firstname;
    /**
     *
     * @var string
     */
    protected $_lastname;
    /**
     *
     * @param array $user
     */
    public function __construct($user = array())
    {
        $this->fromArray($user);
    }
    /**
     *
     * @param array $user
     * @return Application_Model_User
     */
    public function fromArray(array $user)
    {
        if(isset($user['id'])){
            $this->_id = $user['id'];
        }
        if(isset($user['email'])){
            $this->_email = $user['email'];
        }
        if(isset($user['firstname'])){
            $this->_firstname = $user['firstname'];
        }
        if(isset($user['lastname'])){
            $this->_lastname = $user['lastname'];
        }
        return $this;
    }
    /**
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->_id,
            'email' => $this->_email,
            'firstname' => $this->_firstname,
            'lastname' => $this->_lastname
        );
    }
    public function toXml()
    {
        $xml = new SimpleXMLElement('<user></user>');
        foreach ($this->toArray() as $key => $value) {
            $xml->addChild($key, $value);
        }
        return $xml;
    }
    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
	/**
     * @return string
     */
    public function getEmail ()
    {
        return $this->_email;
    }

	/**
     * @return string
     */
    public function getFirstname ()
    {
        return $this->_firstname;
    }

	/**
     * @return string
     */
    public function getLastname ()
    {
        return $this->_lastname;
    }
    /**
     *
     * @param int $id
     * @return Application_Model_User
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }
    /**
     * @param string $email
     * @return Application_Model_User
     */
    public function setEmail ($email)
    {
        $this->_email = $email;
        return $this;
    }


    /**
     * @param string $firstname
     * @return Application_Model_User
     */
    public function setFirstname ($firstname)
    {
        $this->_firstname = $firstname;
        return $this;
    }


    /**
     * @param string $lastname
     * @return Application_Model_User
     */
    public function setLastname ($lastname)
    {
        $this->_lastname = $lastname;
        return $this;
    }

}

