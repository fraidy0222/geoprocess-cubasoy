<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response()->json(['user' => UserResource::collection( User::all()), 'roles' => Role::pluck('name')->all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $role = Role::where('name', $request->role)->first();
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
      ]);
      $user->role()->associate($role);

      $user->save();

      return response()->json(['user' => new UserResource($user)], 200);
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
      $role = Role::where('name', $request->role)->first();
      $user = User::find($id);
      $user->role()->dissociate($role);
      $user->role()->associate($role);
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->save();
    
      return response()->json(['user' => new UserResource($user)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return response()->json(['user' => $user], 200);
    }
    public function login (Request $request) 
    {
       $credentials =$request->only('email', 'password');

       if(Auth::attempt($credentials)) {
          $token = Str::random(80);
          Auth::user()->api_token = $token;
          Auth::user()->save();

          $isAdmin = Auth::user()->isAdmin();
          $editor = Auth::user()->editor();
          $invitado = Auth::user()->invitado();

         return response()->json([
           'token' => $token, 
           'isAdmin' => $isAdmin, 
           'editor' => $editor,
           'invitado' => $invitado,
          ], 200);
       }
      return response()->json(['status' => 'Correo y contraseña incorrectos'], 403);
    }

    public function verify (Request $request) {
      return $request->user()->only('name', 'email');
   }
}
