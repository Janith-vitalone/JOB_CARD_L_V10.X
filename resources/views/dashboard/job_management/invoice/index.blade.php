@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('invoice.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Quick Invoice Management',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Quick Invoice<small>Use this section to manage quick invoices</small></h2>
                    <ul class="header-dropdown dropdown">
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    </ul>
                </div>
                <div class="body">
                    {{-- Filters --}}
                    <form action="#" method="POST" id="search-form">
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Invoice No</label>
                                    <input type="text" name="invoice_no" id="invoice_no" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Client Name</label>
                                    <div class="multiselect_div">
                                        <select id="client" class="multiselect multiselect-custom" name="client_id">
                                            <option value="0">- Choose Client -</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->contact_person }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Invoice Payment Status</label>
                                    <div class="multiselect_div">
                                        <select id="invoice_payment_status" class="multiselect multiselect-custom" name="invoice_payment_status">
                                            <option value="0">- Choose Status -</option>
                                            <option value="paid">Paid</option>
                                            <option value="partially_paid">Partially Paid</option>
                                            <option value="unpaid">Unpaid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix mb-4">
                            <div class="col-lg-3 col-md-12">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="stock-product" class="table table-hover table-custom spacing8">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice No</th>
                                    <th>Invoice Type</th>
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
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script>
        $('#client').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $('#invoice_payment_status').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $(function() {
           var table = $('#stock-product').DataTable({
               "processing": true,
               "serverSide": true,
               "pageLength": 10,
               "responsive": true,
               "searching": false,
               "ajax": {
                   url: "{{ config('app.url') }}/invoice/quick/get/all",
                   type: "GET",
                   cache: false,
                   data: function(d){
                        d.invoice_no = $('input[name=invoice_no]').val();
                        d.client_id = $('select[name=client_id]').val();
                        d.invoice_payment_status = $('select[name=invoice_payment_status]').val();
                   },
                   error: function(){
                       $("#designations").append('<tbody class="errors"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                   }
               },
               "columns": [
                   { data: 'id'},
                   { data: 'invoice_no' },
                   { data: 'note' },
                   { data: 'grand_total' },
                   { data: 'created_at'},
                   { data: 'id'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['invoice_no']);
                    $('td:eq(2)', nRow).html(aData['note']);
                    $('td:eq(3)', nRow).html(aData['grand_total']);
                    $('td:eq(4)', nRow).html(aData['created_at']);

                    var actions = '<a href="{{ route("invoice.index") }}/quick/print/' + aData['id']+ '" class="btn btn-xs btn-warning mr-1" ><i class="icon-printer"></i></a>';
                    actions += '<a href="{{ route("invoice.index") }}/quick/' + aData['id']+ '/edit" class="btn btn-xs btn-secondary mr-1" ><i class="fa fa-pencil"></i></a>';
                    actions += '<a href="{{ route("invoice.index") }}/quick/payment/' + aData['id']+ '" class="btn btn-xs btn-primary mr-1" ><i class="fa fa-money"></i></a>';
                    // actions += `<form action="{{ route("stock.index") }}/` + aData['id']+ `" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>`;
                    // actions += '@csrf @method("Delete")';
                    // actions += '<button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>';
                    // actions += '</a>';

                    $('td:eq(5)', nRow).html(actions);
               }
           });

           // Apply the search
           $('#search-form').on('submit', function(e) {
                e.preventDefault();
                table.draw();
            });
        });
   </script>
@endsection
