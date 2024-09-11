.. title:: Index

===========
Basic Usage
===========

Setup

.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\GoogleProductFeed\Client;
    
    // params
    $domain = 'www.example.nl';
    $feedKey = '1bc29b36f623ba82aaf6724fd3b16718';
    
    // setup client
    $client = new Client($domain, $feedKey);


Get Products
````````````

.. code-block:: php
    
    $products = $client->products();
