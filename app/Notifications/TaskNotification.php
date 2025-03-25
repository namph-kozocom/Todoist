<?php

namespace App\Notifications;

use App\Enums\TaskNotif;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $actionType;

    /**
     * Create a new notification instance.
     */
    public function __construct($task, TaskNotif $actionType = TaskNotif::ASSIGNED)
    {
        $this->task = $task;
        $this->actionType = $actionType;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->actionType === TaskNotif::ASSIGNED
            ? "You have been assigned a new task: {$this->task->title}"
            : "Task updated: {$this->task->title}";

        $message = $this->actionType === TaskNotif::ASSIGNED
            ? "A new task has been assigned to you. Please check the details below:"
            : "The task you are assigned to has been updated. Please review the changes:";

        return (new MailMessage)
            ->subject($subject)
            ->greeting("Hello {$notifiable->name},")
            ->line($message)
            ->line("**Title:** {$this->task->title}")
            ->line("**Description:** " . ($this->task->description ?? 'No description provided.'))
            ->line("**Due Date:** " . ($this->task->due_date ?? 'No due date set.'))
            ->action('View Task', url("/tasks/{$this->task->id}"))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'description' => $this->task->description,
            'due_date' => $this->task->due_date,
            'actionType' => $this->actionType,
        ];
    }
}
