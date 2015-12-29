<?php

namespace AppBundle\Tests\Service\Feed\Parser;

use AppBundle\Service\Feed\Parser\ProductParser;

/**
 * Test for AppBundle\Service\Parser\ProductParser.php
 */
class ProductParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for AppBundle\Service\Parser\ProductParser::parseNode
     */
    public function testParseNode()
    {
        $xml = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<product>
    <productID>1c company_ma509pu013043-stck1</productID>
    <name>1C Company Toccare (MA509PU013043) (MA509PU013043-STCK1)</name>
    <price currency="EUR">146.85</price>
    <productURL>http://www.centralpoint.nl/tracker/index.php?tt=534_251713_1_&amp;r=https%3A%2F%2F</productURL>
    <imageURL>http://www02.cp-static.com/images/pna_fo.jpg</imageURL>
    <description><![CDATA[ de doos open is geweest ]]></description>
    <categories>
        <category path="POS TERMINALS">POS TERMINALS</category>
        <category path="SUPER CATEGORY">SUPER CATEGORY</category>
    </categories>
    <additional>
        <field name="brand">1C Company</field>
        <field name="producttype">Toccare (MA509PU013043)</field>
        <field name="deliveryCosts">0.00</field>
        <field name="SKU">MA509PU013043-STCK1</field>
        <field name="brand_and_type">1C Company MA509PU013043-STCK1</field>
        <field name="stock">Op voorraad</field>
        <field name="thumbnailURL">http://www01.cp-static.com/images/pna.jpg</field>
        <field name="deliveryTime">1 werkdag</field>
        <field name="imageURLlarge">http://www03.cp-static.com/images/pna_fo.jpg</field>
        <field name="categoryURL">http://www.centralpoint.nl/pos-terminals/</field>
        <field name="EAN">0000000000000</field>
    </additional>
</product>
XML;

        $node = new \DOMDocument();
        $node->loadXML($xml);

        $product = array(
            'productID' => '1c company_ma509pu013043-stck1',
            'name' => '1C Company Toccare (MA509PU013043) (MA509PU013043-STCK1)',
            'price' => '146.85',
            'currency' => 'EUR',
            'description' => ' de doos open is geweest ',
            'categories' => array(
                'POS TERMINALS',
                'SUPER CATEGORY',
            ),
            'productURL' => 'http://www.centralpoint.nl/tracker/index.php?tt=534_251713_1_&r=https%3A%2F%2F',
            'imageURL' => 'http://www02.cp-static.com/images/pna_fo.jpg',
        );

        $parser = new ProductParser();
        $this->assertEquals($product, $parser->parseNode($node->firstChild));
    }
}
