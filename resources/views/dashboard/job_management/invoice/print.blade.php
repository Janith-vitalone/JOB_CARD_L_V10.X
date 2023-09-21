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

        page[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;
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

        #watermark img{
            padding-left: 682px;
            width: 138px;
            margin-top: -152px;
        }
    </style>
</head>
    <body>
        <page size="A5" layout="landscape" id="content">
            {{-- <div id="watermark">
                <img src="{{ asset('/assets/images/watermark-land.png') }}" />
            </div> --}}
            <table class="w100">
                <tr>
                    <td class="w50">
                        {{-- <img src="{{ asset('assets/images/logo/Senevi.png') }}" class="logo" alt="Logo" /><br>
                        No.52 Raajagiriya  Road, Rajagiriya Sri Lanka.<br>
                        Tel: +94 11 2874773 H.L: +94 703 500700<br>
                        E: acc@senevi.lk, info@senevi.lk<br> --}}
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
                                    Sales Person
                                </td>
                                <td class="font-weight-bold">
                                    {{ $payment->invoice->job->user->name }}
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
                                    Signature & date
                                </center>
                            </td>
                        </tr>
                    </table>
                </tr>
            </table>
            {{-- <table class="mt10" cellspacing="2">
                <tr>
                    <td class="w30 font-weight-bold">
                        Client / Company Name &nbsp;&nbsp;
                    </td>
                    <td class="w30 font-weight-bold">
                        Invoice No
                    </td>
                    <td class="w30 font-weight-bold">
                        Job No
                    </td>
                    <td class="w30 font-weight-bold">
                        Due Date
                    </td>
                    <td class="w50 font-weight-bold">
                        Note
                    </td>
                </tr>
                <tr>
                    <td class="w30 font-weight-bold bordered-col p10 mr5">
                        {{ $payment->invoice->job->client->name }}
                    </td>
                    <td class="w30 font-weight-bold bordered-col p10 mr5">
                        {{ $payment->invoice->invoice_no }}
                    </td>
                    <td class="w30 font-weight-bold bordered-col p10">
                        {{ $payment->invoice->job->job_no }}
                    </td>
                    <td class="w30 font-weight-bold bordered-col p10">
                        {{ $payment->invoice->due_date }}
                    </td>
                    <td class="w30 font-weight-bold bordered-col p10">
                        {{ $payment->invoice->note }}
                    </td>
                </tr>
            </table>
            <table class="bordered-tbl w100 mt10">
                <tr>
                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>Unit Price Rs.</th>
                    <th>Amount Rs.</th>
                </tr>
                @foreach ($payment->invoice->job->jobHasTasks as $item)
                    <tr>
                        <td class="text-center">{{ $item->description }} {{ $item->material }} - {{ $item->print_type }} ({{ $item->finishing }} | {{ $item->lamination }})</td>
                        <td class="text-center">{{ $item->copies }}</td>
                        <td class="text-right pr20">{{ $item->unit_price }}</td>
                        <td class="text-right pr20">{{ number_format($item->total, 2, '.', '') }}</td>
                    </tr>
                @endforeach
                @foreach ($payment->invoice->job->jobHasProducts as $item)
                    <tr>
                        @if ($item->name == 'Custom')
                            <td class="text-center">{{ $item->description }}</td>
                        @else
                            <td class="text-center">{{ $item->name }}</td>
                        @endif
                        <td class="text-center">{{ number_format($item->qty, 0, '.', '') }}</td>
                        <td class="text-right pr20">{{ $item->price }}</td>
                        <td class="text-right pr20">{{ number_format($item->total, 2, '.', '') }}</td>
                    </tr>
                @endforeach
                @php
                    $jobTotal = $payment->invoice->job->jobHasTasks->sum('total');
                    $produtsTotal = $payment->invoice->job->jobHasProducts->sum('total');
                    $totalPaid = $payment->invoice->payments->sum('paid_amount') - $payment->paid_amount;
                @endphp
                <tr>
                    <td class="alter-column font-weight-bold text-right">Discount(%)</td>
                    <td class="text-center font-weight-bold">{{ number_format($payment->invoice->discount, 0) }}</td>
                    <td class="alter-column font-weight-bold text-right">Sub Total</td>
                    <td class="text-right pr20 font-weight-bold">{{ number_format($jobTotal + $produtsTotal, 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="alter-column font-weight-bold text-right">Grand Total</td>
                    <td class="text-right pr20 font-weight-bold">{{ $payment->invoice->grand_total }}</td>
                </tr>
                <tr>
                    <td class="alter-column font-weight-bold text-right">Previous Payments</td>
                    <td class="text-center font-weight-bold">{{ $totalPaid }}</td>
                    <td class="alter-column font-weight-bold text-right">Paid Amount</td>
                    <td class="text-right pr20 font-weight-bold">{{ $payment->paid_amount }}</td>
                </tr>
                @if ($payment->paid_amount < ($payment->invoice->grand_total - $totalPaid))
                    <tr>
                        <td colspan="3" class="alter-column font-weight-bold text-right">Due Amount</td>
                        <td class="text-right pr20 font-weight-bold">{{ number_format($payment->invoice->grand_total - ($totalPaid + $payment->paid_amount), 2, '.', '') }}</td>
                    </tr>
                @endif
            </table> --}}
            {{-- <table class="w100 mt10">
                <tr>
                    <td class="w50 v-top">
                        Designer - {{ $payment->invoice->job->user->name }} ({{ $payment->invoice->job->user->contact_no }}) <br>
                        Acc. Name : Helium Solutions (pvt) ltd. <br>
                        Bank: Commercial Bank <br>
                        Branch: Union place <br>
                        Acc.No: 1000293546
                    </td>
                    <td class="w50 text-right">
                        Helium Solutions (Pvt) Ltd. <br>
                        No: 12, Lillie Street, Union Place, <br>
                        Colombo 02. <br>
                        +94 (11) 2 500 750
                    </td>
                </tr>
            </table> --}}
        </page>

        <script>
            //window.print();
        </script>
    </body>
</html>
