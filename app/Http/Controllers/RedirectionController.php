<?php

namespace App\Http\Controllers;

use App\Exports\PostsExport;
use App\Exports\RedirectionsExport;
use Illuminate\Http\Request;
use App\Models\Redirection;
use Illuminate\Support\Facades\View;
use App\Http\Requests\RedirectionStore;
use App\Http\Requests\RedirectionUpdate;
use Cache;
use Maatwebsite\Excel\Facades\Excel;

class RedirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->user()->can('redirections.index')) {
            throw new AccessDeniedHttpException;
        }
        $redirectionType =  Redirection::TYPE;
        $redirections = Redirection::search($request->get('q'))->orderBy('id', 'DESC')->paginate();
        return view('redirections.index', compact('redirections', 'redirectionType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('redirections.store')) {
            throw new AccessDeniedHttpException;
        }
        $redirectionType =   Redirection::TYPE;
        return view('redirections.form', compact('redirectionType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\\RedirectionStore  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RedirectionStore $request)
    {
        $validated = $request->validated();
        $redirection = Redirection::create([
            'link_from'          => $validated['link_from'],
            'link_to'            => $validated['link_to'],
            'type'               => $validated['type'],
        ]);

        Cache::pull('redirections');
        return redirect()->route('redirections.index')->with('success', __('Created redirection: :link_from', ['link_from' => $redirection->link_from]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Redirection        $redirection
     *
     * @return mixed
     */
    public function edit(Request $request, redirection $redirection)
    {
        if (!$request->user()->can('redirections.update')) {
            throw new AccessDeniedHttpException;
        }
        $redirectionType =   Redirection::TYPE;
        return view('redirections.form', compact('redirection', 'redirectionType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RedirectionUpdate  $request
     * @param  \App\Models\Redirection               $redirection
     *
     * @return mixed
     */
    public function update(RedirectionUpdate $request, Redirection $redirection)
    {
        $validated = $request->validated();
        $data = [
            'link_from'          => $validated['link_from'],
            'link_to'            => $validated['link_to'],
            'type'               => $validated['type'],
        ];

        $redirection->update($data);

        Cache::pull('redirections');

        return redirect()->route('redirections.index')->with('success', __('Updated redirection: :link_from', ['link_from' => $redirection->link_from]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \App\Models\Redirection             $redirection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Redirection $redirection)
    {
        if (!$request->user()->can('redirections.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$redirection->delete()) {
            throw new AccessDeniedHttpException;
        }
    }
    public function export(){
        return Excel::download(new RedirectionsExport, 'redirections_' . date('Ymd_His') . '.xlsx');
    }
}
