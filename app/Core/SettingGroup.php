<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App\Core;

use Illuminate\Database\Eloquent\Model;

class SettingGroup extends Model
{
    protected $table = 'settings_groups';
    public $timestamps = false;

    /**
     * Get all groups from cache
     */
    public function scopeGetGroups()
    {
        Cache::grab('setting_groups');
    }

    /**
     * A setting group has many sub-setting groups
     * @return mixed
     */
    public function subGroups()
    {
        return $this->hasMany(SettingGroup::class, 'parent_id')->orderBy('order')->orderBy('name')->with('settings');
    }

    /**
     * A setting group has many settings
     * @return mixed
     */
    public function settings()
    {
        return $this->hasMany(Setting::class, 'settings_group_id')->orderBy('order')->orderBy('name');
    }
}
