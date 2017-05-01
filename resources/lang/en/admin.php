<?php

return [
    'title' => 'Admin',
    'panel' => 'Admin Panel',

    'dashboard' => [
        'recent_updates'     => 'Recent Updates',
        'recent_forum_stats' => 'Recent forum stats includes the latest post and thread.',
        'recent'             => [
            'thread' => 'Most Recent Thread',
            'post'   => 'Most Recent Post',
        ],
        'note'               => [
            'title'                => 'Admin Note',
            'update_success'       => 'Admin note has been updated successfully',
            'visible_to_all_admin' => 'Visible to all admins',
        ],
    ],

    'pages' => [
        'title'                         => 'Manage Pages',
        'name'                          => 'Page Name/Title',
        'body'                          => 'Page Body',
        'slug'                          => 'Slug',
        'slug_helper'                   => 'The URL of this page will be:',
        'new'                           => 'New Page',
        'create'                        => 'Create a new page',
        'create_short'                  => 'Create Page',
        'edit'                          => 'Edit a page',
        'cannot_delete_system_required' => 'Sorry, that page is required by system so it cannot be deleted.',
        'create_success'                => 'The page has been created successfully!',
        'update_success'                => 'The page has been updated successfully!',
        'no_results'                    => 'No pages found.',
    ],

    'tools' => [
        'title' => 'Site Tools',
        'desc'  => 'You may use these tools to completely customize and modify your application. You can view your application stats, system info as well as how your application is doing health-wise.',
        'php'   => [
            'info'    => 'PHP Info',
            'version' => 'Version :version',
        ],

        'cache' => [
            'manager'         => 'Cache Manager',
            'name'            => 'Cache Name',
            'identifier'      => 'Identifier',
            'current_driver'  => 'Current Cache Driver',
            'not_found'       => 'Cache not found. Try recaching.',
            'recache'         => 'Recache',
            'view'            => 'View Cache',
            'recache_success' => 'Cache has been re-cached successfully.',
            'clear_success'   => 'Cache has been cleared. If applicable, it has been re-cached for better performance.',
        ],

        'health' => [
            'directory'        => 'Directory',
            'site'             => 'Site Health',
            'database_size'    => 'Database Size',
            'items_cached'     => 'Items Cached',
            'optimize_success' => 'Application has been optimized for fast performance.',
            'optimize'         => 'Optimize Performance',
            'fix'              => 'Fix Errors',
            'fix_desc'         => 'Fix errors such as users with missing roles, thread with missing icons, posts and such. <br>You can also fix forum with incorrect number of threads/posts.<br>This can take a few minutes depending on the size of your database.',
            'fix_success'      => 'The fix was successfully ran and a total of <b>:errors</b> errors have been fixed.',
        ],

        'database' => [
            'title'          => 'Rebuild Database',
            'rebuild'        => 'Rebuild',
            'sizes'          => 'Database Sizes',
            'sizes_desc'     => 'Here are all the tables in database and their sizes in megabytes.',
            'seed_success'   => 'Database has been rebuilt successfully.',
            'seed_desc'      => 'If some database tables are not responsive or are missing some important rows that came with the install, you may rebuild that specific table by using the database rebuild feature below. Using this will not modify or delete any old data, just attempt to fix the table by using the data that came with the fresh install.',
            'seed_not_found' => 'The database rebuild failed because the database seeder could not be found.',
        ],

        'stats' => [
            'title'   => 'Recount Stats',
            'recount' => 'Recount',
            'desc'    => 'You may recount any stats that may be off by their actual value. Please note that this process may take longer depending on the size of the database.',
        ],
    ],

    'role'       => [
        'name'                        => 'Role Name',
        'name_helper'                 => 'This is the name that is not seen by the user. It is used for internal purposes. This is sort of like a "slug" and must be unique.',
        'display_name'                => 'Display Name',
        'display_name_helper'         => 'This is the display name of the role. This is what the users will see.',
        'index'                       => 'All Roles',
        'view'                        => 'View Role',
        'edit'                        => 'Edit Role',
        'add'                         => 'Add Role',
        'edit_role'                   => 'Edit Role: ":role"',
        'delete'                      => 'Delete Role',
        'delete_success'              => 'Role has been deleted successfully.',
        'delete_error'                => 'Role cannot be deleted either because it is required by system or because it currently has users.',
        'system_required'             => 'System Required',
        'system_required_description' => 'This is a system required role. Therefore, it cannot be deleted and some edited permissions may not take effect.',
        'all'                         => 'All User Roles',
        'note'                        => 'System Roles cannot be deleted. The "admin" role has all permissions, regardless of what permissions you set. If you would like additional admin members with limited admin permissions, please add another user role.',
        'edit_permission'             => 'Edit Permissions: ":role"',
        'permission_update_success'   => 'Permissions have been updated successfully.',
    ],
    'permission' => [
        'title'                            => 'Permissions',
        'edit'                             => 'Edit Permission|Edit Permissions',
        'edit_permission'                  => 'Edit Permission: ":permission"',
        'view'                             => 'View Permissions',
        'display_name'                     => 'Display Name',
        'copy'                             => 'Copy Permissions',
        'parent'                           => 'Parent Permission',
        'system_required_cannot_be_edited' => 'System-required permissions cannot be edited. You can add your own permissions and use them in this application.',
        'parent_description'               => 'Select a Parent Permission Group in which this permission belongs to. When choosing permissions for a role, this permission will be displayed under that group.',
        'cannot_modify'                    => 'You cannot modify permissions required by system',
        'add'                              => 'Add Permission',
        'copy_description'                 => 'Select a role to copy existing permissions from the selected user group to this user group.',
        'update_success'                   => 'Permission has been updated successfully.',
        'create_success'                   => 'Permission has been created successfully.',
    ],

    'user' => [
        'create'           => 'Create User',
        'created'          => 'New user has been created successfully.',
        'delete'           => 'Delete User',
        'deleted'          => 'User has been deleted successfully.',
        'email'            => [
            'verify'       => 'Verify user\'s email address',
            'not_verified' => 'User\'s email has not been verified.',
            'verified'     => 'User\'s email has already been verified.',
        ],
        'deactivated'      => 'User\'s account is deactivated.',
        'activate_account' => 'Activate user\'s account',
        'edit_in_panel'    => 'Edit User in Admin Panel',
        'ip'               => [
            'address'      => 'IP Address',
            'registration' => 'Registration IP Address',
            'view_log'     => 'View IP Logs',
            'logs'         => 'IP Logs',
        ],

        'title' => [
            'title'                   => 'User Titles',
            'new'                     => 'New Title',
            'create'                  => 'Create Title',
            'form'                    => [
                'title'              => 'Title Name',
                'stars'              => 'Number of Stars',
                'stars_desc'         => 'Number of stars users in this user title will receive',
                'posts_required'     => 'Posts Required',
                'post_required_desc' => 'The number of posts required to receive this user title and the number of stars',
            ],
            'delete_all_will_disable' => 'Please note: Deleting all user titles will disable the use of user titles in the site.',
            'create_success'          => 'User title has been created successfully!',
            'update_success'          => 'User title has been updated successfully!',
            'delete_success'          => 'User title has been deleted successfully!',
            'none'                    => 'No user titles found.',
        ],
    ],

    'config' => [
        'title'          => 'Configuration',
        'update_success' => 'Settings have been saved successfully.',
    ],
];