<?php

namespace App\Providers;

use App\Forum\Post;
use App\Forum\Thread;
use Illuminate\Routing\Router;
use App\Exceptions\ThreadDoesNotExistException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to your controller routes.
     * In addition, it is set as the URL generator's root namespace.
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $router->model('thread', 'App\Forum\Thread', function ($thread) {
            return Thread::withTrashed()->where('id', $thread)->firstOrFail();
        });

        $router->bind('post', function ($post) {
            return Post::withTrashed()->where('id', $post)->firstOrFail();
        });

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
