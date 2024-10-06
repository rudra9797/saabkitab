@extends('dashboard.body.main')

@section('specificpagescripts')
<script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
</nav>

<div class="card shadow ">
    <div class="card-header">

        <div class="row">
            <div class="col-md-6  my-2">
                <h6 class="m-0 font-weight-bold text-primary">Add Customer </h6>
            </div>

        </div>

    </div>
    <div class="card-body ">
        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xl-4">
                    <!-- Profile picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Profile Picture</div>
                        <div class="card-body text-center">
                            <!-- Profile picture image -->
                            <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/demo/user-placeholder.svg') }}" alt="" id="image-preview" />
                            <!-- Profile picture help block -->
                            <div class="small font-italic text-muted mb-2">JPG or PNG no larger than 2 MB</div>
                            <!-- Profile picture input -->
                            <input class="form-control form-control-solid mb-2 @error('photo') is-invalid @enderror" type="file" id="image" name="photo" accept="image/*" onchange="previewImage();">
                            @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <!-- BEGIN: Customer Details -->
                    <div class="card mb-4">
                        <div class="card-header">
                            Customer Details
                        </div>
                        <div class="card-body">
                            <!-- Form Group (name) -->
                            <div class="mb-3">
                                <label class="small mb-1" for="name">Name  </label>
                                <input class="form-control form-control-solid @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="" value="{{ old('name') }}" />
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Form Group (email address) -->
                            <div class="mb-3">
                                <label class="small mb-1" for="email">Email address  </label>
                                <input class="form-control form-control-solid @error('email') is-invalid @enderror" id="email" name="email" type="text" placeholder="" value="{{ old('email') }}" />
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number) -->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="phone">Phone number  <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-solid @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" placeholder="" value="{{ old('phone') }}" />
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="advance_amount">Advance Amount </label>
                                    <input class="form-control form-control-solid @error('advance_amount') is-invalid @enderror" id="advance_amount" name="advance_amount" type="text" placeholder="" value="{{ old('advance_amount') }}" />
                                    @error('advance_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Form Group (bank name) -->
                                <!-- <div class="col-md-6">
                                <label class="small mb-1" for="bank_name">Bank Name</label>
                                <select class="form-select form-control-solid @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name">
                                    <option selected="" disabled="">Select a bank:</option>
                                    <option value="BRI" @if(old('bank_name') == 'BRI')selected="selected"@endif>BRI</option>
                                    <option value="BNI" @if(old('bank_name') == 'BNI')selected="selected"@endif>BNI</option>
                                    <option value="BCA" @if(old('bank_name') == 'BCA')selected="selected"@endif>BCA</option>
                                    <option value="BSI" @if(old('bank_name') == 'BSI')selected="selected"@endif>BSI</option>
                                    <option value="Mandiri" @if(old('bank_name') == 'Mandiri')selected="selected"@endif>Mandiri</option>
                                </select>
                                @error('bank_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> -->
                            </div>
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (name) -->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="ref_name">Referrer Name  </label>
                                    <input class="form-control form-control-solid @error('ref_name') is-invalid @enderror" id="ref_name" name="ref_name" type="text" placeholder="" value="{{ old('ref_name') }}" />
                                    @error('ref_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Form Group (ref_phone) -->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="ref_phone">Referrer Phone number  </label>
                                    <input class="form-control form-control-solid @error('ref_phone') is-invalid @enderror" id="ref_phone" name="ref_phone" type="text" placeholder="" value="{{ old('ref_phone') }}" />
                                    @error('ref_phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Form Group (address) -->
                            <div class="mb-3">
                                <label for="address">Address  </label>
                                <textarea class="form-control form-control-solid @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <button class="btn btn-primary" type="submit">Add</button>
                            <a class="btn btn-danger" href="{{ route('customers.index') }}">Cancel</a>
                        </div>
                    </div>
                    <!-- END: Customer Details -->
                </div>
            </div>
        </form>
    </div>
</div>
@endsection