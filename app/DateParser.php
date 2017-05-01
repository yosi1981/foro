<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App;


use Carbon\Carbon;

trait DateParser {


    /**
     * Parse the created_at date
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return $this->parseDate($date);
    }

    /**
     * Parse the updated_at date
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return $this->parseDate($date);
    }

    /**
     * Parse the deleted_at date only if the date even exists
     * @param $date
     * @return string
     */
    public function getDeletedAtAttribute($date)
    {
        if (isset($date))
            return $this->parseDate($date);
    }

    /**
     * Parse the date to human readable format (e.g. 13 hours ago).
     * Get the user's timezone from database and show them the time in human readable format.
     * Called in by all date attributes which require a human readable format
     * @param $date
     * @return string
     */
    function parseDate($date)
    {
        $timezone = user() ? user()->timezone : config('app.timezone');
        if ($timezone == '') $timezone = config('app.timezone');
        $formatted_date = Carbon::createFromTimestamp(strtotime($date))->timezone($timezone);

        // Parse the date accordingly depending on the site config
        if (!site('parse-date-human-readable'))
            return $formatted_date->format('M d, Y');
        return $formatted_date->diffForHumans();
    }
}