<?php

namespace AppBundle\Service\Feed\Parser;

/**
 * Product Parser class
 */
class ProductParser implements ParserInterface
{
    /**
     * @return string
     */
    public function getTagName()
    {
        return 'product';
    }

    /**
     * @param \DOMNode $node
     *
     * @return array
     */
    public function parseNode(\DOMNode $node)
    {
        $product = array();
        /** @var \DOMNode $item */
        foreach ($node->childNodes as $item) {
            if (in_array($item->nodeName, array('productID', 'name', 'description', 'productURL', 'imageURL'))) {
                $product[$item->nodeName] = $item->nodeValue;
            } elseif ($item->nodeName == 'price') {
                $product['price'] = $item->nodeValue;
                $product['currency'] = $item->attributes->getNamedItem('currency')->nodeValue;
            } elseif ($item->nodeName == 'categories') {
                $product['categories'] = $this->parseCategories($item);
            }
        }

        return $product;
    }

    /**
     * @param \DOMNode $node
     *
     * @return array
     */
    private function parseCategories(\DOMNode $node)
    {
        $categories = array();
        /** @var \DOMNode $category */
        foreach ($node->childNodes as $category) {
            if ($category->nodeName == 'category') {
                $categories[] = $category->nodeValue;
            }
        }

        return $categories;
    }
}
