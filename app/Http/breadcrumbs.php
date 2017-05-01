<?php

/*
 * ----------------------------------
 * MODERATION PANEL BREADCRUMBS
 * ----------------------------------
 */

// Dashboard
Breadcrumbs::register('mod.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push(trans('mod.dashboard'), route('mod.dashboard'));
});

// Reported Post
Breadcrumbs::register('mod.report.index', function ($breadcrumbs, $show_all) {
    $breadcrumbs->parent('mod.dashboard');
    $breadcrumbs->push(trans('mod.report.reported'), route('mod.reported.index'));
    if ($show_all) {
        $breadcrumbs->push(trans('site.all'), route('mod.reported.index', ['show' => 'all']));
    }
});

// Banned Users
Breadcrumbs::register('mod.banned', function ($breadcrumbs) {
    $breadcrumbs->parent('mod.dashboard');
    $breadcrumbs->push(trans('mod.banned.all'), route('mod.banned.index'));
});

// Show a banned user
Breadcrumbs::register('mod.banned.show', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('mod.banned');
    $breadcrumbs->push($user->info, route('mod.banned.index'));
});

// Ban a new user
Breadcrumbs::register('mod.banned.create', function ($breadcrumbs) {
    $breadcrumbs->parent('mod.banned');
    $breadcrumbs->push(trans('mod.banned.create'), route('mod.banned.index'));
});

// Edit a banned user
Breadcrumbs::register('mod.banned.edit', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('mod.banned.show', $user);
    $breadcrumbs->push(trans('mod.banned.edit'), route('mod.banned.index'));
});

// Editing Users
Breadcrumbs::register('mod.user.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('mod.user.title'), route('mod.user.index'));
});

// Show a user
Breadcrumbs::register('mod.user.show', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('mod.user.index');
    $breadcrumbs->push($user->info, route('mod.user.show', $user->info));
});

// Edit a user
Breadcrumbs::register('mod.user.edit', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('mod.user.show', $user);
    $breadcrumbs->push(trans('site.edit'), route('mod.user.edit', $user->info));
});

/*
 * ----------------------------------
 * END MODERATION PANEL BREADCRUMBS
 * ----------------------------------
 */


/*
 * ----------------------------------
 * FORUM BREADCRUMBS
 * ----------------------------------
 */

// Home
Breadcrumbs::register('forum.home', function ($breadcrumbs) {
    $breadcrumbs->push(trans('forum.title'), route('forum.home'));
});

//Edit post
Breadcrumbs::register('post.edit', function ($breadcrumbs, $post) {
    $breadcrumbs->parent('thread', $post->thread);
    $breadcrumbs->push(trans('forum.post.edit'));
});

// Create thread
Breadcrumbs::register('thread.create', function ($breadcrumbs, $forum) {
    $breadcrumbs->parent('forum.subforum', $forum);
    $breadcrumbs->push(trans('forum.thread.create'));
});

// Reply to thread
Breadcrumbs::register('thread.reply', function ($breadcrumbs, $thread) {
    $breadcrumbs->parent('thread', $thread);
    $breadcrumbs->push(trans('forum.thread.reply.to_thread'));
});

// Subforum the user is currently on
Breadcrumbs::register('forum.subforum', function ($breadcrumbs, $forum) {
    $breadcrumbs->parent('forum.home');
    $ancestors = $forum->getAncestors();
    foreach ($ancestors as $ancestor) {
        $breadcrumbs->push($ancestor->name, $ancestor->forumURL());
    }
    $breadcrumbs->push($forum->name, $forum->forumURL());
});

// Specific thread
Breadcrumbs::register('thread', function ($breadcrumbs, $thread) {
    $breadcrumbs->parent('forum.subforum', $thread->forum);
    //$breadcrumbs->push($thread->title, route('forum.thread', $thread->id));
    $breadcrumbs->push(trans('forum.thread.view'), route('forum.thread', $thread->id));
});

/*
 * ----------------------------------
 * END FORUM BREADCRUMBS
 * ----------------------------------
 */

