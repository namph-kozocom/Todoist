<?php

namespace App\Observers;

use App\Enums\TaskNotif;
use App\Models\Assign;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Auth;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task)
    {
        $creatorId = $task->created_by;
        if (request()->has('assignees') && is_array(value: request()->input('assignees'))) {
            $assignData = [];
            foreach (request()->input('assignees') as $assignerId) {
                $assignData[] = [
                    'assigner_id' => $assignerId,
                    'task_id'     => $task->id
                ];
            }
            Assign::insert($assignData);

            $assignees = User::whereIn('id', request()->input('assignees'))
                ->where('id', '!=', $creatorId)
                ->get();

            foreach ($assignees as $user) {
                $user->notify(new TaskNotification($task, TaskNotif::ASSIGNED));
            }
        }
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task)
    {
        $updatedBy = Auth::id();
        $assignees = Assign::where('task_id', $task->id)
            ->where('assigner_id', '!=', $updatedBy)
            ->pluck('assigner_id');

        foreach ($assignees as $assignerId) {
            $user = User::find($assignerId);
            if ($user) {
                $user->notify(new TaskNotification($task, TaskNotif::CHANGE));
            }
        }
    }
}
