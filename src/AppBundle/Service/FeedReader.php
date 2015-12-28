<?php

namespace AppBundle\Service;

/**
 * Feed Reader Service
 */
class FeedReader
{
    /**
     * @param string $xmlPath
     *
     * @return array
     */
    public function processXml($xmlPath)
    {
        $start = 0;
        $amount = 100;
        $xmlDocumentsCount = 0;
        $items = array();

        try {
            $xmlDocument = $this->getXmlDocument($xmlPath);
            while ($xmlDocument->read() && $this->isBetween($xmlDocumentsCount, $start, $amount)) {
                if ($this->isTargetElement($xmlDocument)) {
                    $xmlDocumentsCount++;

                    if ($xmlDocumentsCount > $start) {
                        $node = $xmlDocument->expand();
                        $children = $node->childNodes;
                        file_put_contents(__DIR__.'/test.txt', var_export($children, true) . PHP_EOL, FILE_APPEND);
                        /** @var \DOMNode $item */
                        foreach ($node->childNodes as $item) {
                            $a = 1;
                            /*$items[] = array(
                                'id' => $this->getValue($xmlNode, './productID'),
                                'name' => $this->getValue($xmlNode, './name'),
                                'snippet' => $this->getValue($xmlNode, './description'),
                            );*/
                        }
                    }
                }
            }
            $xmlDocument->close();
        } catch (\Exception $e) {
            // todo: add displaying errors
            //$this->logger->error($e->getMessage() . "\n" . $e->getTraceAsString());
        }
        file_put_contents(__DIR__.'/test.txt', $xmlDocumentsCount . PHP_EOL, FILE_APPEND);
        file_put_contents(__DIR__.'/test.txt', count($items).' - '.round(memory_get_usage(true) / 1000000, 3).PHP_EOL, FILE_APPEND);

        return $items;
    }

    /**
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
     * {@inheritdoc}
     */
    protected function isTargetElement($xmlDocument)
    {
        return $xmlDocument->nodeType == \XMLReader::ELEMENT && $xmlDocument->name == 'product';
    }
}
