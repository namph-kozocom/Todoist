<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Danh sách công việc
    public function index($page = 1, $limit = 10)
    {
        $tasks = Task::with(['creator:id,username'])->paginate(perPage: $limit, page: $page);

        return view('tasks.index', compact('tasks'));
    }

    // Hiển thị form tạo công việc
    public function create()
    {
        return view('tasks.create');
    }

    
}
