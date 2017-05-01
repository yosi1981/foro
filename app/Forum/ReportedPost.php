<?php

namespace App\Forum;

use App\DateParser;
use App\User\User;
use Illuminate\Database\Eloquent\Model;

class ReportedPost extends Model {

    use DateParser;

    protected $table = 'forum_reported_posts';
    protected $fillable = ['user_id', 'post_id', 'reason', 'resolved'];

    /**
     * A report belongs to a user as they reported it
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark all reports that belong to one specific post as resolved
     * @return mixed
     */
    public function markAsResolved()
    {
        Cache::recache('reported_posts_count');
        return $this->reports()->update(['resolved' => true]);
    }

    /**
     * Delete all reports that belong to one specific post
     * @return mixed
     */
    public function deleteReport()
    {
        Cache::recache('reported_posts_count');
        return $this->reports()->delete();
    }

    /**
     * Scope to get all new reports that have not been marked read
     * @param $query
     * @return mixed
     */
    public function scopeNewReports($query)
    {
        return $query->allReports()->where('resolved', false);
    }

    /**
     * Scope to get all reports from database
     * @param $query
     * @return mixed
     */
    public function scopeAllReports($query)
    {
        return $query->with('user', 'post.thread', 'post.reports')->groupBy('post_id')->orderBy('created_at', 'desc');
    }

    /**
     * Find all reports that belong to the same reported post
     * @param $query
     * @return mixed
     */
    public function scopeReports($query)
    {
        return $query->where('post_id', $this->post_id);
    }
    
    /**
     * A report belongs to a post
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class)->withTrashed();
    }

    /**
     * Get all reasons to report a post
     */
    public static function reasons()
    {
        $reasons = preg_split('/[\n\,]+/', site('forum-report-post-reasons'));
        sort($reasons);
        $reasons = array_combine($reasons, $reasons);
        return array_merge($reasons, ['Other' => trans('site.other')]);
    }

}
