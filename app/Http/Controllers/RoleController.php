<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStore;
use App\Http\Requests\RoleUpdate;
use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        if (!$request->user()->can('roles.index')) {
            throw new AccessDeniedHttpException;
        }

        $currentRole = null;
        $roles = Role::search($request->get('q'))->paginate();
        $permissions = Permission::all('name');

        if ($request->has('id')) {
            $currentRole = Role::with('permissions')->find($request->get('id'));
        }

        return view('roles.index', compact('roles', 'currentRole', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleStore  $request
     *
     * @return mixed
     */
    public function store(RoleStore $request)
    {
        $validated = $request->validated();

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);

        $role->syncPermissions($validated['permissions']);

        return redirect()->back()->with('success', __('Created role: :name', ['name' => $role->name]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleUpdate  $request
     * @param  \App\Models\Role               $role
     *
     * @return mixed
     */
    public function update(RoleUpdate $request, Role $role)
    {
        $validated = $request->validated();

        $role->update([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);

        $role->syncPermissions($validated['permissions']);

        return redirect()->back()->with('success', __('Edited role: :name', ['name' => $role->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        if (!request()->user()->can('roles.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$role->delete()) {
            throw new AccessDeniedHttpException;
        }
        return [
            'message' => 'success',
        ];
    }
}
