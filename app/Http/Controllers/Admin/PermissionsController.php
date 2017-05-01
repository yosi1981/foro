<?php

namespace App\Http\Controllers\Admin;

use App\User\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller {

    protected $indexURL;
    protected $permission;
    public function __construct()
    {
        parent::__construct();
        $this->indexURL = route('admin.role.permission.index');
        $this->middleware('admin.permission.modify', ['only' => ['edit', 'update', 'destroy']]);
    }

    /**
     * Show the index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $permissions = Permission::orderBy('system_required', 'desc')->orderBy('name')->get();
        return view('admin.role.permissions.index', compact('permissions'));
    }

    /**
     * Edit a specific permission
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        return view('admin.role.permissions.edit', compact('permission'));
    }

    /**
     * Create a new permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.role.permissions.create');
    }

    /**
     * Save the newly created permission in database
     * @param Requests\Admin\NewPermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Requests\Admin\NewPermissionRequest $request)
    {
        $permission = new Permission();
        $permission->updateInfo($request);
        flash(trans('admin.permission.create_success'));
        return redirect($this->indexURL);
    }

    /**
     * Update a permission
     * @param Permission                          $permission
     * @param Requests\Admin\NewPermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Permission $permission, Requests\Admin\NewPermissionRequest $request)
    {
        $permission->updateInfo($request);
        flash(trans('admin.permission.update_success'));
        return redirect($this->indexURL);
    }


    /**
     * Delete a permission
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect($this->indexURL);
    }

}
