@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('other-payment.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Other Payment Management',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Other Payment <small>Use this section to manage other payment</small></h2>
                    <ul class="header-dropdown dropdown">
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="other-payment" class="table table-hover table-custom spacing8">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Payment Category</th>
                                    <th>Bank</th>
                                    <th>Description</th>
                                    <th>Cheque no</th>
                                    <th>Banking date</th>
                                    <th>Amount</th>
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
           var table = $('#other-payment').DataTable({
               "processing": true,
               "serverSide": true,
               "pageLength": 10,
               "responsive": true,
               "searching": false,
               "ajax": {
                   url: "{{ config('app.url') }}/other-payment/get/all",
                   type: "GET",
                   cache: false,
                   error: function(){
                       $("#designations").append('<tbody class="errors"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                   }
               },
               "columns": [
                   { data: 'id'},
                   { data: 'payment_category.category'},
                   { data: 'bank' },
                   { data: 'description'},
                   { data: 'cheque_no'},
                   { data: 'banking_date'},
                   { data: 'amount'},
                   { data: 'id'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['payment_category.category']);
                    $('td:eq(2)', nRow).html(aData['bank']);
                    $('td:eq(3)', nRow).html(aData['description']);
                    $('td:eq(4)', nRow).html(aData['cheque_no']);
                    $('td:eq(5)', nRow).html(aData['banking_date']);
                    $('td:eq(6)', nRow).html(aData['amount']);

                    var actions = '<a href="{{ route("other-payment.index") }}/' + aData['id']+ '/edit" class="btn btn-xs btn-warning mr-1" ><i class="icon-note"></i></a>';
                    actions += `<form action="{{ route("other-payment.index") }}/` + aData['id']+ `" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>`;
                    actions += '@csrf @method("Delete")';
                    actions += '<button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>';
                    actions += '</a>';

                    $('td:eq(7)', nRow).html(actions);
               }
           });
        });
   </script>
@endsection
