<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Quotation</title>

    <style>
        html {
            height: 100%;
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
            width: 150px;
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
            position: fixed;
            text-align: center;
            bottom: 20px;
            width: 100%;
        }

        .footer-title {
            font-size: 24px;
        }

        .footer-sub-title {
            font-size: 18px;
        }

        #watermark {
            position: fixed;
            bottom:   12cm;
            left:     5.5cm;
            width:    8cm;
            height:   8cm;
            z-index:  -1000;
        }
    </style>
</head>
    <body>
        <!-- <div id="watermark">
            <img src="{{ public_path('/assets/images/watermark.png') }}" width="100%" />
        </div> -->
        <table class="w100">
            <tr>
                <td class="w50">
                    <img src="{{ public_path('/assets/images/logo/Senevi.png') }}" class="logo" alt="Logo" />
                </td>

                
               <td class="w50 text-right" text >
                            <h4>  Quotation </h4> <br>
                             To: {{ $quote->client->name }} <br>
                             Address: {{ $quote->client->address }} <br>
                             Quote No: {{ $quote->quote_no }} <br>
                             Date: {{ $quote->quote_date }}
                </td>
            </tr>
        </table>

        <table class="w100 mt100">
            <tr>
                <th class="text-left">#</th>
                <th class="text-left border-bottom">Description</th>
                <th class="text-right"><span class="border-bottom pr5 pl5">Unit Price</span></th>
                <th class="text-right"><span class="border-bottom pr5 pl5">Qty</span></th>
                <th class="text-right"><span class="border-bottom pr5 pl5">Amount</span></th>
            </tr>
            <tr>
                <td colspan="5" class="p10"></td>
            </tr>
            @foreach ($quote->quotationHasItems as $key => $item)
                <tr>
                    <td class="text-left v-top">{{ $key + 1 }}</td>
                    <td>
                        <span class="font-weight-bold">{{ $item->description }}</span> <br>
                        <span>{{ $item->sub_description }}</span>
                    </td>
                    <td class="text-right">{{ $item->unit_price }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="5" class="p10 border-bottom"></td>
            </tr>
            <tr>
                <td colspan="5" class="p10 border-bottom pt20">&nbsp;</td>
            </tr>
            <tr>
                <td class="text-left pt10 font-weight-bold" colspan="3">Total Rs.</td>
                <td class="text-right pt10 font-weight-bold" colspan="2">{{ number_format($quote->total, 2) }}</td>
            </tr>
            <tr>
                <td class="text-center pt30 footer-sub-title" colspan="5">
                        * Chequrs Should be drown in favor of "Senevi Creation" & Cross A/C Payee.<br>
                        * Above information is not an invoice and only an estimate of services/goods described above.<br>
                        * Please confirm your acceptance of this quote by signing this document and make 60% Advance.<br>
                        * Price Validity period 5 days only.
                </td>
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
    </body>
</html>
