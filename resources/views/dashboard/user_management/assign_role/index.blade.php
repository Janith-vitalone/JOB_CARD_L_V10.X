@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('user-assign.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Assign User Role Management',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>User Roles <small>Use this section to manage Assinged User Roles</small></h2>
                    <ul class="header-dropdown dropdown">
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="assigned-role" class="table table-hover table-custom spacing8">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>User Role</th>
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
           var table = $('#assigned-role').DataTable({
               "processing": true,
               "serverSide": true,
               "pageLength": 10,
               "responsive": true,
               "searching": false,
               "ajax": {
                   url: "{{ config('app.url') }}/get/assign/role",
                   type: "GET",
                   cache: false,
                   error: function(){
                       $("#assigned-role").append('<tbody class="errors"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    //    $("#companies_processing").css("display","none");
                   }
               },
               "columns": [
                   { data: 'id'},
                   { data: 'name'},
                   { data: 'user_roles[].name'},
                   { data: 'id'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['name']);
                    $('td:eq(2)', nRow).html(aData['user_roles.name']);

                    var actions = '<a href="{{ route("user-assign.index") }}/' + aData['id']+ '/edit" class="btn btn-xs btn-warning mr-1"><i class="icon-note"></i></a>';
                    actions += `<form action="{{ route("user-assign.index") }}/` + aData['id']+ `" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>`;
                    actions += '@csrf @method("Delete")';
                    actions += '<button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>';
                    actions += '</a>';

                    $('td:eq(3)', nRow).html(actions);
               }
           });
        });
   </script>
@endsection
