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
                        <img src="{{ asset('assets/images/logo/Senevi.png') }}" class="logo" alt="Logo" /><br>
                        No.52 Raajagiriya  Road, Rajagiriya Sri Lanka.<br>
                        Tel: +94 11 2874773 H.L: +94 703 500700<br>
                        E: acc@senevi.lk, info@senevi.lk<br>
                        <br><br>
                    </td>
                    <td class="w30">
                        <h1>INVOICE</h1>
                        {{-- <h4>{{ date_format($invoice->created_at, 'Y-m-d') }}</h4> --}}
                        <table class="w100 bordered-tbl">
                            <tr>
                                <td class="font-weight-bold">
                                    Invoice No.
                                </td>
                                <td class="font-weight-bold">
                                    {{ $invoice->invoice_no }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    Invoice Date
                                </td>
                                <td class="font-weight-bold">
                                    {{ date_format($invoice->created_at, 'Y-m-d') }}
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
                        @foreach ($products as $key => $product)
                        <tr>
                            @php
                                $total = 0;
                                $total = $product->unit_price * $product->qty;
                            @endphp
                            <td class="text-center">{{$key+1}}</td>
                            <td class="text-center">
                                {{ $product->description }}<br>
                                {{ $product->products->name }}
                            </td>
                            <td class="text-center">
                                {{ $product->qty }}
                            </td>
                            <td class="text-center">
                                {{ $product->unit_price }}
                            </td>
                            <td class="text-center">
                                {{ number_format($total, 2, '.', '') }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </tr>
                <tr>
                    <table class="w100 bordered-tbl">
                        <tr>
                            <td class="w50"></td>
                            <td class="w30 font-weight-bold">
                                Discount<br>
                                Total<br>
                                Payment<br>
                                Balance
                            </td>
                            <td class="text-right pr20">
                                {{ number_format($invoice->discount, 0) }}<br>
                                {{ $invoice->grand_total }} <br>
                                {{ $invoice->grand_total }}<br>
                                0.00
                            </td>
                        </tr>
                    </table>
                </tr>
                <tr>
                    <br>
                    <strong>NOTE</strong> : Cheques Should be drawn in favour of " Senevi Creation " & cross A/C Payee.
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
        </page>

        <script>
            window.print();
        </script>
    </body>
</html>
