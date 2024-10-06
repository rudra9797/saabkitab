@extends('dashboard.body.main')

@section('specificpagestyles')
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@stop


@section('content')

<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Units</h1> -->

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Due Orders</li>
    </ol>
</nav>
<!-- BEGIN: Alert -->
@if (session()->has('success'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    {{ session('success') }}
</div>
@endif

<!-- END: Alert -->


<!-- DataTales Example -->
<div class="card shadow ">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6  my-auto">
                <h6 class="m-0 font-weight-bold text-primary">Due Orders</h6>
            </div>
            <div class="col-md-6 text-right">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Invoice No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Payment</th>
                        <th scope="col">Paid</th>
                        <th scope="col">Due</th>
                        <th scope="col">Action</th>
                      
                    </tr>
                </thead>
                <!-- <tfoot>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Unit Name</th>
                            <th scope="col">Unit Slug</th>
                            <th scope="col">Action</th>
                        </tr>
                    </tfoot> -->
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ (($orders->currentPage() * (request('row') ? request('row') : 10)) - (request('row') ? request('row') : 10)) + $loop->iteration  }}</th>
                        <td>{{ $order->invoice_no }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>{{ $order->payment_type }}</td>
                        <td>
                            <span class="btn btn-warning btn-sm">{{ $order->pay }}</span>
                        </td>
                        <td>
                            <span class="btn btn-danger btn-sm">{{ $order->due }}</span>
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="https://api.whatsapp.com/send?phone={{ $order->customer->phone }}&text={{URL::to('/')}}  Your payment is pending at {{Auth::user()->name}} of amount INR {{ $order->due }} " class="btn btn-outline-success btn-sm mx-1" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#26a269}</style><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg></a>
                                <a href="{{ route('order.dueOrderDetails', $order->id) }}" class="btn btn-outline-success btn-sm mx-1"><i class="fas fa-money-bill"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('specificpagescripts')
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables-demo.js') }}"></script>
@stop

@endsection
<?php /*?>


@extends('dashboard.body.main')

@section('content')
<!-- BEGIN: Header -->
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto my-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fa-solid fa-clock"></i></div>
                        Due Order List
                    </h1>
                </div>
                <div class="col-auto my-4">
                    <a href="{{ route('pos.index') }}" class="btn btn-primary add-list my-1"><i class="fa-solid fa-plus me-3"></i>Add</a>
                    <a href="{{ route('order.dueOrders') }}" class="btn btn-danger add-list my-1"><i class="fa-solid fa-trash me-3"></i>Clear Search</a>
                </div>
            </div>

            <nav class="mt-4 rounded" aria-label="breadcrumb">
                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Due Orders</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- BEGIN: Alert -->
    <div class="container-xl px-4 mt-n4">
        @if (session()->has('success'))
        <div class="alert alert-success alert-icon" role="alert">
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon-aside">
                <i class="far fa-flag"></i>
            </div>
            <div class="alert-icon-content">
                {{ session('success') }}
            </div>
        </div>
        @endif
    </div>
    <!-- END: Alert -->
</header>
<!-- END: Header -->


<!-- BEGIN: Main Page Content -->
<div class="container px-2 mt-n10">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mx-n4">
                <div class="col-lg-12 card-header mt-n4">
                    <form action="{{ route('order.dueOrders') }}" method="GET">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="form-group row align-items-center">
                                <label for="row" class="col-auto">Row:</label>
                                <div class="col-auto">
                                    <select class="form-control" name="row">
                                        <option value="10" @if(request('row')=='10' )selected="selected" @endif>10</option>
                                        <option value="25" @if(request('row')=='25' )selected="selected" @endif>25</option>
                                        <option value="50" @if(request('row')=='50' )selected="selected" @endif>50</option>
                                        <option value="100" @if(request('row')=='100' )selected="selected" @endif>100</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row align-items-center justify-content-between">
                                <label class="control-label col-sm-3" for="search">Search:</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <select class="form-select form-control-solid  selectpicker p-0  @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id"  data-live-search="true" data-container="body">
                                            <option selected="" disabled="">Select a customer:</option>
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" @if(request('customer_id')==$customer->id) selected="selected" @endif>{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" id="search" class="form-control me-1" name="search" placeholder="Search order" value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20 text-white"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <hr>

                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Invoice No</th>
                                    <th scope="col">@sortablelink('customer.name', 'name')</th>
                                    <th scope="col">@sortablelink('order_date', 'date')</th>
                                    <th scope="col">Payment</th>
                                    <th scope="col">@sortablelink('pay')</th>
                                    <th scope="col">@sortablelink('due')</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <th scope="row">{{ (($orders->currentPage() * (request('row') ? request('row') : 10)) - (request('row') ? request('row') : 10)) + $loop->iteration  }}</th>
                                    <td>{{ $order->invoice_no }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->payment_type }}</td>
                                    <td>
                                        <span class="btn btn-warning btn-sm">{{ $order->pay }}</span>
                                    </td>
                                    <td>
                                        <span class="btn btn-danger btn-sm">{{ $order->due }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="https://api.whatsapp.com/send?phone={{ $order->customer->phone }}&text={{URL::to('/')}}  Your payment is pending at {{Auth::user()->name}} of amount INR {{ $order->due }} " class="btn btn-outline-success btn-sm mx-1" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                                            <a href="{{ route('order.dueOrderDetails', $order->id) }}" class="btn btn-outline-success btn-sm mx-1"><i class="fa-solid fa-money-bill"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
<!-- END: Main Page Content -->
@endsection
<?php */?>