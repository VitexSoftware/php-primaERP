<?php

namespace test\primaERP;

use primaERP\ApiClient;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-10-05 at 14:07:11.
 */
class ApiClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiClient
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ApiClient();
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
        $section   = $this->object->getSection();

        // Get mock, without the constructor being called
        $mock = $this->getMockBuilder($classname)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $mock->__construct(1, ['debug' => false]);

        $mock->__construct('',
            [
            'company' => 'vitexsoftware',
            'url' => 'https://vitexsoftware.api.primaerp.com/',
            'user' => 'info@vitexsoftware.cz',
            'password' => 'erpjeprima',
            'debug' => true,
            'evidence' => $section]);
    }

    /**
     * @covers primaERP\ApiClient::setUp
     * @todo   Implement testSetUp().
     */
    public function testSetUp()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::curlInit
     * @todo   Implement testCurlInit().
     */
    public function testCurlInit()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::processInit
     * @todo   Implement testProcessInit().
     */
    public function testProcessInit()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::setSection
     * @todo   Implement testSetSection().
     */
    public function testSetSection()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::getSection
     * @todo   Implement testGetSection().
     */
    public function testGetSection()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::object2array
     * @todo   Implement testObject2array().
     */
    public function testObject2array()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::objectToID
     * @todo   Implement testObjectToID().
     */
    public function testObjectToID()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::setPostFields
     * @todo   Implement testSetPostFields().
     */
    public function testSetPostFields()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::getSectionURL
     * @todo   Implement testGetSectionURL().
     */
    public function testGetSectionURL()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::sectionUrlWithSuffix
     * @todo   Implement testSectionUrlWithSuffix().
     */
    public function testSectionUrlWithSuffix()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::updateApiURL
     * @todo   Implement testUpdateApiURL().
     */
    public function testUpdateApiURL()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
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
     * @todo   Implement testAuthentication().
     */
    public function testAuthentication()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::addUrlParams
     * @todo   Implement testAddUrlParams().
     */
    public function testAddUrlParams()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::addDefaultUrlParams
     * @todo   Implement testAddDefaultUrlParams().
     */
    public function testAddDefaultUrlParams()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::rawResponseToArray
     * @todo   Implement testRawResponseToArray().
     */
    public function testRawResponseToArray()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
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
     * @todo   Implement testDoCurlRequest().
     */
    public function testDoCurlRequest()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::xml2array
     * @todo   Implement testXml2array().
     */
    public function testXml2array()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
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
     * @todo   Implement testLogResult().
     */
    public function testLogResult()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::getTokenString
     * @todo   Implement testGetTokenString().
     */
    public function testGetTokenString()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::ignore404
     * @todo   Implement testIgnore404().
     */
    public function testIgnore404()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::disconnect
     * @todo   Implement testDisconnect().
     */
    public function testDisconnect()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::__wakeup
     * @todo   Implement test__wakeup().
     */
    public function test__wakeup()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers primaERP\ApiClient::__destruct
     * @todo   Implement test__destruct().
     */
    public function test__destruct()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}