<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Product;
use App\Models\User;
use App\Models\Post;
use App\Models\Order;
use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $data = [];
        $data["countProduct"] = Product::withoutGlobalScope('enabled')->count();
        $data["countUser"] = User::count();
        $data["countPost"]    = Post::count();
        $data["countOrder"]   = Order::count();
        $data["latestOrders"]  = Order::orderBy('id', 'DESC')->take(8)->get();
        $data["recentlyAddedProducts"]  = Product::withoutGlobalScope('enabled')->with('productCategory')->orderBy('id', 'DESC')->take(3)->get();
        $data["mostViewedProduct"] = Product::withoutGlobalScope('enabled')->with('productCategory')->orderBy('view_count', 'DESC')->take(3)->get();
        
        return view('home.index', $data);
    }
}
