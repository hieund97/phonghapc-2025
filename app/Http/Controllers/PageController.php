<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageStore;
use App\Http\Requests\PageUpdate;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('pages.index');

        return view('pages.index', [
            'pages' => Page::orderByDesc('id')->paginate(),
        ]);
    }

    /**
     * Display the preview content of the resource.
     *
     * @param \App\Models\Page $page
     *
     * @return mixed|string
     */
    public function preview(Page $page)
    {
        $this->authorize('pages.index');

        return $page->content;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('pages.store');

        return view('pages.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PageStore $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PageStore $request): RedirectResponse
    {
        $this->authorize('pages.store');

        $page = Page::create($data = $request->validated());

        //if (!empty($data['seo'])) {
            $page->seo()->create($data['seo']);
       // }

        return redirect()->route('pages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Page $page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Page $page)
    {
        $this->authorize('pages.update');

        return view('pages.form', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\PageUpdate $request
     * @param \App\Models\Page              $page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PageUpdate $request, Page $page): RedirectResponse
    {
        $this->authorize('pages.update');

        $page->update($data = $request->validated());

        $page->seo()->update($data['seo']);
  
        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Page $page
     *
     * @return void
     * @throws \Exception
     */
    public function destroy(Page $page): void
    {
        $this->authorize('pages.destroy');

        $page->delete();
    }
}
