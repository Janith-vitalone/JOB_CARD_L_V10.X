@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('quotation.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Quotation Mangement',
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
                                        <label for="phone" class="control-label">Quote No</label>
                                        <input type="text" name="quote_no" id="quote_no" class="form-control">
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
                                        <label for="phone" class="control-label">Quotation Status</label>
                                        <div class="multiselect_div">
                                            <select id="quote_status" class="multiselect multiselect-custom" name="quote_status">
                                                <option value="0">- Choose Status -</option>
                                                <option value="open">Open</option>
                                                <option value="sent">Sent</option>
                                                <option value="approved">Approved</option>
                                                <option value="rejected">Rejected</option>
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
                            <table id="quotes" class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Quote No</th>
                                        <th>Quote Date</th>
                                        <th>Client</th>
                                        <th>Total</th>
                                        <th>Status</th>
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
        $('#quote_status').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        $(function() {
            var table = $('#quotes').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                "responsive": true,
                "searching": false,
                "ajax": {
                    url: "{{ config('app.url') }}/quotation/get/all",
                    type: "GET",
                    cache: false,
                    data: function (d) {
                            d.quote_no = $('input[name=quote_no]').val();
                            d.client_id = $('select[name=client_id]').val();
                            d.quote_status = $('select[name=quote_status]').val();
                        },
                    error: function(){
                        $("#quotes").append('<tbody class="errors"><tr><th colspan="10">No data found in the server</th></tr></tbody>');
                    }
                },
                "columns": [
                    { data: 'id'},
                    { data: 'quote_no'},
                    { data: 'quote_date'},
                    { data: 'client'},
                    { data: 'total'},
                    { data: 'status'},
                    { data: 'id'},
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['quote_no']);
                    $('td:eq(2)', nRow).html(aData['quote_date']);
                    $('td:eq(3)', nRow).html(aData['client'].name + ' (' + aData['client'].contact_person + ')');
                    $('td:eq(4)', nRow).html(aData['total']);
                    $('td:eq(5)', nRow).html(aData['status']);

                    var actions = '';
                    actions += '<a href="{{ route("quotation.index") }}/' + aData['id'] + '/edit" target="_blank" class="btn btn-xs btn-primary mr-1"><i class="icon-note"></i></a>';
                    // actions += '<a href="{{ route("quotation.index") }}/to/pdf/' + aData['id'] + '" target="_blank" class="btn btn-xs btn-primary mr-1"><i class="icon-doc"></i></a>';
                    actions += '<a href="{{ route("quotation.index") }}/' + aData['id'] + '" target="_blank" class="btn btn-xs btn-warning mr-1"><i class="icon-printer"></i></a>';

                    if (aData['status'] == 'open') {
                        actions += '<a href="{{ route("quotation.index") }}/change/status/' + aData['id'] + '/sent" class="btn btn-xs btn-primary mr-1"><i class="icon-cursor"></i> Sent</a>';
                    } else if (aData['status'] == 'sent') {
                        actions += '<a href="{{ route("quotation.index") }}/change/status/' + aData['id'] + '/approved" class="btn btn-xs btn-success mr-1"><i class="icon-check"></i> Approved</a>';
                        actions += '<a href="{{ route("quotation.index") }}/change/status/' + aData['id'] + '/rejected" class="btn btn-xs btn-danger mr-1"><i class="icon-close"></i> Rejected</a>';
                    }

                    actions += `<form action="{{ route("quotation.index") }}/` + aData['id']+ `" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>`;
                    actions += '@csrf @method("Delete")';
                    actions += '<button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>';
                    actions += '</form>';

                    $('td:eq(6)', nRow).html(actions);
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
