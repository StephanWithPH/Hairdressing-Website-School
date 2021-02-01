<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    /**
     * Submit the contact form.
     *
     * @param Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(Request $request)
    {
        /* Create new mail with mailable class new ContactFormSubmit */
        Mail::to(env('MAIL_CONTACTFORM_TO'))->send(new ContactFormSubmit($request->name, $request->email, $request->comment));
        /* Return flash success message */
        flash(__('Bedankt voor invullen van het contactformulier. We nemen zo spoedig mogelijk contact met u op.'))->success();
        /* Redirect back to original page */
        return redirect()->back();
    }
}
