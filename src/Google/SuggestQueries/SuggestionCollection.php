<?php

namespace Google\SuggestQueries;

/**
 * Collection of suggestion results
 *
 * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
 */
class SuggestionCollection implements \ArrayAccess, \Countable
{

    /**
     * @var array
     */
    private $suggestions = array();

    /**
     * @param array $suggestions
     */
    public function __construct(array $suggestions)
    {
        $this->suggestions = $suggestions;
    }

    /**
     * Sort the suggestions by the num_queries field.
     *
     * This method clones the suggestions and does not modify the original.
     *
     * @return SuggestionCollection
     */
    public function sortByNumQueries()
    {
        $suggestions = $this->suggestions;

        usort($suggestions, function($a, $b) {
            if ($a['num_queries'] == $b['num_queries']) {
                return 0;
            }

            return ($a['num_queries'] > $b['num_queries']) ? -1 : 1;
        });

        return $suggestions;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->suggestions);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->suggestions[] = $value;
        } else {
            $this->suggestions[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->suggestions[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->suggestions[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return isset($this->suggestions[$offset]) ? $this->suggestions[$offset] : null;
    }

}
