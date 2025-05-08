<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\View;
use App\Http\Requests\TagStore;
use App\Http\Requests\TagUpdate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->user()->can('tags.index')) {
            throw new AccessDeniedHttpException;
        }
        $tagType =  Tag::TYPE;
        $tags =  $this->getTag($request);
        return view('tags.index', compact('tags', 'tagType'));
    }

    protected function getTag(Request $request): LengthAwarePaginator
    {
        return Tag::filter($request->all())
            ->orderByDesc('id')
            ->paginate();
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('tags.store')) {
            throw new AccessDeniedHttpException;
        }
        $tagType =   Tag::TYPE;
        return view('tags.form', compact('tagType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagStore $request)
    {
        $data = $request->validated();
        $tag = Tag::create($data);

        return redirect()->route('tags.index')->with('success', __('Created tag: :name', ['name' => $tag->name]));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Tag $tag)
    {
        if (!$request->user()->can('tags.update')) {
            throw new AccessDeniedHttpException;
        }
        $tagType =   Tag::TYPE;

        return view('tags.form', compact('tag','tagType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdate $request, Tag $tag): RedirectResponse
    {
        $data = $request->validated();

        $tag->update($data);

        return redirect()
            ->back()
            ->with('success', __('Updated category: :name', ['name' => $data['name']]));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tag $tag)
    {
        if (!$request->user()->can('tags.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$tag->delete()) {
            throw new AccessDeniedHttpException;
        }
    }
}
