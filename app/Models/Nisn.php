<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Nisn extends Model
{
    use HasFactory;

    protected $table = 'nisn';
    protected $guarded = ['student_id'];

    public function scopeForNisn($query)
    {
        return $query->select('*')->get();
    }

    
    public function student() {
        return $this->belongsTo(Student::class, 'id');
    }
}
