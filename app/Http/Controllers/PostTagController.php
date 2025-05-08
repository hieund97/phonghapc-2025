<?php

namespace App\Http\Controllers;

use App\Models\PostTag;
use Illuminate\Http\Request;
use App\Http\Requests\PostTagStore;
use App\Http\Requests\PostTagUpdate;
use Illuminate\Http\RedirectResponse;
use Str;
use Cache;

class PostTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $this->authorize('post_tags.index');
        $currentPostTag = null;
        $postTags = PostTag::search($request->get('q'))
            ->paginate();

        if ($request->has('id')) {
            $currentPostTag = PostTag::findOrFail($request->get('id'));
        }
        return view('post_tags.index', compact('postTags', 'currentPostTag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostTagStore  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostTagStore $request): RedirectResponse
    {
        $data = $request->validated();
        $postTag = PostTag::create($data);
        $this->storeExtraData($postTag, $data);

        Cache::pull('post_tag_options');
        return redirect()
            ->back()
            ->with('success', __('Created postTag: :name', ['name' => $data['title']]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostTagUpdate  $request
     * @param  \App\Models\PostTag               $postTag
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostTagUpdate $request, PostTag $postTag): RedirectResponse
    {
        $data = $request->validated();

        $postTag->update($data);

        $this->storeExtraData($postTag, $data);
        Cache::pull('post_tag_options');
        return redirect()
            ->back()
            ->with('success', __('Updated postTag: :name', ['name' => $data['title']]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostTag  $postTag
     *
     * @return void
     */
    public function destroy(PostTag $postTag): void
    {
        $this->authorize('post_tags.destroy');
        $postTag->delete();
    }

    /**
     * Store post extra data
     *
     * @param \App\Models\PostTag $post
     * @param array            $data
     *
     * @return void
     */
    public function storeExtraData(PostTag $postTag, array $data): void
    {
        // SEO
        if (!empty($postTag->seo)) {
            $postTag->seo()->update($data['seo']);
        } else {
            
            $postTag->seo()->create($data['seo']);

        }
    }
}
