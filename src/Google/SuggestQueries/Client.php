<?php

namespace Google\SuggestQueries;

use \InvalidArgumentException;

use Buzz\Client\Curl;
use Buzz\Client\ClientInterface;
use Buzz\Message\Request;
use Buzz\Message\Response;

/**
 * Simple client for the Google suggestqueries API
 *
 * @author  Joseph Wynn <joseph_wynn@ipcmedia.com>
 */
class Client
{

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var array
     */
    private $options = array(
        'base_url' => 'http://www.google.com/complete/search?output=toolbar'
    );

    /**
     * @param null|ClientInterface $client
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?: new Curl;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $name
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        return $this->options[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        $this->options[$name] = $value;
    }

    /**
     * Build a query URL
     *
     * @param  array $options
     * @return string
     */
    public function buildUrl(array $options = array())
    {
        return "{$this->options['base_url']}&q={$options['q']}";
    }

    /**
     * Get suggestions for the given query
     *
     * @param string $query
     * @return SuggestionCollection
     */
    public function getSuggestions($query)
    {
        $request = new Request('GET', $this->buildUrl(array('q' => $query)));
        $response = new Response;

        $this->client->send($request, $response);

        $results = new XMLSuggestions($response->getContent());

        return new SuggestionCollection($results->asArray());
    }

}
