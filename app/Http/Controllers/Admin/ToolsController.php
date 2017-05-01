<?php

namespace App\Http\Controllers\Admin;

use App\Core\Core;
use App\Core\Cache;
use App\Core\NavigationMenu;
use App\Events\Admin\Tools\SiteWasFixed;
use App\Forum\Post;
use App\Forum\Thread;
use App\Forum\ThreadRead;
use App\User\User;
use Artisan;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ToolsController extends Controller {

    /**
     * Tools index page.
     * Only viewable if clicked from breadcrumb or visited directly as it does not show from sidebar menu.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tools = NavigationMenu::adminMenu()[5];
        return view('admin.tools.index', compact('tools'));
    }
    /**
     * Display a view with php info
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function phpInfo()
    {
        return view('admin.tools.php_info');
    }

    /**
     * Display the raw php-info
     */
    public function phpInfoRaw()
    {
        phpInfo();
    }

    /**
     * Show the cache manager page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cacheManager()
    {
        return view('admin.tools.cache_manager');
    }

    /**
     * Recache one cached item via ajax or POST request
     *
     * @param         $identifier
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function recache($identifier, Request $request)
    {
        Cache::recache($identifier);
        if ($request->ajax()) {
            return response()->json(['success' => trans('admin.tools.cache.recache_success')]);
        }
        flash(trans('admin.tools.cache.recache_success'));
        return redirect(route('admin.tools.cache.manager'));
    }

    public function removeCache($identifier, Request $request)
    {
        switch ($identifier) {
            case 'routes':
                Artisan::call('route:clear');
                Artisan::call('route:cache');
                break;
            case 'views':
                Artisan::call('view:clear');
                break;
            case 'config':
                Artisan::call('config:clear');
                Artisan::call('config:cache');
                break;
            case 'compiled':
                Artisan::call('clear-compiled');
        }

        if ($request->ajax()) {
            return response()->json(['success' => trans('admin.tools.cache.clear_success')]);
        }
        flash(trans('admin.tools.cache.clear_success'));
        return back();
    }

    /**
     * Read a specific cache identifier and return the data it has
     *
     * @param $identifier
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function readCache($identifier)
    {

        $cache = Cache::get($identifier);
        if (is_a($cache, 'Illuminate\Database\Eloquent\Collection')) {
            $cache = $cache->toArray();
        }

        return response()->json(
            [
                'title' => trans('admin.tools.cache.view'),
                'view'  => view('admin.tools.cache_read', compact('identifier', 'cache'))->render(),
            ]
        );
    }


    /**
     * Display the site health view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function siteHealth()
    {
        $database_size = Core::getDatabaseSize()->sum('size');
        $items_cached = Cache::cacheNames()->count();
        $file_permissions = $this->filePermissions();
        return view('admin.tools.site_health', compact('database_size', 'items_cached', 'file_permissions'));
    }

    /**
     * Optimize the site
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function optimize(Request $request)
    {
        Artisan::call('clear-compiled');
        Artisan::call('optimize');

        // Clear records for threads read if its older than the admin-set value of max-days to mark a thread as read
         ThreadRead::where('created_at', '<', Carbon::now()->subDays(site('forum-mark-thread-as-read-max-days')))->delete();

        if ($request->ajax()) {
            return response()->json(['success' => trans('admin.tools.health.optimize_success')]);
        }

        flash(trans('admin.tools.health.optimize_success'));
        return back();
    }

    public function fix(Request $request)
    {

        // Find users with no primary roles or missing primary roles and give them the default role
        $users = User::all();
        $error_count = 0;
        foreach ($users as $user) {
            if (!$user->primaryRole) {
                $user->primary_role = Core::defaultRole();
                $user->save();
                $error_count++;
            }
        }

        // Find threads whose first post is trashed but the thread is not and restore them
        $threads = Thread::all();
        foreach ($threads as $thread) {
            if ($thread->firstPost && ($thread->firstPost->trashed() && !$thread->trashed())) {
                $thread->firstPost()->restore();
                $error_count++;
            }
        }

        // Fix the total number of post/thread count for forums
        $posts = Post::all();
        foreach ($posts as $post) {
            event(new SiteWasFixed($post));
            $error_count++;
        }

        $success_message = trans('admin.tools.health.fix_success', ['errors' => $error_count]);
        if ($request->ajax()) {
            return response()->json(['success' => $success_message]);
        }

        flash($success_message);
        return back();
    }

    /**
     * Get all the directory permissions as well as the recommended ones
     *
     * @return array
     */
    public function filePermissions()
    {
        return [
            [
                'directory'   => base_path('bootstrap/cache'),
                'permission'  => $this->getFilePermission('bootstrap/cache'),
                'recommended' => '0775',
            ],
            [
                'directory'   => base_path('public'),
                'permission'  => $this->getFilePermission('public'),
                'recommended' => '0775',
            ],
            [
                'directory'   => base_path('storage'),
                'permission'  => $this->getFilePermission('storage'),
                'recommended' => '0775',
            ],
            [
                'directory'   => base_path('vendor'),
                'permission'  => $this->getFilePermission('vendor'),
                'recommended' => '0775',
            ],
        ];
    }

    /**
     * Get the file permissions for a specific path/file
     *
     * @param $path
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getFilePermission($path)
    {
        try {
            return substr(sprintf('%o', fileperms(base_path($path))), -4);
        } catch (\Exception $ex) {
            return trans('site.error');
        }
    }

    /**
     * Show the view to rebuild database
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rebuildDatabase()
    {
        $sizes = Core::getDatabaseSize();
        $seeders = $this->databaseSeeders();
        return view('admin.tools.database_rebuild', compact('seeders', 'sizes'));
    }

    /**
     * Seed a specific database by using the Database Seeder (ajax request)
     *
     * @param $seeder
     * @return \Illuminate\Http\JsonResponse
     */
    public function seedDatabase($seeder)
    {
        foreach ($this->databaseSeeders() as $database_seeders) {
            if (in_array($seeder, $database_seeders) && class_exists($seeder)) {
                Eloquent::unguard();
                $class = new $seeder;
                $class->run();
                Eloquent::reguard();
                return response()->json(['success' => trans('admin.tools.database.seed_success')]);
            }
        }
        return response()->json(['error' => trans('admin.tools.database.seed_not_found')]);
    }

    /**
     * All the database seeders that are available for seeding.
     * You can add your own custom database seeder to make it easy to seed from admin panel
     *
     * @return array
     */
    public function databaseSeeders()
    {
        return [
            ['seeder' => 'PermissionsTableSeeder', 'name' => 'Permissions Table', 'description' => 'Rebuild permissions that the site uses for user roles and ACL'],
            ['seeder' => 'SettingsGroupSeeder', 'name' => 'Settings Group Table', 'description' => 'Rebuild all setting groups that the settings table uses to organize itself'],
            ['seeder' => 'SettingsTableSeeder', 'name' => 'Settings Table', 'description' => 'Rebuild all the settings the site uses and relies on to function properly'],
            ['seeder' => 'UserRolesSeeder', 'name' => 'User Roles Table', 'description' => 'Rebuild all the default user roles (admin, member and moderator)'],
            ['seeder' => 'CoreSeeder', 'name' => 'Core Site Seeder', 'description' => 'Rebuild the core settings of the site that it uses behind the scenes'],
            ['seeder' => 'PermissionSettingsSeeder', 'name' => 'Permission Settings', 'description' => 'Rebuild the permission settings (permission groups) that the permissions are grouped into'],
        ];
    }

    /**
     * View for recount stats
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recountStats()
    {
        $stats = Core::whereType('stats')->get();
        return view('admin.tools.stats_recount', compact('stats'));
    }

    /**
     * Update the site stats
     * @param $stat_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStat($stat_name)
    {
        $new_stat = Core::recountStat($stat_name);
        return response()->json(['stat_name' => $stat_name, 'stat_value' => number_format($new_stat)]);
    }

}
