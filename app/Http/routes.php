<?php


// View the home page
Route::get('/', 'HomeController@index')
    ->name('home');
// View any pages (such as terms page or any other page created by admin)
Route::get('/pages/{slug}', 'HomeController@showPage')
    ->name('pages.show');


/*
 * ----------------------------------
 * USER AUTHENTICATION ROUTES
 * ----------------------------------
 */

// Login Routes
Route::get('login', 'Auth\LoginController@showLoginForm')
    ->name('auth.login');

Route::get('login/ajax', 'Auth\LoginController@loadAjaxLoginForm')
    ->name('auth.login.ajax.form');

Route::post('login', 'Auth\LoginController@loginUser')
    ->name('auth.login.post');

Route::get('logout', 'Auth\LoginController@logout')
    ->name('auth.logout');

// Registration Routes...
Route::get('register', 'Auth\RegistrationController@showRegistrationForm')
    ->name('auth.register');

Route::post('register', 'Auth\RegistrationController@addUser')
    ->name('auth.register.post');

Route::get('/register/verify/{token}', 'Auth\RegistrationController@verifyEmail')
    ->name('auth.register.verify');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm')
    ->name('auth.password.reset');

Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail')
    ->name('auth.password.reset.post');

Route::post('password/reset', 'Auth\PasswordController@reset')
    ->name('auth.password.reset.new');

/*
 * ----------------------------------
 * USER ACCOUNT ROUTES
 * ----------------------------------
 */

Route::group(['namespace' => 'User', 'middleware' => ['auth']], function () {

    // Show all users
    Route::get('/all-users', 'ProfileController@allUsers')
        ->name('user.all');

    // User Profile routes
    Route::group(['prefix' => 'profile/{user}'], function () {

        // View a user profile
        Route::get('/', 'ProfileController@index')
            ->name('viewProfile');
        // View all posts by that user
        Route::get('posts', 'ProfileController@allPosts')
            ->name('user.all.posts');
        // View all threads by that user
        Route::get('threads', 'ProfileController@allThreads')
            ->name('user.all.threads');

    });

    // User Account routes
    Route::group(['prefix' => 'account', 'as' => 'user.settings.'], function () {

        // View user settings
        Route::get('/', 'SettingsController@show')
            ->name('index');
        // Save general settings
        Route::patch('/save-general', 'SettingsController@saveGeneral')
            ->name('general');
        // Save account settings
        Route::patch('/save-account', 'SettingsController@saveAccount')
            ->name('account');
        // Save forum settings
        Route::patch('/save-forum', 'SettingsController@saveForum')
            ->name('forum');
    });

});


/*
 * ----------------------------------
 * FORUM ROUTES
 * ----------------------------------
 */
Route::group(['prefix' => site('forum-prefix'), 'as' => 'forum.', 'namespace' => 'Forum', 'middleware' => ['forum.access']], function () {

    // Forum homepage
    Route::get('/', 'ForumController@index')
        ->name('home');
    // View a thread
    Route::get('thread/{thread}/{title?}', 'ThreadController@show')
        ->name('thread');

    // Auth Middleware
    Route::group(['middleware' => ['auth']], function () {

        // Create a thread
        Route::get('/create', 'ThreadController@showCreateForm')
            ->name('create');
        // Store the thread
        Route::post('/create', 'ThreadController@store')
            ->name('store');

        /*
         * ROUTE GROUP: An individual post
         */
        Route::group(['prefix' => 'post/{post}'], function () {

            // Show edit form of post
            Route::get('edit', 'PostController@showEditForm')
                ->name('edit');
            // Submit the form (update it)
            Route::patch('edit', 'PostController@update')
                ->name('edit.post');

        });


        // View the reply page
        Route::get('{thread}/reply', 'PostController@showReplyForm')
            ->name('reply');
        // Reply to a post
        Route::post('{thread}/reply', 'PostController@store')
            ->name('reply.post');
        // Show the report form
        Route::get('/report-form/{post?}', 'ReportController@reportForm')
            ->name('report.form');
        // Report a post (store in database)
        Route::post('/report/{post}', 'ReportController@store')
            ->name('report');
        // Thread Actions
        Route::post('/actions/threads', 'ThreadController@actions')
            ->name('actions');
        // Do the selected action
        Route::post('/actions/posts', 'PostController@actions')
            ->name('actions.post');

    });

});

/*
 * ----------------------------------
 * MODERATION ROUTES
 * ----------------------------------
 */
Route::group(['prefix' => 'moderation', 'as' => 'mod.', 'namespace' => 'Mod', 'middleware' => ['auth', 'user.mod']], function () {

    // Dashboard
    Route::get('/', 'ModController@index')
        ->name('dashboard');
    // Search for a user
    Route::post('/search-user', 'ModController@searchUser')
        ->name('search.user');
    // Save the moderation note
    Route::patch('/notes', 'ModController@notes')
        ->name('notes');
    // Resource User controller
    Route::resource('user', 'UserController', [
        'only'       => ['index', 'show', 'edit', 'update'],
        'middleware' => 'mod.edit.user',
    ]);

    // Manage Reported posts
    Route::group(['as' => 'reported.', 'prefix' => 'reported', 'middleware' => ['mod.reported.posts']], function () {

        // Show all reported posts
        Route::get('/', 'ReportedPostsController@index')
            ->name('index');
        // Do certain actions with a reported post
        Route::post('/', 'ReportedPostsController@action')
            ->name('action');
        // Delete all reported posts
        Route::delete('/', 'ReportedPostsController@deleteAll')
            ->name('delete_all');
    });

    // Banned Users
    Route::group(['middleware' => 'mod.ban.user'], function () {

        // View/Update a banned user AJAX
        Route::post('/banned/view', 'BannedUsersController@getForm')
            ->name('banned.user');
        // Ban a user
        Route::post('/banned/{user}', 'BannedUsersController@store')
            ->name('banned.store');
        // Resource route to manage Banned Users
        Route::resource('banned', 'BannedUsersController', [
            'except'     => 'store',
            'parameters' => ['banned' => 'user',],
        ]);
    });
});


