<?php

namespace Onetoweb\GoogleProductFeed;

/**
 * Options.
 */
final class Options
{
    /**
     * price_as_float: (bool, default=false) removes currency code and converts prices to floats.
     */
    public const PRICE_AS_FLOAT = 'price_as_float';
    
    /**
     * availability_as_bool: (bool, default=false) convert the availability value to boolean (true == 'in_stock').
     */
    public const AVAILABILITY_AS_BOOL = 'availability_as_bool';
}