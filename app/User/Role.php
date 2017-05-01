<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function assign(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    public function allUsersCount()
    {
        return $this->users->isEmpty() ?: $this->users->count();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function hasPermission($permission)
    {
        if (is_string($permission->name)) {
            return $this->permissions->contains('name', $permission->name);
        }
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function getInfoAttribute()
    {
        return strip_tags($this->display_name, '<img>');
    }

    public static function getList()
    {
        return \Cache::rememberForever('roles_name', function () {
            return static::orderBy('display_name')->lists('display_name', 'id');
        });
    }

    public static function getListArray()
    {
        return static::getList()->toArray();
    }

    public function updateRole($request)
    {
        $this->allUsersCount();
        $this->name = $request->input('name');
        $this->display_name = $request->input('display_name');
        $this->description = $request->input('description');
        $this->save();
    }

    public static function getBannedRoleId()
    {
        return self::whereName('banned')->first()->id;
    }
}
