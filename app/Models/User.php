<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Nisn;
use App\Models\Student;
use App\Models\Parents;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    public function scopeForUser($query) {

        return $query->select(['*'])
        ->leftJoin('nisn', 'nisn.user_id', '=', 'users.id')
        ->leftJoin('parents', 'parents.user_id', '=', 'users.id')
        ->leftJoin('students', 'students.user_id', '=', 'users.id')
        ->get();

    }

    public function scopeForUserId($query, $q) {

        return $query->select(['*'])
        ->leftJoin('nisn', 'nisn.user_id', '=', 'users.id')
        ->leftJoin('parents', 'parents.user_id', '=', 'users.id')
        ->leftJoin('students', 'students.user_id', '=', 'users.id')
        ->where('users.id', $q)
        ->get();

    }

    public function nisn()
    {
        return $this->hasOne(Nisn::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function parent()
    {
        return $this->hasOne(Parents::class);
    }
} 
