<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Sử dụng when() để xử lý tìm kiếm theo tên
        $tasks = Task::with('user')
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->when($request->status !== null, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->created_at, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->paginate(1);

        // Trả về view với dữ liệu nhiệm vụ và từ khóa tìm kiếm
        return view('admin.tasks.index', compact('tasks'));
    }


    public function create()
    {
        $users = User::all();
        return view('admin.tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'status' => false,
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully!');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $users = User::all();
        return view('admin.tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'status' => $request->has('status') ? true : false,
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully!');
    }
}

