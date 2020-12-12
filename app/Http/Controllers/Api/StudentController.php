<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Parents;
use App\Models\Nisn;
use App\Models\ClassStudent;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\ClassType;

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
        try {
            
            $first_name         = $request->input('first_name');
            $last_name          = $request->input('last_name');
            $school_origin      = $request->input('school_origin');
            $place              = $request->input('place');

            $father_name        = $request->input('father_name');
            $mother_name        = $request->input('mother_name');
            $jobs               = $request->input('jobs');
            $contact            = $request->input('contact');

            $nisn               = $request->input('nisn');

            $class_student      = $request->input('class_student');
            $class_type         = $request->input('class_type');

            $user_id = JWTAuth::parseToken()->authenticate();

            $studentStore = new Student();
            $studentStore->first_name       = $first_name;
            $studentStore->last_name        = $last_name;
            $studentStore->school_origin    = $school_origin;
            $studentStore->place            = $place ;
            $studentStore->user_id          = $user_id['id'] ;
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

            $classStudentStore = new ClassStudent;
            $classStudentStore->student_id = $studentStore->id;
            $classStudentStore->class_id = $class_student;
            $classStudentStore->type_class_id = $class_type;
            $classStudentStore->save();


        return response()->json([
                'status' =>  'success', 
                'student' => $studentStore, 
                'parents' => $parentStore,
                'student_detail' => $classStudentStore, 
                'nisn' => $nisnStore], 
            200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' =>  'error', 
                'student' => 'empty', 
                'parents' => 'empty', 
                'student_detail' => 'empty', 
                'nisn' => 'empty'], 
            400);
        }

    }

    public function getStudentDetail($id)
    {
        $users = User::with('student', 'student.parent', 'student.nisn', 'student.classStudent', 'student.classStudent.classId', 'student.classStudent.TypeClassId')->where('id', $id)->get();
        
        // return response()->json( $users ,200);

        foreach($users as $item) {
            $id = $item->id;
            $username = $item->name;
            $email = $item->email;
            
            $first_name = $item->student->first_name;
            $last_name  = $item->student->last_name;
            $school_origin = $item->student->school_origin;
            $place          = $item->student->place;

            $parent    = $item->student->parent;

            foreach($parent as $parents) {
                $father_name = $parents->father_name;
                $mother_name = $parents->mother_name;
                $jobs        = $parents->jobs;
                $contact     = $parents->contact;
            }

        }

        $params = [
            'id' => $id,
            'username' => $username,
            'email'     => $email,

            'first_name'   => $first_name,
            'last_name'     => $last_name,
            'school_origin' => $school_origin,
            'address'       => $place,

            'father_name' => $father_name,
            'mother_name'   => $mother_name,
            'jobs'  => $jobs,
            'contact'   => $contact,
        ];

        return response()->json(['users' =>  $params] ,200);
    }
}
