<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class Common extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'common';
    }
}
