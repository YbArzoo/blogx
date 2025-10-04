<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $q = request('q');

        $users = User::when($q, fn($x) => $x->where(fn($w) => $w
                ->where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
        ))
        ->latest()
        ->paginate(12);

        return view('admin.users.index', compact('users', 'q'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:100'],
            'email'    => ['required','email','max:150','unique:users,email'],
            'password' => ['required','string','min:8','max:100'],
            'is_admin' => ['required','boolean'],
            'status'   => ['required','in:0,1'],
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => (bool) $data['is_admin'],
            'status'   => (int) $data['status'],
        ]);

        return back()->with('ok', 'User created.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:100'],
            'email'    => ['required','email','max:150', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','string','min:8','max:100'],
            'is_admin' => ['required','boolean'],
            'status'   => ['required','in:0,1'],
        ]);

        $user->name     = $data['name'];
        $user->email    = $data['email'];
        $user->is_admin = (bool) $data['is_admin'];
        $user->status   = (int) $data['status'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('ok', 'User updated.');
    }

    public function destroy(User $user)
    {
        // Don’t allow deleting yourself
        if (Auth::id() === $user->id) {
            abort(403);
        }
    
        $user->delete();
    
        return back()->with('ok', 'User deleted.');
    }
    
}
