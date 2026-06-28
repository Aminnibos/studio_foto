<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if a user with this google_id already exists
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // If the user exists, log them in
                Auth::login($user);
                return redirect()->intended('/dashboard-studio');
            } else {
                // Check if a user with this email already exists
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    // Update the existing user with the google_id
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                    ]);
                    Auth::login($existingUser);
                    return redirect()->intended('/dashboard-studio');
                } else {
                    // Create a new user
                    $newUser = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        // No password for Google users by default, or set a dummy one if needed
                        'password' => bcrypt(uniqid()), 
                        'role' => 'user',
                        // no_hp is nullable in our new migration
                    ]);

                    Auth::login($newUser);
                    return redirect()->intended('/dashboard-studio');
                }
            }
        } catch (Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Terjadi kesalahan saat login menggunakan Google. ' . $e->getMessage()]);
        }
    }
}
