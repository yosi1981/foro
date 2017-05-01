<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App\Mailer;

use App\User\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Artisan;


class AppMailer {

    protected $mailer;
    protected $from;
    protected $to;
    protected $replyToEmail;
    protected $replyToName;
    protected $subject;
    protected $view;
    protected $data = [];

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->from = site('site-email');
    }


    /**
     * Send a user's confirmation email
     *
     * @param User $user
     */
    public function sendEmailConfirmationTo(User $user)
    {
        $verification_url = route('auth.register.verify', $user->emailVerification->token);
        $this->to = $user->email;
        $this->subject = trans('user.register.confirm_email');
        $this->view = 'emails.confirm_email';
        $this->data = compact('user', 'verification_url');

        $this->deliver();
    }

    ///**
    // * Send email to admin when a user sends email
    // * @param $data
    // */
    //public function sendContactEmail($data)
    //{
    //    $this->to = $this->from;
    //    $this->subject = 'Contact Form Email';
    //    $this->view = 'emails.contact_email';
    //    $this->replyToEmail = $data->email;
    //    $this->replyToName = $data->name;
    //    $this->data = compact('data');
    //
    //    $this->deliverToSelf();
    //}

    //todo make contact email sender

    /**
     * Deliver a user's confirmation email TO USER.
     */
    public function deliver()
    {
        $subject = $this->subject . ' ' . site('site-name');
        $from = $this->from;
        $to = $this->to;

       // To queue the email, simply change the $this->mailer->send to $this->mailer->queue.

        try {
            $this->mailer->send($this->view, $this->data, function ($message) use ($subject, $from, $to) {
                $message->subject($subject);
                $message->from($from, site('site-name'))
                    ->to($to);
            });
        } catch (\Exception $ex) {
            // Email sending failed...
        }

    }

    /**
     * Deliver email to admin
     */
    public function deliverToSelf()
    {
        // To queue the email, simply change the $this->mailer->send to $this->mailer->queue.

        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->subject($this->subject);
            $message->replyTo($this->replyToEmail, $this->replyToName);
            $message->from($this->from, siteName())
                ->to($this->to);
        });
    }


}