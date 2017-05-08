<?php

namespace ChemLab\Helpers;

use Illuminate\Support\Facades\Facade;

class HtmlFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'htmlex';
    }
}