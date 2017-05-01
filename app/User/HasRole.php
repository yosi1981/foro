<?php

namespace App\User;

use App\Forum\Thread;
use Carbon\Carbon;

/**
 * A trait for all user roles and permissions.
 * Used in the Users model.
 * Class HasRole
 *
 * @package App\User
 */
trait HasRole {

    /**
     * Belongs to Many relationship - A role belongs to many users
     *
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->where('user_id', $this->id);
    }

    public function getRolesListAttribute()
    {
        return $this->roles->lists('display_name', 'id')->toArray();
    }

    public function additionalRoles()
    {
        if ($this->primaryRole) {
            return $this->belongsToMany(Role::class)->where('id', '!=', $this->primaryRole->id);
        }
        return $this->belongsToMany(Role::class);
    }

    public function primaryRole()
    {
        return $this->hasOne(Role::class, 'id', 'primary_role');
    }

    /**
     * A user has many roles.
     * Check if user has one or many roles
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {

        // If the user is banned and has additional roles, return false for those roles so that
        // the permissions for the banned roles work 100%
        if ($this->isBanned()) {
            if (is_string($role) && $role != 'banned') {
                return false;
            }
        }

        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !!$role->intersect($this->roles)->count();
    }

    /**
     * Return boolean if the user is admin or not
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is moderator
     *
     * @return mixed
     */
    public function isModerator()
    {
        return ($this->can('user-role-is-moderator') || $this->hasRole('moderator'));
    }

    /**
     * Check if the user is banned
     *
     * @return bool
     */
    public function isBanned()
    {
        $ban = $this->ban;
        // If ban has already been expired, lift the ban.
        if ($ban && $ban->getOriginal('expires_at') <= Carbon::now()) {
            $ban->lift();
        }
        return !!$ban;
    }

    /**
     * Determine if the user can mass moderate posts.
     * This includes:
     * - Junking/Restoring Post
     * - Permanently Deleting Post
     * - Hide/Show Signature
     *
     * @return bool
     */
    public function canModeratePost()
    {
        if (user()->can('forum-moderate-junk-post')
            || user()->can('forum-moderate-junked-post')
            || user()->can('forum-moderate-delete-post')
            || user()->can('forum-moderate-thread')
        )
            return true;
        return false;
    }

    /**
     * Determine if the user can mass moderate threads
     * This includes:
     * - Junking/Restoring Threads
     * - Permanently Deleting Threads
     * - Locking/Unlocking Threads
     * - Pinning/Unpinning Threads
     *
     * @param Thread $thread
     * @return bool
     */
    public function canModerateThread(Thread $thread)
    {
        if (
            user()->can('junkThread', $thread)
            || user()->can('restoreJunkedThread', $thread)
            || user()->can('deleteThread', $thread)
            || user()->can('lock', $thread)
            || user()->can('pin', $thread)
        )
            return true;
        return false;
    }

    public function canUseReplyOptions()
    {
        return user()->can('forum-use-signature') || user()->can('forum-moderate-thread');
    }

    /**
     * Assign a role to user
     *
     * @param $role
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function assign($role)
    {
        if (is_string($role)) {
            return $this->roles()->save(Role::whereName($role)->firstOrFail());
        }
        return $this->roles()->save($role);
    }
}