<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $row = (int) request('row', 50);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $products = Product::with(['category', 'unit'])
                ->where(['user_id'=>Auth::user()->id])
                ->filter(request(['search']))
                ->sortable()
                ->paginate($row)
                ->appends(request()->query());

        $customers = Customer::where(['user_id'=>Auth::user()->id])->orderBy('name')->get();
        $carts = Cart::content();

        return view('pos.index', [
            'products' => $products,
            'customers' => $customers,
            'carts' => $carts,
            'categories' => Category::where(['user_id'=> Auth::user()->id])->get(),
            'units' => Unit::where(['user_id'=> Auth::user()->id])->get(),
        ]);
    }

    /**
     * Handle add product to cart.
     */
    public function addCartItem(Request $request)
    {
        $rules = [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'price' => 'required|numeric',
        ];

        $validatedData = $request->validate($rules);

        Cart::add([
            'id' => $validatedData['id'],
            'name' => $validatedData['name'],
            'qty' => 1,
            'price' => $validatedData['price'],
            'options'=>['actual_price' => $validatedData['price']]
        ]);

        return Redirect::back()->with('success', 'Product has been added to cart!');
    }

    /**
     * Handle update product in cart.
     */
    public function updateCartItem(Request $request, $rowId)
    {

      
        $rules = [
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
        ];

        $validatedData = $request->validate($rules);
        // echo "<pre>";
        // print_r($validatedData);
        // print_r(Cart::content());
        
       // die;
        Cart::update($rowId, $validatedData['qty']);
        Cart::update($rowId, ['price' => $validatedData['price']]);

        return Redirect::back()->with('success', 'Product has been updated from cart!');
    }

    /**
     * Handle delete product from cart.
     */
    public function deleteCartItem(String $rowId)
    {
        Cart::remove($rowId);

        return Redirect::back()->with('success', 'Product has been deleted from cart!');
    }

    /**
     * Handle create an invoice.
     */
    public function createInvoice(Request $request)
    {
        $rules = [
            'customer_id' => 'required|string'
        ];

        $validatedData = $request->validate($rules);
        $customer = Customer::where('id', $validatedData['customer_id'])->first();
        $carts = Cart::content();

        return view('pos.create', [
            'customer' => $customer,
            'carts' => $carts
        ]);
    }
}
