<?php

return [

    'title'          => 'Moderation',
    'dashboard'      => 'Dashboard',
    'options'        => 'Moderation Options',
    'junked'         => 'Junked',
    'actions'        => 'Actions',
    'select_action'  => 'Select Action',
    'select_all'     => 'Select all',
    'with_selected'  => 'With Selected...',
    'after_posting'  => 'after posting',
    'invalid_action' => 'You have selected an invalid action.',
    'signature'      => [
        'hide' => 'Hide Signature in Posts',
        'show' => 'Show Signature in Posts',
    ],
    'thread'         => [
        'delete'        => 'Delete Thread|Delete Threads',
        'perm_delete'   => 'Permanently Delete Thread|Permanently Delete Threads',
        'junk'          => 'Junk Thread|Junk Threads',
        'junked'        => 'This thread is junked. Only users with permissions to manage junk threads can see it.',
        'restore'       => 'Restore Thread|Restore Threads',
        'pin'           => 'Pin Thread|Pin Threads',
        'lock'          => 'Lock Thread|Lock Threads',
        'unpin'         => 'Unpin Thread|Unpin Threads',
        'unlock'        => 'Unlock Thread|Unlock Threads',
        'move'          => 'Move Thread|Move Threads',
        'select_all'    => 'Select all threads',
        'with_selected' => 'With selected threads...',
        'with_thread'   => 'With thread...',
    ],
    'post'           => [
        'perm_delete'   => 'Permanently Delete Post|Permanently Delete Posts',
        'junk'          => 'Junk Post|Junk Posts',
        'restore'       => 'Restore Post|Restore Posts',
        'select'        => 'Select Post #:number',
        'select_all'    => 'Select all posts',
        'with_selected' => 'With selected posts...',
    ],
    'banned'         => [
        'title'            => 'Ban Users',
        'ban'              => 'Ban',
        'ban_user'         => 'Ban User',
        'create'           => 'Ban a User',
        'all'              => 'Banned Users',
        'search_ban'       => 'Search and Ban User',
        'expiry'           => 'Expiry Date',
        'expiry_desc'      => 'Length of time the user should be banned for.',
        'custom_date'      => 'Custom Date',
        'custom_date_desc' => 'Select a custom date.',
        'length'           => 'Length',
        'reason'           => 'Reason',
        'by'               => 'Banned By',
        'on'               => 'Banned On',
        'updated'          => 'Ban Updated',
        'edit'             => 'Edit Ban',
        'update'           => 'Update Ban',
        'delete'           => 'Delete Ban',
        'delete_success'   => 'Ban has been deleted successfully.',
        'update_success'   => 'Ban has been updated successfully.',
        'not_banned'       => 'That user has not been banned.',
        'none'             => 'There are no banned users.',
    ],
    'report'         => [
        'reported'       => 'Reported Posts',
        'delete'         => 'Delete Report|Delete Reports',
        'delete_all'     => 'Delete All Reports',
        'delete_success' => 'All reports have been deleted successfully.',
        'view_all'       => 'View All Reports',
        'view_new'       => 'View New Reports',
        'no_results'     => 'There are no reported posts',
        'last_report'    => 'Last Report',
        'not_found'      => 'That report cannot be found.',
    ],
    'note'           => [
        'title'               => 'Moderation Notes',
        'updated'             => 'Mod note has been updated successfully.',
        'last_updated'        => 'Last Updated',
        'visible_to_all_mods' => 'Visible to all moderators',
    ],
    'user'           => [
        'title'                => 'Manage Users',
        'view'                 => 'View ":user"',
        'edit'                 => 'Edit ":user"',
        'search'               => 'Search for a user...',
        'edit_in_panel'        => 'Edit User in Mod Panel',
        'suspend_signature'    => 'Suspend user\'s privilege to edit or add a signature and hide signature on all their posts',
        'suspend_posts'        => 'Suspend user\'s privilege to create new posts',
        'suspend_threads'      => 'Suspend user\'s privilege to create new threads',
        'note_on_user'         => [
            'label' => 'Note on user',
            'desc'  => 'You can make any notes that you wish to make on this user here. This note will be shown to all moderators and admin if they are viewing this user.',
        ],
        'private_announcement' => [
            'label' => 'Private Announcement',
            'desc'  => 'User will see an alert on every page on this site if you set a private announcement for user.',
        ],
    ],
];