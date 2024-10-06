@extends('dashboard.body.main')

@section('specificpagestyles')
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap-select.css') }}" rel="stylesheet" />
@stop


@section('content')

    <!-- Page Heading -->

    {{-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">POS</li>
    </ol>
</nav> --}}
    <!-- BEGIN: Alert -->
    @if (session()->has('success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-warning">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            {{ session('error') }}
        </div>
    @endif

    <!-- END: Alert -->


    <!-- DataTales Example -->
    <div class="card shadow ">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6  my-auto">
                    <h6 class="m-0 font-weight-bold"><a href="{{ route('dashboard') }}"
                            class="text-decoration-none">Dashboard</a> / POS</h6>
                </div>
                <div class="col-md-6 text-right">
                    <h6 class="m-0 font-weight-bold text-primary"> Point of Sale</h6>
                </div>
            </div>
        </div>
        <div class="row py-4 px-1">
            <div class="col-md-6 pr-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cart</h6>
                    </div>
                    <div class="card-body p-1">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">MRP</th>
                                        <th scope="col">Our Price</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">SubTotal</th>
                                        <th scope="col" data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->options->actual_price }}</td>
                                            <form action="{{ route('pos.updateCartItem', $item->rowId) }}" method="POST">
                                                @csrf
                                                <td style="min-width: 75px;">
                                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control px-2" name="price"
                                                            required value="{{ old('price', $item->price) }}">
                                                    </div>

                                                </td> 
                                                <td style="min-width: 120px;">

                                                    <div class="input-group">

                                                        <input onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" type="text" class="form-control px-2 @error('qty') is-invalid @enderror" name="qty"
                                                            required value="{{ old('qty', $item->qty) }}">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-success border-none"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="Sumbit"><i
                                                                    class="fas fa-check"></i></button>
                                                        </div>
                                                        @error('qty')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                </td>
                                            </form>
                                            <td>{{ number_format($item->subtotal, 2) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <form action="{{ route('pos.deleteCartItem', $item->rowId) }}"
                                                        method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this record?')">
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
                        <!-- END: Table Cart -->

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (total product) -->
                            <div class="col-md-6">
                                <label class="small mb-1">Total Product</label>
                                <div class="form-control form-control-solid fw-bold text-red">{{ Cart::count() }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Total</label>
                                <div class="form-control form-control-solid fw-bold text-red">{{ number_format((float) Cart::total(), 2) }}</div>
                            </div>
                        </div>
                        <!-- Form Row -->
                        <form action="{{ route('save.customer.phone') }}" method="POST">
                            @csrf
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control px-2" id="name" name="name"
                                            required placeholder="Name">
                                    </div>
                                    <div id="name" class="text-danger mt-2"></div> <!-- Error message container -->
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input
                                            onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                            type="text" class="form-control px-2" id="phone_number" name="phone"
                                            required placeholder="Enter phone number" maxlength="10">
                                        <div class="input-group-append">
                                            <button type="submit" id="savePhoneNumber"
                                                class="btn btn-success border-none" data-toggle="tooltip"
                                                title="Submit"><i class="fas fa-check"></i></button>
                                        </div>
                                    </div>
                                    <div id="phoneError" class="text-danger mt-2"></div> <!-- Error message container -->
                                </div>
                            </div>
                        </form>

                        <form id="createInvoiceForm">
                            @csrf
                            <div class="row mb-0">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="customer_id">Customer <span class="text-danger">*</span></label>
                                    <select class="form-select form-control-solid selectpicker p-0 @error('customer_id') is-invalid @enderror"
                                        id="customer_id" name="customer_id" data-live-search="true" data-container="body">
                                        <option selected="" disabled="">Select a customer:</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" @if (old('customer_id') == $customer->id) selected="selected" @endif>
                                                {{ $customer->name ?? $customer->phone }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                        
                                <div class="col-md-6">
                                    <!-- Append input field dynamically here -->
                                    <div id="phoneNumberInput" class="mt-3"></div>
                                </div>
                        
                                <!-- Submit button -->
                                <div class="col-md-12 mt-4">
                                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                                        <button type="submit" class="btn btn-success add-list mx-1">Create Invoice</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Success message -->
                        <div id="successMessage" class="mt-3 text-success" style="display: none;">Invoice created successfully!</div>
                        
                        <!-- jQuery CDN -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        <script>
                            $(document).ready(function() {
                                // Handle form submission
                                $('#createInvoiceForm').on('submit', function(e) {
                                    e.preventDefault(); // Prevent the default form submission

                                    // Get the form data
                                    let formData = $(this).serialize();
                                    let customerId = $('#customer_id').val(); // Get selected customer ID

                                   // Make the AJAX request
                                    $.ajax({
                                        url: "{{ route('pos.createInvoice') }}",
                                        method: "POST",
                                        data: formData,
                                        success: function(response) {
                                            if (response.success) {
                                                window.location.href = "{{ url('pos/invoice') }}/" + response.customer.id;
                                            } else {
                                                alert(response.message);
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            alert('Error: ' + xhr.responseJSON.message || error);
                                        }
                                    });
                                });
                            });

                        </script>

                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-0">
                <div class="card shadow mb-4">

                    <div class="card-header m-0 font-weight-bold text-primary">List Product
                        <button class="btn btn-primary add-list mx-1 float-right" type="button" data-toggle="modal"
                            data-target="#modalProduct" id="addProductButton"> Add Product</button>
                    </div>
                    <div class="card-body p-0">
                        <!-- BEGIN: Search products -->


                        <!-- BEGIN: Products List -->
                        <div class="col-lg-12 p-2">
                            <div class="table-responsive py-0">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" style='width: 5%;'>No.</th>
                                            <th scope="col" style='width: 45%;'>Name</th>
                                            <th scope="col" style='width: 10%;'>Stock</th>
                                            <th scope="col" style='width: 25%;'>Unit</th>
                                            <th scope="col" style='width: 10%;'>MRP</th>
                                            <th scope="col" style='width: 10%;'>Our Price</th>
                                            <th scope="col" style='width: 5%;'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr>
                                                <th scope="row">
                                                    {{ $products->currentPage() * (request('row') ? request('row') : 10) - (request('row') ? request('row') : 10) + $loop->iteration }}
                                                </th>

                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->stock }}</td>
                                                <td>{{ $product->unit->name }}</td>
                                                <td>{{ $product->selling_price }}</td>
                                                <td>{{ number_format($product->our_price, 2) }}</td>
                                                <td>
                                                    <div class="d-flex ">
                                                        <form class=""
                                                            action="{{ route('pos.addCartItem', $product->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $product->id }}">
                                                            <input type="hidden" name="name"
                                                                value="{{ $product->product_name }}">
                                                            <input type="hidden" name="price"
                                                                value="{{ $product->selling_price }}">

                                                                <input type="hidden" name="our_price"
                                                                value="{{ $product->our_price }}">

                                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <th colspan="6" class="text-center">
                                                    Data not found!
                                                </th>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        @section('specificpagescripts')
            <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('assets/js/datatables-demo.js') }}"></script>
            <script src="{{ asset('assets/js/bootstrap-select.js') }}"></script>
        @stop


        <!-- BEGIN: Modal -->
        <div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center mx-auto" id="modalCenterTitle">ADD Product</h3>
                    </div>

                    <div class="container-xl px-2 mt-n10">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4">
                                    <!-- Product image card-->
                                    <div class="card mb-4 mb-xl-0">
                                        <div class="card-header">Product Image</div>
                                        <div class="card-body text-center">
                                            <!-- Product image -->
                                            <img class="img-account-profile mb-2"
                                                src="{{ asset('assets/img/products/default.webp') }}" alt=""
                                                id="image-preview" />
                                            <!-- Product image help block -->
                                            <div class="small font-italic text-muted mb-2">JPG or PNG no larger than 2 MB
                                            </div>
                                            <!-- Product image input -->
                                            <input
                                                class="form-control form-control-solid mb-2 @error('product_image') is-invalid @enderror"
                                                type="file" id="image" name="product_image" accept="image/*"
                                                onchange="previewImage();">
                                            @error('product_image')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-8">
                                    <!-- BEGIN: Product Details -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            Product Details
                                        </div>
                                        <div class="card-body">
                                            <!-- Form Group (product name) -->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="product_name">Product name <span
                                                        class="text-danger">*</span></label>
                                                <input
                                                    class="form-control form-control-solid @error('product_name') is-invalid @enderror"
                                                    id="product_name" name="product_name" type="text" placeholder=""
                                                    value="{{ old('product_name') }}" autocomplete="off" />

                                                <input class="" id="pos_name" name="pos_name" type="hidden"
                                                    value="1" />

                                                @error('product_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!-- Form Row Form Group (address) -->
                                            <div class="mb-3">
                                                <label for="description">Product Description </label>
                                                <textarea class="form-control form-control-solid @error('description') is-invalid @enderror" id="description"
                                                    name="description" rows="3">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!-- Form Row -->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (type of product category) -->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="category_id">Product category <span
                                                            class="text-danger">*</span></label>
                                                    <select
                                                        class="form-select form-control-solid selectpicker p-0 @error('category_id') is-invalid @enderror"
                                                        id="category_id" name="category_id" data-live-search="true"
                                                        data-container="body">
                                                        <option selected="" disabled="">Select a category:</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                @if (old('category_id') == $category->id) selected="selected" @endif>
                                                                {{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <!-- Form Group (type of product unit) -->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="unit_id">Unit <span
                                                            class="text-danger">*</span></label>
                                                    <select
                                                        class="form-select form-control-solid  selectpicker p-0 @error('unit_id') is-invalid @enderror"
                                                        id="unit_id" name="unit_id" data-live-search="true"
                                                        data-container="body">
                                                        <option selected="" disabled="">Select a unit:</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->id }}"
                                                                @if (old('unit_id') == $unit->id) selected="selected" @endif>
                                                                {{ $unit->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('unit_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Form Row -->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (buying price) -->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="buying_price">Buying price <span
                                                            class="text-danger">*</span></label>
                                                    <input
                                                        class="form-control form-control-solid @error('buying_price') is-invalid @enderror"
                                                        id="buying_price" name="buying_price" type="text"
                                                        placeholder="" value="{{ old('buying_price') }}"
                                                        autocomplete="off" />
                                                    @error('buying_price')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <!-- Form Group (selling price) -->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="selling_price">MRP <span
                                                            class="text-danger">*</span></label>
                                                    <input
                                                        class="form-control form-control-solid @error('selling_price') is-invalid @enderror"
                                                        id="selling_price" name="selling_price" type="text"
                                                        placeholder="" value="{{ old('selling_price') }}"
                                                        autocomplete="off" />
                                                    @error('selling_price')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Form Row -->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (buying price) -->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="stock">Stock <span
                                                            class="text-danger">*</span></label>
                                                    <input
                                                        class="form-control form-control-solid @error('stock') is-invalid @enderror"
                                                        id="stock" name="stock" type="text" placeholder=""
                                                        value="{{ old('stock') }}" autocomplete="off" />
                                                    @error('stock')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <!-- Form Group (selling price) -->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="our_price">Our Price</label>
                                                    <input
                                                        class="form-control form-control-solid @error('our_price') is-invalid @enderror"
                                                        id="our_price" name="our_price" type="text" placeholder=""
                                                        value="{{ old('our_price') }}" autocomplete="off" />
                                                    @error('our_price')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Submit button -->
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <a class="btn btn-danger" href="{{ route('pos.index') }}">Cancel</a>
                                        </div>
                                    </div>
                                    <!-- END: Product Details -->
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <!-- END: Modal -->

        <?php //@if (count($errors) > 0)
        ?>
        @if ($errors->has('product_name'))
            <script type="text/javascript">
                window.onload = function() {
                    var hangoutButton = document.getElementById("addProductButton");

                    hangoutButton.click(); // this will trigger the click event

                };


                // jQuery( document ).ready(function() {
                //     alert('here');
                //  $('#modal').modal('show');
                // });
            </script>
        @endif

    @endsection
