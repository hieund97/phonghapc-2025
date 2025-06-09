<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStore;
use App\Http\Requests\OrderUpdate;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('orders.index');

        $requestAll = Arr::except($request->all(), ['page', '_pjax']);

        $orderStatus = Order::$ORDERSTATUS;

        $orders = Order::when($request->customer_name, function ($query) use ($request) {
            $query->where('customer_name', 'LIKE', '%' . $request->customer_name . '%');
        })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', '=', $request->status);
            })
            ->when($request->id, function ($query) use ($request) {
                $query->where('id', '=', $request->id);
            })
            ->when($request->created_at, function ($query) use ($request) {
                $query->whereBetween('created_at', dateRangePicker($request->created_at));
            })
            ->when($request->order_id, function ($query) use ($request) {
                $query->where('order_id', $request->order_id);
            })
            ->when($request->provider_order_id, function ($query) use ($request) {
                $query->where('provider_order_id', $request->provider_order_id);
            })
            ->when($request->buy_type, function ($query) use ($request) {
                $query->where('buy_type', $request->buy_type);
            })
            ->with(['address', 'orderProducts.product:id,name'])
            ->orderBy('id', 'desc')
            ->paginate();

        return view('orders.index', compact('orders', 'requestAll', 'orderStatus'));
    }

    public function editable(Request $request)
    {
        $name = $request->get('name');
        $order = Order::findOrFail($request->get('pk'));
        $order->{$name} = $request->get('value');
        $order->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('orders.store')) {
            throw new AccessDeniedHttpException;
        }
        $orderStatus = Order::$ORDERSTATUS;
        $products = [];
        return view('orders.form', compact('orderStatus', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request      $request
     * @param \App\Http\Requests\OrderStore $request
     *
     * @return mixed
     */
    public function store(OrderStore $request)
    {
        $validated = $request->validated();

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'customer_mobile' => $validated['customer_mobile'],
            'customer_address' => $validated['customer_address'],
            'customer_note' => $validated['customer_note'],
            'note' => $validated['note'],
            'total_price' => $validated['total_price'],
            'extra_name' => $validated['extra_name'],
            'extra_price' => $validated['extra_price'],
            'total_payment_price' => $validated['total_payment_price'],
            'coupon_code' => $validated['coupon_code'],
            'status' => $validated['status'],
            'thumbnail' => $validated['thumbnail'],
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', __('Created order: :customer_name', ['customer_name' => $order->customer_name]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Order $order)
    {
        if (!$request->user()->can('orders.show')) {
            throw new AccessDeniedHttpException;
        }
        $orderStatus = Order::$ORDERSTATUS;
        $products = OrderProduct::where('order_id', '=', $order->id)->with('product')->get();
        return view('orders.show', compact('order', 'orderStatus', 'products'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request, Order $order)
    {
        if (!$request->user()->can('orders.show')) {
            throw new AccessDeniedHttpException;
        }
        $orderStatus = Order::$ORDERSTATUS;
        $products = OrderProduct::where('order_id', '=', $order->id)->with('product')->get();
        return view('orders.print', compact('order', 'orderStatus', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order        $order
     *
     * @return mixed
     */
    public function edit(Request $request, Order $order)
    {
        if (!$request->user()->can('orders.update')) {
            throw new AccessDeniedHttpException;
        }
        $orderStatus = Order::$ORDERSTATUS;
        $products = OrderProduct::where('order_id', '=', $order->id)->with('product')->get();
        return view('orders.form', compact('order', 'orderStatus', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\OrderUpdate $request
     * @param \App\Models\Order              $order
     *
     * @return mixed
     */
    public function update(OrderUpdate $request, Order $order)
    {
        $validated = $request->validated();

        $order->update($validated);

        return redirect()
            ->route('orders.index')
            ->with('success', __('Updated order: :title', ['title' => $order->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order        $order
     *
     * @return void
     * @throws \Exception
     */
    public function destroy(Request $request, Order $order): void
    {
        if (!$request->user()->can('orders.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$order->delete()) {
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
        $this->authorize('orders.update');
        $type = $request->input('type');
        $value = $request->input('value');
        $id = $request->input('id');
        $dataUpdate = [$type => $value];
        $result = Order::where('id', '=', $id)->update($dataUpdate);

        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
}
