<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\OperationLog;
use App\Models\User;
use App\Models\Option;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('settings.index');
        $options = Option::get();
        return view('setting.index', compact('options'));
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function log(Request $request)
    {
        $this->authorize('settings.log');
        $requestAll = Arr::except($request->all(), ['page', '_pjax']);
        $methods = OperationLog::$methods;
        $logs    = OperationLog::when($request->user, function ($query) use ($request) {
            $query->where('user_id', 'LIKE', '%' . $request->user . '%');
        })
            ->when($request->path, function ($query) use ($request) {
                $query->where('path', 'LIKE', '%' . $request->path . '%');
            })
            ->when($request->getMethod(), function ($query) use ($request) {
                $query->where('method', '==', $request->getMethod());
            })
            ->when($request->ip, function ($query) use ($request) {
                $query->where('ip', 'LIKE', '%' . $request->ip . '%');
            })
            ->when($request->created_at, function ($query) use ($request) {
                $query->whereBetween('created_at', dateRangePicker($request->created_at));
            })
            ->with('user')
            ->orderBy('id', 'desc')
            ->paginate();
        /*Todo*/
        $users = User::with('roles')->with('permissions')->get();
        return view('setting.log', compact('logs', 'requestAll', 'methods', 'users'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('settings.destroy');
        $ids = explode(',', $id);
        if ($ids && !OperationLog::destroy(array_filter($ids))) {
            throw new AccessDeniedHttpException;
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $this->authorize('settings.update');
        $data = Arr::except($request->all(), ['_token', '_pjax']);
        if(empty($data['is_popup'])){
            $data['is_popup']=0;
        }
        foreach ($data as $name => $value) {
            $option = Option::where('option_name', '=', $name)->update(["option_value" => $value]);
        }
        \Cache::forget('api_settings');
        \Cache::forget('mail_config');
        \Cache::pull('main-setting');
        return redirect()->route('settings.index')->with('success', __('Updated success'));
    }
}
