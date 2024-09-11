<?php

namespace Onetoweb\GoogleProductFeed;

use DOMDocument;
use DOMElement;

/**
 * Google Product Feed Client.
 */
class Client
{
    /**
     * @var string
     */
    private $url;
    
    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }
    
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
    
    /**
     * @param DOMElement $node
     * @return string[]
     */
    private function readAttr(DOMElement $node): array
    {
        $result = [];
        
        foreach ($node->childNodes as $childNode) {
            $result[$childNode->localName] = count($childNode->childNodes) > 1 ? $this->readAttr($childNode) : (string) $childNode->nodeValue;
        }
        
        return $result;
    }
    
    /**
     * @return array
     */
    public function products(): array
    {
        // read feed
        $feedContents = file_get_contents($this->getUrl());
        
        $doc = new DOMDocument();
        $doc->loadXML($feedContents);
        
        $products = [];
        foreach ($doc->getElementsByTagName('item') as $item) {
            
            $products[] = $this->readAttr($item);
        }
        
        return $products;
    }
}
