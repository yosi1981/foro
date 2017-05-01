<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App\Core;

use App\DateParser;
use App\Forum\Post;
use App\Forum\Thread;
use App\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Core extends Model {

    protected $fillable = ['name', 'value'];
    protected $table = 'core';

    use dateParser;

    /**
     * Moderation scope to retrieve the mod note
     *
     * @param $query
     * @return mixed
     */
    public function scopeModerationNote($query)
    {
        return $query->whereName('mod_note')->first();
    }

    /**
     * Admin scope to retrieve the admin note
     * @param $query
     * @return mixed
     */
    public function scopeAdminNote($query)
    {
        return $query->whereName('admin_note')->first();
    }

    /**
     * Create a new note (either admin or moderation)
     *
     * @param $for
     * @param $request
     */
    public static function createNote($for, $request)
    {
        $log = Core::firstOrCreate(['name' => $for]);
        $log->value = $request->input('note');
        $log->save();
        return $log;
    }

    /**
     * Create a new moderation note
     *
     * @param $request
     * @return mixed
     */
    public static function createModNote($request)
    {
        return Core::createNote('mod_note', $request);
    }

    /**
     * Create a new admin note
     *
     * @param $request
     * @return mixed
     */
    public static function createAdminNote($request)
    {
        return Core::createNote('admin_note', $request);
    }

    /**
     * How many results to be displayed in an option for a per-page select dropdown
     * @return array
     */
    public static function per_page()
    {
        return [5, 10, 15, 20, 25, 30, 40, 50, 60, 80, 100];
    }

    /**
     * Purify text by stripping certain HTML tags
     * @param $text
     * @return string
     */
    public static function purifyHTML($text)
    {
        return strip_tags($text, '<b></br><h><ol><ul><li><u><i><p><span><div><a>');
    }

    public static function getDatabaseSize()
    {
        $sizes = DB::select(' SELECT table_name AS `table`,
            round(((data_length + index_length) / 1024 / 1024), 2) `size`
            FROM information_schema.TABLES
            WHERE table_schema = "' . config('database.connections.mysql.database') . '"');
        return collect($sizes);
    }

    /**
     * Get stats from cache
     * @param $name
     * @return int
     */
    public static function getStat($name)
    {
        $stat = Cache::get($name);
        return $stat ?: self::recountStat($name);
    }

    /**
     * Recount stats
     * @param $stat_name
     * @return bool|int
     */
    public static function recountStat($stat_name)
    {
        $stat = Core::whereName($stat_name)->first();
        if (!$stat) {
            \Log::warning("Stat name '{$stat_name}' while recounting stat.");
            return false;
        }
        $value = 0;
        switch ($stat_name) {
            case 'total_users':
                $value = User::count();
                break;
            case 'total_threads':
                $value = Thread::count();
                break;
            case 'total_posts':
                $value = Post::count();
                break;
        }
        $stat->value = $value;
        $stat->save();

        Cache::recache($stat_name, $value);
        return $value;
    }

    /**
     * Get the default role the user receives upon registration
     * @return mixed
     */
    public static function defaultRole()
    {
        return site('user-default-role-on-registration');
    }

    /**
     * Get the signature settings from database
     * @return string
     */
    public static function signatureAttributes()
    {
        return 'style="width:' .
        site('signature-max-width') . 'px; max-height:' .
        site('signature-max-height') . 'px; overflow: hidden" ';
    }

}
