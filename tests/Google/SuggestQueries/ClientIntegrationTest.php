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
        if (isset($_ENV['TRAVIS'])) {
            $this->markTestSkipped('Not running full integration test on Travis');
        }

        $client = new Client;

        $suggestions = $client->getSuggestions('chesecake');

        $this->assertTrue(count($suggestions) > 0);
    }

}
