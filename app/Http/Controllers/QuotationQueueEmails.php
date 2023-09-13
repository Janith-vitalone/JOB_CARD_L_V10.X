<?php

namespace App\Http\Controllers;
use App\Jobs\QuotationEmail;
use App\Quotation;
use Mail;
use App\Mail\quotationMail;

use Illuminate\Http\Request;

class QuotationQueueEmails extends Controller
{
    public function sendQuotationEmails()
    {
        $id = 13;
        $quote = Quotation::with('quotationHasItems', 'user', 'client')->findOrFail($id);
        // return $quote;
        // $email = new quotationMail($quote);
        // Mail::to('hasindu@helium.lk')
        // ->subject("Quotation - Senavi")
        // ->send(new quotationMail($quote));
        return view('mail.quotation', compact('quote'));
       // $emailJobs = new QuotationEmail($quote);
        //dispatch($emailJobs);
    }
}
