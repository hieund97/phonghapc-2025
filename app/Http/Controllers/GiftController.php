<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Gift;
use App\Models\Product;
use App\Http\Requests\GiftStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('product_categories.index');
        $aryGift = $this->getGift($request);

        return view('gift.index', compact('aryGift'));
    }

    protected function getGift(Request $request)
    {
        return Gift::filter($request->all())
                   ->orderByDesc('id')
                   ->paginate()
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gift.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(GiftStore $request)
    {
        $data = $request->validated();
        \DB::beginTransaction();

        try {
            $gift = Gift::create($data);
            $gift->category()->sync($data['product_category_id'] ?? []);

            \DB::commit();
            //all good
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back();
        }

        return redirect()
            ->back()
            ->with('success', __('Created Gift: :name', ['name' => $data['name']]))
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Gift $gift
     * @return \Illuminate\Http\Response
     */
    public function edit(Gift $gift)
    {
        return view('gift.create', compact('gift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Gift         $gift
     * @return \Illuminate\Http\Response
     */
    public function update(GiftStore $request, Gift $gift)
    {
        $data = $request->validated();

        if ($gift->update($data)) {
            $gift->category()->sync($data['product_category_id'] ?? []);
        }

        return redirect()
            ->back()
            ->with('success', __('Updated Gift: :name', ['name' => $data['name']]))
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Gift $gift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gift $gift)
    {
        $this->authorize('product_categories.destroy');
        $gift->delete();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function quickUpdate(Request $request): JsonResponse
    {
        $this->authorize('product_categories.update');
        $type       = $request->input('type');
        $value      = $request->input('value');
        $id         = $request->input('gift_id');
        $dataUpdate = [$type => $value];
        $result     = Gift::where('id', $id)
                               ->update($dataUpdate)
        ;

        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
}
