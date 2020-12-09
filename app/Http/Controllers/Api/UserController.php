<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{    
    public function login(Request $request)
    {
        $creadentials = $request->only('name', 'password');

        if(!$token = JWTAuth::attempt($creadentials)) {
            return response()->json(['error' => 'invalid credentials'], 400);
        }

        // try {

        // } catch (\Throwable $th) {
        //     return response()->json(['error' => 'could_not_create_token'], 500);
        // }
        
        if(!empty(Auth()->user()->id)) {
            $user_id = Auth()->user()->id;
            $users = User::find($user_id);
            $users->remember_token = $token;
            $users->save();
        }
        return response()->json(compact('token', 'users'));
    }

    public function register(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'username'  => 'required|string|max:60',
            'email'     => 'required|string|email|max:225|unique:users',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        if($valid->fails()) {
            return response()->json(['errors' => $valid->errors()->toJson(), 400]);
        }

        $user = User::create([
            'name'  => $request->get('username'),
            'email'     => $request->get('email'),
            'password'  => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticated() {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
        return response()->json(compact('user'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        try {
            $users = User::ForUser();
            return response()->json(['users' => $users], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $users = User::ForUserId($id);
            return response()->json(['users' => $users], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
