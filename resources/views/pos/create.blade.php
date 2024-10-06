<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/bootstrap.min.css') }}">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/style.css') }}">
</head>
<body>

<!-- BEGIN: Invoice -->
<div class="invoice-16 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- BEGIN: Invoice Details -->
                <div class="invoice-inner-9" id="invoice_wrapper">
                    <div class="invoice-top">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="logo">
                                    <h1>{{Auth::user()->name}}</h1>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <!-- <div class="invoice">
                                    <h1>Invoice # <span>123456</span></h1>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="invoice-info">
                        <div class="row">
                            <div class="col-sm-6 mb-50">
                                <div class="invoice-number">
                                    <h4 class="inv-title-1">Invoice date:</h4>
                                    <p class="invo-addr-1">
                                        {{ Carbon\Carbon::now()->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-50">
                                <h4 class="inv-title-1">Customer</h4>
                                <p class="inv-from-1">{{ $customer->name }}</p>
                                <p class="inv-from-1">{{ $customer->phone }}
                                </p>
                                <p class="inv-from-1">{{ $customer->email }}</p>
                                <p class="inv-from-2">{{ $customer->address }}</p>
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
                    <div class="order-summary">
                        <div class="table-outer">
                            <table class="default-table invoice-table">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>MRP</th>
                                    <th>Our Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($carts as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->options->actual_price }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->subtotal }}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="4"><strong>**You Saved </strong></td>
                                    <td><strong>{{Cart::totalSaving()}}</strong></td>
                                </tr> 
                                <tr>
                                    <td colspan="4"><strong>Total</strong></td>
                                    <td><strong>{{ Cart::total() }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center py-2">
                            <p><strong>Thank you for shopping with us! We hope to see you again soon.</strong></p>
                        </div>
                        

                    </div>
                    {{-- <div class="invoice-informeshon-footer">
                        <ul>
                            <li><a href="#">www.website.com</a></li>
                            <li><a href="mailto:sales@hotelempire.com">info@example.com</a></li>
                            <li><a href="tel:+088-01737-133959">+62 123 123 123</a></li>
                        </ul>
                    </div> --}}
                </div>
                <!-- END: Invoice Details -->

                <!-- BEGIN: Invoice Button -->
                <div class="invoice-btn-section clearfix d-print-none">
                    <a class="btn btn-lg btn-primary" href="{{ route('pos.index') }}">
                        Back
                    </a>
                    <button class="btn btn-lg btn-download" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                        Pay Now
                    </button>
                    <a class="btn btn-lg btn-success text-white" 
   href="https://api.whatsapp.com/send?phone={{ '91'. $customer->phone }}&text=Hello%20*{{ $customer->name }}*,%0A%0A&#128512;%20*Thank%20you%20for%20choosing%20us!*%20&#128512;%0A%0AWe%20are%20pleased%20to%20inform%20you%20that%20your%20invoice%20has%20been%20successfully%20generated%20by%20*{{ Auth::user()->name }}*%20at%20*{{ Auth::user()->store_name ?? 'SAAB KITAB' }}*.%20Here%20are%20the%20details:%0A%0A**&#128181;%20Amount%20Due:**%20INR%20*{{ Cart::total() }}*%0A**&#128184;%20Total%20Savings:**%20INR%20*{{ Cart::totalSaving() }}*%0A%0AIf%20you%20have%20any%20questions%20or%20need%20further%20assistance,%20feel%20free%20to%20reply%20to%20this%20message.%20We’re%20here%20to%20help!%0A%0AThank%20you%20for%20your%20business!%20&#128522;" 
   class="btn btn-outline-success btn-sm mx-1" 
   target="_blank">
                        <!-- WhatsApp SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="1.5em" width="1.5em"><path fill="#fff" d="M380.9 97.1C339 55.1 283.2 32 223.9 32 101.5 32 2 131.6 2 254.2c0 43.3 11.3 85.7 32.8 122.9L0 480l127.2-33.5c35.1 19.1 74.5 29.2 115.1 29.2 121.9 0 221.7-99.8 221.7-222.5 0-59.2-23-114.8-65.1-156.1zm-157 338.9c-33.1 0-65.5-8.9-94.4-25.6l-6.8-4-70.3 18.4 19.3-68.5-4.4-7c-18.4-29.3-28.2-63.2-28.2-98.2 0-101.6 82.9-184.5 184.6-184.5 49.2 0 95.4 19.2 130.2 54 34.7 34.9 54 81.1 54 130.3-.1 101.6-82.9 184.5-184.6 184.5zm101.1-138.2c-5.5-2.8-32.7-16.2-37.8-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.2 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                    </a>
                    
                    {{-- <a class="btn btn-lg btn-success text-white" href="https://api.whatsapp.com/send?phone={{ '91'. $customer->phone }}&text=Your invoice at {{Auth::user()->name}} of amount INR {{ Cart::total() }} " class="btn btn-outline-success btn-sm mx-1" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#26a269}</style><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg></a> --}}


                    {{-- <a href="https://api.whatsapp.com/send?phone={{ $customer->phone }}&text=Your invoice at {{Auth::user()->name}} of amount INR {{ Cart::total() }} " class="btn btn-outline-success btn-sm mx-1" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#26a269}</style><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg></a> --}}

                </div>
                <!-- END: Invoice Button -->
            </div>
        </div>
    </div>
</div>
<!-- END:Invoice -->

<!-- BEGIN: Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center mx-auto" id="modalCenterTitle">Invoice of {{ $customer->name }}<br/>Total Amount {{ Cart::total() }}<br/>Balance Advance amount {{  $customer->advance_amount }}</h3>
            </div>

            <form action="{{ route('pos.createOrder') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <div class="mb-3">
                            <!-- Form Group (type of product category) -->
                            <label class="small mb-1" for="payment_type">Payment <span class="text-danger">*</span></label>
                            <select class="form-control @error('payment_type') is-invalid @enderror" id="payment_type" name="payment_type" required>
                                <option value="HandCash">Cash</option>
                                <option value="fromBalance">From Balance Amount</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                            @error('payment_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="pay">Pay Now <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control form-control-solid @error('pay') is-invalid @enderror" id="pay" name="pay" placeholder="" value="{{ old('pay') }}" autocomplete="off" required/>
                            @error('pay')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-lg btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-lg btn-download" type="submit">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: Modal -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>
