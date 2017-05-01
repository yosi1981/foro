<?php

/**
 * Return values from the Site table from database
 *
 * @param $name
 * @return mixed
 */
function site($name)
{
    try {
        $site = App\Core\Cache::grab('settings');
        foreach ($site as $config) {
            if ($config->name == $name) {
                return $config->value;
            }
        }
    } catch (\Exception $ex) {
        // Do Nothing
    }
}

/**
 * Handles flash (one-time-session) messages.
 *
 * @param null $message
 * @return \Illuminate\Foundation\Application|mixed
 */
function flash($message = null)
{
    $flash = app(App\Http\Flash::class);
    if (func_num_args() == 0) {
        return $flash;
    }
    return $flash->success($message);
}

/**
 * Mark a link as active in navigation bar or wherever else its called.
 *
 * @param null   $path
 * @param string $nav
 * @return \Illuminate\Foundation\Application|mixed|string
 */
function setActive($path = null, $nav = 'class=active')
{
    $set_active = app(App\Http\SetActive::class);
    if (func_num_args() == 0) {
        return $set_active;
    }
    return Request::url() === $path ? $nav : '';
}