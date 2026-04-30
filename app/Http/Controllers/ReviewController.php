<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        // 1. Validation
        $request->validate([
            'comment' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        // 2. Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        // 3. Save Review
        Review::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'image' => $imagePath,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Your review has been posted!');
    }
}