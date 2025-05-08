<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends AdminController
{
    public $routeName = 'buyers';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('users.buyers', [
            'users' => User::search($request->get('q'))
                ->whereDoesntHave('roles')
                ->whereDoesntHave('permissions')
                ->with(['socials', 'orders:id'])
                ->orderByDesc('id')
                ->paginate(),
        ]);
    }
}
