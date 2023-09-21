@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('invoice.index'),
            'page' => 'Manage',
            'current_page' => 'Payment',
            'heading' => 'Invoice Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Client Information</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="tab-content">
                                    {{-- Existing Client Form --}}
                                    <div class="tab-pane show active" id="Home-new2">
                                        <div class="row clearfix">
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Client Name</label>
                                                    <input type="text" name="client_id" id="client_id" class="form-control" value="{{ $client[0]->name }}" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Contact Person</label>
                                                    <input type="text" name="client_name" id="client_name" class="form-control" value="{{ $client[0]->contact_person }}" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Phone</label>
                                                    <input type="text" name="client_phone" id="client_phone" class="form-control" value="{{ $client[0]->phone }}" disabled required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Email</label>
                                                    <input type="text" name="client_email" id="client_email" class="form-control" value="{{ $client[0]->email }}" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Fax</label>
                                                    <input type="text" name="client_fax" id="client_fax" class="form-control" value="{{ $client[0]->fax }}" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="client_addrse" class="control-label">Address</label>
                                                    <textarea class="form-control @error('client_addrse') is-invalid @enderror" id="client_addrse" name="client_addrse" disabled rows="6">{{ $client[0]->address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Invoice Items --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Invoice Items</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_quote_items">
                                    @foreach($products as $key => $product)
                                        @php
                                            $amount = 0.00;
                                            $amount = $product->unit_price * $product->qty;
                                        @endphp
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                {{ $product->description }}<br>
                                                {{ $product->products->name }}
                                            </td>
                                            <td>{{ $product->qty }}</td>
                                            <td>{{ $product->unit_price }}</td>
                                            <td class="text-right">{{ number_format($amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td colspan="4" class="text-right font-weight-bold">SubTotal</td>
                                            <td class="text-right">
                                                {{ number_format($invoice->sub_total, 2) }}
                                            </td>
                                        </tr>
                                        @php
                                            $discount = 0;
                                            $discount = ($invoice->discount * 100) /$invoice->sub_total;
                                        @endphp
                                        <tr>
                                            <td colspan="4" class="text-right font-weight-bold">Discount</td>
                                            <td class="text-right">
                                                {{ $discount }} %
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right font-weight-bold">Total</td>
                                            <td class="text-right">
                                                {{ number_format($invoice->grand_total, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                        @php
                                            $amount = 0.00;
                                        @endphp
                                        @foreach($payments as $key => $payment)
                                            @php
                                                $amount = $amount + $payment->paid_amount ;
                                            @endphp
                                                <input value="{{ $payment->paid_amount }}" hidden>
                                        @endforeach
                                            <td colspan="4" class="text-right font-weight-bold">Payments</td>
                                            <td class="text-right">
                                                {{ number_format($amount, 2) }}
                                            </td>
                                        </tr>
                                        @if($invoice->payment_status == "partially_paid")
                                        <tr>
                                            <td colspan="4" class="text-right font-weight-bold">Payment Status</td>
                                            <td class="text-right" style="color:yellow;">
                                                Partially Paid
                                            </td>
                                        </tr>
                                        <tr>
                                            @php
                                                $balance = 0;
                                                $balance = $invoice->grand_total - $amount;
                                            @endphp
                                            <td colspan="4" class="text-right font-weight-bold">Balance</td>
                                            <th class="text-right" style="color:red;">
                                                {{ number_format($balance, 2) }}
                                            </th>
                                        </tr>
                                        @endif
                                        @if($invoice->payment_status == "unpaid")
                                        <tr>
                                            <td colspan="4" class="text-right font-weight-bold">Payment Status</td>
                                            <td class="text-right" style="color:yellow;">
                                                Unpaid
                                            </td>
                                        </tr>
                                        <tr>
                                            @php
                                                $balance = 0;
                                                $balance = $invoice->grand_total - $amount;
                                            @endphp
                                            <td colspan="4" class="text-right font-weight-bold">Balance</td>
                                            <th class="text-right" style="color:red;">
                                                {{ number_format($balance, 2) }}
                                            </th>
                                        </tr>
                                        @endif
                                        @if($invoice->payment_status == "paid")
                                        <tr>
                                            <td colspan="4" class="text-right font-weight-bold">Payment Status</td>
                                            <td class="text-right" style="color:yellow;">
                                                Paid
                                            </td>
                                        </tr>
                                        @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Create Quote Button --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                <div class="header">
                        <h2>Invoice Payments</h2>
                    </div>
                    <div class="body">
                    <div class="table-responsive">
                            <table class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Paid Amount</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_quote_items">
                                        @php
                                            $amount = 0.00;
                                        @endphp
                                        @foreach($payments as $key => $payment)
                                            @php
                                                $amount = $amount + $payment->paid_amount ;
                                            @endphp
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $payment->paid_amount }}</td>
                                                <td>{{ $payment->created_at }}</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($invoice->payment_status == "paid")

                        @else
                            <form id="payment_form" action="" method="POST">
                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group">
                                            <label for="phone" class="control-label">Paid Amount</label>
                                            <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success" id="createquote">
                                                <span>Create Payment</span>
                                                <div class="la-ball-fall">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($invoice->payment_status == "paid")
    @else
        <input id="balance" name="balance" value="{{ $balance }}" hidden>
        <input id="invoice_id" name="invoice_id" value="{{ $invoice->id }}" hidden>
        <input id="payment_method" name="payment_method" value="cash" hidden>
    @endif
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">

    <style>
        .client-note-container {
            position: relative;
        }

        .client-note {
            position: absolute;
            width: calc(100% - 30px);
        }

        .target {
            border: solid 1px #aaa;
            min-height: 200px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            transition: 300ms all;
            position: relative;
            background-size: cover;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    {{-- Multi Select and Date Pickers Initilization --}}
    <script>
        $(document).ready(function() {
            $('#createquote > div').css('display', 'none');

            $('#save').css('display', 'none');
            $('#addnew').css('display', 'block');

            $('#client').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });
        });

        // Submit Payment Form
        $('#payment_form').on('submit', function (e) {
            e.preventDefault();

            var $balance = parseFloat($('#balance').val());
            var $paidAmount = parseFloat($('#paid_amount').val());

            if ($paidAmount > $balance) {
                swal('Warning', 'Paid amount should less than Balance Amount', 'warning')
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{ config('app.url') }}/invoice/quick/new/payment",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'invoice_id': Number($('#invoice_id').val()),
                    'paid_amount': Number($('#paid_amount').val()),
                    'balance': Number($('#balance').val()),
                    'payment_method': $('#payment_method').val(),
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
            });
        });
    </script>
@endsection
