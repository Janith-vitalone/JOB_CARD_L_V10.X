@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('stock.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Stock Management',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Stock Product<small>Use this section to manage stock products</small></h2>
                    <ul class="header-dropdown dropdown">
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="stock-product" class="table table-hover table-custom spacing8">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Category</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <!-- <th>Reorder Level</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function() {
           var table = $('#stock-product').DataTable({
               "processing": true,
               "serverSide": true,
               "pageLength": 10,
               "responsive": true,
               "searching": false,
               "ajax": {
                   url: "{{ config('app.url') }}/stock/get/all",
                   type: "GET",
                   cache: false,
                   error: function(){
                       $("#designations").append('<tbody class="errors"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                   }
               },
               "columns": [
                   { data: 'id'},
                   { data: 'stock_product_category.name' },
                   { data: 'product.name' },
                   { data: 'qty' },
                //    { data: 'reorder_level'},
                   { data: 'id'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['stock_product_category.name']);
                    $('td:eq(2)', nRow).html(aData['product.name']);
                    $('td:eq(3)', nRow).html(aData['qty']);
                    // $('td:eq(4)', nRow).html(aData['reorder_level']);

                    var actions = '<a href="{{ route("stock.index") }}/' + aData['id']+ '/edit" class="btn btn-xs btn-warning mr-1" ><i class="icon-note"></i></a>';
                    actions += `<form action="{{ route("stock.index") }}/` + aData['id']+ `" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>`;
                    actions += '@csrf @method("Delete")';
                    actions += '<button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>';
                    actions += '</a>';

                    $('td:eq(4)', nRow).html(actions);
               }
           });
        });
   </script>
@endsection
