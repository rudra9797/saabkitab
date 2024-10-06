<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a pending orders.
     */
    public function pendingOrders()
    {
        $row = (int) request('row', 100);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $orders = Order::where(['order_status'=>'pending','user_id'=> Auth::user()->id])
            ->filter(request(['search','customer_id']))
            ->sortable()
            ->paginate($row)
            ->appends(request()->query());
        $customers = Customer::where(['user_id'=>Auth::user()->id])->orderBy('name')->get();

        return view('orders.pending-orders', [
            'orders' => $orders,
            'customers' => $customers

        ]);
    }

    /**
     * Display a pending orders.
     */
    public function completeOrders()
    {
         $row =  Order::where(['order_status'=>'complete','user_id'=>Auth::user()->id])->count();

        $orders = Order::where(['order_status'=>'complete','user_id'=> Auth::user()->id])
        //$orders = Order::filter(request(['search']))
            ->filter(request(['search','customer_id']))
            ->sortable()
            ->paginate($row)
            ->appends(request()->query());

            // $orders = Order::filter(request(['search']))
            // ->where(['user_id'=>Auth::user()->id])
            // ->sortable()
            // ->paginate($row)
            // ->appends(request()->query());

        $customers = Customer::where(['user_id'=>Auth::user()->id])->orderBy('name')->get();
        return view('orders.complete-orders', [
            'orders' => $orders,
            'customers' => $customers
        ]);
    }

    public function dueOrders()
    {
        $row = (int) request('row', 100);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $orders = Order::where('due', '>', '0')
            ->where(['user_id'=> Auth::user()->id])
            ->filter(request(['search','customer_id']))
            ->sortable()
            ->paginate($row)
            ->appends(request()->query());
            $customers = Customer::where(['user_id'=>Auth::user()->id])->orderBy('name')->get();

        return view('orders.due-orders', [
            'orders' => $orders,
            'customers' => $customers

        ]);
    }

    /**
     * Display an order details.
     */
    public function dueOrderDetails(String $order_id)
    {
        $order = Order::where('id', $order_id)->first();
        $orderDetails = OrderDetails::with('product')
            ->where('order_id', $order_id)
            ->orderBy('id')
            ->get();

        return view('orders.details-due-order', [
            'order' => $order,
            'orderDetails' => $orderDetails,
        ]);
    }

    /**
     * Display an order details.
     */
    public function orderDetails(String $order_id)
    {
        $order = Order::where('id', $order_id)->first();
        $orderDetails = OrderDetails::with('product')
            ->where('order_id', $order_id)
            ->orderBy('id')
            ->get();

        return view('orders.details-order', [
            'order' => $order,
            'orderDetails' => $orderDetails,
        ]);
    }

    /**
     * Handle create new order
     */
    public function createOrder(Request $request)
    {

        $contents = Cart::content();
        $rules = [
            'customer_id' => 'required|numeric',
            'payment_type' => 'required|string',
            'pay' => 'required|numeric',
        ];

        $invoice_no = IdGenerator::generate([
            'table' => 'orders',
            'field' => 'invoice_no',
            'length' => 10,
            'prefix' => 'INV-'
        ]);

        $validatedData = $request->validate($rules);

        if($validatedData['payment_type']=='fromBalance'){
            $customer = Customer::findOrFail($validatedData['customer_id']);
            $advanceAmount = $customer->advance_amount;
            $balanceAmount = $advanceAmount - $validatedData['pay'];
            Customer::findOrFail($validatedData['customer_id'])->update([
                'advance_amount' => $balanceAmount,
            ]);
        }

        if(((int)Cart::total() - (int)$validatedData['pay'])<= 0 )
        {
            $orderStatus = "complete";
            $orderRedirectPage = "order.completeOrders";

        }else{
            $orderStatus = "pending";
            $orderRedirectPage = "order.pendingOrders";
        }

        $validatedData['order_date'] = Carbon::now()->format('Y-m-d');
        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['order_status'] = $orderStatus;
        $validatedData['total_products'] = Cart::count();
        $validatedData['sub_total'] = Cart::subtotal();
        $validatedData['vat'] = Cart::tax();
        $validatedData['invoice_no'] = $invoice_no;
        $validatedData['total'] = Cart::total();
        $validatedData['due'] = ((int)Cart::total() - (int)$validatedData['pay']);
        $validatedData['created_at'] = Carbon::now();

        $order_id = Order::insertGetId($validatedData);

        // Create Order Details
        $contents = Cart::content();
        $oDetails = array();
       
        foreach ($contents as $content) {
            // echo "<pre>";
            // print_r($content);die;
            $oDetails['order_id'] = $order_id;
            $oDetails['product_id'] = $content->id;
            $oDetails['quantity'] = $content->qty;
            $oDetails['unitcost'] = $content->price;
            $oDetails['actual_unitcost'] = $content->options->actual_price;
            $oDetails['total'] = $content->subtotal;
            $oDetails['created_at'] = Carbon::now();

            OrderDetails::insert($oDetails);
        }

        // Delete Cart Sopping History
        Cart::destroy();

        return Redirect::route($orderRedirectPage)->with('success', 'Order has been created!');
    }

    /**
     * Handle update a status order
     */
    public function updateOrder(Request $request)
    {
        $order_id = $request->id;

        // Reduce the stock
        $products = OrderDetails::where('order_id', $order_id)->get();

        foreach ($products as $product) {
            Product::where('id', $product->product_id)
                    ->update(['stock' => DB::raw('stock-'.$product->quantity)]);
        }

        Order::findOrFail($order_id)->update(['order_status' => 'complete']);

        return Redirect::route('order.completeOrders')->with('success', 'Order has been completed!');
    }

    /**
     * Handle update a due pay order
     */
    public function updateDueOrder(Request $request)
    {
        $rules = [
            'id' => 'required|numeric',
            'pay' => 'required|numeric'
        ];

        $validatedData = $request->validate($rules);
        $order = Order::findOrFail($validatedData['id']);
        //update advance amount of customer 
        if($order->payment_type=='fromBalance'){
            $customer = Customer::findOrFail($order->customer_id);
            $advanceAmount = $customer->advance_amount;
            $balanceAmount = $advanceAmount - $validatedData['pay'];
            Customer::findOrFail($order->customer_id)->update([
                'advance_amount' => $balanceAmount,
            ]);
        }

        $mainPay = $order->pay;
        $mainDue = $order->due;

        $paidDue = $mainDue - $validatedData['pay'];
        $paidPay = $mainPay + $validatedData['pay'];

        Order::findOrFail($validatedData['id'])->update([
            'due' => $paidDue,
            'pay' => $paidPay
        ]);

        return Redirect::route('order.dueOrders')->with('success', 'Due amount has been updated!');
    }

    /**
     * Handle to print an invoice.
     */
    public function downloadInvoice(Int $order_id)
    {
        $order = Order::with('customer')->where('id', $order_id)->first();
        $orderDetails = OrderDetails::with('product')
                        ->where('order_id', $order_id)
                        ->orderBy('id', 'DESC')
                        ->get();

        return view('orders.print-invoice', [
            'order' => $order,
            'orderDetails' => $orderDetails,
        ]);
    }

    /**
     * Handle to print customers invoice.
     */
    public function downloadCustomerInvoice(Int $customer_id)
    {

       $customer = Customer::find($customer_id);
       $order = Order::with('orderDetails')->without('customer')->where('customer_id', $customer_id)->orderBy('id', 'DESC')->get();
            // echo "<pre>";
            // print_r( $customer->name);die;
        //$order = Order::with('customer')->where('id', $customer_id)->first();

        // $orderDetails = OrderDetails::with('product')
        //                 ->where('order_id', $customer_id)
        //                 ->orderBy('id', 'DESC')
        //                 ->get();

        // echo "<pre>";
        // print_r( $orderDetails);die;

        return view('orders.print-customer-invoice', [
            'order' => $order,
            'customer' => $customer,
        ]);
    }
}
