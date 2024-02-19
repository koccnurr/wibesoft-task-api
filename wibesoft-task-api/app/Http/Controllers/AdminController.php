<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return response()->json($admins, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email|unique:admins',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
        ]);

        return response()->json($admin, 201);
    }

    public function show($id)
    {
        $admin = Admin::findOrFail($id);
        return response()->json($admin, 200);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $id,
        ]);

        $admin->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
        ]);

        return response()->json($admin, 200);
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return response()->json(null, 204);
    }
}
