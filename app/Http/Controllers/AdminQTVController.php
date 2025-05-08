<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AdminQTVController extends Controller
{
    public $routeName = 'admins';

    protected function getRouteName()
    {
        return request('route_name', $this->routeName);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('users.index');

        return view('users.admin.index', [
            // 'users' => User::search($request->get('q'))->whereHas('roles')->orWhereHas('permissions')->with('roles')->paginate(),
            'users' => User::role('Super Admin')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('users.store');

        $roles = [];
        if (auth()->user()->can('users.assignRoles')) {
            $roles = Role::all();
        }

        $permissions = [];
        if (auth()->user()->can('users.assignPermissions')) {
            $permissions = Permission::all();
        }

        return view('users.admin.form', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {

        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        if ($request->user()->can('users.assignRoles')) {
            $user->syncRoles($validated['roles'] ?? []);
        }

        if ($request->user()->can('users.assignPermissions')) {
            $user->syncPermissions($validated['permissions'] ?? []);
        }
        return redirect()->route($this->getRouteName() . '.index')->with('success',
            __('Created admin: :name', ['name' => $user->name]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (!$request->user()->can('users.update')) {
            throw new AccessDeniedHttpException;
        }
        $user = User::findOrFail($id);
        $user->load(['roles', 'permissions']);

        $roles = [];
        if (auth()->user()->can('users.assignRoles')) {
            $roles = Role::all();
        }

        $permissions = [];
        if (auth()->user()->can('users.assignPermissions')) {
            $permissions = Permission::all();
        }

        return view('users.admin.form', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, $id)
    {
        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = bcrypt($validated['password']);
        }
        $user = User::findOrFail($id);

        $user->update($data);

        if ($request->user()->can('users.assignRoles')) {
            $user->syncRoles($validated['roles'] ?? []);
        }

        if ($request->user()->can('users.assignPermissions')) {
            $user->syncPermissions($validated['permissions'] ?? []);
        }

        return redirect()->route($this->getRouteName() . '.index')->with('success', __('Updated admin: :name', ['name' => $user->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$request->user()->can('users.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$user->delete()) {
            throw new AccessDeniedHttpException;
        }
    }
}
