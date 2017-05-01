<?php

namespace App\Providers;

use App\Forum\Post;
use App\Forum\Forum;
use App\Forum\Thread;
use App\Policies\UserPolicy;
use App\User\Permission;
use App\Forum\ReportedPost;
use App\Policies\Forum\PostPolicy;
use App\Policies\Forum\ForumPolicy;
use App\Policies\Forum\ThreadPolicy;
use App\Policies\Forum\ReportPostPolicy;
use App\User\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model'         => 'App\Policies\ModelPolicy',
        Thread::class       => ThreadPolicy::class,
        Post::class         => PostPolicy::class,
        Forum::class        => ForumPolicy::class,
        User::class         => UserPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->before(function ($user) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        try {
            foreach ($this->getPermissions() as $permission) {
                $gate->define($permission->name, function ($user) use ($permission) {
                    return $user->hasRole($permission->roles);
                });
            }
        } catch (\Exception $ex) {

        }

    }

    public function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
