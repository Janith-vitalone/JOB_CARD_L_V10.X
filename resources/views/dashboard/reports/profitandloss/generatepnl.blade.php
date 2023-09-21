@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('home'),
            'page' => 'Reports',
            'current_page' => 'Profit and Loss Report',
            'heading' => 'Reports',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Profit and Loss <small>From {{ $from_date }} to {{ $to_date }}</small></h2>
                    <ul class="header-dropdown dropdown">
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col">
                            <div class="profit-and-loss-single">
                                <p class="mb-0">Income</p>
                                <h1 class="fs-40 text-dark">Rs. {{number_format($income, 2, '.', '') }} </h1>
                            </div>
                        </div>
                        <div class="col">
                            <div class="profit-and-loss-single">
                                <p class="mb-0">Expenses</p>
                                <h1 class="fs-40 text-dark">Rs. {{number_format($expense, 2, '.', '') }}  </h1>
                            </div>
                        </div>
                        <div class="col">
                            <div class="profit-and-loss-single">
                                <p class="mb-0">Net Profit</p>
                                <h1 class="fs-40 text-danger">{{number_format($income - $expense, 2, '.', '')}}</h1>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="p_and_l_report" class="table table-hover table-custom spacing8">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Particulars</th>
                                    <th>Amount (Rs.)</th>
                                    <th>Amount (Rs.)</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input value="{{ $from_date }}" name="from" hidden>
    <input value="{{ $to_date }}" name="to" hidden>
@endsection

@section('css')
 
 <style>
    .profit-and-loss-report {
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-align: center;
    }
    .mt-50 {
        margin-top: 50px !important;
    }
    .mt-30 {
        margin-top: 30px !important; 
    }
    .bb-2 {
      border-bottom: 2px solid #ebebeb !important;
    }
    .mt-20 {
       margin-top: 20px !important;  
    }
    .mt-10 {
       margin-top: 10px !important;  
    }
 </style>
   
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
           var table = $('#p_and_l_report').DataTable({
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
                    url: "{{ config('app.url') }}/reports/profitandloss/genarate/table",
                    type: "GET",
                    cache: false,
                    data: function (d) {
                        d.from = $('input[name=from]').val();
                        d.to = $('input[name=to]').val();
                    },
                    error: function() {
                        $("#p_and_l_report").append('<tbody class="errors"><tr><th colspan="8">No data found in the server</th></tr></tbody>');
                    }
                },
                "columns": [
                   { data: 'id'},
                   { data: 'name'},
                   { data: 'single'},
                   { data: 'total'},
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['name']);
                    $('td:eq(2)', nRow).html(aData['single']);
                    $('td:eq(3)', nRow).html(aData['total']);
                }
           });
        });
   </script>
@endsection
