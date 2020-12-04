<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Parents extends Model
{
    use HasFactory;

    protected $table = 'parents';

    public function user() {
        return $this->belongsTo(User::class);
    }
}
