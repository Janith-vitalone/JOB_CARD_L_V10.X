@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('material.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Utility Management',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Materials <small>Use this section to manage Materials</small></h2>
                    <ul class="header-dropdown dropdown">
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="materials" class="table table-hover table-custom spacing8">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Job Type</th>
                                    <th>Format</th>
                                    <th>Created At</th>
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
           var table = $('#materials').DataTable({
               "processing": true,
               "serverSide": true,
               "pageLength": 10,
               "responsive": true,
               "searching": false,
               "ajax": {
                   url: "{{ config('app.url') }}/material/get/all",
                   type: "GET",
                   cache: false,
                   error: function(){
                       $("#materials").append('<tbody class="errors"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                   }
               },
               "columns": [
                   { data: 'id'},
                   { data: 'name'},
                   { data: 'job_type'},
                   { data: 'format'},
                   { data: 'created_at'},
                   { data: 'id'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['name']);
                    $('td:eq(2)', nRow).html(aData['job_type']);
                    $('td:eq(3)', nRow).html(aData['format'].name);
                    $('td:eq(4)', nRow).html(aData['created_at']);

                    var actions = '<a href="{{ route("material.index") }}/' + aData['id']+ '/edit" class="btn btn-xs btn-warning mr-1" ><i class="icon-note"></i></a>';
                    actions += `<form action="{{ route("material.index") }}/` + aData['id']+ `" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>`;
                    actions += '@csrf @method("Delete")';
                    actions += '<button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>';
                    actions += '</a>';

                    $('td:eq(5)', nRow).html(actions);
               }
           });
        });
   </script>
@endsection
