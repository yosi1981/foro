<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App\Providers;

use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Routing\Router;

class ResourceNoPrefixRegistrar extends ResourceRegistrar {

    public function __construct(Router $router)
    {
        parent::__construct($router);
    }

    /**
     * Get the resource name for a grouped resource.
     *
     * @param  string $prefix
     * @param  string $resource
     * @param  string $method
     * @return string
     */
    protected function getGroupResourceName($prefix, $resource, $method)
    {
        return trim("{$prefix}{$resource}.{$method}", '.');
    }
}