<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Parents extends Model
{
    use HasFactory;

    protected $table = 'parents';

    
    protected $guarded = ['student_id'];

    public function student() {
        return $this->belongsTo(Student::class, 'id');
    }
}
