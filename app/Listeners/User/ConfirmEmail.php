<?php

namespace App\Listeners\User;

use App\Events\User\UserWasCreated;
use App\Mailer\AppMailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmEmail
{
    public $mailer;

    /**
     * Create the event listener.
     *
     * @param AppMailer $mailer
     */
    public function __construct(AppMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send the confirmation email to user and make the user's email not verified
     *
     * @param  UserWasCreated $event
     */
    public function handle(UserWasCreated $event)
    {
        if (site('confirm-email-on-registration')) {
            $event->user->newEmailVerification();
            $this->mailer->sendEmailConfirmationTo($event->user);
        }
    }
}
