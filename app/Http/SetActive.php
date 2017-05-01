<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App\Http;


use Request;

class SetActive {

    /**
     * Check if the current url is contained in the path.
     * If so, return the active class
     * E.g. The "Forum" menu link should be active if the user is viewing a thread, because the Forum URL
     * is http://example.com/forum and the thread URL is http://example.com/forum/thread/example-thread
     * Notice, they are both in http://example.com/forum.
     *
     * If this is the case, you return an active class.
     * @param         $path
     * @param string  $class
     * @return string
     */
    public function all($path, $class = 'class=active')
    {
        return str_contains(Request::url(), $path) ? $class : '';
    }

}