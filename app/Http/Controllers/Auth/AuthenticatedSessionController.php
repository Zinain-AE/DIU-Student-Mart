<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. User Authenticate kora
        $request->authenticate();

        $user = Auth::user();

        // 2. Account Active status check kora (Jodi Admin block kore thake)
        if (isset($user->is_active) && !$user->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => 'Your account is blocked. Please contact support.']);
        }

        // 3. Session regenerate kora (Security-r jonno)
        $request->session()->regenerate();

        // 4. Role based Redirect Logic (admin, seller, user)
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }

        // Default role 'user' hole products marketplace-e pathabe
        return redirect()->route('products.index');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // after log out , go to home page
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}