/*
 * ----------------------------------
 * ADMIN PANEL BREADCRUMBS
 * ----------------------------------
 */

// Admin dashboard
Breadcrumbs::register('admin.dashboard', function($breadcrumbs) {
    $breadcrumbs->push(trans('admin.panel'), route('admin.index'));
});

//-------USERS--------//
// Show all users
Breadcrumbs::register('admin.user.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('user.all'), route('admin.user.index'));
});

// Show a single user
Breadcrumbs::register('admin.user.show', function ($breadcrumbs, $member) {
    $breadcrumbs->parent('admin.user.index');
    $breadcrumbs->push($member->info, route('admin.user.show', $member->info));
});

// Show user IP logs
Breadcrumbs::register('admin.user.ip.logs', function ($breadcrumbs, $member) {
    $breadcrumbs->parent('admin.user.show', $member);
    $breadcrumbs->push(trans('admin.user.ip.logs'), route('admin.user.ip.log', $member));
});

// Create a new user
Breadcrumbs::register('admin.user.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.user.index');
    $breadcrumbs->push(trans('admin.user.create'), route('admin.user.create'));
});

//-------FORUM--------//
// Show all forums
Breadcrumbs::register('admin.forum.index', function ($breadcrumbs, $forums = null) {
    $breadcrumbs->push(trans('forum.manage'), route('admin.forum.index'));
    if ($forums) {
        $forum = $forums->first();
        $ancestors = $forum->getAncestors();
        foreach ($ancestors as $ancestor) {
            $breadcrumbs->push($ancestor->name, route('admin.forum.index', ['fid' => $ancestor->id]));
        }
        $breadcrumbs->push($forum->name, route('admin.forum.index', ['fid' => $forum->id]));
    }
});

// Create a new forum
Breadcrumbs::register('admin.forum.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.forum.index');
    $breadcrumbs->push(trans('forum.add'), route('admin.forum.create'));
});

// Show a forum
Breadcrumbs::register('admin.forum.show', function ($breadcrumbs, $forum) {
    $breadcrumbs->parent('admin.forum.index');
    $breadcrumbs->push($forum->name, route('admin.forum.index', ['fid' => $forum->id]));
});

// Move threads from one forum to another
Breadcrumbs::register('admin.forum.manage.move', function ($breadcrumbs, $forum) {
    $breadcrumbs->parent('admin.forum.show', $forum);
    $breadcrumbs->push(trans('forum.move_threads'), route('admin.forum.manage.move', $forum->id));
});

//-------USER TITLES--------//
//Show all user titles
Breadcrumbs::register('user_title.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('admin.user.title.title'), route('admin.title.index'));
});
// Create a new user title
Breadcrumbs::register('user_title.create', function ($breadcrumbs) {
    $breadcrumbs->parent('user_title.index');
    $breadcrumbs->push(trans('admin.user.title.create'), route('admin.title.create'));
});
// Update a user title
Breadcrumbs::register('user_title.edit', function ($breadcrumbs, $title) {
    $breadcrumbs->parent('user_title.index');
    $breadcrumbs->push($title->title, route('admin.title.edit', $title->id));
});


//-------USER ROLES--------//
// Show all user roles
Breadcrumbs::register('admin.role.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('admin.role.index'), route('admin.role.index'));
});

// Add a new user role
Breadcrumbs::register('admin.role.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.role.index');
    $breadcrumbs->push(trans('admin.role.add'), route('admin.role.create'));
});

// Show a user role
Breadcrumbs::register('admin.role.show', function ($breadcrumbs, $role) {
    $breadcrumbs->parent('admin.role.index');
    $breadcrumbs->push($role->display_name, route('admin.role.show', $role->name));
});

// Edit a user role
Breadcrumbs::register('admin.role.edit', function ($breadcrumbs, $role) {
    $breadcrumbs->parent('admin.role.show', $role);
    $breadcrumbs->push(trans('admin.role.edit'), route('admin.role.edit', $role->name));
});

