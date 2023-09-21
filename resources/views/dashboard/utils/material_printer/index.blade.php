@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('printermaterial.create'),
            'page' => 'Create',
            'current_page' => 'Manage',
            'heading' => 'Utility Management',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Printer Materials <small>Use this section to manage Printer Materials</small></h2>
                    <ul class="header-dropdown dropdown">
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="printer-materials" class="table table-hover table-custom spacing8">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Printer</th>
                                    <th>Materials</th>
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
           var table = $('#printer-materials').DataTable({
               "processing": true,
               "serverSide": true,
               "pageLength": 10,
               "responsive": true,
               "searching": false,
               "ajax": {
                   url: "{{ config('app.url') }}/printermaterial/get/all",
                   type: "GET",
                   cache: false,
                   error: function(){
                       $("#printer-materials").append('<tbody class="errors"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                   }
               },
               "columns": [
                   { data: 'id'},
                   { data: 'name'},
                   { data: 'materials'},
               ],
               fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['name']);

                    var perms = '';

                    // Looping through permission array
                    $.each(aData['materials'], function(key, value) {
                        perms += value.name + ', '
                    });

                    $('td:eq(2)', nRow).html(perms);
               }
           });
        });
   </script>
@endsection
