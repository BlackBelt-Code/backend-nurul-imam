<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\ClassType;

class ClassStudent extends Model
{
    use HasFactory;

    protected $table = 'class_student';

    protected $guarded = ['student_id', 'class_id', 'type_class_id'];

    public function student() {
        return $this->belongsTo(Student::class, 'id');
    }

    public function classId() {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
    
    public function TypeClassId() {
        return $this->belongsTo(ClassType::class, 'type_class_id');
    }
}
