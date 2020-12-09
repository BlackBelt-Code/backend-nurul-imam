<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Parents;
use App\Models\Nisn;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudentController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('jwt.verify');
    // }
    
    public function index()
    {
        $studentIndex = Student::with('user');
        if($studentIndex->count() > 0) {
            $render = response()->json(['student' => $studentIndex], 200);
        } else {
            $render = response()->json(['student' => $studentIndex], 401);
        }

        return $render;
    }

    public function store(Request $request)
    {
        // $user = JWTAuth::parseToken()->authenticate();
        // $userId = $user->id;

        $first_name       = $request->input('first_name');
        $last_name        = $request->input('last_name');
        $school_origin    = $request->input('school_origin');
        $place            = $request->input('place');
        // $user_id          = $userId;


        $studentStore = new Student();
        
        $studentStore->first_name       = $first_name;
        $studentStore->last_name        = $last_name;
        $studentStore->school_origin    = $school_origin;
        $studentStore->place            = $place ;
        // $studentStore->user_id          = $user_id ;

        if($studentStore->save())
        {
            $render = response()->json(['student' => $studentStore], 200);
        } else {
            $render = response()->json(['student' => 'Failed Entry'], 200);
        }

        return $render;
    }

    public function StudentStore(Request $request) {

        $first_name         = $request->input('first_name');
        $last_name          = $request->input('last_name');
        $school_origin      = $request->input('school_origin');
        $place              = $request->input('place');

        $father_name        = $request->input('father_name');
        $mother_name        = $request->input('mother_name');
        $jobs               = $request->input('jobs');
        $contact            = $request->input('contact');

        $nisn               = $request->input('nisn');

        $studentStore = new Student();
        $studentStore->first_name       = $first_name;
        $studentStore->last_name        = $last_name;
        $studentStore->school_origin    = $school_origin;
        $studentStore->place            = $place ;
        $studentStore->user_id          = 1 ;
        $studentStore->save();

        $parentStore = new Parents();
        $parentStore->student_id = $studentStore->id;
        $parentStore->father_name = $father_name;
        $parentStore->mother_name = $mother_name;
        $parentStore->jobs = $jobs; 
        $parentStore->contact = $contact;
        $parentStore->save();

        $nisnStore = new Nisn();
        $nisnStore->student_id = $studentStore->id;
        $nisnStore->nisn        = $nisn;
        $nisnStore->save();


       return response()->json([
            'student' => $studentStore, 
            'parents' => $parentStore, 
            'nisn' => $nisnStore], 
        200);

    }
}