// Edit a permission for a role
Breadcrumbs::register('admin.role.permission.role.edit', function ($breadcrumbs, $role) {
    $breadcrumbs->parent('admin.role.show', $role);
    $breadcrumbs->push(trans_choice('admin.permission.edit', 2), route('admin.role.edit', $role->name));
});

//-------ROLE PERMISSIONS--------//
// Show all permissions
Breadcrumbs::register('admin.permission.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('admin.permission.title'), route('admin.role.permission.index'));
});

// Add a new permission
Breadcrumbs::register('admin.permission.create', function ($breadcrumbs) {
    $breadcrumbs->push(trans('admin.permission.add'), route('admin.role.permission.create'));
});

// Edit a permission
Breadcrumbs::register('admin.permission.edit', function ($breadcrumbs, $permission) {
    $breadcrumbs->parent('admin.permission.index');
    $breadcrumbs->push(trans_choice('admin.permission.edit', 1), route('admin.role.permission.edit', $permission->id));
});

//-------SITE CONFIGURATION--------//
// Show config page
Breadcrumbs::register('admin.config.index', function ($breadcrumbs, $config) {
    $breadcrumbs->push(trans('admin.config.title'), route('admin.config.index'));
    $breadcrumbs->push($config->name, route('admin.config.index', $config->id));
});

//-------SITE TOOLS--------//
// Show tools homepage
Breadcrumbs::register('admin.tools.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('admin.tools.title'), route('admin.tools.index'));
});

// Cache manager for site
Breadcrumbs::register('admin.tools.cache.manager', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.tools.index');
    $breadcrumbs->push(trans('admin.tools.cache.manager'), route('admin.tools.cache.manager'));
});

// Show site health status
Breadcrumbs::register('admin.tools.site.health', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.tools.index');
    $breadcrumbs->push(trans('admin.tools.health.site'), route('admin.tools.site.health'));
});

// PHP info
Breadcrumbs::register('admin.tools.php.info', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.tools.index');
    $breadcrumbs->push(trans('admin.tools.php.info'), route('admin.tools.php.info'));
});

// Rebuild database (seeder)
Breadcrumbs::register('admin.tools.database.rebuild', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.tools.index');
    $breadcrumbs->push(trans('admin.tools.database.title'), route('admin.tools.database.rebuild'));
});

// Stats recount
Breadcrumbs::register('admin.tools.stats.recount', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.tools.index');
    $breadcrumbs->push(trans('admin.tools.stats.title'), route('admin.tools.stats.recount'));
});

//-------PAGES--------//
// Show all pages
Breadcrumbs::register('admin.pages.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('admin.pages.title'), route('admin.page.index'));
});

// Edit a page
Breadcrumbs::register('admin.pages.edit', function ($breadcrumbs, $page) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push(trans('admin.pages.edit'), route('admin.page.edit', $page->id));
});

// Create a new page
Breadcrumbs::register('admin.pages.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push(trans('admin.pages.create'), route('admin.page.create'));
});

/*
 * ----------------------------------
 * END ADMIN PANEL BREADCRUMBS
 * ----------------------------------
 */

/*
 * ----------------------------------
 * USER PROFILE BREADCRUMBS
 * ----------------------------------
 */

// Show user profile
Breadcrumbs::register('user.profile', function ($breadcrumbs, $member) {
    $breadcrumbs->push($member->info, $member->profileURL());
});

// All threads by a user
Breadcrumbs::register('user.profile.all.threads', function ($breadcrumbs, $member) {
    $breadcrumbs->parent('user.profile', $member);
    $breadcrumbs->push(trans('forum.thread.all'), route('user.all.threads', $member->info));
});

// All posts by a user
Breadcrumbs::register('user.profile.all.posts', function ($breadcrumbs, $member) {
    $breadcrumbs->parent('user.profile', $member);
    $breadcrumbs->push(trans('forum.post.all'), route('user.all.posts', $member->info));
});

/*
 * ----------------------------------
 * END USER PROFILE BREADCRUMBS
 * ----------------------------------
 */