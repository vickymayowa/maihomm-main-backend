@extends('dashboards.admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 style="color: #dea739">Edit Product</h1>
            <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                <ol class="breadcrumb pt-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin.properties.index') }}">Properties </a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.market.products.show', $property->id) }}">{{ $property->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                </ol>
            </nav>
            <div class="separator mb-5"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.admin.properties.update', $property->id) }}" method="post"
                enctype="multipart/form-data">@csrf @method('put')
                <div class="row clearfix g-3">
                    <div class="col-md-8 form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control"
                            placeholder="Name of app or site. E.g: Google" name="name" required
                            value="{{ old('name') ?? $property->name }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">Category</label>
                        <select class="form-control" name="category_id">
                            <option value="" disabled selected>Select Option</option>
                            @foreach ($category_properties as $category)
                                <option value="{{ $category->id }}"
                                    {{ (old('category_id') ?? $property->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">No. of Bedrooms</label>
                        <input type="number" class="form-control" placeholder="How many bedrooms available"
                            name="bedrooms" required value="{{ old('bedrooms') ?? $property->bedrooms }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">No. of Bathrooms</label>
                        <input type="number" class="form-control" placeholder="How many bathrooms available"
                            name="bathrooms" required value="{{ old('bathrooms') ?? $property->bathrooms }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">In Stock</label>
                        <input type="number" class="form-control"
                            placeholder="How many do you have available" name="in_stock" required
                            value="{{ old('in_stock') ?? $property->in_stock }}">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">Description</label>
                        <textarea class="form-control" type="text" required name="description" placeholder="Tell us about the product in simple terms..."id="tinymceEditor">{{ old("description") ?? $property->description }}</textarea>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">Currency</label>
                        <select class="form-control" name="currency_id">
                            <option value="" disabled selected>Select Option</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}"
                                    {{ (old('currency_id') ?? $property->currency_id) == $currency->id ? 'selected' : '' }}>
                                    {{ $currency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">Price</label>
                        <input type="number" class="form-control" placeholder="" name="price"
                            required value="{{ old('price') ?? $property->price }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">Discount</label>
                        <input type="number" class="form-control" placeholder="" name="discount"
                            value="{{ old('discount') ?? $property->discount }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="" disabled selected>Select Option</option>
                            @foreach ($statusOptions as $key => $value)
                                <option value="{{ $key }}"
                                    {{ (old('status') ?? $property->status) == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-success text-white">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
