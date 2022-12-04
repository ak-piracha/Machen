<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return ['message', 'Already Verified...'];
        }

        $request->user()->sendEmailVerificationNotification();

        return ['message', 'Link has been sent to the Email...'];
    }

    public  function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return ['message', 'Already Verified...'];
        }

        if ($request->user()->markEmailAsVerified()) {

            event(new Verified($request->user()));
        }

        return ['message', 'Email has been Verified...'];
    }
}
