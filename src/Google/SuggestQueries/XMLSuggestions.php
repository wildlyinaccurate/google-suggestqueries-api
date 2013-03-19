<?php

namespace Google\SuggestQueries;

use Google\SuggestQueries\Exception\XMLSuggestionsException;

/**
 * XML representation of query suggestions
 *
 * @author  Joseph Wynn <joseph_wynn@ipcmedia.com>
 */
class XMLSuggestions
{

    /**
     * @var string
     */
    private $xml;

    /**
     * @var DOMDocument
     */
    private $document;

    /**
     * @param string $xml
     *
     * @throws XMLSuggestionException
     */
    public function __construct($xml)
    {
        $this->xml = $xml;
        $this->document = new \DOMDocument;

        if (! @$this->document->loadXML($this->xml)) {
            throw new XMLSuggestionsException('Invalid XML supplied.');
        }
    }

    /**
     * Build an array of suggestions from the XML
     *
     * @return array
     */
    public function asArray()
    {
        $suggestions = array();

        foreach ($this->document->getElementsByTagName('CompleteSuggestion') as $completeSuggestion) {
            $suggestion = $completeSuggestion->getElementsByTagName('suggestion')->item(0);
            $numQueries = $completeSuggestion->getElementsByTagName('num_queries')->item(0);

            if ($suggestion && $numQueries) {
                $suggestions[] = array(
                    'suggestion' => $suggestion->getAttribute('data'),
                    'num_queries' => $numQueries->getAttribute('int'),
                );
            }
        }

        return $suggestions;
    }

}
