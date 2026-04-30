<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
        'image',
        'rating'
    ];

    // Review belongs to a Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Review belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}