<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model {

    /**
     * Return the admin sidebar menu
     * @return array
     */
    public static function adminMenu()
    {

        $setting_groups = [];
        foreach (Cache::grab('setting_groups') as $setting) {
            $setting_groups[] = [
                'name' => $setting->name,
                'icon' => $setting->icon,
                'url'  => route('admin.config.index', $setting->id),
            ];
        }

        return [
            [
                'name' => 'Dashboard',
                'icon' => 'fa fa-home',
                'url'  => route('admin.index'),
            ],
            [
                'name' => 'Users',
                'icon' => 'fa fa-users',
                'url'  => route('admin.user.index'),
                [
                    [
                        'name' => 'All Users',
                        'icon' => 'fa fa-list',
                        'url'  => route('admin.user.index'),
                    ],
                    [
                        'name' => 'New User',
                        'icon' => 'fa fa-user-plus',
                        'url'  => route('admin.user.create'),
                    ],
                    [
                        'name' => 'Banned Users',
                        'icon' => 'fa fa-ban',
                        'url'  => route('mod.banned.index'),
                        [
                            [
                                'name' => 'Ban a User',
                                'icon' => 'fa fa-user-times',
                                'url'  => route('mod.banned.create'),
                            ],
                            [
                                'name' => 'Banned Users',
                                'icon' => 'fa fa-list',
                                'url'  => route('mod.banned.index'),
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'User Roles',
                'icon' => 'fa fa-shield',
                'url'  => route('admin.role.index'),
                [
                    [
                        'name' => 'View Roles',
                        'icon' => 'fa fa-list',
                        'url'  => route('admin.role.index'),
                    ],
                    [
                        'name' => 'New Role',
                        'icon' => 'fa fa-plus',
                        'url'  => route('admin.role.create'),
                    ],
                    [
                        'name' => 'Permissions',
                        'icon' => 'fa fa-circle-o',
                        'url'  => route('admin.role.permission.index'),
                    ],
                    [
                        'name' => 'New Permission',
                        'icon' => 'fa fa-plus-circle',
                        'url'  => route('admin.role.permission.create'),
                    ],
                ],
            ],
            [
                'name' => 'User Titles',
                'icon' => 'fa fa-font',
                'url'  => route('admin.title.index'),
                [
                    [
                        'name' => 'View Titles',
                        'icon' => 'fa fa-align-justify',
                        'url'  => route('admin.title.index'),
                    ],
                    [
                        'name' => 'New Title',
                        'icon' => 'fa fa-plus',
                        'url'  => route('admin.title.create'),
                    ],
                ],
            ],
            [
                'name' => 'Forum',
                'icon' => 'fa fa-comments',
                'url'  => route('admin.forum.index'),
                [
                    [
                        'name' => 'View Forums',
                        'icon' => 'fa fa-list-alt',
                        'url'  => route('admin.forum.index'),
                    ],
                    [
                        'name' => 'New Forum',
                        'icon' => 'fa fa-plus',
                        'url'  => route('admin.forum.create'),
                    ],
                ],
            ],

            [
                'name' => 'Pages',
                'icon' => 'fa fa-file',
                'url'  => route('admin.page.index'),
                [
                    [
                        'name' => 'Manage Pages',
                        'icon' => 'fa fa-files-o',
                        'url'  => route('admin.page.index'),
                    ],
                    [
                        'name' => 'Create Page',
                        'icon' => 'fa fa-plus',
                        'url'  => route('admin.page.create'),
                    ],
                ],
            ],
            [
                'name' => trans('admin.config.title'),
                'icon' => 'fa fa-gear',
                'url'  => route('admin.config.index'),
                $setting_groups,
            ],
            [
                'name' => 'Tools',
                'icon' => 'fa fa-wrench',
                'url'  => route('admin.tools.index'),
                [
                    [
                        'name' => 'Site Health',
                        'icon' => 'fa fa-medkit',
                        'url'  => route('admin.tools.site.health'),
                    ],
                    [
                        'name' => 'Cache Manager',
                        'icon' => 'fa fa-hdd-o',
                        'url'  => route('admin.tools.cache.manager'),
                    ],
                    [
                        'name' => 'PHP Info',
                        'icon' => 'fa fa-info',
                        'url'  => route('admin.tools.php.info'),
                    ],
                    [
                        'name' => 'Rebuild Database',
                        'icon' => 'fa fa-database',
                        'url'  => route('admin.tools.database.rebuild'),
                    ],
                    [
                        'name' => 'Recount Stats',
                        'icon' => 'fa fa-list-ol',
                        'url'  => route('admin.tools.stats.recount'),
                    ],
                ],
            ],
        ];
    }
}
