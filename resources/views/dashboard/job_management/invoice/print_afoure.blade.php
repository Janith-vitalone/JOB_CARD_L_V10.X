<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <title>Invoice</title>

    <style>
        body {
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
            {{-- <page size="A4" id="content" style="background: url(/assets/images/print/invoice-bg.png) no-repeat;background-size: 100%;"> --}}
            {{-- <div id="watermark">
                <img src="{{ asset('/assets/images/watermark.png') }}" width="100%" />
            </div> --}}
            <div>
                <table class="w100">
                    <tr>
                        <td class="w50">
                            {{-- <img src="{{ asset('/assets/images/logo/Senevi.png') }}" class="logo" alt="Logo" />
                            <br>
                            No.52 Raajagiriya  Road, Rajagiriya Sri Lanka.<br>
                            Tel: +94 11 2874773 H.L: +94 703 500700<br>
                            E: acc@senevi.lk, info@senevi.lk<br>
                            <br> --}}
                            <table class="w100" style="margin-top: 230px">
                                <tr>
                                    <td class="font-weight-bold"></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 36px; font-size: 12px;">
                                        {{ $payment->invoice->job->client->name }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        {{-- <td class="w20"></td> --}}
                        <td class="text-right">
                            <table class=" w100" style="margin-top: 180px; padding-right: 40px;">
                                <tr>
                                    <td class="font-weight-bold"></td>
                                    <td class="text-right" style="font-size: 12px; height:24px;">
                                        {{ $payment->invoice->job->job_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"></td>
                                    <td class="text-right" style="font-size: 12px; height:24px;">
                                        {{ $payment->invoice->job->quote_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-center"></td>
                                    <td class="text-right" style="font-size: 12px; height:24px;">
                                        {{ $payment->invoice->job->po_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-center"></td>
                                    <td class="text-right" style="font-size: 12px; height:24px;">
                                        {{ $payment->invoice->invoice_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold text-center"></td>
                                    <td class="text-right" style="font-size: 12px; height:24px;">
                                        {{ $payment->invoice->job->user->name }}
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
            </div>
            <div style="height: 505px">
                <table class="w100 mt10" style="padding-top: 50px; font-size: 12px;">
                    @foreach ($payment->invoice->job->jobHasTasks as $key => $item)
                        <tr>
                            <td class="text-center v-top" style="padding-left: 30px">{{ $key + 1 }}</td>
                            <td style="width: 50%; padding-left:40px">
                                <span class="font-weight-bold">{{ $item->description }}</span> <br>
                                <span>({{ $item->materials }})</span>
                                {{-- <span>{{ $item->print_type }} ({{ $item->finishing }} | {{ $item->lamination }})</span> --}}
                            </td>
                            <td class="text-right">{{ $item->copies }}</td>
                            <td class="text-right" style="width:20%; padding-right: 10px">{{ $item->unit_price }}</td>
                            <td class="text-right" style="width:20%;padding-right: 40px ">{{ number_format($item->total, 2, '.', '') }}</td>
                        </tr>
                    @endforeach

                    @foreach ($payment->invoice->job->jobHasProducts as $key => $item)
                        <tr>
                            <td class="text-center v-top" style="padding-left: 30px">{{ $key + 1 }}</td>
                            @if ($item->name == 'Custom')
                                <td class="text-center" style="width: 50%; padding-left:40px">
                                    {{ $item->description }}
                                </td>
                            @else
                                <td class="text-center" style="width: 50%; padding-left:40px">
                                    {{ $item->name }}
                                </td>
                            @endif
                            <td class="text-right">{{ number_format($item->qty, 0, '.', '') }}</td>
                            <td class="text-right" style="width:20%">{{ $item->price }}</td>
                            <td class="text-right" style="width:20%;padding-right: 35px ">{{ number_format($item->total, 2, '.', '') }}</td>
                        </tr>
                    @endforeach
                    @php
                        $jobTotal = $payment->invoice->job->jobHasTasks->sum('total');
                        $produtsTotal = $payment->invoice->job->jobHasProducts->sum('total');
                        $totalPaid = $payment->invoice->payments->sum('paid_amount') - $payment->paid_amount;
                    @endphp
                </table>
            </div>
            <div>
                <table class="w100" style="font-size: 12px; padding-right: 40px;">
                    <tr>
                        <td class="w50"></td>
                        <td class="w30 font-weight-bold">
                        </td>
                        <td class="text-right">
                            {{ $payment->invoice->grand_total }} <br><br>
                            {{ number_format($totalPaid, 2) }}<br><br>
                            @if ($payment->paid_amount < ($payment->invoice->grand_total - $totalPaid))
                                {{ number_format($payment->invoice->grand_total - ($totalPaid + $payment->paid_amount), 2, '.', '') }}
                            @else
                                0.00
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            {{-- <br><br>
            <table class="w100 mt10">
                <tr>
                    * Noted: Please make your payment by a Cheque n favor of " Senevi fast print" and Crossed Account Pay Only<br>
                    * Noted: We are not Guaranteed for your goods after 14 days. දින 14 කින් පසු ඔබගේ භාන්ඩ සදහ වගකියනු නොලැබේ.<br><br>
                    * Cheques Sould be drown in favor of " Senevi Creation " & Cross A/C payee.
                </tr>
                <tr>
                    <td class="w30"></td>
                    <td>
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
            </table> --}}


            {{-- <div class="footer">
                <div class="footer-title font-weight-bold">
                    <img src="{{ asset('/assets/images/social-media/tiktok.png') }}" alt="tiktok" width="20px">
                    <img src="{{ asset('/assets/images/social-media/instagram.png') }}" alt="instagram" width="20px">
                    <img src="{{ asset('/assets/images/social-media/facebook.png') }}" alt="facebook" width="20px">
                    Senavi Creation
                </div>
                <div class="footer-sub-title">www.senevi.lk</div>
            </div> --}}
        </page>
        <script>
            window.print();
        </script>
    </body>
</html>
