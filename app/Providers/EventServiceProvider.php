<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        /* User Events */

        // Fired when a user is created
        'App\Events\User\UserWasCreated'        => [
            'App\Listeners\Core\Stats@addUser',
            'App\Listeners\User\ConfirmEmail',
        ],
        // Fired when a user is deleted
        'App\Events\User\UserWasDeleted'        => [
            'App\Listeners\Core\Stats@subtractUser',
        ],
        // Fired when a user has logged in
        'App\Events\User\UserHasLoggedIn'       => [
            'App\Listeners\User\UpdateLastActiveTime',
        ],


        /* Thread Events */

        // Fired when a thread has been read
        'App\Events\Forum\ThreadWasRead'        => [
            'App\Listeners\Forum\MarkThreadAsRead',
        ],
        // Fired when a thread has been created
        'App\Events\Forum\ThreadWasCreated'     => [
            'App\Listeners\Forum\UpdateTotalCount@handleTotalThreadCount',
        ],
        // Fired when a thread has been edited
        'App\Events\Forum\ThreadWasEdited'      => [

        ],
        // Fired when a thread has been junked
        'App\Events\Forum\ThreadWasJunked'      => [
            'App\Listeners\Forum\JunkFirstPost@junk',
            'App\Listeners\Forum\UpdateTotalCount@handleTotalThreadCount',
        ],
        // Fired when a thread has been restored
        'App\Events\Forum\ThreadWasRestored'    => [
            'App\Listeners\Forum\UpdateTotalCount@handleTotalThreadCount',
            'App\Listeners\Forum\JunkFirstPost@restore',
        ],
        // Fired when a thread has been permanently deleted
        'App\Events\Forum\ThreadWasDeleted'     => [
            'App\Listeners\Forum\UpdateTotalCount@handleTotalThreadCount',
        ],

        /* Post Events */

        // Fired when a post has been created
        'App\Events\Forum\PostWasCreated'       => [
            'App\Listeners\Forum\MarkThreadAsUnread',
            'App\Listeners\Forum\UpdateTotalCount@handleTotalPostCount',
        ],
        // Fired when a post has been edited
        'App\Events\Forum\PostWasEdited'        => [
            'App\Listeners\Forum\CreateEditedRecord',
        ],
        // Fired when a post has been deleted
        'App\Events\Forum\PostWasDeleted'       => [
            'App\Listeners\Forum\UpdateTotalCount@handleTotalPostCount',
        ],
        // Fired when a post has been junked
        'App\Events\Forum\PostWasJunked'        => [
            'App\Listeners\Forum\JunkThreadIfFirstPost@junk',
            'App\Listeners\Forum\UpdateTotalCount@handleTotalPostCount',
        ],
        // Fired when a post has been restored
        'App\Events\Forum\PostWasRestored'      => [
            'App\Listeners\Forum\JunkThreadIfFirstPost@restore',
            'App\Listeners\Forum\UpdateTotalCount@handleTotalPostCount',
        ],

        /*
         * Admin pages events
         */
        // Fired when a new page is created
        'App\Events\Admin\Pages\PageWasCreated' => [
            'App\Listeners\Pages\UpdatePagesCache',
        ],
        // Fired when a page is deleted
        'App\Events\Admin\Pages\PageWasDeleted' => [
            'App\Listeners\Pages\UpdatePagesCache',
        ],
        // Fired when a page is updated
        'App\Events\Admin\Pages\PageWasUpdated' => [
            'App\Listeners\Pages\UpdatePagesCache',
        ],

        // Fired when trying to recount stats
        'App\Events\Admin\Tools\SiteWasFixed'   => [
            'App\Listeners\Forum\UpdateTotalCount@handleTotalThreadCount',
            'App\Listeners\Forum\UpdateTotalCount@handleTotalPostCount',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
