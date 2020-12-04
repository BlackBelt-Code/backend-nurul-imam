<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parents;
use Tymon\JWTAuth\Facades\JWTAuth;

class ParentController extends Controller
{
    public function index()
    {
        $parentIndex = Parents::with('user')->get();
        try {
            if($parentIndex->count() > 0)
            {
                return response()->json(['parents' => $parentIndex], 200);
            } else {
                return response()->json(['parents' => 'Data Empty'], 200);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['errors' => $th], 401);
        }
    }

    public function store(Request $request) 
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $fatherName = $request->input('father_name');
        $motherName = $request->input('mother_name');
        $jobs = $request->input('jobs');
        $contact = $request->input('contact');

        $parentStore = new Parents();

        $parentStore->user_id = $userId;
        $parentStore->father_name = $fatherName;
        $parentStore->mother_name = $motherName;
        $parentStore->jobs = $jobs; 
        $parentStore->contact = $contact;

        if($parentStore->save()) {
            $render = response()->json(['parents' => $parentStore, 'success' => true], 200);
        } else {
            $render = response()->json(['parents' => 'Data failed', 'failed' => true], 4001);
        }

        return $render;
    }
}
