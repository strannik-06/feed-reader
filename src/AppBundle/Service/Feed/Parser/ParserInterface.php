<?php

namespace AppBundle\Service\Feed\Parser;

/**
 * Interface ParserInterface
 */
interface ParserInterface
{
    /**
     * @return string
     */
    public function getTagName();

    /**
     * @param \DOMNode $node
     *
     * @return array
     */
    public function parseNode(\DOMNode $node);
}
