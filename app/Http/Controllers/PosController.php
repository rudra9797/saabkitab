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
        //$row = (int) request('row', 50);
        $row = Product::where(['user_id' => Auth::user()->id])->count();

        $products = Product::with(['category', 'unit'])
            ->where(['user_id' => Auth::user()->id])
            ->filter(request(['search']))
            ->sortable()
            ->paginate($row)
            ->appends(request()->query());

        $customers = Customer::where(['user_id' => Auth::user()->id])->orderBy('name')->get();

        $carts = Cart::content();

        return view('pos.index', [
            'products' => $products,
            'customers' => $customers,
            'carts' => $carts,
            'categories' => Category::where(['user_id' => Auth::user()->id])->get(),
            'units' => Unit::where(['user_id' => Auth::user()->id])->get(),
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

        $product = Product::find($request->id);

        // Check if the product stock is available
        if ($product->stock <= 0) {
            return Redirect::back()->with('error', 'Product is out of stock.');
        }

        $validatedData = $request->validate($rules);

        $price = floatval($validatedData['price']);
        $numericOurPrice = number_format(floatval($request->our_price), 2);

        Cart::add([
            'id' => $validatedData['id'],
            'name' => $validatedData['name'],
            'qty' => 1,
            'price' => $numericOurPrice,
            'options' => ['actual_price' => $price]
        ]);

        $product->stock -= 1;
        $product->save();

        return Redirect::back()->with('success', 'Product has been added to cart!');
    }

    /**
     * Handle update product in cart.
     */
    public function updateCartItem(Request $request, $rowId)
    {
        $rules = [
            'qty' => 'required|numeric|between:1,100',
            'price' => 'required|numeric',
        ];
    
        // Validate the incoming request data
        $validatedData = $request->validate($rules);
    
        // Retrieve the cart item
        $cartItem = Cart::get($rowId);
        $product = Product::find($cartItem->id);
    
        // Check the difference in quantity
        $quantityDifference = $validatedData['qty'] - $cartItem->qty;

        // If quantity is increasing
        if ($quantityDifference > 0) {
            // Check if the requested quantity exceeds available stock
            if ($quantityDifference > $product->stock) {
                return Redirect::back()->with('error', 'The requested quantity exceeds the available stock.');
            }
        }
    
        // Update the stock based on the quantity difference
        $product->stock -= $quantityDifference;
        $product->save();

        $qty = intval($validatedData['qty']);
        $price = floatval($validatedData['price']);

        // Update the cart item
        Cart::update($rowId, ['qty' => $qty, 'price' => $price]);
    
        return Redirect::back()->with('success', 'Product has been updated in the cart!');
    }

    public function checkCustomerPhone(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        if ($customer && $customer->phone) {
            return response()->json(['phone_exists' => true]);
        } else {
            return response()->json(['phone_exists' => false]);
        }
    }

    public function saveCustomerPhone(Request $request)
    {
        // Define validation rules for customer creation
        $rules = [
            'name' => 'nullable|string|max:100', // Assuming a name field
            'phone' => 'required|unique:customers,phone',
            // Add other fields here as needed, e.g., address, city, etc.
        ];

        // Validate the incoming request data
        $validatedData = $request->validate($rules);

        // Assign the user_id from the authenticated user
        $validatedData['user_id'] = Auth::user()->id;

        // Create a new customer record
        Customer::create($validatedData);

        // Redirect back with a success message
        return Redirect::back()->with('success', 'New customer has been created!');
    }


    /**
     * Handle delete product from cart.
     */
    public function deleteCartItem(String $rowId)
    {
        // Get the current cart item
        $cartItem = Cart::get($rowId);

        // Remove the cart item
        Cart::remove($rowId);

        // Add the deleted quantity back to the product stock
        $product = Product::find($cartItem->id);
        $product->stock += $cartItem->qty;
        $product->save();


        return Redirect::back()->with('success', 'Product has been deleted from cart!');
    }

    /**
     * Handle create an invoice.
     */
    public function createInvoice(Request $request)
    {
        // Check if customer exists
        $customer = Customer::find($request->customer_id);

        if ($customer) {
            // If customer exists, return a successful JSON response
            return response()->json([
                'success' => true,
                'message' => 'Customer found successfully.',
                'customer' => $customer
            ]);
        } else {
            // If customer doesn't exist, return an error JSON response
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ], 404); // Use 404 status for not found
        }
    }


    public function invoiceCreate($id)
    {
        $customer = Customer::find($id);
        $carts = Cart::content();

        // dd($carts);

        return view('pos.create', [
            'customer' => $customer,
            'carts' => $carts
        ]);
    }
}
