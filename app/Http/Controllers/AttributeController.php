<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeStore;
use App\Http\Requests\AttributeUpdate;
use App\Models\Attribute;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Cache;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('attribute.index');
        $arrAttribute = $this->getAttribute($request);

        return view('attribute.index', compact('arrAttribute'));
    }

    protected function getAttribute(Request $request)
    {
        return Attribute::filter($request->all())
                        ->orderByDesc('id')
                        ->paginate()
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        return view('attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeStore $request
     * @return RedirectResponse
     */
    public function store(AttributeStore $request)
    {
        $data          = $request->validated();
        $data['model'] = 'App\Models\Product';
        $attribute     = Attribute::create($data);
        $this->storeExtraData($attribute, $data);

        Cache::pull('attribute_options');

        return redirect()
            ->back()
            ->with('success', __('Created attribute: :name', ['name' => $data['title']]))
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request, $id)
    {
        $currentAttrCategory = Attribute::findOrFail($id);

        return view('attribute.create', compact('currentAttrCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeUpdate $request
     * @param Attribute       $attribute
     * @return RedirectResponse
     */
    public function update(AttributeUpdate $request, Attribute $attribute)
    {
        $data = $request->validated();

        $attribute->update($data);

        $this->storeExtraData($attribute, $data);

        Cache::pull('category_options');

        return redirect()
            ->back()
            ->with('success', __('Updated Attribute: :name', ['name' => $data['title']]))
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Attribute $attribute
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Attribute $attribute)
    {
        $this->authorize('attribute.destroy');
        Cache::pull('attribute_options');
        $attribute->delete();
    }

    /**
     * Store product extra data
     *
     * @param Attribute $attribute
     * @param array     $data
     *
     * @return void
     */
    public function storeExtraData(Attribute $attribute, array $data): void
    {
        // SEO
        if (!empty($attribute->seo)) {
            $attribute->seo()->update($data['seo']);
        } else {
            $attribute->seo()->create($data['seo']);
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
        $this->authorize('attribute.update');
        $type       = $request->input('type');
        $value      = $request->input('value');
        $id         = $request->input('attribute_id');
        $dataUpdate = [$type => $value];
        $result     = Attribute::where('id', $id)
                               ->update($dataUpdate)
        ;

        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
}
