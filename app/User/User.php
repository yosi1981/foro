<?php

namespace App\User;

use App\DateParser;
use App\Forum\Post;

//use App\Forum\ThreadRead;
//use App\Forum\UserSetting;
use App\Forum\Thread;
use App\Forum\UserTitle;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {


    use dateParser;
    use HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'avatar', 'timezone', 'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * A user has many posts - relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * A user has many threads – relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * Check if user owns something
     *
     * @param $related
     * @return bool
     */
    public function owns($related)
    {
        return $this->id == $related->user_id;
    }

    /**
     * A user has one ban - aka a user has only one ban record
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ban()
    {
        return $this->hasOne(Banned::class);
    }

    /**
     * A user has one email verification record (contains the verification token)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emailVerification()
    {
        return $this->hasOne(EmailVerification::class);
    }

    /**
     * Return true if user has their email verified
     *
     * @return bool
     */
    public function emailVerified()
    {
        return !$this->emailVerification;
    }

    /**
     * Mark a user's current email address as unverified
     * Can accept an email to mark as unverified. If none provided, use user's current email address
     *
     * @param string $email
     */
    public function newEmailVerification($email = null)
    {
        // Delete any old not verified email records
        EmailVerification::whereUserId($this->id)->delete();
        $verification_email = $email ?: $this->email;
        // Set up a new verification token
        $this->emailVerification()->create(['token' => str_random(100), 'email' => $verification_email]);
    }

    /**
     * Verify a user's email
     */
    public function verifyEmail()
    {
        $this->email = $this->emailVerification->email;
        $this->save();
        $this->emailVerification->delete();
    }

    /**
     * Get the user's forum title.
     * Returns how many stars a user has, what their current user-title is (if custom set, return the custom set one),
     * etc.
     *
     * @return mixed
     */
    public function forumTitle()
    {
        // Get all user titles
        $titles = UserTitle::getTitles();

        // Find the user title that the user currently holds
        foreach ($titles as $title) {
            if ($title->posts <= $this->totalPosts()) {
                $main_title = $title;
            }
        }

        // If no user title found, just return false.
        if (!isset($main_title)) {
            return false;
        }

        // Set the title to that user title
        $user_title['title'] = $main_title->title;

        // If user has and is able to set their own, use that one instead
        if (isset($this->settings->user_title) && $this->settings->user_title != '' && $this->can('forum-user-title-custom')) {
            $user_title['title'] = $this->settings->user_title;
        }

        // Generate user stars
        $user_title['stars'] = $main_title->renderStars();

        // Return result
        return $user_title;
    }

    /**
     * Get the total number of posts a user has
     *
     * @return mixed
     */
    public function totalPosts()
    {
        return $this->posts->count();
    }

    /**
     * Hash the user password anytime user data is updated.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Change the route key name to whatever is set in database
     */
    public function getRouteKeyName()
    {
        return site('view-profile-user-display');
    }


    /**
     * Get new users
     *
     * @param $query
     * @return mixed
     */
    public function scopeNewUsers($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDay())->take(8)->get();
    }

    public function getAvatarAttribute($avatar)
    {
        if (!isset($avatar) || $avatar == '') {
            return url('images/default/avatar.png');
        }
        return $avatar;
    }

    /**
     * How the user's profile info should be displayed.
     * For instance, it may be set to a user's email from database, which will make this user's email appear instead of
     * their username throughout the site
     *
     * @return mixed
     */
    public function getInfoAttribute()
    {
        $view = site('view-profile-user-display');
        if (isset($view) || $view) {
            return $this->$view;
        }
        return $this->username;
    }

    /**
     * Determine if user has a signature
     *
     * @return bool
     */
    public function hasSignature()
    {
        return isset($this->signature) && $this->signature != '' ? true : false;
    }

    /**
     * Easier finding the user with their $info
     * Info being what the user display is in admin panel.
     *
     * @param $query
     * @param $info
     * @return mixed
     */
    public function scopeWhereInfo($query, $info)
    {
        return $query->where(site('view-profile-user-display'), $info);
    }

    /**
     * Generate user's profile URL and return it
     * You can parse it however you'd like (e.g. maybe adding a slug?)
     *
     * @return string
     */
    public function profileURL()
    {
        $site = site('view-profile-user-display');
        return route('viewProfile', $this->$site);
    }

    /**
     * Update general settings
     *
     * @param $request
     */
    public function updateGeneralSettings($request)
    {
        $this->avatar = $request->input('avatar');
        $this->about_me = $request->input('about_me');
        $this->timezone = $request->input('timezone');
    }

    /**
     * Update account settings
     *
     * @param $request
     */
    public function updateAccountSettings($request)
    {
        $this->email = $request->input('email');
        $this->username = $request->input('username');
    }

    /**
     * Update forum settings
     *
     * @param $request
     */
    public function updateForumSettings($request)
    {
        $this->signature = $request->input('signature');
        $this->per_page_posts = $request->input('per_page_threads');
        $this->per_page_threads = $request->input('per_page_posts');
    }

    /**
     * Update account privileges
     *
     * @param $request
     */
    public function updateAccountPrivileges($request)
    {
        $this->suspend_posts = $request->input('suspend_posts');
        $this->suspend_threads = $request->input('suspend_threads');
        $this->suspend_signature = $request->input('suspend_signature');
    }

    /**
     * Update private announcement
     *
     * @param $request
     */
    public function updatePrivateAnnouncement($request)
    {
        $announcement = $request->input('private_announcement') == '' ? $request->input('private_announcement') : null;
        $this->private_announcement = $announcement;
    }

    /**
     * Update mod settings
     *
     * @param $request
     */
    public function updateModSettings($request)
    {
        $this->note_on_user = $request->input('note_on_user');
    }

    /**
     * Update password
     *
     * @param $request
     */
    public function updatePassword($request)
    {
        $this->password = $request->input('password');
    }

    /**
     * Update role
     *
     * @param $request
     */
    public function updateRole($request)
    {
        $this->roles()->sync(array_merge((array)$request->input('roles'), [$request->input('primary_role')]));
    }

    /**
     * Check if the new password matches the current password
     *
     * @param $password
     * @return bool
     */
    public function passwordMatchesCurrent($password)
    {
        return \Hash::check($password, $this->password);
    }

    /**
     * Check if user has private announcement
     *
     * @return bool
     */
    public function hasPrivateAnnouncement()
    {
        return (strlen($this->private_announcement) > 0) ? true : false;
    }
}
