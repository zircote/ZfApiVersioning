<?php
class Application_Model_UserCollection extends ArrayObject
{
    /**
     * @return SimpleXMLElement
     */
    public function toXml()
    {
        $xml = new SimpleXMLElement('<users/>');
        /* @var $user Application_Model_User */
        foreach ($this->getIterator() as $k => $user){
            $xml->addChild('user');
            foreach ($user->toArray() as $key => $value) {
                $xml->user[$k]->addChild($key,$value);
            }
        }
        return $xml;
    }
    /**
     *
     * @param Application_Model_User $user
     */
    public function append(Application_Model_User $user)
    {
        parent::append($user);
    }
    /**
     *
     * @return array
     */
    public function toArray()
    {
        $result = array();
        foreach ($this->getArrayCopy() as $child) {
            $result[] = $child->toArray();
        }
        return $result;
    }
}