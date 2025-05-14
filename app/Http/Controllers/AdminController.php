<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AdminController extends Controller
{
    public $routeName = 'users';

    protected function getRouteName()
    {
        return request('route_name', $this->routeName);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('users.index');

        return view('users.index', [
            'users' => User::role('Customers')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
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

        return view('users.form', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\UserStore $request
     *
     * @return mixed
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
            __('Created user: :name', ['name' => $user->name]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User         $user
     *
     * @return mixed
     */
    public function edit(Request $request, User $user)
    {
        if (!$request->user()->can('users.update')) {
            throw new AccessDeniedHttpException;
        }

        $user->load(['roles', 'permissions']);

        $roles = [];
        if (auth()->user()->can('users.assignRoles')) {
            $roles = Role::all();
        }

        $permissions = [];
        if (auth()->user()->can('users.assignPermissions')) {
            $permissions = Permission::all();
        }

        return view('users.form', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserUpdate $request
     * @param \App\Models\User              $user
     *
     * @return mixed
     */
    public function update(UserUpdate $request, User $user)
    {
        $validated = $request->validated();

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = bcrypt($validated['password']);
        }

        $user->update($data);

        if ($request->user()->can('users.assignRoles')) {
            $user->syncRoles($validated['roles'] ?? []);
        }

        if ($request->user()->can('users.assignPermissions')) {
            $user->syncPermissions($validated['permissions'] ?? []);
        }

        return redirect()->route($this->getRouteName() . '.index')->with('success',
            __('Updated user: :name', ['name' => $user->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User         $user
     *
     * @return void
     * @throws \Exception
     */
    public function destroy(Request $request, User $user): void
    {
        if (!$request->user()->can('users.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$user->delete()) {
            throw new AccessDeniedHttpException;
        }
    }
}
