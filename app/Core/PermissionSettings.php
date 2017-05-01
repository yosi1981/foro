<?php

namespace App\Core;

use App\User\Permission;
use Illuminate\Database\Eloquent\Model;

class PermissionSettings extends Model {

    protected $fillable = ['id', 'name', 'category_id', 'order'];
    public $timestamps = false;

    /**
     * A permission has many sub-permissions
     * @return mixed
     */
    public function subPermissions()
    {
        return $this->hasMany(PermissionSettings::class, 'parent_id')->orderBy('order')->orderBy('name');
    }

    /**
     * Settings can have many permissions
     * @return mixed
     */
    public function settings()
    {
        return $this->hasMany(Permission::class)->orderBy('order', 'asc');
    }

    /**
     * Return all cached permission settings from database.
     * @return mixed
     */
    public static function getCached()
    {
        return Cache::rememberForever('permission_settings', function() {
           return  PermissionSettings::where('is_category', false)->orderBy('order')->lists('name', 'id');
        });
    }

    /**
     * Return all cached permission settings groups (categories) from database.
     * @return mixed
     */
    public static function getCachedGroups()
    {
        return Cache::rememberForever('permission_settings_groups', function (){
           return PermissionSettings::where('is_category', true)->orderBy('order')->with('subPermissions')->get();
        });
    }
}
