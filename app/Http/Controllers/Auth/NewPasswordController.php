<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the OTP verification view.
     */
    public function showOtpForm(Request $request): View
    {
        return view('auth.verify-otp', ['email' => $request->email]);
    }

    /**
     * Verify the OTP code.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $storedOtp = cache()->get('password_reset_otp_' . $request->email);

        if (!$storedOtp || $storedOtp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP code. 🐾']);
        }

        // OTP is valid, clear it and redirect to password reset
        cache()->forget('password_reset_otp_' . $request->email);
        
        // Generate a token for password reset
        $token = Str::random(60);
        
        // Store the token temporarily
        cache()->put('password_reset_token_' . $request->email, $token, now()->addMinutes(60));
        
        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email])
            ->with('status', 'OTP verified! Please set your new password. 🐱');
    }

    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Verify the token exists in cache (from OTP verification)
        $cachedToken = cache()->get('password_reset_token_' . $request->email);
        
        if ($cachedToken !== $request->token) {
            return back()->withErrors(['email' => 'Invalid or expired password reset token. 🐾']);
        }

        // Find the user and update password
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found. 🐾']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        // Clear the token from cache
        cache()->forget('password_reset_token_' . $request->email);

        return redirect()->route('login')->with('status', 'Password reset successfully! 🐱');
    }
}