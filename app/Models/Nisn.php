<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Nisn extends Model
{
    use HasFactory;

    protected $table = 'nisn';
    protected $guarded = [];

    public function scopeForNisn($query)
    {
        return $query->select('*')->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
