<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nisn;
use Tymon\JWTAuth\Facades\JWTAuth;

class NisnController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }
    
    public function index()
    {
        $studentNisn = Nisn::with('user')->get();
        try {
            if($studentNisn->count() > 0) 
            {
                return response()->json(['student_nisn' => $studentNisn], 200);
            } else {
                return response()->json(['student_nisn' => 'Data Tidak ada'], 200);
            }
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => $th], 401);
        }
    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $nisnStudent = $request->input('nisn');

        $studentStore = new Nisn();
        $studentStore->user_id = $userId;
        $studentStore->nisn = $nisnStudent;

        if($studentStore->save()) 
        {
            $render =  response()->json(['student_nisn' => $studentStore], 200);
        } else {
            $render = response()->json(['student_nisn' => 'erros'], 401);
        }
    return $render;
    }
}
