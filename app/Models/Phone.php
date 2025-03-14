<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Phone extends Model
{
    use HasFactory;

        protected $fillable = ['number', 'user_id'];

    // Define the one-to-one inverse relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}