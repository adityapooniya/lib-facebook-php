<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'setup.php');
require_once(LIB_FACEBOOK_PATH . DIRECTORY_SEPARATOR . 'LibFacebook.php');

/**
 * Test class for LibFacebook.
 * Generated by PHPUnit on 2012-04-15 at 19:29:07.
 */
class LibFacebookTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var LibFacebook
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = LibFacebook::getInstance();

        $this->object->getApi()->setAccessToken(USER_ACCESS_TOKEN);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers LibFacebook::getInstance
     */
    public function testGetInstanceIsSingleton()
    {
        $this->assertEquals($this->object, LibFacebook::getInstance());

        $this->object->setApiConfig(array());

        $this->assertEquals($this->object, LibFacebook::getInstance());
    }

    /**
     * @covers LibFacebook::getApi
     */
    public function testGetApi()
    {
        $api = $this->object->getApi();
        $this->assertInstanceOf('Facebook', $api);
    }

    /**
     * @covers LibFacebook::getApi
     */
    public function testGetApiIsSingleton()
    {
        $api = $this->object->getApi();

        $this->object->getApi()->setAccessToken('12345');

        $this->assertEquals($api->getAccessToken(), '12345');

        $this->assertEquals(
            spl_object_hash($api), spl_object_hash($this->object->getApi())
        );
    }

    /**
     * @covers LibFacebook::getUser
     */
    public function testGetUser()
    {
        $connection = $this->object->getUser('105699866131371');
        $this->assertInstanceOf('LibFacebook_Connection_User', $connection);
    }

    /**
     * @covers LibFacebook::getById
     */
    public function testGetById()
    {
        $connection = $this->object->getById('105699866131371');
        $this->assertTrue(class_exists('LibFacebook_Connection_Abstract'));
        $this->assertInstanceOf('LibFacebook_Connection_Abstract', $connection);
    }

    /**
     * @covers LibFacebook::generateConnection
     */
    public function testGenerateConnectionByUserData()
    {
        $json = file_get_contents(LIB_FACEBOOK_TEST_PATH . DIRECTORY_SEPARATOR . 'data/userdata.txt');

        $data = json_decode(utf8_encode($json), false);

        $connection = LibFacebook::generateConnection($data);

        $this->assertTrue(class_exists('LibFacebook_Connection_User'));
        $this->assertInstanceOf('LibFacebook_Connection_User', $connection);

    }

    /**
     * @covers LibFacebook::generateConnection
     */
    public function testGenerateConnectionByGenericSummaryData()
    {
        $json = file_get_contents(LIB_FACEBOOK_TEST_PATH . DIRECTORY_SEPARATOR . 'data/userdata.txt');

        $data = json_decode(utf8_encode($json), false);

        unset($data->type);

        $connection = LibFacebook::generateConnection($data);

        $this->assertTrue(class_exists('LibFacebook_Connection_Summary'));
        $this->assertInstanceOf('LibFacebook_Connection_Summary', $connection);

    }

    /**
     * @covers LibFacebook::generateConnection
     */
    public function testGenerateConnectionByPageData()
    {
        $json = file_get_contents(LIB_FACEBOOK_TEST_PATH . DIRECTORY_SEPARATOR . 'data/pagedata.txt');

        $data = json_decode(utf8_encode($json), false);

        $connection = LibFacebook::generateConnection($data);

        $this->assertTrue(class_exists('LibFacebook_Connection_Page'));
        $this->assertInstanceOf('LibFacebook_Connection_Page', $connection);
    }
}
?>