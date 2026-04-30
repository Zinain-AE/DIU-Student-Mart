<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * User Seller-e upgrade 
     */
    public function becomeSeller()
    {
        // 1.  logged-in user
        $user = Auth::user();

        
        if ($user->role !== 'seller') {
            $user->role = 'seller';
            $user->save();
            
            // Success message 
            return redirect()->route('seller.dashboard')->with('success', 'Congratulations! You are now a verified Seller.');
        }

        
        return redirect()->route('seller.dashboard');
    }
}