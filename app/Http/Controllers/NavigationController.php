<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Navigation;
use App\Http\Requests\NavigationStore;
use App\Http\Requests\NavigationUpdate;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navigations = Navigation::orderByDesc('id')->paginate();
        return view('navigations.index',compact('navigations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('navigations.store')) {
            throw new AccessDeniedHttpException;
        }
        return view('navigations.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NavigationStore $request)
    {
        $data = $request->validated();
        $navigations = Navigation::create($data);

        return redirect()->route('navigations.index');
    }

    public function updateNavigation($id,$navigation,$request){
        $order = Navigation::find($id,$navigation);
        $order->update($request->order);
        return "success";
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (!$request->user()->can('navigations.update')) {
            throw new AccessDeniedHttpException;
        }
        $navigations = Navigation::find($id);
        return view('navigations.form', compact('navigations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NavigationUpdate $request, Navigation $navigation)
    {
        $validated = $request->validated();
        $navigation->update($validated);

        return redirect()->route('navigations.index')->with('success', __('Updated navigation: :name', ['name' => $navigation->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('navigations.destroy');
        $navigations = Navigation::find($id);

        $navigations->delete();
    }
}
