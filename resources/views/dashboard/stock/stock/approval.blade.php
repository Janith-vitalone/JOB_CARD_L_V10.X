@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('stock.index'),
            'page' => 'index',
            'current_page' => 'Approval',
            'heading' => 'Stock Approval Management',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Stock Approval<small>Use this section to manage stock approvals</small></h2>
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
                                    <th>User</th>
                                    <th>Qty</th>
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
                   url: "{{ config('app.url') }}/stock-approvel/get/all",
                   type: "GET",
                   cache: false,
                   error: function(){
                       $("#designations").append('<tbody class="errors"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                   }
               },
               "columns": [
                   { data: 'id'},
                   { data: 'stock[0].stock_product_category.name' },
                   { data: 'stock[0].product.name' },
                   { data: 'user.email' },
                   { data: 'qty'},
                   { data: 'id'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['stock[0].stock_product_category.name']);
                    $('td:eq(2)', nRow).html(aData['stock[0].product.name']);
                    $('td:eq(3)', nRow).html(aData['user.email']);
                    $('td:eq(4)', nRow).html(aData['qty']);
                    
                    var actions = '<a href="{{ route("stock-approvel.index") }}/' + aData['id']+ '/edit" class="btn btn-xs btn-success mr-1" ><i class="fa fa-check"></i></a>';

                    $('td:eq(5)', nRow).html(actions);
               }
           });
        });
   </script>
@endsection
