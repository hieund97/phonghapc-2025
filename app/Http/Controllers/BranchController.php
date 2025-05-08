<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchPriority;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\View;
use App\Http\Requests\BranchStore;
use App\Http\Requests\BranchUpdate;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->user()->can('branches.index')) {
            throw new AccessDeniedHttpException;
        }
        $branches = Branch::search($request->get('q'))->orderBy('id', 'DESC')->paginate();
        return view('branches.index', compact('branches'));
    }

    /**
     * Save sort priority of the resource.
     *
     * @param \App\Http\Requests\BranchPriority $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function priority(BranchPriority $request)
    {
        foreach ($request->validated()['data'] as $data) {
            Branch::whereId($data['id'])->update(['sort' => $data['priority']]);
        }

        return redirect()->back()->with('success', 'Success');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('branches.store')) {
            throw new AccessDeniedHttpException;
        }
        return view('branches.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\\BranchStore  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchStore $request)
    {
        $branch = Branch::create($request->validated());

        return redirect()->route('branches.index')->with('success', __('Created branch: :title', ['title' => $branch->title]));
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
     * @param  \App\Models\Branch        $branch
     *
     * @return mixed
     */
    public function edit(Request $request, Branch $branch)
    {
        if (!$request->user()->can('branches.update')) {
            throw new AccessDeniedHttpException;
        }
        return view('branches.form', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BranchUpdate  $request
     * @param  \App\Models\Branch               $branch
     *
     * @return mixed
     */
    public function update(BranchUpdate $request, Branch $branch)
    {
        $branch->update($request->validated());

        return redirect()->route('branches.index')->with('success', __('Updated branch: :title', ['title' => $branch->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \App\Models\Branch             $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Branch $branch)
    {
        if (!$request->user()->can('branches.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$branch->delete()) {
            throw new AccessDeniedHttpException;
        }
    }
}
