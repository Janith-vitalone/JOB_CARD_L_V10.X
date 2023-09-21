@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('assign-permission.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Assign Role Permissions',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Role Permissions <small>Use this section to manage Assinged Role Permissions</small></h2>
                    <ul class="header-dropdown dropdown">
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="role-permission" class="table table-hover table-custom spacing8">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Role</th>
                                    <th>Permissions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .table tr td {
            white-space: pre-wrap !important;
        }
    </style>
@endsection

@section('js')
    <script>
        $(function() {
           var table = $('#role-permission').DataTable({
               "processing": true,
               "serverSide": true,
               "pageLength": 10,
               "responsive": true,
               "searching": false,
               "ajax": {
                   url: "{{ config('app.url') }}/assign-permission/get/all",
                   type: "GET",
                   cache: false,
                   error: function(){
                       $("#role-permission").append('<tbody class="errors"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                   }
               },
               "columns": [
                   { data: 'id'},
                   { data: 'name'},
                   { data: 'permissions'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['name']);

                    var perms = '';

                    // Looping through permission array
                    $.each(aData['permissions'], function(key, value) {
                        perms += value.name + ', '
                    });

                    $('td:eq(2)', nRow).html(perms);
               }
           });
        });
   </script>
@endsection
