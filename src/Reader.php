<?php

namespace Onetoweb\GoogleProductFeed;

use Onetoweb\GoogleProductFeed\Options;
use DOMDocument;
use DOMElement;

/**
 * Google Product Feed Reader.
 */
class Reader
{
    /**
     * @var string
     */
    private $source;
    
    /**
     * Options with default values.
     * 
     * @var array
     */
    private $options = [
        Options::PRICE_AS_FLOAT => false,
        Options::AVAILABILITY_AS_BOOL => false,
    ];
    
    /**
     * @param string $source
     * @param array $options = []
     */
    public function __construct(string $source, array $options = [])
    {
        $this->source = $source;
        $this->options = array_merge($this->options, $options);
    }
    
    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }
    
    /**
     * @param string $price
     * @return float|NULL
     */
    public static function getPrice(?string $price): ?float
    {
        if ($price !== null) {
            
            // remove currency code and return float
            return (float) str_replace(['.', ','], ['', '.'], substr($price, 0, -4));
        }
        
        return null;
    }
    
    /**
     * @param DOMElement $node
     * @return string|float|null[]
     */
    private function readAttr(DOMElement $node): array
    {
        $result = [];
        
        foreach ($node->childNodes as $childNode) {
            
            if (count($childNode->childNodes) > 1) {
                $result[$childNode->localName] = $this->readAttr($childNode);
            } elseif ($this->options[Options::PRICE_AS_FLOAT] and str_ends_with($childNode->localName, 'price')) {
                $result[$childNode->localName] = self::getPrice($childNode->nodeValue);
            } elseif ($this->options[Options::AVAILABILITY_AS_BOOL] and $childNode->localName === 'availability') {
                $result[$childNode->localName] = (bool) ($childNode->nodeValue === 'in_stock');
            } else {
                $result[$childNode->localName] = (string) $childNode->nodeValue;
            }
        }
        
        return $result;
    }
    
    /**
     * @return array
     */
    public function products(): array
    {
        // read feed
        $feedContents = file_get_contents($this->getSource());
        
        $doc = new DOMDocument();
        $doc->loadXML($feedContents);
        
        $products = [];
        foreach ($doc->getElementsByTagName('item') as $item) {
            
            $product = $this->readAttr($item);
            
            $products[] = $product;
        }
        
        return $products;
    }
}
