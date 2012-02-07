<?php
/**
 *
 *
 * @author Robert Allen <rallen@ifbyphone.com>
 * @package V2
 * @subpackage Tests
 *
 *
 */
class V2_UsersControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }
    /**
     * @group V2
     */
    public function testGetAction()
    {
        $params = array('controller' => 'Users', 'module' => 'v2');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->getRequest()->setMethod('get');
        $this->dispatch($url .'/4');
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction('get');
        $actual = $this->getResponse()->getBody();
        /* Is it a JSON Header? */
        $this->assertHeaderContains('Content-Type', 'application/json');
        /* is it a 200 status code? */
        $this->assertEquals('200', $this->getResponse()->getHttpResponseCode());
        /* Is the body what we expect? */
        $expected = array (
            'lastname' => 'Allen',
            'id' => 4,
            'email' => 'zircote@gmail.com',
            'firstname' => 'Robert'
        );
        $this->assertEquals($expected, Zend_Json::decode($actual));
    }


}



