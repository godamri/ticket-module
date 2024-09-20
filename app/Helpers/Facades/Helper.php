<?php
namespace App\Helpers\Facades;

use App\Helpers\Helper as HelperClass;
use Illuminate\Support\Facades\Facade;

class Helper extends Facade {    
    protected static function getFacadeAccessor()
    {
        return HelperClass::class;
    }
}