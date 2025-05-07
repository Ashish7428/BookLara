<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class OtpVerificationController extends Controller
{
    //
    public function showForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp_code', $request->otp)
                    ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid OTP code.']);
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired.']);
        }

        // Set new password
        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('login')->with('status', 'Password reset successfully! You can now login.');
    }
}
