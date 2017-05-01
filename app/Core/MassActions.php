<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App\Core;


trait MassActions {

    /**
     * Mass actions are used by many different classes and functions.
     * For instance, mass-junking posts and threads, mass-banning users, etc.
     *
     * @param           $methodCheckIn
     * @param           $model
     * @param           $request
     * @param bool|null $success_message
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function massActions($methodCheckIn, $model, $request, $success_message = false)
    {
        $results = explode(',', $request->input('model-input'));
        $action = $request->input('action');

        if (!method_exists($methodCheckIn, $action)) {
            return redirect()->back()->withErrors(trans('mod.invalid_action'));
        }
        foreach ($results as $single_result) {
            if (method_exists($model, 'bootSoftDeletes')) {
                $result = $model::withTrashed()->where('id', $single_result)->firstOrFail();
            } else {
                $result = $model::where('id', $single_result)->firstOrFail();
            }
            $this->$action($result);
        }

        if ($success_message) {
            flash($success_message);
        }

        return redirect()->back();
    }

}