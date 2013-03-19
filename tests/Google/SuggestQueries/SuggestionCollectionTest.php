<?php

namespace Google\SuggestQueries;

class SuggestionCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function isCountable()
    {
        $collection = new SuggestionCollection(array(1, 2, 3));

        $this->assertCount(3, $collection);
    }

    /**
     * @test
     */
    public function collectionCanBeSortedByNumQueries()
    {
        $data = array(
            array(
                'suggestion' => 'cheesecake',
                'num_queries' => 100,
            ),
            array(
                'suggestion' => 'cheesecake burger',
                'num_queries' => 80,
            ),
            array(
                'suggestion' => 'cheese burger',
                'num_queries' => 180,
            ),
        );

        $collection = new SuggestionCollection($data);

        $expectedSorted = array(
            array(
                'suggestion' => 'cheese burger',
                'num_queries' => 180,
            ),
            array(
                'suggestion' => 'cheesecake',
                'num_queries' => 100,
            ),
            array(
                'suggestion' => 'cheesecake burger',
                'num_queries' => 80,
            ),
        );

        $this->assertEquals($expectedSorted, $collection->sortByNumQueries());
    }

}
