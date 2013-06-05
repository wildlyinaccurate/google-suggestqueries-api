<?php

namespace Google\SuggestQueries;

class ClientIntegrationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group integration
     */
    public function resultsShouldBeReturnedFromGoogle()
    {
        $client = new Client;
        $client->getClient()->setProxy('proxyhost:8080');

        $suggestions = $client->getSuggestions('chesecake');

        $this->assertTrue(count($suggestions) > 0);
    }

}
