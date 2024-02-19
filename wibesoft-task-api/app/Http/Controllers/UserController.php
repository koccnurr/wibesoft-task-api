<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = Users::all();
        return response()->json($users, 200);
    }

    public function show($id)
    {
        $user = Users::find($id);

        if (!$user) {
            return response()->json(['message' => 'Kullanıcı bulunamadı'], 404);
        }

        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = Users::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $user = Users::find($id);

        if (!$user) {
            return response()->json(['message' => 'Kullanıcı bulunamadı'], 404);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Parola güncellenecekse ekle
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = Users::find($id);

        if (!$user) {
            return response()->json(['message' => 'Kullanıcı bulunamadı'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Kullanıcı silindi'], 200);
    }
}
