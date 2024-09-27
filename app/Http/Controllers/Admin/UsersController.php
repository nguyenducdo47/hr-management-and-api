<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request)
{

    $users = User::when($request->search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->when($request->created_at, function ($query, $date) {
            return $query->whereDate('created_at', $date);
        })
        ->paginate(1);

    // Trả về view với dữ liệu đã phân trang
    return view('admin.users.index', compact('users'));
}



    public function create()
    {
        $roles = Role::whereIn('id', [1,2,3])->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
{
    // Validate form inputs
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'role_id' => 'required|integer'
    ]);

    // dd($validatedData);

    // Tạo người dùng mới với mật khẩu được mã hoá
    try{
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
            'password' => Hash::make('12345678'), // Hash password
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');

    }catch(\Exception $e){
        return redirect()->back()->with('error', 'Failed to add user!');
    }

}

    public function edit(User $user)
    {
        $roles = Role::whereIn('id', [1,2,3])->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|integer|in:1,2,3',
        ]);

        try{
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role_id = $request->input('role_id');

            // Kiểm tra nếu có mật khẩu mới
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to updated user!');
        }


    }

    public function destroy(User $user)
    {
        try{
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to delete user!');
        }

    }
}
