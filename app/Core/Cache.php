<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App\Core;

use App\Forum\Forum;
use App\Forum\ReportedPost;
use App\Forum\UserTitle;
use App\User\Role;
use Log;

/**
 * This class extends to the main \Cache class to add more features to the already available Cache class.
 *
 * Class Cache
 *
 * @package App\Core
 */
class Cache extends \Cache {

    /**
     * Grab a cache and if it does not exist, cache it and return the cache
     * @param $cache_name
     * @return bool|mixed
     */
    public static function grab($cache_name)
    {
        $cache = Cache::get($cache_name);
        return $cache ?: self::newCache($cache_name);
    }


    /**
     * Recache a cache after forgetting it
     * @param      $cache_name
     * @param bool $value
     */
    public static function recache($cache_name, $value = false)
    {
        self::forget($cache_name);
        if ($value) {
            Cache::rememberForever($cache_name, function() use ($value) {
               return $value;
            });
        } else {
            self::newCache($cache_name);
        }
    }

    /**
     * All the system-required cache names that are used by application.
     * The names and description is shown in admin panel.
     * @return \Illuminate\Support\Collection
     */
    public static function cacheNames()
    {
        return collect([
            [
                'name'        => 'Forums',
                'identifier'  => 'forums',
                'description' => 'Cache all forums and subforums for faster retrieval and faster page load',
            ],
            [
                'name'        => 'Roles Name',
                'identifier'  => 'roles_name',
                'description' => 'Cache all roles display name and its ID',
            ],
            [
                'name'        => 'Permission Settings',
                'identifier'  => 'permission_settings',
                'description' => 'Cache permission settings and their name and ID',
            ],
            [
                'name'        => 'Permission Settings Groups',
                'identifier'  => 'permission_settings_groups',
                'description' => 'Cache permission setting groups (all permission setting categories) with their "sub-permissions"',
            ],
            [
                'name'        => 'Setting Groups',
                'identifier'  => 'setting_groups',
                'description' => 'Cache setting groups for site configuration',
            ],
            [
                'name'        => 'Settings',
                'identifier'  => 'settings',
                'description' => 'Cache site settings which is used throughout the site (such as enable/disable forum, registration, etc)',
            ],
            [
                'name'        => 'Forum User Titles',
                'identifier'  => 'user_titles',
                'description' => 'Cache forum user titles like newbie and starter.',
            ],
            [
                'name'        => 'Route',
                'identifier'  => 'route',
                'description' => 'Clear the route cache and recache if necessary.',
                'remove_only' => true
            ],
            [
                'name'        => 'Views',
                'identifier'  => 'views',
                'description' => 'Clear the cache that is used by all views. Site may be slow while it recaches when users visit pages.',
                'remove_only' => true
            ],
            [
                'name'        => 'Config',
                'identifier'  => 'config',
                'description' => 'Clear the config cache that is used to config the site and recache if necessary.',
                'remove_only' => true
            ],
            [
                'name'        => 'Compiled',
                'identifier'  => 'compiled',
                'description' => 'Clear the compiled files by application.',
                'remove_only' => true
            ],
        ]);
    }

    /**
     * Add a new cache
     * @param $cache_name
     * @return bool|mixed
     */
    public static function newCache($cache_name)
    {
        if (method_exists(Cache::class, $cache_name)) {
            $cache_method = new Cache();
            return $cache_method->storeInCache($cache_name);
        }
        return Log::alert('Cache name does not exist!', ['cache_name' => $cache_name]);
    }

    /**
     * Store a specific cache and remember it forever
     * @param $cache_name
     * @return mixed
     */
    public function storeInCache($cache_name)
    {
        return \Cache::rememberForever($cache_name, function () use ($cache_name) {
            return $this->$cache_name();
        });
    }

    /**
     * Cache all forums with their subforums (children)
     * @return mixed
     */
    public function forums()
    {
        return Forum::with('children')->where('parent_id', false)->orderBy('order')->get();
    }

    /**
     * Cache all user role names
     * @return mixed
     */
    public function roles_name()
    {
        return Role::orderBy('display_name')->lists('display_name', 'id');
    }

    /**
     * Cache all permission settings
     * @return mixed
     */
    public function permission_settings()
    {
        return PermissionSettings::where('is_category', false)->orderBy('order')->lists('name', 'id');
    }

    /**
     * Cache all permission setting groups
     * @return mixed
     */
    public function permission_settings_groups()
    {
        return PermissionSettings::where('is_category', true)->orderBy('order')->with('subPermissions')->get();
    }

    /**
     * Cache all site setting groups
     * @return mixed
     */
    public function setting_groups()
    {
        return SettingGroup::where('is_category', true)->orderBy('order')->get(['id', 'name', 'icon']);
    }

    /**
     * Cache all site-settings.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function settings()
    {
        return Setting::all();
    }

    /**
     * Cache all user titles to be used in forums (such as Member, Top poster, etc)
     * @return mixed
     */
    public function user_titles()
    {
        return UserTitle::orderBy('posts', 'asc')->get();
    }

    /**
     * Cache the total number of reported posts
     * @return int
     */
    public function reported_posts_count()
    {
        return ReportedPost::all()->count();
    }

}