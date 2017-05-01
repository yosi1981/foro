<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App\BBCode;

use Illuminate\Support\Facades\Facade;

class BBCodeFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'App\BBCode\BBCode';
    }
}