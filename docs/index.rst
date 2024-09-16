.. title:: Index

===========
Basic Usage
===========

Setup

.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\GoogleProductFeed\Reader;
    use Onetoweb\GoogleProductFeed\Options;
    
    // as source param you can use a url
    $source = 'https://www.example.nl/feeds/google-shopping/feed.rss';
    
    // or use a local file as source
    $source = '/path/to/feed.rss';
    
    // options (optional)
    $options = [
        Options::PRICE_AS_FLOAT => false,
        Options::AVAILABILITY_AS_BOOL => false
    ];
    
    // setup client
    $reader = new Reader($source, $options);


Get Products
````````````

.. code-block:: php
    
    $products = $reader->products();
