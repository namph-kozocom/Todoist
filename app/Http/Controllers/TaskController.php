<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Danh sách công việc
    public function index()
    {
        // $tasks = Task::all();
        return view('tasks.index');
    }

    // Hiển thị form tạo công việc
    public function create()
    {
        return view('tasks.create');
    }

    
}
