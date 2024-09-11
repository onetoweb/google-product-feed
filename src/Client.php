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
     * Url Format.
     */
    public const URL_FORMAT = 'https://%s/feeds/google-shopping/%s';
    
    /**
     * @var string
     */
    private $domain;
    
    /**
     * @var string
     */
    private $feedKey;
    
    /**
     * @param string $domain
     * @param string $feedKey
     */
    public function __construct(string $domain, string $feedKey)
    {
        $this->domain = $domain;
        $this->feedKey = $feedKey;
    }
    
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return sprintf(self::URL_FORMAT, $this->domain, $this->feedKey);
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
