<?php

namespace App\User;

use App\Core\PermissionSettings;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $fillable = ['name', 'display_name', 'permission_settings_id', 'order'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function updateInfo($request)
    {
        $this->name = $request->input('name');
        $this->display_name = $request->input('display_name');
        $this->description = $request->input('description');
        $this->order = $request->input('order');
        $this->permission_settings_id = $request->input('permission_settings_id');
        $this->save();
    }
}
