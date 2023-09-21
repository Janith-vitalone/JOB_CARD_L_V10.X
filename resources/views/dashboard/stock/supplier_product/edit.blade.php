@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('supplier-product.index'),
            'page' => 'Manage',
            'current_page' => 'Edit',
            'heading' => 'Supplier Products Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Supplier Product</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('supplier-product.update',$supplierProduct->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="user" class="control-label">Select Supplier</label>
                                        <div class="multiselect_div">
                                            <select id="supplier" name="supplier" class="multiselect multiselect-custom @error('supplier') is-invalid @enderror" required>
                                                <option value="0"> -Please Choose- </option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('supplier')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="user" class="control-label">Select Product Category</label>
                                        <div class="multiselect_div">
                                            <select id="category" name="category" class="multiselect multiselect-custom @error('category') is-invalid @enderror" required>
                                                <option value="0"> -Please Choose- </option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Product Name</label>
                                        <input type="text" name="name" id="name" value="{{ $supplierProduct->name }}" class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(ProMate)</span>
                                    </div>
                                    <label for="phone" class="control-label"><b>Size</b></label>
                                    <div class="form-group">
                                        <label for="user" class="control-label">Select Unit</label>
                                        <div class="multiselect_div">
                                            <select id="unit" name="unit" class="multiselect multiselect-custom @error('unit') is-invalid @enderror" required>
                                                <option value="0"> -Please Choose- </option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('unit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Width</label>
                                        <input type="number" step="0.01" name="width" id="width" value="{{ $supplierProduct->width }}" class="form-control @error('width') is-invalid @enderror">
                                        @error('width')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Height</label>
                                        <input type="number" name="height" id="height" value="{{ $supplierProduct->height }}" class="form-control @error('height') is-invalid @enderror">
                                        @error('height')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> <span>Add</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/multi-select/js/jquery.multi-select.js') }}"></script><!-- Multi Select Plugin Js -->
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>

    <script>
        $('#category').val('{{ $supplierProduct->stockProductCategory->id }}');
        $('#supplier').val('{{ $supplierProduct->supplier->id }}');
        $('#unit').val('{{ $supplierProduct->unit->id }}');

        $('#category').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $('#supplier').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $('#unit').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
    </script>
@endsection