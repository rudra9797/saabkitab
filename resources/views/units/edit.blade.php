@extends('dashboard.body.main')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('units.index') }}">Units</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>

<div class="card shadow ">
    <div class="card-header">

        <div class="row">
            <div class="col-md-6  my-2">
                <h6 class="m-0 font-weight-bold text-primary">Edit Unit </h6>
            </div>

        </div>

    </div>
    <div class="card-body ">
    <form action="{{ route('units.update', $unit->slug) }}" method="POST">
        @csrf
        @method('put')
        <div class="row">

            <div class="col-xl-12">
                <!-- BEGIN: Unit Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        Unit Details
                    </div>
                    <div class="card-body">
                        <!-- Form Group (name) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Unit Name <span class="text-danger">*</span></label>
                            <input class="form-control form-control-solid @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="" value="{{ old('name', $unit->name) }}" autocomplete="off" />
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Form Group (slug) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="slug">Unit Slug (non editable).</label>
                            <input class="form-control form-control-solid @error('slug') is-invalid @enderror" id="slug" name="slug" type="text" placeholder="" value="{{ old('slug', $unit->slug) }}" readonly />
                            @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-danger" href="{{ route('units.index') }}">Cancel</a>
                    </div>
                </div>
                <!-- END: Unit Details -->
            </div>
        </div>
    </form>
    </div>
</div>


<script>
    // Slug Generator
    const title = document.querySelector("#name");
    const slug = document.querySelector("#slug");
    title.addEventListener("keyup", function() {
        let preslug = title.value;
        preslug = preslug.replace(/ /g,"-");
        slug.value = preslug.toLowerCase();
    });
</script>
@endsection
