<?php

namespace App\Policies;

use App\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{

    use HandlesAuthorization;

    /**
     * If user can search an admin
     *
     * @param User $logged_user
     * @param      $admin_user
     * @return bool
     */
    public function searchAdmin(User $logged_user, $admin_user)
    {
        if ($admin_user->isAdmin() && $logged_user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * User can edit user
     *
     * @param User $user
     * @return bool
     */
    public function editUsername(User $user)
    {
        return $user->can('user-edit-username') || $this->moderateEditAccountInfo($user);
    }

    /**
     * User can edit email address
     *
     * @param User $user
     * @return bool
     */
    public function editEmail(User $user)
    {
        return $user->can('user-edit-email') || $this->moderateEditAccountInfo($user);
    }

    /**
     * User can edit signature
     *
     * @param User $user
     * @return bool
     */
    public function editSignature(User $user)
    {
        return $user->can('forum-use-signature') || $this->moderateEditForumInfo($user);
    }

    /**
     * User can edit about me
     *
     * @param User $user
     * @return bool
     */
    public function editAboutMe(User $user)
    {
        return $user->can('user-edit-about-me') || $this->moderateEditGeneralInfo($user);
    }

    /**
     * Moderator can edit the account info
     *
     * @param User $user
     * @return bool
     */
    public function moderateEditAccountInfo(User $user)
    {
        return $user->can('moderate-edit-user-account-info');
    }

    /**
     * Moderator can edit general info
     *
     * @param User $user
     * @return bool
     */
    public function moderateEditGeneralInfo(User $user)
    {
        return $user->can('moderate-edit-user-general-info');
    }

    /**Moderator can edit forum info
     *
     * @param User $user
     * @return bool
     */
    public function moderateEditForumInfo(User $user)
    {
        return $user->can('moderate-edit-user-forum-info');
    }

    /**
     * Moderator can suspend user's privileges
     *
     * @param User $user
     * @return bool
     */
    public function moderateSuspendPrivileges(User $user)
    {
        return $user->can('moderate-edit-user-suspend-privileges');
    }

    /**
     * Moderator can edit and create private announcements that will be shown to user on all pages
     *
     * @param User $user
     * @return bool
     */
    public function moderateEditPrivateAnnouncement(User $user)
    {
        return $user->can('moderate-edit-user-private-announcement');
    }

    /**
     * User can view the last active user
     *
     * @param User $user
     * @return bool
     */
    public function viewLastActiveUser(User $user)
    {
        return ($user->can('view-last-active-time') || $user->isModerator());
    }

}
