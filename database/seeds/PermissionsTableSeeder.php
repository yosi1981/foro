<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name'                   => 'user-edit-username',
                'display_name'           => 'Edit username',
                'permission_settings_id' => 10,
                'order'                  => 1,
            ],
            [
                'name'                   => 'user-edit-email',
                'display_name'           => 'Edit email',
                'permission_settings_id' => 10,
                'order'                  => 2,
            ],
            [
                'name'                   => 'user-edit-about-me',
                'display_name'           => 'Set and edit "about me"',
                'permission_settings_id' => 11,
                'order'                  => 1,
            ],

            [
                'name'                   => 'user-search-for-users',
                'display_name'           => 'Search for other users',
                'permission_settings_id' => 11,
                'order'                  => 1,
            ],

            [
                'name'                   => 'forum-access',
                'display_name'           => 'Access Forum',
                'permission_settings_id' => 7,
                'order'                  => -1,
            ],
            [
                'name'                   => 'forum-access-when-disabled',
                'display_name'           => 'Access Forum when forum is disabled',
                'permission_settings_id' => 7,
                'order'                  => 0 ,
            ],
            [
                'name'                   => 'forum-use-signature',
                'display_name'           => 'Use signature',
                'description'            => 'Signature will be visible on all posts and user will be able edit/update it anytime.',
                'permission_settings_id' => 7,
                'order'                  => 2,
            ],
            [
                'name'                   => 'forum-user-title-custom',
                'display_name'           => 'Set custom user-title to be displayed',
                'permission_settings_id' => 7,
                'order'                  => 3,
            ],

            [
                'name'                   => 'forum-view-thread',
                'display_name'           => 'View threads',
                'permission_settings_id' => 8,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-create-thread',
                'display_name'           => 'Create threads',
                'permission_settings_id' => 8,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-edit-thread',
                'display_name'           => 'Edit threads',
                'permission_settings_id' => 8,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-lock-thread',
                'display_name'           => 'Lock and unlock threads',
                'permission_settings_id' => 8,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-pin-thread',
                'display_name'           => 'Pin and unpin threads',
                'permission_settings_id' => 8,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-junk-thread',
                'display_name'           => 'Junk threads',
                'permission_settings_id' => 8,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-delete-thread',
                'display_name'           => 'Permanently delete threads',
                'permission_settings_id' => 8,
                'order'                  => 0,
            ],


            [
                'name'                   => 'forum-reply',
                'display_name'           => 'Reply to a thread',
                'permission_settings_id' => 9,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-edit-post',
                'display_name'           => 'Edit posts',
                'permission_settings_id' => 9,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-junk-post',
                'display_name'           => 'Junk posts',
                'permission_settings_id' => 9,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-report-post',
                'display_name'           => 'Report posts',
                'permission_settings_id' => 9,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-junk-posts-when-thread-locked',
                'display_name'           => 'Junk posts if thread locked',
                'description'            => 'Users will be able to junk posts even if the thread is locked',
                'permission_settings_id' => 9,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-see-last-edited-info',
                'display_name'           => 'See last edited information',
                'description'            => 'Users will be able to see that a post was edited (if edited)',
                'permission_settings_id' => 9,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-see-last-edited-user',
                'display_name'           => 'See the user who last edited a post',
                'description'            => 'Please note: Users must be able to see the last edited information to see this.',
                'permission_settings_id' => 9,
                'order'                  => 0,
            ],


            [
                'name'                   => 'user-role-is-moderator',
                'display_name'           => 'Users are moderators',
                'description'            => 'User having this role are moderators and can access moderation panel and do actions assigned for moderators',
                'permission_settings_id' => 6,
                'order'                  => -1,
            ],
            [
                'name'                   => 'moderate-edit-user-forum-info',
                'display_name'           => 'Edit forum information',
                'description'            => 'Users can edit forum info  of other users such as signature and other forum settings in moderation panel.',
                'permission_settings_id' => 6,
                'order'                  => 0,
            ],
            [
                'name'                   => 'moderate-edit-user-account-info',
                'display_name'           => 'Edit account information',
                'description'            => 'Users can edit account info of other users which includes username and email.',
                'permission_settings_id' => 6,
                'order'                  => 0,
            ],
            [
                'name'                   => 'moderate-edit-user-general-info',
                'display_name'           => 'Edit general information',
                'description'            => 'Users can edit general info of other users such as timezone and about me.',
                'permission_settings_id' => 6,
                'order'                  => 0,
            ],
            [
                'name'                   => 'moderate-edit-user-suspend-privileges',
                'display_name'           => 'Suspend privileges',
                'description'            => 'Users can suspend user\'s privilege to create a new post, thread or use a signature.',
                'permission_settings_id' => 6,
                'order'                  => 0,
            ],
            [
                'name'                   => 'moderate-edit-user-private-announcement',
                'display_name'           => 'Add/Update private announcement',
                'permission_settings_id' => 6,
                'order'                  => 0,
            ],
            [
                'name'                   => 'moderate-ban-user',
                'display_name'           => 'Ban other users',
                'permission_settings_id' => 6,
                'order'                  => 0,
            ],


            [
                'name'                   => 'forum-moderate-thread',
                'display_name'           => 'Moderate threads',
                'description'            => 'Moderate everyone\'s threads (junk, lock and reply to locked threads)',
                'permission_settings_id' => 4,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-pin-thread',
                'display_name'           => 'Pin/unpin threads',
                'permission_settings_id' => 4,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-lock-thread',
                'display_name'           => 'Lock/unlock threads',
                'permission_settings_id' => 4,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-hard-lock-thread',
                'display_name'           => 'Hard-lock/unlock threads',
                'description'            => 'Hard-locking threads means locking threads without them being able to unlock it.',
                'permission_settings_id' => 4,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-hard-pin-thread',
                'display_name'           => 'Hard-pin/unpin threads',
                'description'            => 'Hard-pinning threads means pinning threads without them being able to unpin it.',
                'permission_settings_id' => 4,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-delete-thread',
                'display_name'           => 'Permanently delete threads',
                'permission_settings_id' => 4,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-junk-thread',
                'display_name'           => 'Junk threads',
                'permission_settings_id' => 4,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-junked-thread',
                'display_name'           => 'View junked threads and restore/permanently delete them',
                'permission_settings_id' => 4,
                'order'                  => 0,
            ],


            [
                'name'                   => 'forum-moderate-reported-post',
                'display_name'           => 'Access reported threads',
                'description'            => 'Access reported threads/posts in the moderation panel to appropriate actions. Please note, users must be able to moderate threads before being able to take actions against reported threads.',
                'permission_settings_id' => 5,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-delete-post',
                'display_name'           => 'Permanently delete posts',
                'permission_settings_id' => 5,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-junk-post',
                'display_name'           => 'Junk posts',
                'permission_settings_id' => 5,
                'order'                  => 0,
            ],
            [
                'name'                   => 'forum-moderate-junked-post',
                'display_name'           => 'View junked posts and restore/permanently delete them',
                'permission_settings_id' => 5,
                'order'                  => 0,
            ],
            [
                'name'                   => 'view-user-ip-addresses',
                'display_name'           => 'View IP Address of users',
                'permission_settings_id' => 11,
                'order'                  => 0,
            ],
            [
                'name'                   => 'view-last-active-time',
                'display_name'           => 'View other user\'s last active time',
                'permission_settings_id' => 11,
                'order'                  => 0,
            ],
        ];
        foreach ($permissions as $permission) {
            \App\User\Permission::firstOrCreate(array_merge($permission, ['system_required' => 1]));
        }
    }
}
