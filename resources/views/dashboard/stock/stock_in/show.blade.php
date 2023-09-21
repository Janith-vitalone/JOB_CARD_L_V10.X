@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('stockin.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Stock In Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Stock In Details</h2>
                    </div>

                    {{-- Enter Product --}}
                    <div id="product-form" class="body">
                        <form action="#" id="product_details">
                            <div class="row clearfix">
                            <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Supplier Name</label>
                                        <input type="text" value="{{ $stock_in[0]->supplier->name }}" name="product_qty" id="product_qty" class="form-control" disabled required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Invoice No</label>
                                        <input type="text" min="1" value="{{ $stock_in[0]->invoice_no }}" name="product_qty" id="product_qty" class="form-control" disabled required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Total</label>
                                        <input type="text" value="{{ $stock_in[0]->total }}" name="product_qty" id="product_qty" class="form-control" disabled required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Product List --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Products List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Category</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                    </tr>
                                </thead>
                                <tbody id="products">
                                    @foreach($stock_in_products as $key => $stock_in_product)
                                        <tr>
                                            <td>{{ $key+1}}</td>
                                            <td>{{ $stock_in_product->stockProductCategory->name }}</td>
                                            <td>{{ $stock_in_product->supplierProduct->name }}</td>
                                            <td>{{ $stock_in_product->qty }}</td>
                                            <td>{{ $stock_in_product->unit_price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection