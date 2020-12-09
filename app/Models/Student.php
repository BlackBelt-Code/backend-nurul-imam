<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Parents;
use App\Models\Nisn;

class Student extends Model
{
    use HasFactory;
    
    protected $table = 'students';

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function nisn()
    {
        return $this->hasMany(Nisn::class);
    }

    public function parent()
    {
        return $this->hasMany(Parents::class);
    }

}
