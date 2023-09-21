@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('jobcard.index'),
            'page' => 'Manage',
            'current_page' => 'Show',
            'heading' => 'Job Management',
        ]])

        @php
            $payments = 0;
            $discountPrice = 0;
        @endphp

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>{{ $job->job_no }}</h2>
                        <ul class="header-dropdown dropdown">
                            @if ($job->job_status != 'closed')
                                @if (!$job->isInvoiced())
                                    <li>
                                        <a href="#" data-toggle="modal" data-target=".new-invoice-modal" class="btn btn-primary text-white">
                                            <i class="icon-drawer"></i> Create Invoice
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="{{ route("jobcard.index") }}/{{ $job->id }}/edit" class="btn btn-xs btn-primary mr-1 text-white"><i class="icon-note"></i> Edit</a>
                                    </li> --}}
                                @else
                                    @if (!$job->isFullyPaid())
                                        <li>
                                            <a href="#" data-toggle="modal" data-target=".new-payment-modal" class="btn btn-danger text-white">
                                                <i class="icon-credit-card"></i> Make Payment
                                            </a>
                                        </li>
                                    @endif
                                @endif

                                @if ($job->job_status != 'completed')
                                    <li>
                                        <a href="{{ config('app.url') }}/jobcard/change/status/{{ $job->id }}/closed" class="btn btn-danger text-white">
                                            <i class="icon-ban"></i> Close Job
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ config('app.url') }}/jobcard/change/status/{{ $job->id }}/completed" class="btn btn-success text-white">
                                            <i class="icon-check"></i> Complete Job
                                        </a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Client</label>
                                    <div>{{ $job->client->name }}</div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Client Note</label>
                                    <textarea class="form-control" name="client_note" rows="6" disabled>{{ $job->client_note }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Contact</label>
                                    <div>{{ $job->client->contact_person }}</div>
                                    <div>{{ $job->client->phone }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Details</label>

                                    <div class="table-responsive">
                                        <table class="table header-border table-hover table-custom spacing5">
                                            <tbody>
                                                <tr>
                                                    <td>Assigned To</td>
                                                    <td>{{ $job->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Job Date</td>
                                                    <td>{{ $job->finishing_date }} {{ $job->finishing_time }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Invoicing</td>
                                                    <td>
                                                        @if ($job->isInvoiced())
                                                            Invoiced
                                                        @else
                                                            Pending
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Payment</td>
                                                    @if ($job->isInvoiced())
                                                        @php
                                                            $payment_status = $job->invoice->payment_status;
                                                            $payments = $job->invoice->payments->sum('paid_amount');
                                                        @endphp

                                                        @switch($payment_status)
                                                            @case('paid')
                                                                <td class="text-success">Paid</td>
                                                                @break
                                                            @case('partially_paid')
                                                                <td class="text-warning">Partially Paid</td>
                                                                @break
                                                            @case('unpaid')
                                                                <td class="text-danger">Pending</td>
                                                                @break
                                                            @default
                                                        @endswitch
                                                    @else
                                                        <td class="text-danger">Pending</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>Job Notes</td>
                                                    <td>{{ $job->job_note }}</td>
                                                </tr>
                                                <tr>
                                                    <td>PO No.</td>
                                                    <td>{{ $job->po_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Job Status</td>
                                                    @switch($job->job_status)
                                                        @case('open')
                                                            <td class="text-warning">Open</td>
                                                            @break
                                                        @case('completed')
                                                            <td class="text-success">Completed</td>
                                                            @break
                                                        @case('closed')
                                                            <td class="text-danger">Closed</td>
                                                            @break
                                                        @default
                                                    @endswitch
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Screenshot</label>
                                    <div>
                                        <img src="{{ url('/jobs') }}/{{ $job->screenshot }}" class="img-fluid" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Job Tasks --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Copies</th>
                                        <th>Description</th>
                                        <th>W x H u</th>
                                        <th>Format</th>
                                        <th>Printer | Mode</th>
                                        <th>Material</th>
                                        <th>Lam | Fin | Bin</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody id="job_list">
                                    {{-- Jobs --}}
                                    @foreach ($job->jobHasTasks as $task)
                                        <tr>
                                            <td>
                                                @if ($task->job_ss)
                                                    <a href="#" class="job-image">
                                                        <img src="{{ url('/jobs') }}/{{ $job->job_no }}/tasks/{{ $task->job_ss }}" class="w35 rounded avatar">
                                                    </a>
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>{{ $task->copies }}</td>
                                            <td>{{ $task->description }}</td>
                                            <td>{{ $task->width }} x {{ $task->height }} {{ $task->unit }}</td>
                                            <td>{{ $task->format }}</td>
                                            <td>{{ $task->printer }} | {{ $task->print_type }}</td>
                                            <td>{{ $task->materials }}</td>
                                            <td>{{ $task->lamination }} | {{ $task->finishing }} | NA</td>
                                            <td class="text-right">{{ $task->unit_price }}</td>
                                            <td class="text-right">{{ $task->total }}</td>
                                        </tr>
                                    @endforeach

                                    @foreach ($job->jobHasProducts as $product)
                                        <tr>
                                            <td>--</td>
                                            <td>{{ $product->qty }}</td>
                                            <td>{{ $product->name }} - {{ $product->description }}</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td class="text-right">{{ $product->price }}</td>
                                            <td class="text-right">{{ $product->total }}</td>
                                        </tr>
                                    @endforeach
                                    @php
                                        $total = $job->jobHasTasks->sum('total') + $job->jobHasProducts->sum('total');
                                    @endphp

                                    <tr>
                                        <td colspan="9" class="text-right font-weight-bold">Total</td>
                                        <td class="text-right">
                                            {{ number_format($total, 2) }}
                                        </td>
                                    </tr>
                                    @if ($job->isInvoiced())
                                        <tr>
                                            <td colspan="9" class="text-right font-weight-bold">Discount(%)</td>
                                            <td class="text-right">
                                                {{ $job->invoice->discount }}
                                            </td>
                                        </tr>

                                        @php
                                            $discountPrice = $total * ($job->invoice->discount / 100);
                                        @endphp
                                    @endif
                                    <tr>
                                        <td colspan="9" class="text-right font-weight-bold">Payments</td>
                                        <td class="text-right">
                                            {{ number_format($payments, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="font-weight-bold">Collection date & time: <span class="text-danger">{{ $job->finishing_date }} {{ $job->finishing_time }}</span></td>
                                        <td colspan="4" class="text-right font-weight-bold">Balance Due Rs</td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($total - $discountPrice -$payments, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payments --}}
        @if ($job->isInvoiced())
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>Invoice No - {{ $job->invoice->invoice_no }}</h2>
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom spacing8">
                                    <thead>
                                        <tr>
                                            <th>Paid Amount</th>
                                            <th>Paid on</th>
                                            <th>Payment Type</th>
                                            <th>Cheque No</th>
                                            <th>Bank</th>
                                            <th>Branch</th>
                                            <th>Cheque Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="payments">
                                        @foreach ($job->invoice->payments as $payment)
                                            <tr>
                                                <td>{{ $payment->paid_amount }}</td>
                                                <td>{{ $payment->created_at }}</td>
                                                <td>{{ $payment->payment_type }}</td>
                                                <td>{{ $payment->cheque_no }}</td>
                                                <td>{{ $payment->bank }}</td>
                                                <td>{{ $payment->branch }}</td>
                                                <td>{{ $payment->cheque_date }}</td>
                                                <td>
                                                    {{-- <a href="{{ route('invoice.show', ['id' => $payment->id]) }}" target="_blank" class="btn btn-xs btn-warning mr-1">A5 <i class="icon-printer"></i></a> --}}
                                                    <form action="{{ route("invoice.print") }}" method="get" target="_blank" style='display: -webkit-inline-box;'>
                                                        @csrf
                                                        <input name="payment_id" value="{{ $payment->id }}" hidden>
                                                        <button type="submit" class="btn btn-xs btn-warning mr-1">A4 <i class="icon-printer"></i></button>
                                                    </form>
                                                    {{-- <a href="{{ route('invoice.update', ['id' => $payment->id]) }}" target="_blank" class="btn btn-xs btn-warning mr-1">A4 <i class="icon-printer"></i></a> --}}
                                                    <form action="{{ route("invoice.delete.payment", ['id' => $payment->id]) }}" method="post" onsubmit="return confirm('Are you sure you want to delete?');" style='display: -webkit-inline-box;'>
                                                        @csrf @method("Delete")
                                                        <button type="submit" class="btn btn-xs btn-danger"><i class="icon-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- New Invoice --}}
    <div class="modal fade new-invoice-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="invoice_form" method="POST" action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Due Date</label>
                                    <input name="due_date" id="due_date" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Sub Total</label>
                                    <input type="number" step="0.1" disabled min="1" value="{{ number_format($total, 2, '.', '') }}" id="sub_total" name="sub_total" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Discount(%)</label>
                                    <input type="number" max="100" value="0" name="discount" id="discount" min="0" step="0.1" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Grand Total</label>
                                    <input type="number" disabled name="grand_total" value="{{ number_format($total, 2, '.', '') }}" min="1" id="grand_total" step="0.1" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Payment Method</label>
                                    <select class="form-control" name="payment_method" id="payment_method" required>
                                        <option value="cash" selected>Cash</option>
                                        <option value="cc">Credit/Debit Card</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Paid Amount</label>
                                    <input type="number" name="paid_amount" min="0" id="paid_amount" step="0.1" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Cheque no</label>
                                    <input type="number" name="cheque_no" id="cheque_no" step="0.1" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Balance Due</label>
                                    <input type="number" name="balance_due" min="0" id="balance_due" step="0.01" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Bank</label>
                                    <select class="form-control" name="bank" id="bank">
                                        <option value="">Select Bank</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Branch</label>
                                    <select class="form-control" name="branch" id="branch">
                                        <option value="">Select branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Cheque Date</label>
                                    <input type="date" name="cheque_date" id="cheque_date" step="0.01" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="job_id" name="job_id" value="{{ $job->id }}"/>
                        <button type="button" class="btn btn-round btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-round btn-success" id="create_invoice">
                            <span>Create Invoice</span>
                            <div class="la-ball-fall">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- New Payment --}}
    <div class="modal fade new-payment-modal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="payment_form" method="POST" action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Balance</label>
                                    <input type="number" disabled name="balance" value="{{ number_format($total - $discountPrice - $payments, 2, '.', '') }}" min="1" id="balance" step="0.1" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Payment Method</label>
                                    <select class="form-control" name="payment_method2" id="payment_method2" required>
                                        <option value="cash" selected>Cash</option>
                                        <option value="cc">Credit/Debit Card</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Paid Amount</label>
                                    <input type="number" name="paid_amount2" min="1" id="paid_amount2" step="0.1" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Cheque no</label>
                                    <input type="number" name="pay_cheque_no" id="pay_cheque_no" step="0.1" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Balance Due</label>
                                    <input type="number" disabled name="balance_due2" min="1" id="balance_due2" step="0.1" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Bank</label>
                                    <select class="form-control" name="pay_bank" id="pay_bank">
                                        <option value="">Select Bank</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Branch</label>
                                    <select class="form-control" name="pay_branch" id="pay_branch">
                                        <option value="">Select branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label font-weight-bold">Cheque Date</label>
                                    <input type="date" name="pay_cheque_date" id="pay_cheque_date" step="0.01" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-round btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-round btn-success" id="create_payment">
                            <span>Add Payment</span>
                            <div class="la-ball-fall">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Job Image Large View --}}
    <div class="modal fade" id="job_image_modal" tabindex="-1" role="dialog" aria-labelledby="job_image_modal_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="job_image_modal_title">Job Image View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" class="img-fluid job_image_view" alt="Job Image" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-round btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">

    <style>
        .avatar {
            object-fit: cover;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#create_invoice > div').css('display', 'none');
            $('#create_payment > div').css('display', 'none');

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '0d',
                daysOfWeekDisabled: [0],
                daysOfWeekHighlighted: [1,2,3,4,5,6]
            });
        });

        $('#discount').on('change', function() {
            calculateGrandTotal();
        });

        $('#paid_amount').on('change', function() {
            calculateBalanceDue();
        });

        // Calculate Balance Due Amount
        function calculateBalanceDue()
        {
            var $paidAmount = $('#paid_amount').val();
            var $grandTotal = $('#grand_total').val();

            if ($paidAmount != '') {
                var $balanceDue = parseFloat($grandTotal) - parseFloat($paidAmount);

                $('#balance_due').val($balanceDue.toFixed(2));
            } else {
                $(this).val(0);

                $('#balance_due').val(parseFloat($grandTotal).toFixed(2));
            }
        }

        // Calculate Grand Total
        function calculateGrandTotal()
        {
            var $subTotal = $('#sub_total').val();
            var $discount = $('#discount').val();
            var $grandTotal = 0;

            if ($subTotal != '' && $discount != '') {
                $subTotal = parseFloat($subTotal);
                $discount = parseFloat($discount);

                if ($discount == 0) {
                    $grandTotal = $subTotal;
                } else {
                    $grandTotal = $subTotal - ($subTotal * ($discount / 100));
                }
            }

            $('#grand_total').val(Math.round($grandTotal).toFixed(2));
            calculateBalanceDue();
        }

        $('#paid_amount2').on('change', function() {
            calculateBalancePaymentForm();
        });

        // Calculate Balance Payment
        function calculateBalancePaymentForm()
        {
            var $balance = parseFloat($('#balance').val());
            var $paidAmount = $('#paid_amount2').val();

            if ($paidAmount != '') {
                $paidAmount = parseFloat($paidAmount);

                if ($paidAmount > $balance) {
                    swal('Warning', 'Paid amount should less than Balance Amount', 'warning')
                    return;
                }

                var $balanceDue = $balance - $paidAmount;
                $('#balance_due2').val($balanceDue);
            }
        }

        // Submit Invoice Form
        $('#invoice_form').on('submit', function (e) {
            e.preventDefault();
            $('#create_invoice > div').css('display', 'block');
            $('#create_invoice > span').css('display', 'none');

            $.ajax({
                type: "POST",
                url: "{{ config('app.url') }}/invoice/new/create",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'job_id': $('#job_id').val(),
                    'discount': $('#discount').val(),
                    'paid_amount': $('#paid_amount').val(),
                    'payment_method': $('#payment_method').val(),
                    'due_date': $('#due_date').val(),
                    'cheque_no': $('#cheque_no').val(),
                    'bank': $('#bank').val(),
                    'branch': $('#branch').val(),
                    'cheque_date': $('#cheque_date').val(),
                },
                success: function (response) {
                    if (response.error) {
                        $.each(response.error, function (key, value) {
                            swal('Error', value[0], 'error');
                            return false;
                        });
                        return;
                    }

                    swal('Success', 'Invoice Created', 'success');

                    setTimeout(function(){
                        location.reload();
                    }, 500);
                },
                error: function (error) {
                    if (error.status == 401) {
                        swal('Failed', 'You dont have permission to create invoices', 'error');
                        return;
                    }

                    swal('Failed', 'Unable to create invoice, please try again later', 'error');
                },
                complete: function () {
                    $('#create_invoice > div').css('display', 'none');
                    $('#create_invoice > span').css('display', 'block');
                }
            });
        });

        // Submit Payment Form
        $('#payment_form').on('submit', function (e) {
            e.preventDefault();

            var $balance = parseFloat($('#balance').val());
            var $paidAmount = parseFloat($('#paid_amount2').val());

            if ($paidAmount > $balance) {
                swal('Warning', 'Paid amount should less than Balance Amount', 'warning')
                return;
            }

            $('#create_payment > div').css('display', 'block');
            $('#create_payment > span').css('display', 'none');

            $.ajax({
                type: "POST",
                url: "{{ config('app.url') }}/invoice/new/payment",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'job_id': $('#job_id').val(),
                    'paid_amount': $('#paid_amount2').val(),
                    'payment_method': $('#payment_method2').val(),
                    'cheque_no': $('#pay_cheque_no').val(),
                    'bank': $('#pay_bank').val(),
                    'branch': $('#pay_branch').val(),
                    'cheque_date': $('#pay_cheque_date').val(),
                },
                success: function (response) {
                    if (response.error) {
                        $.each(response.error, function (key, value) {
                            swal('Error', value[0], 'error');
                            return false;
                        });
                        return;
                    }

                    swal('Success', 'Payment Added', 'success');

                    setTimeout(function () {
                        location.reload();
                    }, 500);
                },
                error: function (error) {
                    if (error.status == 401) {
                        swal('Failed', 'You dont have permission to add payments', 'error');
                        return;
                    }

                    swal('Failed', 'Unable to add payment, please try again later', 'error');
                },
                complete: function () {
                    $('#create_payment > div').css('display', 'none');
                    $('#create_payment > span').css('display', 'block');
                }
            });
        });

        // Opening Job Image Modal
        $('.job-image').on('click', function(e) {
            e.preventDefault();

            var $image = $(this).find('img').attr('src');
            $('.job_image_view').attr('src', $image);

            $('#job_image_modal').modal('toggle');
        });
    </script>
@endsection
