<?php

namespace Google\SuggestQueries;

class XMLSuggestionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException Google\SuggestQueries\Exception\XMLSuggestionsException
     */
    public function invalidXMLShouldRaiseAnException()
    {
        $suggestions = new XMLSuggestions($this->getFixtureData('invalid.xml'));
    }

    /**
     * @test
     */
    public function shouldConvertEmptyXMLToEmptyArray()
    {
        $suggestions = new XMLSuggestions($this->getFixtureData('no-results.xml'));

        $this->assertEquals(array(), $suggestions->asArray());
    }

    /**
     * @test
     */
    public function shouldCorrectlyConvertXMLToArray()
    {
        $suggestions = new XMLSuggestions($this->getFixtureData('chesecake.xml'));

        $this->assertEquals(array(
            array(
                'suggestion' => 'cheesecake factory',
                'num_queries' => '11000000',
            ),
            array(
                'suggestion' => 'cheesecake recipe',
                'num_queries' => '19000000',
            ),
            array(
                'suggestion' => 'cheesecake factory menu',
                'num_queries' => '2770000',
            ),
        ), $suggestions->asArray());
    }

    public function getFixtureData($fixture)
    {
        return file_get_contents(__DIR__ . "/Fixtures/{$fixture}");
    }

}
