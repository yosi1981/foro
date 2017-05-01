<?php

namespace App\Http\Controllers\Admin;

use App\Core\PermissionSettings;
use App\Core\SelectInput;
use App\User\Permission;
use App\User\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class RolesController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->middleware('demo', ['only' => ['update', 'updatePermissions']]);
    }

    /**
     * Roles index page - show all roles
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::orderBy('system_required', 'desc')->orderBy('display_name')->with('users')->get();
        return view('admin.role.index', compact('roles'));
    }


    /**
     * All users in a role
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users(Role $role)
    {
        $users = $role->users()->paginate(20);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show a specific role
     *
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Role $role)
    {
        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the page to edit a role
     *
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update a role
     *
     * @param Role                          $role
     * @param Requests\Admin\NewRoleRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Role $role, Requests\Admin\NewRoleRequest $request)
    {
        $role->updateRole($request);
        if ($request->ajax()) {
            return response()->json(['redirect' => route('admin.role.show', $role->name)]);
        }
        return redirect(route('admin.role.show', $role->name));
    }

    /**
     * Show the page to create a  new role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store the new role in database
     *
     * @param Requests\Admin\NewRoleRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Requests\Admin\NewRoleRequest $request)
    {
        $role = new Role;
        $role->updateRole($request);
        if ($request->input('copy_permissions_role')) {
            $copy_role = Role::find($request->input('copy_permissions_role'));
            foreach ($copy_role->permissions as $permission) {
                $role->permissions()->attach($permission->id);
            }
        }
        if ($request->ajax()) {
            return response()->json(['redirect' => route('admin.role.permission.role.edit', $role->name)]);
        }
        return redirect(route('admin.role.permission.role.edit', $role->name));
    }

    /**
     * Show the page to edit the permissions
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPermissions(Role $role)
    {
        $setting_groups = PermissionSettings::where('is_category', 1)->with('subPermissions.settings')->get();
        return view('admin.role.edit_permissions', compact('role', 'setting_groups'));
    }

    /**
     * Update the edited permissions and store them in database
     * @param Role    $role
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updatePermissions(Role $role, Request $request)
    {
        if ($request->has('permission')) {
            $role->permissions()->sync(array_keys($request->input('permission')));
        }
        flash(trans('admin.role.permission_update_success'));
        return redirect(route('admin.role.edit', $role->name));
    }

    /**
     * Delete a specific role
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        if ($role->system_required) {
            flash()->error(trans('admin.role.delete_error'));
            return redirect()->back();
        }
        $role->delete();
        flash(trans('admin.role.delete_success'));
        return redirect(route('admin.role.index'));
    }

}
