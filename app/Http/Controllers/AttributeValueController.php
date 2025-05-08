<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeValueStore;
use App\Http\Requests\AttributeValueUpdate;
use App\Models\AttributeValue;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Cache;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('attribute.index');
        $arrAttributeValue = $this->getAttribute($request);

        return view('attribute_value.index', compact('arrAttributeValue'));
    }

    protected function getAttribute(Request $request)
    {
        return AttributeValue::filter($request->all())
                             ->orderByDesc('id')
                             ->paginate()
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|
     */
    public function create()
    {
        return view('attribute_value.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeValueStore $request
     * @return RedirectResponse
     */
    public function store(AttributeValueStore $request)
    {
        $data           = $request->validated();
        $attributeValue = AttributeValue::create($data);
        $this->storeExtraData($attributeValue, $data);

        Cache::pull('attribute_value_options');

        return redirect()
            ->back()
            ->with('success', __('Created attribute: :name', ['name' => $data['title']]))
        ;
    }

    /**
     * Store product extra data
     *
     * @param AttributeValue $attribute
     * @param array          $data
     *
     * @return void
     */
    public function storeExtraData(AttributeValue $attribute, array $data): void
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
        $result     = AttributeValue::where('id', $id)
                                    ->update($dataUpdate)
        ;

        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param         $id
     * @return View
     */
    public function edit(Request $request, $id)
    {
        $currentAttrValue = AttributeValue::findOrFail($id);

        return view('attribute_value.create', compact('currentAttrValue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeValueUpdate $request
     * @param AttributeValue       $attributeValue
     * @return RedirectResponse
     */
    public function update(AttributeValueUpdate $request, AttributeValue $attributeValue)
    {
        $data = $request->validated();

        $attributeValue->update($data);

        $this->storeExtraData($attributeValue, $data);

        Cache::pull('attribute_value_options');

        return redirect()
            ->back()
            ->with('success', __('Updated Attribute: :name', ['name' => $data['title']]))
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AttributeValue $attributeValue
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy(AttributeValue $attributeValue)
    {
        $this->authorize('attribute.destroy');
        Cache::pull('attribute_options');
        $attributeValue->delete();
    }
}
