<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClassStudent;

class ClassType extends Model
{
    use HasFactory;

    protected $table = 'type_class';

    protected $guarded = ['id'];

    public function classStudent() {
        return $this->hasMany(ClassStudent::class, 'class_type_id');
    }
}
