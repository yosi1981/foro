<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'name'              => 'user-validation-username',
                'display_name'      => 'Validation for "username" field',
                'value'             => 'required|min:3|max:15|alpha_dash',
                'order'             => 10,
                'settings_group_id' => 5,
                'type'              => 'text',
            ],
            [
                'name'              => 'user-validation-email',
                'display_name'      => 'Validation for "email" field',
                'value'             => 'required|email',
                'order'             => 10,
                'settings_group_id' => 5,
                'type'              => 'text',
            ],
            [
                'name'              => 'enable-registration',
                'display_name'      => 'Enable Registration',
                'value'             => '1',
                'order'             => 1,
                'settings_group_id' => 11,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'confirm-email-on-registration',
                'display_name'      => 'Users must confirm their email on registration',
                'value'             => '1',
                'order'             => 2,
                'settings_group_id' => 11,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'user-default-role-on-registration',
                'display_name'      => 'Default user role on registration',
                'value'             => '2',
                'order'             => 10,
                'settings_group_id' => 11,
                'type'              => 'text',
            ],
            [
                'name'              => 'user-validation-password',
                'display_name'      => 'Validation for "password" field',
                'value'             => 'required_with:current_password|confirmed',
                'order'             => 10,
                'settings_group_id' => 5,
                'type'              => 'text',
            ],
            [
                'name'              => 'user-validation-about-me',
                'display_name'      => 'Validation for "about me" field',
                'value'             => 'max:120',
                'order'             => 10,
                'settings_group_id' => 5,
                'type'              => 'text',
            ],
            [
                'name'              => 'view-profile-user-display',
                'display_name'      => 'Display a user\'s ID or username for others to click on - <b>Must</b> be a column name in the users table',
                'value'             => 'username',
                'order'             => 10,
                'settings_group_id' => 4,
                'type'              => 'select:id|username',
            ],
            [
                'name'              => 'parse-date-human-readable',
                'display_name'      => 'Enable to parse date using human readable timestamp (e.g. 3 days ago)',
                'value'             => 1,
                'order'             => 10,
                'settings_group_id' => 13,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'forum-enable',
                'display_name'      => 'Enable Forum system-wide',
                'value'             => 1,
                'order'             => 10,
                'settings_group_id' => 6,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'forum-prefix',
                'display_name'      => 'Forum URL prefix - Users will type this in the URL when viewing forums',
                'value'             => 'forums',
                'order'             => 10,
                'settings_group_id' => 6,
                'type'              => 'text',
            ],
            [
                'name'              => 'forum-report-post-reasons',
                'display_name'      => 'Reasons a user can select using a dropdown menu to report a post. <br> Enter one reason per line (no commas required to separate). An "other" option is provided by default at the end.',
                'value'             => 'Breaking site rules
                Harassment or Bullying',
                'order'             => 10,
                'settings_group_id' => 14,
                'type'              => 'textarea',
            ],
            [
                'name'              => 'forum-rules-show-while-creating-post',
                'display_name'      => 'Show forum rules (if set) while creating a new thread',
                'value'             => true,
                'order'             => 10,
                'settings_group_id' => 14,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'forum-rules-show-index',
                'display_name'      => 'Show forum rules (if set) in forum',
                'value'             => true,
                'order'             => 10,
                'settings_group_id' => 14,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'forum-report-post-more-than-once',
                'display_name'      => 'A post can be reported more than once',
                'value'             => true,
                'order'             => 10,
                'settings_group_id' => 14,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'forum-guests-can-access',
                'display_name'      => 'Guests can access all forums (view all threads) but not read an individual thread',
                'value'             => true,
                'order'             => 10,
                'settings_group_id' => 8,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'forum-guests-can-read-threads',
                'display_name'      => 'Guests can read individual threads',
                'value'             => true,
                'order'             => 10,
                'settings_group_id' => 8,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'forum-thread-icon',
                'display_name'      => 'Forum icon for threads',
                'value'             => url('images/forum/thread-icons/thread.png'),
                'order'             => 10,
                'settings_group_id' => 9,
                'type'              => 'text',
            ],
            [
                'name'              => 'forum-thread-icon-locked',
                'display_name'      => 'Forum icon for locked threads',
                'value'             => 'images/forum/thread-icons/locked.png',
                'order'             => 10,
                'settings_group_id' => 9,
                'type'              => 'text',
            ],
            [
                'name'              => 'forum-thread-icon-locked-pinned',
                'display_name'      => 'Forum icon for locked and pinned threads',
                'value'             => 'images/forum/thread-icons/locked-pinned.png',
                'order'             => 10,
                'settings_group_id' => 9,
                'type'              => 'text',
            ],
            [
                'name'              => 'forum-thread-icon-pinned',
                'display_name'      => 'Forum icon for pinned threads',
                'value'             => 'images/forum/thread-icons/pinned.png',
                'order'             => 10,
                'settings_group_id' => 9,
                'type'              => 'text',
            ],
            [
                'name'              => 'forum-mark-thread-as-read',
                'display_name'      => 'Enable threads to be automatically marked as read when viewing them (unread threads appear bold)',
                'value'             => '1',
                'order'             => 10,
                'settings_group_id' => 6,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'forum-mark-thread-as-read-max-days',
                'display_name'      => 'How many days old should a thread be to mark it as read? The lower the number of days, the faster the performance',
                'value'             => '3',
                'order'             => 10,
                'settings_group_id' => 6,
                'type'              => 'number',
            ],
            [
                'name'              => 'star-image',
                'display_name'      => 'Star image (32x32 max) to display in forum beside the user, and user profile and other various places throughout the site',
                'value'             => '/images/default/star.png',
                'order'             => 10,
                'settings_group_id' => 9,
                'type'              => 'text',
            ],
            [
                'name'              => 'star-image-empty',
                'display_name'      => 'Empty star image (32x32 max) to display. For e.g., if a user has 3 stars out of 5, they will see 3 stars and 2 empty stars.',
                'value'             => '/images/default/star-empty.png',
                'order'             => 10,
                'settings_group_id' => 9,
                'type'              => 'text',
            ],
            [
                'name'              => 'star-max',
                'display_name'      => 'Max number of stars a user can have.',
                'value'             => 10,
                'order'             => 10,
                'settings_group_id' => 9,
                'type'              => 'number',
            ],
            [
                'name'              => 'pagination-per-page',
                'display_name'      => 'How many results to show per page on pagination',
                'value'             => 10,
                'order'             => 10,
                'settings_group_id' => 6,
                'type'              => 'number',
            ],
            [
                'name'              => 'signature-max-width',
                'display_name'      => 'Max width for signature.',
                'value'             => 650,
                'order'             => 10,
                'settings_group_id' => 10,
                'type'              => 'number',
            ],
            [
                'name'              => 'signature-max-height',
                'display_name'      => 'Max width for signature.',
                'value'             => 650,
                'order'             => 10,
                'settings_group_id' => 10,
                'type'              => 'number',
            ],
            ['name'              => 'signature-min-characters',
             'display_name'      => 'Min number of characters for signature.',
             'value'             => 5,
             'order'             => 10,
             'settings_group_id' => 10,
             'type'              => 'number',
            ],
            [
                'name'              => 'signature-max-characters',
                'display_name'      => 'Max number of characters for signature.',
                'value'             => 150,
                'order'             => 10,
                'settings_group_id' => 10,
                'type'              => 'number',
            ],

            [
                'name'              => 'site-name',
                'display_name'      => 'Site Name',
                'value'             => 'ProChaterr',
                'order'             => -1,
                'settings_group_id' => 13,
                'type'              => 'text',
            ],
            [
                'name'              => 'site-email',
                'display_name'      => 'Site email address to send/receive emails',
                'value'             => 'contact@proadmin.com',
                'order'             => 1,
                'settings_group_id' => 13,
                'type'              => 'text',
            ],
            [
                'name'              => 'site-description',
                'display_name'      => 'Site description for SEO.',
                'value'             => 'This is the best forum ever!',
                'order'             => 2,
                'settings_group_id' => 13,
                'type'              => 'textarea',
            ],
            [
                'name'              => 'default-homepage-forum',
                'display_name'      => 'Use forums as the default homepage. All redirects to will be redirected to the forum',
                'value'             => 0,
                'order'             => 2,
                'settings_group_id' => 13,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'enable-login',
                'display_name'      => 'Enable login',
                'value'             => 1,
                'order'             => -1,
                'settings_group_id' => 12,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'banned-users-can-login',
                'display_name'      => 'Banned users can log in',
                'value'             => 1,
                'order'             => 1,
                'settings_group_id' => 12,
                'type'              => 'yesno',
            ],
            [
                'name'              => 'thread-validation-title',
                'display_name'      => 'Validation for the thread title',
                'value'             => 'required|min:3|max:200',
                'order'             => 1,
                'settings_group_id' => 7,
                'type'              => 'text',
            ],
            [
                'name'              => 'thread-validation-body',
                'display_name'      => 'Validation for a new post (when replying or creating a thread)',
                'value'             => 'required|max:5000',
                'order'             => 1,
                'settings_group_id' => 7,
                'type'              => 'text',
            ],
        ];

        foreach ($settings as $setting) {
            \App\Core\Setting::firstOrCreate(array_merge($setting, ['system_required' => 1]));
        }
    }
}
