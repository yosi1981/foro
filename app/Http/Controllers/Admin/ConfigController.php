<?php

namespace App\Http\Controllers\Admin;

use App\Core\Cache;
use App\Core\Setting;
use App\Core\SettingGroup;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfigController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->middleware('demo', ['only' => ['update']]);
    }

    /**
     * Show the configuration page
     *
     * @param SettingGroup $settings_group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(SettingGroup $settings_group)
    {
        if (!count($settings_group->subGroups)) {
            $settings_group = SettingGroup::where('is_category', true)->first();
        }
        $sub_groups = $settings_group->subGroups;
        return view('admin.config.index', compact('settings_group', 'sub_groups'));
    }

    /**
     * Update the settings
     *
     * @param SettingGroup                     $settings_group
     * @param Requests\Admin\SaveConfigRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SettingGroup $settings_group, Requests\Admin\SaveConfigRequest $request)
    {
        foreach ($request->all() as $key => $value) {
            $setting = Setting::where('name', $key)->first();
            // Check if $setting exists because of the "_token" filed in input.
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            }
        }

        flash(trans('admin.config.update_success'));
        Cache::recache('settings');
        return redirect(route('admin.config.index', $settings_group->id));
    }

}
