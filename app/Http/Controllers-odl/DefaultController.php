<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefaultController extends Controller
{
    // Get all products by category
    public function GetProducts(Request $request){
        $category_id = $request->category_id;
        $allProduct = Product::where('category_id',$category_id)->get();

        return response()->json($allProduct);
    }
    /**
     * Dashboard page.
     */
    public function index()
    {
        $totalOrders = Order::where(['order_status'=>'complete','user_id'=> Auth::user()->id])->count();
        $pendingOrders = Order::where(['order_status'=>'pending','user_id'=> Auth::user()->id])->count();
        $dueOrders = Order::where(['user_id'=> Auth::user()->id])->where('due', '>', '0')->count();

        $totalProducts = Product::where(['user_id'=> Auth::user()->id])->count();

        $allUsersCount = User::where(['is_admin'=> 0])->count();
        $allUsersProducts = Product::count();
        $allCustomers = Customer::count();

        return view('dashboard.index', [
           'totalOrders' => $totalOrders,
           'pendingOrders' => $pendingOrders,
           'dueOrders' => $dueOrders,
           'totalProducts' => $totalProducts,
           'allUsersCount' => $allUsersCount,
           'allUsersProducts' => $allUsersProducts,
           'allCustomers' => $allCustomers,

        ]);
    }
}
