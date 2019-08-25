<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   public function index()
   {
      $users = User::all();
      return view('users.index', compact('users'));
   }

   public function getUsers()
   {
      return datatables()
         ->eloquent(User::query())
         ->addColumn('edit_url', function ($row) {
            return $row->id;
         })
         ->addColumn('delete_url', function ($row) {
            return route('users.destroy', $row->id);
         })
         ->toJson();
   }

   public function edit(User $user)
   {
      if (request()->ajax()) {
         return response()->json(['data' => $user]);
      }
   }

   public function store(Request $request)
   {

      $validator = Validator::make($request->all(), [
         'name'                  => ['required'],
         'last_name'             => ['required'],
         'identification_card'   => ['required', 'numeric', 'unique:users,identification_card'],
         'phone_number'          => ['required', 'numeric'],
         'email'                 => ['required', 'email', 'unique:users,email'],
         'password'              => ['nullable']
      ]);

      if ($validator->fails()) {
         return response()->json(['errors' => $validator->errors()->all()]);
      }

      User::create([
         'name'                  => $request->name,
         'last_name'             => $request->last_name,
         'identification_card'   => $request->identification_card,
         'phone_number'          => $request->phone_number,
         'email'                 => $request->email,
         'password'              => $request->password ?? bcrypt('password'),
      ]);

      return response()->json([
         'success' => 'Usuario creado correctamente'
      ]);
   }

   public function update(Request $request, User $user)
   {

      $validator = Validator::make($request->all(), [
         'name'                  => ['required'],
         'last_name'             => ['required'],
         'identification_card'   => ['required', 'numeric', Rule::unique('users')->ignore($user)],
         'phone_number'          => ['required', 'numeric'],
         'email'                 => ['required', 'email', Rule::unique('users')->ignore($user)],
         'password'              => ['nullable']
      ]);

      if ($validator->fails()) {
         return response()->json(['errors' => $validator->errors()->all()]);
      }

      $user->update([
         'name'                  => $request->name,
         'last_name'             => $request->last_name,
         'identification_card'   => $request->identification_card,
         'phone_number'          => $request->phone_number,
         'email'                 => $request->email,
      ]);

      return response()->json([
         'success' => 'Usuario editado correctamente'
      ]);
   }

   public function destroy(User $user)
   {
      $user->delete();

      return [
         'message' => 'El usuario ha sido eliminado correctamente',
         'icon' => 'success',
         'listId' => '#userList'
      ];
   }

   public function emailExist($email)
   {

      $query = User::where('email', $email)->first();

      if ($query != null) {
         return response()->json(['errors' => 'El email ingresado ya existe, ingrese uno nuevo']);
      }
   }
}
