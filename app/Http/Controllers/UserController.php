<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        $roles = Role::get();
        return view('dashboard.user.index', ['users' => $users, 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.user.index')
                ->withErrors($validator)
                ->withInput()
                ->with('form_type', 'store');
        }

        $validated = $validator->validated();

        User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => '112233',
            'role_id' => $validated['role_id']
        ]);

        return redirect()->route('dashboard.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.user.index')
                ->withErrors($validator)
                ->withInput()
                ->with('form_type', 'update');
        }

        $validated = $validator->validated();

        $user = User::find($id);

        $user->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id']
        ]);

        return redirect()->route('dashboard.user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        if (Auth::id() == $id) {
            return redirect()->route('dashboard.user.index')
                ->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri']);
        }

        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('dashboard.user.index')->with('success', 'User berhasil dihapus');
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('profile.show', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$user->id",
            'password' => 'nullable|min:8',
            'password_confirmation' => 'same:password'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('profile.show')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];

        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui');
    }
}
