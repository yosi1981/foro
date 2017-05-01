<?php

namespace App\Forum;

use App\Core\Cache;
use Illuminate\Database\Eloquent\Model;

class UserTitle extends Model {

    protected $table = 'forum_user_titles';
    protected $fillable = ['posts', 'title', 'stars'];

    public $timestamps = false;

    /**
     * Return all user titles
     *
     * @return mixed
     */
    public static function getTitles()
    {
        return Cache::grab('user_titles');
    }

    /**
     * Render the image tag for stars
     *
     * @return string
     */
    public function renderStars()
    {
        $default_star_img = site('star-image-empty');
        $star_img = $this->star_img ?: site('star-image');
        return
            str_repeat("<img height='16' width='16' src='$star_img'>", $this->stars) .
            str_repeat("<img height='16' width='16' src='$default_star_img'>", site('star-max') - $this->stars);
    }

}