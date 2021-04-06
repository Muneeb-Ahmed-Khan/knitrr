<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    /*
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
    */

    /**
     * @param  Illuminate\Http\Request  $request
     * 
     * Modified function to work with api.
     */
    public function __invoke(Request $request)
    {
        $user = User::find($request->route('id'));

        if (! hash_equals((string) $request->route('id'),
                          (string) $user->getKey())) {
            return redirect(route('web-email-failed'));
        }

        if (! hash_equals((string) $request->route('hash'),
                          sha1($user->getEmailForVerification()))) {
            return redirect(route('web-email-failed'));
        }

        if ($user->hasVerifiedEmail()) {
            return redirect(route('web-email-sucess'));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect(route('web-email-sucess'));
    }
}
