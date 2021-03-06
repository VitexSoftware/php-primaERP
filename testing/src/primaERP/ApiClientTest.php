<?php

namespace test\primaERP;

use primaERP\ApiClient;
use Test\ObjectForTesting;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-10-05 at 14:07:11.
 */
class ApiClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiClient
     */
    protected $object;
    public $clientConfig = [
        'company' => 'vitexsoftware',
        'url' => 'https://vitexsoftware.api.primaerp.com/',
        'user' => 'info@vitexsoftware.cz',
        'password' => 'erpjeprima',
        'debug' => true];

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object                  = new ApiClient();
        $section                       = $this->object->getSection();
        $this->clientConfig['section'] = $section;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testConstructor()
    {
        $classname = get_class($this->object);
        // Get mock, without the constructor being called
        $mock      = $this->getMockBuilder($classname)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $mock->__construct(1, ['debug' => false]);

        $mock->__construct('', $this->clientConfig);
    }

    /**
     * @covers primaERP\ApiClient::setUp
     */
    public function testSetUp()
    {
        $this->object->setUp(['section' => 'time']);
    }

    /**
     * @covers primaERP\ApiClient::curlInit
     */
    public function testCurlInit()
    {
        $this->object->curlInit();
        $this->assertInternalType('resource', $this->object->curl,
            'Eror initialising cURL');
    }

    /**
     * @covers primaERP\ApiClient::processInit
     */
    public function testProcessInit()
    {
        $this->object->processInit('1');
    }

    /**
     * @covers primaERP\ApiClient::setSection
     */
    public function testSetSection()
    {
        $this->object->setSection('time');
        $this->assertEquals('time', $this->object->getSection());
    }

    /**
     * @covers primaERP\ApiClient::getSection
     */
    public function testGetSection()
    {
        $this->object->setSection('time');
        $this->assertEquals('time', $this->object->getSection());
    }

    /**
     * @covers primaERP\ApiClient::object2array
     */
    public function testObject2array()
    {
        $this->assertNull($this->object->object2array(new \stdClass()));
        $this->assertEquals(
            [
            'item' => 1,
            'arrItem' => ['a', 'b' => 'c']
            ]
            , $this->object->object2array(new ObjectForTesting()));
        $this->assertEquals(
            [[
            'item' => 1,
            'arrItem' => ['a', 'b' => 'c']
            ]]
            , $this->object->object2array([new ObjectForTesting()]));
    }

    /**
     * @covers primaERP\ApiClient::setPostFields
     */
    public function testSetPostFields()
    {
        $this->object->setPostFields('ToPOST');
    }

    /**
     * @covers primaERP\ApiClient::getSectionURL
     */
    public function testGetSectionURL()
    {
        $this->object->setSection('test');
        $this->assertEquals('https://vitexsoftware.api.primaerp.com/v1/test',
            $this->object->getSectionURL());
    }

    /**
     * @covers primaERP\ApiClient::sectionUrlWithSuffix
     */
    public function testSectionUrlWithSuffix()
    {
        $this->object->setSection('test');
        $this->assertEquals('https://vitexsoftware.api.primaerp.com/v1/test/SomeParams',
            $this->object->sectionUrlWithSuffix('SomeParams'));
    }

    /**
     * @covers primaERP\ApiClient::updateApiURL
     */
    public function testUpdateApiURL()
    {
        $this->object->section = 'unknown';
        $this->object->updateApiURL();
        $this->assertEquals('https://vitexsoftware.api.primaerp.com/v1/unknown',
            $this->object->apiURL);
    }

    /**
     * @covers primaERP\ApiClient::requestData
     * @todo   Implement testRequestData().
     */
    public function testRequestData()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::authentication
     */
    public function testAuthentication()
    {
        $this->object->authentication(); 
        $this->assertNotEmpty($this->object->defaultUrlParams['token'] );
    }

    /**
     * @covers primaERP\ApiClient::addUrlParams
     */
    public function testAddUrlParams()
    {
        $this->assertEquals('http://vitexsoftware.cz/path?id=1&a=b',
            $this->object->addUrlParams('http://vitexsoftware.cz/path?a=b',
                ['id' => 1], TRUE));
    }

    /**
     * @covers primaERP\ApiClient::addDefaultUrlParams
     */
    public function testAddDefaultUrlParams()
    {
        $this->assertEquals('http://vitexsoftware.cz?a=b',
            $this->object->addDefaultUrlParams('http://vitexsoftware.cz?a=b'));
        $this->object->defaultUrlParams['id'] = 1;
        $this->assertEquals('http://vitexsoftware.cz/path?a=b&id=1',
            $this->object->addDefaultUrlParams('http://vitexsoftware.cz/path?a=b'));
    }

    /**
     * @covers primaERP\ApiClient::rawResponseToArray
     */
    public function testRawResponseToArray()
    {
        $this->assertEquals(array(1, -2, 3.333, 4e17, "abc", "á\n", null, array(
                2.1, 2.2, array("2.2.1")), false, true, "", "key" => "value", 'abc"def' => array()),
            $this->object->rawResponseToArray('{
    "0": 1,
    "1": -2,
    "2": 3.333,
    "3": 4.0e+17,
    "4": "abc",
    "5": "\u00e1\n",
    "6": null,
    "7": [
        2.1,
        2.2,
        [
            "2.2.1"
        ]
    ],
    "8": false,
    "9": true,
    "10": "",
    "key": "value",
    "abc\"def": []
}
'));
        $this->assertEmpty($this->object->rawResponseToArray('No Json - Error'));
    }

    /**
     * @covers primaERP\ApiClient::parseResponse
     * @todo   Implement testParseResponse().
     */
    public function testParseResponse()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::parseError
     * @todo   Implement testParseError().
     */
    public function testParseError()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::doCurlRequest
     */
    public function testDoCurlRequest()
    {
        $this->object->debug = true;
        $this->object->doCurlRequest('http://nonexistent.comain.wtf', 'OPTIONS');
    }

    /**
     * @covers primaERP\ApiClient::loadFromAPI
     * @todo   Implement testLoadFromAPI().
     */
    public function testLoadFromAPI()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::logResult
     */
    public function testLogResult()
    {
        $this->object->lastResult = ['code' => 'OK', 'message' => 'test','description'=>'just test'];
        $this->object->logResult();
    }

    /**
     * @covers primaERP\ApiClient::getTokenString
     */
    public function testGetTokenString()
    {
        $this->assertNotEmpty($this->object->getTokenString());
    }

    /**
     * @covers primaERP\ApiClient::ignore404
     */
    public function testIgnore404()
    {
        $this->object->ignore404(true);
        $this->assertTrue($this->object->ignore404());
    }

    /**
     * @covers primaERP\ApiClient::disconnect
     */
    public function testDisconnect()
    {
        $this->object->disconnect();
        $this->assertNull($this->object->curl);
    }

    /**
     * @covers primaERP\ApiClient::__wakeup
     */
    public function test__wakeup()
    {
        $this->object->__wakeup();
        $this->testCurlInit();
    }

    /**
     * @covers primaERP\ApiClient::__destruct
     */
    public function test__destruct()
    {
        $this->object->__destruct();
        $this->testDisconnect();
    }
}