/*
 * ----------------------------------
 * ADMIN PANEL ROUTES
 * ----------------------------------
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.', 'middleware' => ['auth', 'user.admin']], function () {

    // Dashboard
    Route::get('/', 'AdminController@index')
        ->name('index');
    // Update admin note
    Route::patch('/', 'AdminController@updateNotes')
        ->name('update.note');
    // User IP Logs
    Route::get('user/{user}/ip-logs', 'UserController@viewIPLogs')
        ->name('user.ip.log');
    // User Management
    Route::resource('user', 'UserController', [
        'except' => ['edit'],
    ]);
    // Do bulk actions to many users at once
    Route::post('/bulk-actions', 'UserController@actions')
        ->name('user.actions');

    // User Roles & Permissions
    Route::group(['prefix' => 'role'], function () {
        // Resource controller for Permissions
        Route::resource('permission', 'PermissionsController', ['as' => 'role']);
        // Edit Permissions
        Route::get('/{role}/edit-permissions', 'RolesController@editPermissions')
            ->name('role.permission.role.edit');
        // Update edited permissions
        Route::patch('/{role}/edit-permissions', 'RolesController@updatePermissions')
            ->name('role.permission.role.update');
        // Show all users in a role
        Route::get('/{role}/users', 'RolesController@users')
            ->name('role.users');

    });

    // Roles resource route
    Route::resource('role', 'RolesController');

    // User titles resource route
    Route::resource('title', 'UserTitleController', ['except' => 'show']);

    //  Forum Management and Settings
    Route::group(['prefix' => 'forum/manage/{forum}', 'as' => 'forum.manage.'], function () {

        // Move threads
        Route::get('move-threads', 'ForumController@showMoveThreads')
            ->name('move');
        Route::post('move-threads', 'ForumController@moveThreads')
            ->name('move.post');

        // Delete threads
        Route::delete('delete-threads', 'ForumController@deleteThreads')
            ->name('delete_threads');
        // Junk threads
        Route::delete('junk-threads', 'ForumController@junkThreads')
            ->name('junk_threads');
        // Restore threads
        Route::post('restore-threads', 'ForumController@restoreThreads')
            ->name('restore_threads');

    });

    // Update forum order
    Route::patch('forum/update-order', 'ForumController@updateOrder')
        ->name('forum.update.order');

    // Resource Forum Controller
    Route::resource('forum', 'ForumController', [
        'except' => ['show', 'edit'],
    ]);

    // Configuration Settings & Site Management
    Route::group(['prefix' => 'configuration', 'as' => 'config.'], function () {
        // Show the config settings
        Route::get('/{settings_group?}', 'ConfigController@index')
            ->name('index');
        // Update config settings
        Route::patch('/{settings_group}', 'ConfigController@update')
            ->name('update');

    });

    // Pages Controller
    Route::resource('page', 'PagesController', ['except' => 'show']);

    // Tools
    Route::group(['prefix' => 'tools', 'as' => 'tools.'], function () {
        // Tools homepage
        Route::get('/', 'ToolsController@index')
            ->name('index');
        // PHP Info
        Route::get('/php-info', 'ToolsController@phpInfo')
            ->name('php.info');
        // Show raw PHP info
        Route::get('/php-info-raw', 'ToolsController@phpInfoRaw')
            ->name('php.info.raw');
        // Cache Manager
        Route::get('/cache-manager', 'ToolsController@cacheManager')
            ->name('cache.manager');
        // Recache AJAX
        Route::post('/cache-manager/recache/{identifier}', 'ToolsController@recache')
            ->name('cache.recache');
        // Remove Cache
        Route::post('/cache-manager/remove/{identifier}', 'ToolsController@removeCache')
            ->name('cache.remove');
        // Show cache data AJAX
        Route::get('/cache-manager/recache/{identifier}', 'ToolsController@readCache')
            ->name('cache.read');
        // Site Health
        Route::get('/site-health', 'ToolsController@siteHealth')
            ->name('site.health');
        // Site health - optimize
        Route::post('/site-health', 'ToolsController@optimize')
            ->name('site.optimize');
        // Site Health - fix errors
        Route::post('/site-health/fix', 'ToolsController@fix')
            ->name('site.fix');
        // Rebuild database
        Route::get('/rebuild-database', 'ToolsController@rebuildDatabase')
            ->name('database.rebuild');
        // Seed database AJAX
        Route::post('/rebuild-database/{seeder}', 'ToolsController@seedDatabase')
            ->name('database.seed');
        // Recount stats page
        Route::get('/recount-stats', 'ToolsController@recountStats')
            ->name('stats.recount');
        // Recount (update) stats AJAX
        Route::post('/recount-stats/{stat_name}', 'ToolsController@updateStat')
            ->name('stats.update');

    });

});

/*
 * ----------------------------------
 * SITE API ROUTES
 * ----------------------------------
 */
Route::group(['prefix' => 'api', 'as' => 'api.', 'middleware' => ['auth']], function () {

    // Search user using AJAX
    Route::get('/search-user', 'APIController@searchUser')
        ->name('search.user');

});