@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('home'),
            'page' => 'Reports',
            'current_page' => 'Invoice Report',
            'heading' => 'Reports',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Invoices <small>All time invoices records</small></h2>
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
                                    <label for="phone" class="control-label">Job No</label>
                                    <input type="text" name="job_no" id="job_no" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Client</label>
                                    <div class="multiselect_div">
                                        <select id="client_name" class="form-control" name="client">
                                            <option value="all" selected>All</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }} ( {{ $client->contact_person }} | {{ $client->phone }} )</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Payment Status</label>
                                    <div class="multiselect_div">
                                        <select id="client" class="form-control" name="invoiced">
                                            <option value="all" selected>All</option>
                                            <option value="fully_paid">Fully Paid</option>
                                            <option value="partially_paid">Partially Paid</option>
                                            <option value="not_paid">Not Paid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Date</label>
                                    <input name="from" id="from" placeholder="From" class="form-control datepicker">
                                    <input name="to" id="to" placeholder="To" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">&nbsp;</label><br>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="invoice_report" class="table table-hover table-custom spacing8">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Job No</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Balance Amount</th>
                                    <th>Due Date</th>
                                    <th>Invoice Status</th>
                                    <th>Invoice No</th>
                                    <th>Invoiced Date</th>
                                    <th>Last Payment Date</th>
                                </tr>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align: right">Total Outstanding :</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    {{-- <link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" /> --}}
@endsection
@section('js')
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                endDate: '1d'
        });

        $(function() {
           var table = $('#invoice_report').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend:'excel',
                    exportOptions: {
                        modifier: {
                            page: 'all',
                            search: 'none'
                        }
                    }
                }],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "searching": false,
                "paging": false,
                "ajax": {
                    url: "{{ config('app.url') }}/reports/get/invoices",
                    type: "GET",
                    cache: false,
                    data: function (d) {
                        d.job_no = $('input[name=job_no]').val();
                        d.invoiced = $('select[name=invoiced]').val();
                        d.client = $('select[name=client]').val();
                        d.from_date = $('input[name=from]').val();
                        d.to_date = $('input[name=to]').val();
                    },
                    error: function() {
                        $("#invoice_report").append('<tbody class="errors"><tr><th colspan="8">No data found in the server</th></tr></tbody>');
                    }
                },
                "columns": [
                   { data: 'id'},
                   { data: 'client'},
                   { data: 'job_no'},
                   { data: 'total_amount'},
                   { data: 'paid_amount'},
                   { data: 'balance_amount'},
                   { data: 'due_date'},
                   { data: 'invoice_status'},
                   { data: 'invoice_no'},
                   { data: 'created_at'},
                   { data: 'last_payment_date'},
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['client']);
                    $('td:eq(2)', nRow).html(aData['job_no']);
                    $('td:eq(3)', nRow).html(aData['total_amount']);
                    $('td:eq(4)', nRow).html(aData['paid_amount']);
                    $('td:eq(5)', nRow).html(aData['balance_amount']);
                    $('td:eq(6)', nRow).html(aData['due_date']);
                    $('td:eq(7)', nRow).html(aData['invoice_status']);
                    $('td:eq(8)', nRow).html(aData['invoice_no']);
                    $('td:eq(9)', nRow).html(aData['created_at'].date);
                    $('td:eq(10)', nRow).html(aData['last_payment_date'].date);
                },
                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    
                    //Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api.column(5).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                    }, 0 );

                    // Total over this page
                    pageTotal = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                    }, 0 );

                    // Update footer
                    $( api.column( 5 ).footer() ).html(
                        '$'+pageTotal +' ( $'+ total +' total)'
                    );
                }
           });
           
           // Apply the search
            $('#search-form').on('submit', function(e) {
                var $outstanding = 0;
                e.preventDefault();
                table.draw();
            });
        });
   </script>
@endsection
