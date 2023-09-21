@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('stock-product-category.index'),
            'page' => 'Manage',
            'current_page' => 'Edit',
            'heading' => 'Stock Product Category Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Update Stock Product Category</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('stock-product-category.update',$stockProductCategory->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Category</label>
                                    <input type="text" name="name" id="name" value="{{ $stockProductCategory->name }}" class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(A4 Paper)</span>
                                    </div>

                                    <button type="submit" class="btn btn-secondary mb-2"><span>Update</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
