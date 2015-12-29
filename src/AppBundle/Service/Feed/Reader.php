<?php

namespace AppBundle\Service\Feed;

use AppBundle\Service\Feed\Parser\ParserInterface;

/**
 * Feed Reader Service.
 */
class Reader
{
    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param string  $xmlPath
     * @param integer $start
     * @param integer $amount
     *
     * @return array
     */
    public function processXml($xmlPath, $start = 0, $amount = 100)
    {
        $xmlDocumentsCount = 0;
        $items = array();

        try {
            $xmlDocument = $this->getXmlDocument($xmlPath);
            while ($xmlDocument->read() && $this->isBetween($xmlDocumentsCount, $start, $amount)) {
                if ($this->isTargetElement($xmlDocument)) {
                    $xmlDocumentsCount++;

                    if ($xmlDocumentsCount > $start) {
                        $items[] = $this->parser->parseNode($xmlDocument->expand());
                    }
                }
            }
            $xmlDocument->close();
        } catch (\Exception $e) {
            // todo: add displaying errors
            //$this->logger->error($e->getMessage() . "\n" . $e->getTraceAsString());
        }
        //file_put_contents(__DIR__.'/test.txt', $xmlDocumentsCount . PHP_EOL, FILE_APPEND);
        //file_put_contents(__DIR__.'/test.txt', count($items).' - '.round(memory_get_usage(true) / 1000000, 3).PHP_EOL, FILE_APPEND);

        return $items;
    }

    /**
     * @param string $xmlPath
     *
     * @return \XMLReader
     * @throws \Exception
     */
    protected function getXmlDocument($xmlPath)
    {
        $xmlReader = new \XMLReader();
        $opened = $xmlReader->open($xmlPath);
        if (!$opened) {
            throw new \Exception('File on url ' . $xmlPath . ' cannot be opened');
        }

        return $xmlReader;
    }

    /**
     * @param int $xmlDocumentsCount
     * @param int $start
     * @param int $amount
     *
     * @return bool
     */
    protected function isBetween($xmlDocumentsCount, $start, $amount)
    {
        return !($amount != 0 && $xmlDocumentsCount >= $start + $amount);
    }

    /**
     * @param \XMLReader $xmlDocument
     *
     * @return bool
     */
    protected function isTargetElement($xmlDocument)
    {
        return $xmlDocument->nodeType == \XMLReader::ELEMENT && $xmlDocument->name == $this->parser->getTagName();
    }
}
