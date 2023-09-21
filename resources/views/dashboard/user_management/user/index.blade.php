@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('user.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'User Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Users <small>Use this section to manage users</small></h2>
                        <ul class="header-dropdown dropdown">
                            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="users" class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Contact No</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
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
    </div>
@endsection

@section('css')
    <style>
        .avatar {
            object-fit: cover;
        }
    </style>
@endsection

@section('js')
    <script>
        $(function() {
           var table = $('#users').DataTable({
               "processing": true,
               "serverSide": true,
               "pageLength": 10,
               "responsive": true,
               "searching": false,
               "ajax": {
                   url: "{{ config('app.url') }}/user/get/all",
                   type: "GET",
                   cache: false,
                   error: function(){
                       $("#users").append('<tbody class="errors"><tr><th colspan="7">No data found in the server</th></tr></tbody>');
                   }
               },
               "columns": [
                   { data: 'avatar'},
                   { data: 'name'},
                   { data: 'contact_no'},
                   { data: 'gender'},
                   { data: 'dob'},
                   { data: 'user_roles'},
                   { data: 'id'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    var avatar = `<img src="{{ url('/assets/avatars/') }}/` + aData['avatar'] + `"data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="w35 rounded avatar">`;
                    var name = '<a href="javascript:void(0);" title="">' + aData['name'] + ' ' + aData['last_name'] + '</a>';
                    name += '<p class="mb-0">' + aData['designation'].name;

                    $('td:eq(0)', nRow).html(avatar);
                    $('td:eq(1)', nRow).html(name);
                    $('td:eq(2)', nRow).html(aData['contact_no']);
                    $('td:eq(3)', nRow).html(aData['gender']);
                    $('td:eq(4)', nRow).html(aData['dob']);
                    if (aData['user_roles'].length > 0) {
                        $('td:eq(5)', nRow).html(aData['user_roles'][0]['name']);
                    } else {
                        $('td:eq(5)', nRow).html('--');
                    }

                    var actions = '<a href="{{ route("user.index") }}/' + aData['id']+ '/edit" class="btn btn-xs btn-warning mr-1"><i class="icon-note"></i></a>';
                    actions += `<form action="{{ route("user.index") }}/` + aData['id']+ `" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>`;
                    actions += '@csrf @method("Delete")';
                    actions += '<button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>';
                    actions += '</a>';

                    $('td:eq(6)', nRow).html(actions);
               }
           });
        });
   </script>
@endsection
