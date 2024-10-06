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
                    <li class="breadcrumb-item active">Products</li>
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
                <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('products.create') }}" class="btn btn-primary add-list"><i class="fas fa-solid fa-plus mr-1"></i>Add</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Unit</th>
                        <th scope="col">MRP</th>
                        <th scope="col">Our Price</th>
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
                @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ (($products->currentPage() * (request('row') ? request('row') : 10)) - (request('row') ? request('row') : 10)) + $loop->iteration  }}</th>
                                    <td>
                                        <div style="max-height: 80px; max-width: 80px;">
                                            <img class="img-fluid"  src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/img/products/default.webp') }}">
                                        </div>
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->unit->name }}</td>
                                    <td>{{ $product->selling_price }}</td>
                                    <td>{{ number_format($product->our_price, 2) }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-success btn-sm mx-1"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary btn-sm mx-1"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
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