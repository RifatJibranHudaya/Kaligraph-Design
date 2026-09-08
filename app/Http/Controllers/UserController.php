<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('branch')
            ->where(function ($q) {
                $q->whereNull('user_type')->orWhere('user_type', 'admin');
            })
            ->where('level', '!=', 'customer')
            ->latest('id')
            ->paginate(15);
        $branches = Branch::all();
        return view('users.index', compact('users', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'  => 'required|string|max:50|unique:users,username',
            'email'     => 'nullable|email|max:100|unique:users,email',
            'phone'     => 'nullable|string|max:20',
            'password'  => 'required|string|min:6',
            'level'     => 'required|in:superadmin,owner,admin,kasir',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        ActivityLogService::log('create_user', 'users', "User '{$user->username}' ({$user->level}) dibuat", $user->id);

        return back()->with('success', "Pengguna '{$user->username}' berhasil ditambahkan.");
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username'  => 'required|string|max:50|unique:users,username,' . $user->id,
            'email'     => 'nullable|email|max:100|unique:users,email,' . $user->id,
            'phone'     => 'nullable|string|max:20',
            'password'  => 'nullable|string|min:6',
            'level'     => 'required|in:superadmin,owner,admin,kasir',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        ActivityLogService::log('update_user', 'users', "User '{$user->username}' diperbarui", $user->id);

        return back()->with('success', "Pengguna '{$user->username}' berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $username = $user->username;
        $id = $user->id;

        $user->delete();

        ActivityLogService::log('delete_user', 'users', "User '{$username}' dihapus", $id);

        return back()->with('success', "Pengguna '{$username}' berhasil dihapus.");
    }
}
