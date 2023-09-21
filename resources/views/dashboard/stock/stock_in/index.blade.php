@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('stockin.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Stock In Management',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Stock In<small>Use this section to manage stock ins</small></h2>
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
                                    <th>Supplier</th>
                                    <th>Invoice No</th>
                                    <th>Total</th>
                                    <th>Created at</th>
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
                   url: "{{ config('app.url') }}/stockin/get/all",
                   type: "GET",
                   cache: false,
                   error: function(){
                       $("#designations").append('<tbody class="errors"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                   }
               },
               "columns": [
                   { data: 'id'},
                   { data: 'supplier.name' },
                   { data: 'invoice_no' },
                   { data: 'total' },
                   { data: 'created_at'},
                   { data: 'id'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['supplier.name']);
                    $('td:eq(2)', nRow).html(aData['invoice_no']);
                    $('td:eq(3)', nRow).html(aData['total']);
                    $('td:eq(4)', nRow).html(aData['created_at']);

                    var actions = '<a href="{{ route("stockin.index") }}/view/' + aData['id']+ '" class="btn btn-xs btn-primary mr-1" ><i class="fa fa-eye"></i></a>';
                    actions += `<form action="{{ route("stockin.index") }}/` + aData['id']+ `" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>`;
                    actions += '@csrf @method("Delete")';
                    actions += '<button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>';
                    actions += '</a>';

                    $('td:eq(5)', nRow).html(actions);
               }
           });
        });
   </script>
@endsection
