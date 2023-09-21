@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('jobcard.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Job Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Jobs <small>Use this section to manage jobs</small></h2>
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
                                        <label for="phone" class="control-label">Client Name</label>
                                        <div class="multiselect_div">
                                            <select id="client" class="multiselect multiselect-custom" name="client_id">
                                                <option value="0">- Choose Client -</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->contact_person }} - {{ $client->phone }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Job Status</label>
                                        <div class="multiselect_div">
                                            <select id="status" class="multiselect multiselect-custom" name="status">
                                                <option value="0">- Choose Status -</option>
                                                <option value="open">Open</option>
                                                <option value="closed">Closed</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Designer</label>
                                        <div class="multiselect_div">
                                            <select id="designer" class="multiselect multiselect-custom" name="designer">
                                                <option value="0">- Choose Designer -</option>
                                                @foreach ($designers as $designer)
                                                    <option value="{{ $designer->id }}">{{ $designer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix mb-4">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Payment Status</label>
                                        <div class="multiselect_div">
                                            <select id="payment_status" class="multiselect multiselect-custom" name="payment_status">
                                                <option value="0">- Choose Payment Status -</option>
                                                <option value="unpaid">Unpaid</option>
                                                <option value="partially_paid">Partially Paid</option>
                                                <option value="paid">Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Invoice No</label>
                                        <input type="text" name="invoice_no" id="invoice_no" class="form-control">
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
                            <table id="jobs" class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job No</th>
                                        <th>Job Note</th>
                                        <th>PO No.</th>
                                        <th>Client</th>
                                        <th>Client Note</th>
                                        <th>Designer</th>
                                        <th>Finishing Date</th>
                                        <th>Finishing Time</th>
                                        <th>Job Status</th>
                                        <th>Invoice No</th>
                                        <th>Payment Status</th>
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
    </div>
@endsection

@section('css')
    <style>
        .avatar {
            object-fit: cover;
        }
    </style>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script>
        $('#client').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $('#designer').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $('#status').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $('#payment_status').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        $(function() {
            var table = $('#jobs').DataTable({
                "dom": "Bfrtip",
                "processing": true,
                "serverSide": true,
                "pageLength": 100,
                buttons: [
                    'excel', 'print'
                ],
                "responsive": true,
                "searching": false,
                "order": [[ 1, "desc" ]],
                "ajax": {
                    url: "{{ config('app.url') }}/jobcard/get/all",
                    type: "GET",
                    cache: false,
                    data: function (d) {
                        d.job_no = $('input[name=job_no]').val();
                        d.client_id = $('select[name=client_id]').val();
                        d.designer = $('select[name=designer]').val();
                        d.status = $('select[name=status]').val();
                        d.payment_status = $('select[name=payment_status]').val();
                        d.invoice_no = $('input[name=invoice_no]').val();
                    },
                    error: function(){
                        $("#jobs").append('<tbody class="errors"><tr><th colspan="10">No data found in the server</th></tr></tbody>');
                    }
                },
                "columns": [
                    { data: 'screenshot'},
                    { data: 'job_no'},
                    { data: 'job_note'},
                    { data: 'po_no'},
                    {
                        data: 'client',
                        render: function ( data, type, row ) {
                            if (data) {
                                return data.name + ' (' + data.contact_person + ' - ' + data.phone + ')';
                            } else {
                                return 'N/A';
                            }
                        }
                    },
                    { data: 'client_note'},
                    { data: 'user', render: 'name'},
                    { data: 'finishing_date'},
                    { data: 'finishing_time'},
                    { data: 'job_status'},
                    {
                        data: 'invoice',
                        render: function ( data, type, row ) {
                            var invoice_no = '';

                            if (data == undefined) {
                                invoice_no = '-';
                            } else {
                                invoice_no = data.invoice_no;
                            }

                            return invoice_no;
                        }
                    },
                    {
                        data: 'invoice',
                        render: function ( data, type, row ) {
                            var paym_status = '';

                            if (data == undefined) {
                                paym_status = 'unpaid';
                            } else {
                                paym_status = data.payment_status;
                            }

                            return paym_status;
                        }
                    },
                    {
                        data: 'invoice',
                        render: function ( data, type, row ) {
                            var amount = '--';

                            if (data == undefined) {
                                amount = '--';
                            } else {
                                amount = data.grand_total;
                            }

                            return amount;
                        }
                    },
                    { data: 'id'},
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                        var avatar = `<img src="{{ url('/jobs') }}/` + aData['screenshot'] + `"data-toggle="tooltip" data-placement="top" title="" alt="Job Screenshot" class="w35 rounded avatar">`;
                        var payment_status = aData['invoice'];

                        $('td:eq(0)', nRow).html(avatar);
                        $('td:eq(1)', nRow).html(aData['job_no']);
                        $('td:eq(2)', nRow).html(aData['job_note']);
                        $('td:eq(3)', nRow).html(aData['po_no']);
                        $('td:eq(4)', nRow).html(aData['client'].name + ' (' + aData['client'].contact_person + ' - ' + aData['client'].phone + ')');
                        $('td:eq(5)', nRow).html(aData['client_note']);
                        $('td:eq(6)', nRow).html(aData['user'].name);
                        $('td:eq(7)', nRow).html(aData['finishing_date']);
                        $('td:eq(8)', nRow).html(aData['finishing_time']);
                        $('td:eq(9)', nRow).html(aData['job_status']);

                        var actions = '';

                        if (aData['invoice'] == undefined) {
                            payment_status = 'unpaid'
                            // actions += '<a href="{{ route("jobcard.index") }}/' + aData['id'] + '/edit" class="btn btn-xs btn-primary mr-1"><i class="icon-note"></i></a>';
                        } else {
                            payment_status = aData['invoice'].payment_status
                        }

                        $('td:eq(11)', nRow).html(payment_status);
                        // $('td:eq(10)', nRow).html(payment_status);

                        actions += '<a href="{{ route("jobcard.index") }}/' + aData['id'] + '" class="btn btn-xs btn-primary mr-1"><i class="icon-list"></i></a>';
                        actions += `<form action="{{ route("jobcard.index") }}/` + aData['id']+ `" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>`;
                        actions += '@csrf @method("Delete")';
                        actions += '<button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>';
                        actions += '</form>';

                        $('td:eq(13)', nRow).html(actions);

                        $(nRow).click(function() {
                            document.location.href = '/jobcard/' + aData['id'];
                        });

                        // nRow().invalidate();
                },
            });

            // Apply the search
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                table.draw();
            });
        });
   </script>
@endsection
