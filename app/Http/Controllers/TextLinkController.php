<?php

namespace App\Http\Controllers;

use App\Exports\PostsExport;
use App\Exports\TextlinksExport;
use App\Models\TextLink;
use Illuminate\Http\Request;
use App\Http\Requests\TextLinkStore;
use App\Http\Requests\TextLinkUpdate;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Excel;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Http\JsonResponse;

class TextLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('text_links.index');

        $requestAll = Arr::except($request->all(), ['page', '_pjax']);

        $textLinks = TextLink::filter($request->all())
            ->with('productCategory')
            ->with('category')
            ->with('productTag')
            ->with('postTag')
            ->orderByDesc('id')
            ->paginate();
        return view('text_links.index', compact('textLinks', 'requestAll',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('text_links.store')) {
            throw new AccessDeniedHttpException;
        }
        return view('text_links.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TextLinkStore $request
     *
     * @return mixed
     */
    public function store(TextLinkStore $request)
    {
        $data = $request->validated();

        $textLink = TextLink::create($data);

        return redirect()->route('text_links.index')->with('success', __('Created textLink: :title', ['title' => $textLink->id]));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TextLink         $textLink
     *
     * @return mixed
     */
    public function edit(Request $request, TextLink $textLink)
    {
        if (!$request->user()->can('text_links.update')) {
            throw new AccessDeniedHttpException;
        }

        return view('text_links.form', compact('textLink'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTextLink $request
     * @param \App\Models\TextLink              $textLink
     *
     * @return mixed
     */
    public function update(TextLinkUpdate $request, TextLink $textLink)
    {
        $data = $request->validated();

        if ($textLink->update($data)) {
        }

        return redirect()->route('text_links.index')->with('success', __('Updated textLink: :title', ['title' => $textLink->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TextLink         $textLink
     *
     * @return void
     * @throws \Exception
     */
    public function destroy(Request $request, TextLink $textLink): void
    {
        if (!$request->user()->can('text_links.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$textLink->delete()) {
            throw new AccessDeniedHttpException;
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function quickUpdate(Request $request): JsonResponse
    {
        $this->authorize('text_links.update');
        $type = $request->input('type');
        $value = $request->input('value');
        $id = $request->input('id');
        $dataUpdate = [$type => $value];
        $result = TextLink::where('id', '=', $id)->update($dataUpdate);

        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function getCategory(Request $request)
    {
        $model = $request->input('model');
        if ($model == 'Home') {
            return '';
        } else if ($model == 'App\Models\ProductCategory') {
            return view('partials.forms.product_category_options');
        } else if ($model == 'App\Models\Category') {
            return view('partials.forms.category_options');
        }
        else if ($model == 'App\Models\ProductTag') {
            return view('partials.forms.product_tag_options');
        }
        else if ($model == 'App\Models\PostTag') {
            return view('partials.forms.post_tag_options');
        }
    }

    public function export(){
        return \Maatwebsite\Excel\Facades\Excel::download(new TextlinksExport, 'textlinks_' . date('Ymd_His') . '.xlsx');
    }
}
