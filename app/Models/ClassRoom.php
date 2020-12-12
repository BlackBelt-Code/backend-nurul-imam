<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClassStudent;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'class';

    protected $guarded = ['id'];

    public function classStudent() {
        return $this->hasOne(ClassStudent::class, 'class_id');
    }
}
