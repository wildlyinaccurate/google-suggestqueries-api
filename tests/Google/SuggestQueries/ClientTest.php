<?php

namespace Google\SuggestQueries;

use Google\SuggestQueries\Mock\TestCurl;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function shouldBuildCorrectQueryURL()
    {
        $client = new Client;
        $baseUrl = $client->getOption('base_url');

        $this->assertEquals("{$baseUrl}&q=something", $client->buildUrl(array('q' => 'something')));
    }

    /**
     * @test
     */
    public function shouldQueryAPIAndBuildASuggestionCollection()
    {
        $curl = new TestCurl;
        $curl->setResponseContent(file_get_contents(__DIR__ . '/Fixtures/chesecake.xml'));

        $client = new Client($curl);
        $suggestions = $client->getSuggestions('chesecake');

        $this->assertCount(3, $suggestions);

        $this->assertEquals(array(
            'suggestion' => 'cheesecake factory',
            'num_queries' => '11000000',
        ), $suggestions[0]);

        $this->assertEquals(array(
            'suggestion' => 'cheesecake recipe',
            'num_queries' => '19000000',
        ), $suggestions[1]);

        $this->assertEquals(array(
            'suggestion' => 'cheesecake factory menu',
            'num_queries' => '2770000',
        ), $suggestions[2]);
    }

    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client;

        $this->assertInstanceOf('Buzz\Client\Curl', $client->getClient());
    }

    /**
     * @test
     */
    public function shouldPassHttpClientInterfaceToConstructor()
    {
        $client = new Client($this->getClientMock());

        $this->assertInstanceOf('Buzz\Client\ClientInterface', $client->getClient());
    }

    /**
     * @test
     */
    public function shouldSetBaseUrlOption()
    {
        $client = new Client;
        $originalBaseUrl = $client->getOption('base_url');

        $client->setOption('base_url', 'http://www.google.com/');
        $this->assertEquals('http://www.google.com/', $client->getOption('base_url'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldRaiseExceptionWhenSettingInvalidOption()
    {
        $client = new Client;
        $client->setOption('invalid_option', 'lorem ipsum');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldRaiseExceptionWhenGettingInvalidOption()
    {
        $client = new Client;
        $client->getOption('invalid_option');
    }

    public function getClientMock(array $methods = array())
    {
        $methods = array_merge(
            array('get'),
            $methods
        );

        return $this->getMock('Buzz\Client\Curl', $methods);
    }

}
