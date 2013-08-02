<?php

namespace Google\SuggestQueries\Mock;

use Buzz\Client\Curl;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

/**
 * Mock for Buzz\Client\Curl
 *
 * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
 */
class TestCurl extends Curl
{

    /**
     * @var string
     */
    private $responseContent = '';

    /**
     * @param string $content
     */
    public function setResponseContent($content)
    {
        $this->responseContent = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function send(RequestInterface $request, MessageInterface $response)
    {
        $response->setContent($this->responseContent);
    }

}
