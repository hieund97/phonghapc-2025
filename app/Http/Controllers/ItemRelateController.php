<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRelateStore;
use App\Http\Requests\ItemRelateUpdate;
use App\Models\ItemRelate;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ItemRelateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = $request->get("model");
        $modelId = $request->get("model_id");
        $itemRelates = ItemRelate::where('model',$model)->where('model_id',$modelId)
            ->orderByDesc('id')
            ->paginate();
        return view('item_relates.index', compact('itemRelates','model','modelId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $model = $request->get("model");
        $modelId = $request->get("model_id");
        return view('item_relates.form', compact('model','modelId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( ItemRelateStore $request)
    {


        $data = $request->validated();
        // $data['model'] = "Model/Product";
        // $data['model_id'] = "1";
        // $data['sort'] = "1";
        $itemRelate = ItemRelate::create($data);
        return redirect()
            ->route('item_relates.index',["model"=>$itemRelate->model,'model_id'=>$itemRelate->model_id])
            ->with('success', __('Created itemrelate: :temrelate', ['title' => $itemRelate->title]));
    }

    // public function storeExtraData(ItemRelate $itemRelate, array $data): void
    // {
    //     if (!empty($data['categories'])) {
    //         $itemRelate->categories()->sync($data['categories']);
    //     }


    //     $itemRelate->itemRelates->create($data['item_relate']);
    // }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,ItemRelate $itemRelate)
    {
        $model = $request->get("model");
        $modelId = $request->get("model_id");

       return view('item_relates.form', compact('itemRelate','model','modelId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRelateUpdate $request, ItemRelate $itemRelate )
    {


        $data = $request->validated();


        $itemRelate->update($data);




        return redirect()->route('item_relates.index',['model'=>$itemRelate->model,'model_id'=>$itemRelate->model_id])->with('success',__('Updated itemrelate: :name', ['name' => $itemRelate->title]));;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemRelate $itemRelate)
    {

        $itemRelate->delete();


    }
}
