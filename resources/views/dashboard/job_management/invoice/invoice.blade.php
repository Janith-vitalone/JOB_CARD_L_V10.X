<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <title>Invoice Print</title>

    <style>
        body {
            font-size: 8pt;
            font-family: 'Roboto', sans-serif;
        }

        .w100 {
            width: 100%;
        }

        .w50 {
            width: 50%;
        }

        .w30 {
            width: 25%;
        }

        .logo {
            width: 225px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .bordered-col {
            border: 1px solid #000000;
        }

        .bordered-tbl, .bordered-tbl tr td, .bordered-tbl tr th {
            border: 1px solid #000000;
            border-collapse: collapse;
            padding: 5px;
        }
        .heightrow {
            height: 60%;
        }
        .p10 {
            padding: 10px !important;
        }

        .pr20 {
            padding-right: 20px !important;
        }

        .alter-column {
            background-color: #c2c2c2;
        }

        .mt10 {
            margin-top: 10px;
        }

        .mr5 {
            margin-right: 5px;
        }

        .v-top {
            vertical-align: top;
        }

        body {
            background: rgb(204,204,204);
        }

        page {
            position: relative;
            background: white;
            display: block;
            margin: 0 auto;
            /* margin-bottom: 0.5cm; */
        }

        page[size="A4"]{
            width: 21cm;
            height: 29.7cm;
        }

        @media print {
            body, page {
                background: white;
                margin: 0;
                box-shadow: 0;
                margin-bottom: 0;
            }
        }

        #watermark {
            position: absolute;
            text-align: center;
            width: 21cm;
            height: calc(100% - 4cm);
            z-index: 1;
            top: 4cm;
        }
    </style>
</head>
    <body>
        <page size="A4" id="content">
            <div id="watermark">
                {{-- <img src="{{ asset('/assets/images/watermark.png') }}" width="200" /> --}}
            </div>
            <table class="w100">
                <tr>
                    <td class="w50">
                        <img src="{{ asset('assets/images/logo/Senevi.png') }}" class="logo" alt="Logo" /><br>
                        No.52 Raajagiriya  Road, Rajagiriya Sri Lanka.<br>
                        Tel: +94 11 2874773 H.L: +94 703 500700<br>
                        E: acc@senevi.lk, info@senevi.lk<br>
                        <br><br>
                        <table class="w50 bordered-tbl">
                            <tr>
                                <td class="font-weight-bold" rowspan="2">
                                    Client Name<br>
                                    <p>
                                        {{ $payment->invoice->job->client->name }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="w30">
                        <h1>INVOICE</h1>
                        {{-- <h4>{{ date_format($payment->invoice->created_at, 'Y-m-d') }}</h4> --}}
                        <table class="w100 bordered-tbl">
                            <tr>
                                <td class="font-weight-bold">
                                    Job No.
                                </td>
                                <td class="font-weight-bold">
                                    {{ $payment->invoice->job->job_no }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    QT No.
                                </td>
                                <td class="font-weight-bold">
                                    {{ $payment->invoice->job->quote_no }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    PO No.
                                </td>
                                <td class="font-weight-bold">
                                    {{ $payment->invoice->job->po_no }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    Invoice No.
                                </td>
                                <td class="font-weight-bold">
                                    {{ $payment->invoice->invoice_no }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    Invoice Date
                                </td>
                                <td class="font-weight-bold">
                                    {{ date_format($payment->invoice->created_at, 'Y-m-d') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    Contact Person
                                </td>
                                <td class="font-weight-bold">

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <table class="w100 bordered-tbl" style="200px">
                        <tr>
                            <th class="alter-column">Item</th>
                            <th class="w50 alter-column">Description</th>
                            <th class="alter-column">Qty</th>
                            <th class="alter-column">Unit price</th>
                            <th class="w30 alter-column">Amount</th>
                        </tr>
                        @foreach ($payment->invoice->job->jobHasTasks as $key => $item)
                        <tr>
                            <td class="text-center">{{$key}}</td>
                            <td class="text-center">
                                {{ $item->description }} {{ $item->material }} - {{ $item->print_type }} ({{ $item->finishing }} | {{ $item->lamination }})
                            </td>
                            <td class="text-center">
                                {{ $item->copies }}
                            </td>
                            <td class="text-center">
                                {{ $item->unit_price }}
                            </td>
                            <td class="text-center">
                                {{ number_format($item->total, 2, '.', '') }}
                            </td>
                        </tr>
                        @endforeach
                        @foreach ($payment->invoice->job->jobHasProducts as $key => $item)
                        <tr>
                            <td class="text-center">{{$key+1}}</td>
                            @if ($item->name == 'Custom')
                                <td class="text-center">
                                    {{ $item->description }}
                                </td>
                            @else
                                <td class="text-center">
                                    {{ $item->name }}
                                </td>
                            @endif
                            <td class="text-center">
                                {{ number_format($item->qty, 0, '.', '') }}
                            </td>
                            <td class="text-center">
                                {{ $item->price }}
                            </td>
                            <td class="text-right pr20">
                                {{ number_format($item->total, 2, '.', '') }}
                            </td>
                        </tr>
                        @endforeach
                        @php
                            $jobTotal = $payment->invoice->job->jobHasTasks->sum('total');
                            $produtsTotal = $payment->invoice->job->jobHasProducts->sum('total');
                            $totalPaid = $payment->invoice->payments->sum('paid_amount') - $payment->paid_amount;
                        @endphp
                    </table>
                </tr>
                <tr>
                    <table class="w100 bordered-tbl">
                        <tr>
                            <td class="w50"></td>
                            <td class="w30 font-weight-bold">
                                Total<br>
                                Discount<br>
                                Balance
                            </td>
                            <td class="text-right pr20">
                                {{ $payment->invoice->grand_total }} <br>
                                {{ number_format($payment->invoice->discount, 0) }}<br>
                                @if ($payment->paid_amount < ($payment->invoice->grand_total - $totalPaid))
                                    {{ number_format($payment->invoice->grand_total - ($totalPaid + $payment->paid_amount), 2, '.', '') }}
                                @else
                                    0.00
                                @endif
                            </td>
                        </tr>
                    </table>
                </tr>
                <tr>
                    <br>
                    Noted: Please make your payment by a Cheque n favor of " Senevi fast print" and Crossed Account Pay Only<br>
                    Noted: We are not Guaranteed for your goods after 14 days. දින 14 කින් පසු ඔබගේ භාන්ඩ සදහ වගකියනු නොලැබේ.<br><br>
                    Cheques Sould be drown in favor of " Senevi Creation " & Cross A/C payee.
                </tr>
                <tr>
                    <table class="w100 mt10">
                        <tr>
                            <td class="w50 mt10"></td>
                            <td class="w30 font-weight-bold mt10">
                                <br><br>
                                <center>
                                    ________________<br>
                                    Authorized by
                                </center>
                            </td>
                            <td class="w30 font-weight-bold mt10">
                                <br><br><br>
                                <center>
                                    ________________<br>
                                    Customer<br>
                                    Signature & dates
                                </center>
                            </td>
                        </tr>
                    </table>
                </tr>
            </table>
        </page>

        <script>
            window.print();
        </script>
    </body>
</html>
