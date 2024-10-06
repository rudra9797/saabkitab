<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/fonts/font-awesome/css/font-awesome.min.css') }}">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/style.css') }}">
    <style>
        .invoice-16 .default-table thead th {
            position: relative;
            padding: 5px 10px;
            font-size: 16px;
            color: #25cc7e;
            font-weight: 500;
            line-height: 30px;
            white-space: nowrap;
        }

        .invoice-16 .default-table tr td {
            position: relative;
            padding: 11px 20px;
            font-size: 14px;
            color: #535353;
            font-weight: 400;
        }
    </style>
</head>

<body>
    <!-- BEGIN: Invoice -->
    <div class="invoice-16 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner-9" id="invoice_wrapper">
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="logo">
                                        <h3>{{Auth::user()->name}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-info">
                            <div class="row">
                                <div class="col-sm-6 mb-50">
                                    <h4 class="inv-title-1">Customer</h4>
                                    <p class="inv-from-1">{{ $customer->name }}</p>
                                    <p class="inv-from-1">{{$customer->phone}}</p>
                                    <p class="inv-from-1">{{$customer->email}}</p>
                                    <p class="inv-from-2">{{$customer->address}}</p>
                                </div>
                                <div class="col-sm-6 text-end mb-50">
                                    <h4 class="inv-title-1">Store</h4>
                                    <p class="inv-from-1">{{Auth::user()->name}}</p>
                                    <p class="inv-from-1">{{Auth::user()->phone}}</p>
                                    <p class="inv-from-1">{{Auth::user()->email}}</p>
                                    <p class="inv-from-2">{{Auth::user()->address}}</p>
                                </div>
                            </div>
                        </div>
                        @foreach ($order as $ord)
                        <div class="invoice-info pb-1">
                            <div class="row ">
                                <div class="col-lg-6 col-sm-6 ">
                                    <div class="invoice">
                                        <h4>Invoice # <span>{{ $ord->invoice_no }}</span></h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 text-end ">
                                    <p class="inv-from-1"><span>Order Date: </span>{{ $ord->order_date }}</p>
                                    <p class="inv-from-1"><span>Status: </span>{{ $ord->order_status }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-summary pb-5">
                            <div class="table-outer">
                                <table class="default-table invoice-table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Our Price</th>
                                            <th>Actual Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ord->orderDetails as $item)
                                        <tr>
                                            <td>{{ $item->product->product_name }}</td>
                                            <td>{{ $item->unitcost }}</td>
                                            <td>{{ $item->actual_unitcost }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>{{ $ord->total }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i> Print Invoice
                        </a>
                        <a id="invoice_download_btn" class="btn btn-lg btn-download">
                            <i class="fa fa-download"></i> Download Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Invoice -->

    <script src="{{ asset('assets/invoice/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/html2canvas.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/app.js') }}"></script>

</body>

</html>