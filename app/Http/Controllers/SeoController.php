<?php

namespace App\Http\Controllers;

use App\Models\Seo;
use Illuminate\Http\Request;
use App\Http\Requests\SeoUpdate;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Http\JsonResponse;

class SeoController extends Controller
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
        $this->authorize('seos.index');

        $requestAll = Arr::except($request->all(), ['page', '_pjax']);
        $model = $request->get('model');

        if(!$model) {
            return redirect()->route('seos.index',['model'=>'App\Models\Product']);
        }
        list($with, $name) = $this->getByModel($model);

        $seos = Seo::filter($request->all())
            ->with($with)
            ->orderByDesc('id')
            ->paginate();
        return view(
            'seos.index',
            compact(
                'seos',
                'requestAll',
                'with',
                'name'
            )
        );
    }

    public function getByModel($model)
    {

        $with = '';
        $name = 'title';
        switch ($model) {
            case "App\\Models\\ProductCategory":
                $with = 'productCategory';
                $name = 'title';
                break;
            case "App\\Models\\Product":
                $with = 'product';
                $name = 'name';
                break;
            case "App\\Models\\Category":
                $with = 'category';
                $name = 'title';
                break;
            case "App\\Models\\Post":
                $with = 'post';
                $name = 'title';
                break;
            case "App\\Models\\Page":
                $with = 'page';
                $name = 'title';
                break;
            case "App\\Models\\ProductTag":
                $with = 'productTag';
                $name = 'title';
                break;
            case "App\\Models\\PostTag":
                $with = 'postTag';
                $name = 'title';
                break;                                   
        }

        return array($with, $name);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Seo         $seo
     *
     * @return mixed
     */
    public function edit(Request $request, Seo $seo)
    {
        if (!$request->user()->can('seos.update')) {
            throw new AccessDeniedHttpException;
        }

        $model = $seo->model;
        list($with, $name) = $this->getByModel($model);

        return view(
            'seos.form',
            compact(
                'seo',
                'with',
                'name',
                )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateSeo $request
     * @param \App\Models\Seo              $seo
     *
     * @return mixed
     */
    public function update(SeoUpdate $request, Seo $seo)
    {
        $data = $request->validated();

        if ($seo->update($data['seo'])) {
        }

        return redirect()->route('seos.index',['model'=>$seo->model])->with('success', __('Updated seo: :title', ['title' => $seo->title]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function quickUpdate(Request $request): JsonResponse
    {
        $this->authorize('seos.update');
        $type = $request->input('type');
        $value = $request->input('value');
        $id = $request->input('id');
        $dataUpdate = [$type => $value];
        $result = Seo::where('id', '=', $id)->update($dataUpdate);
        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
}
