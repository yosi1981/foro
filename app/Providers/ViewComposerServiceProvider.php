<?php

namespace App\Providers;

use App\Core\Cache;
use App\Core\NavigationMenu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider {

    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.includes.sidebar', function ($view) {
            $view->with('setting_groups', Cache::grab('setting_groups'));
            $view->with('links', NavigationMenu::adminMenu());
      });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
