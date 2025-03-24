<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskRequest;
use App\Models\Assign;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Danh sách công việc
    public function index($page = 1, $limit = 10)
    {
        try {
            $tasks = Task::with(['creator:id,username', 'assigns'])
                ->with('assigns.assigner:id,username')
                ->orderBy('status')
                ->orderBy('created_at', 'desc')
                ->paginate(perPage: $limit, page: $page);

            return view('tasks.index', compact('tasks'));
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function create()
    {
        try {
            $users = User::orderBy('username')->get(['id', 'username']);
            $task = null;

            return view('tasks.form', compact('users', 'task'));
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $users = User::orderBy('username')->get(['id', 'username']);
            $task = Task::with(['creator:id,username', 'assigns.assigner:id,username'])->find($id);

            return view('tasks.form', compact('users', 'task'));
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function store(TaskRequest $request)
    {
        try {
            $validated = $request->validated();
            $task = Task::create([
                'title'       => $validated['title'],
                'description' => $validated['description'] ?? null,
                'due_date'    => $validated['due_date'] ?? null,
                'status'      => $validated['status'],
                'created_by'  => Auth::id(),
            ]);

            if (!empty($validated['assignees'])) {
                $assignData = [];
                foreach ($validated['assignees'] as $assignerId) {
                    $assignData[] = [
                        'assigner_id' => $assignerId,
                        'task_id'     => $task->id
                    ];
                }

                Assign::insert($assignData);
            }

            return redirect()->route('tasks.index')->withSuccess('Create task successfully');
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function update(TaskRequest $request, Task $task)
    {
        try {
            $validated = $request->validated();
            $task->update([
                'title'       => $validated['title'],
                'description' => $validated['description'] ?? null,
                'due_date'    => $validated['due_date'] ?? null,
                'status'      => $validated['status'],
            ]);

            $newAssignees = $validated['assignees'] ?? [];
            $currentAssignees = $task->assigns()->pluck('assigner_id')->toArray();
            Assign::where('task_id', $task->id)
                ->whereNotIn('assigner_id', $newAssignees)
                ->delete();

            $newAssignData = [];
            foreach ($newAssignees as $assignerId) {
                if (!in_array($assignerId, $currentAssignees)) {
                    $newAssignData[] = [
                        'assigner_id' => $assignerId,
                        'task_id'     => $task->id,
                    ];
                }
            }

            if (!empty($newAssignData)) {
                Assign::insert($newAssignData);
            }

            return redirect()->route('tasks.index')->withSuccess('Update task successfully');
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $task = Task::find($id);

            if (empty($task)) {
                return redirect()->route('tasks.index')->withError('Task not found');
            }

            $task->delete();
            return redirect()->route('tasks.index')->withSuccess('Delete task successfully');
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }
}
