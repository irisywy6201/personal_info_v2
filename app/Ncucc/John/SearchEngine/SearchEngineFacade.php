<?php

namespace App\Ncucc\John\SearchEngine;

use Illuminate\Support\Facades\Facade;

class SearchEngineFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'SearchEngine'; }
}