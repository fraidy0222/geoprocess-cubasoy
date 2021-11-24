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
    return response()->json(['user' => UserResource::collection(User::all()), 'roles' => Role::pluck('name')->all()], 200);
  }

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

  public function destroy($id)
  {
    $user = User::find($id)->delete();

    return response()->json(['user' => $user], 200);
  }
  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      Auth::user()->api_token = Str::random(80);
      Auth::user()->save();

      $user = Auth::user();

      $user->load('role');

      return response()->json(compact('user'));
    }
    return response()->json(['status' => 'Correo y contraseña incorrectos'], 403);
  }

  public function verify(Request $request)
  {
    return $request->user()->only('name', 'email');
  }

  public function verifyEmail(Request $request)
  {
    $request->validate([
      'email' => 'required|unique:users'
    ]);

    return response()->json(['messages' => 'Correo Valido'], 200);
  }
}
