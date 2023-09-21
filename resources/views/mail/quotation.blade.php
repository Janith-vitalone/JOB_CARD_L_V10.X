<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <title>Quotation</title>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .w100 {
            width: 100%;
        }
        .h50 {
            height: 30%;
        }
        .w50 {
            width: 50%;
        }

        .w30 {
            width: 25%;
        }

        .w20 {
            width: 5%;
        }

        .logo {
            width: 300px;
        }

        .text-left {
            text-align: left;
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

        .bordered-tl, .bordered-tl tr th {
            border: 1px solid #000000;
            border-collapse: collapse;
            padding: 5px;
        }

        .border-bottom {
            border-bottom: 1px solid #48b1a7;
        }

        .p10 {
            padding: 10px !important;
        }

        .pr20 {
            padding-right: 20px !important;
        }

        .pl5 {
            padding-left: 5px;
        }

        .pr5 {
            padding-right: 5px;
        }

        .pt30 {
            padding-top: 30px;
        }

        .pt20 {
            padding-top: 20px;
        }

        .pt10 {
            padding-top: 20px;
        }

        .alter-column {
            background-color: #c2c2c2;
        }

        .mt10 {
            margin-top: 10px;
        }

        .mt100 {
            margin-top: 100px;
        }

        .mr5 {
            margin-right: 5px;
        }

        .v-top {
            vertical-align: top;
        }

        .footer{
            position: absolute;
            text-align: center;
            bottom: 0px;
            width: 21cm;
        }

        .footer-title {
            font-size: 24px;
        }

        .footer-sub-title {
            font-size: 18px;
        }

        body {
            background: rgb(204,204,204);
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
        }

        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
            position: relative;
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
            bottom:   12cm;
            left:     5.5cm;
            width:    8cm;
            height:   8cm;
            z-index:  1;
        }
    </style>
</head>
    <body>
        <page size="A4" id="content">
            {{-- <div id="watermark">
                <img src="{{ asset('/assets/images/watermark.png') }}" width="100%" />
            </div> --}}
            <table class="w100">
                <tr>
                    <td class="w50">
                        <img src="{{ asset('/assets/images/logo/Senevi.png') }}" class="logo" alt="Logo" />
                        <br>

                    </td>
                    {{-- <td class="w20"></td> --}}
                    <td class="text-right">
                        <h1>Quatation</h1>
                        <table class=" w100 bordered-tbl">
                            <tr>
                                <td class="font-weight-bold text-center">
                                    QT. Date
                                </td>
                                <td class="text-center">
                                    {{ $quote->quote_date }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-center">
                                    QT. No
                                </td>
                                <td class="text-center">
                                    {{ $quote->quote_no }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-center">
                                   Sales Person
                                </td>
                                <td class="text-center">
                                    {{ $quote->user->name }}
                                </td>
                            </tr>
                        </table>
                        {{-- To: {{ $quote->client->name }} <br>
                        Address: {{ $quote->client->address }} <br>
                        Quote No: {{ $quote->quote_no }} <br>
                        Date: {{ $quote->quote_date }} --}}
                    </td>
                </tr>
                <tr>
                    <td class="w50">
                        No.52 Raajagiriya  Road, Rajagiriya Sri Lanka.<br>
                        Tel: +94 11 2874773 H.L: +94 703 500700<br>
                        E: acc@senevi.lk, info@senevi.lk<br>
                    </td>
                    {{-- <td class="w20"></td> --}}
                    <td class="w50">
                        <table class="w100 bordered-tbl">
                            <tr>
                                <td class="font-weight-bold">
                                    Client Name
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $quote->client->name }}
                                </td>
                            </tr>
                        </table>
                        {{-- To: {{ $quote->client->name }} <br>
                        Address: {{ $quote->client->address }} <br>
                        Quote No: {{ $quote->quote_no }} <br>
                        Date: {{ $quote->quote_date }} --}}
                    </td>
                </tr>
            </table>

            <table class="w100 mt10 bordered-tl">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quote->quotationHasItems as $key => $item)
                    <tr style="border: 1px solid black;text-align:center;">
                        <td>
                            {{ $item->description }}<br>
                            - {{ $item->sub_description }}
                        </td>
                        <td style="border: 1px solid black;text-align:center;">{{ $item->qty }}</td>
                        <td style="border: 1px solid black;text-align:center;">{{ $item->unit_price }}</td>
                        <td style="border: 1px solid black;text-align:center;">{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <br><br>
            <table class="w100 mt10">
                <tr>
                        * Chequrs Should be drown in favor of "Senevi Creation" & Cross A/C Payee.<br>
                        * Above information is not an invoice and only an estimate of services/goods described above.<br>
                        * Please confirm your acceptance of this quote by signing this document and make 60% Advance.<br>
                        * Price Validity period 5 days only.
                </tr>
                <tr>
                    <td class="w30"></td>
                    <td>
                        <br><br><br>
                        _________________<br>
                        Prepared by
                    </td>
                    <td class="w30"></td>
                    <td class="text-center">
                        <br><br><br>
                        _________________<br>
                        Authorized by
                    </td>
                    <td class="w30"></td>
                    <td class="text-center">
                        <br><br><br><br>
                        _________________<br>
                        Customer<br> Signature & date
                    </td>
                    <td class="w30"></td>
                </tr>
            </table>


            <div class="footer">
                <div class="footer-title font-weight-bold">
                    <img src="{{ asset('/assets/images/social-media/tiktok.png') }}" alt="tiktok" width="20px">
                    <img src="{{ asset('/assets/images/social-media/instagram.png') }}" alt="instagram" width="20px">
                    <img src="{{ asset('/assets/images/social-media/facebook.png') }}" alt="facebook" width="20px">
                    Senavi Creation
                    <img src="{{ asset('/assets/images/social-media/pic.png') }}" alt="facebook" width="250px">
                </div>
                <div class="footer-sub-title font-weight-bold">www.senevi.lk</div>
            </div>
        </page>
        {{-- <script>
            window.print();
        </script> --}}
    </body>
</html>
