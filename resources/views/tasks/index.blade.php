@extends('layouts.app')

@section('title', 'Task List')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Your Tasks</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3 text-center">Title</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Assigned To</th>
                    <th class="p-3 text-center">Due Date</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                                                        <tbody x-data="{ open: false }">
                                                            <!-- Row chính -->
                                                            <tr class="border-b">
                                                                <td class="p-3 text-center font-semibold">
                                                                    {{$task->title}}
                                                                </td>
                                                                <td class="p-3 text-center">
                                                                    @php
                    $statusColorMap = [
                        'Pending' => 'bg-yellow-100 text-yellow-700',
                        'In Progress' => 'bg-blue-100 text-blue-700',
                        'Completed' => 'bg-green-100 text-green-700',
                        'Unknown' => 'bg-gray-100 text-gray-700',
                    ];
                    $statusColor = $statusColorMap[$task->status ?? 'Unknown'] ?? 'bg-gray-100 text-gray-700';
                                                                    @endphp
                                                                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                                                        {{ $task->status ?? 'Unknown' }}
                                                                    </span>
                                                                </td>
                                                                <td class="p-3 text-center">
                                                                    {{ $task->assigns->implode('assigner.username', ', ')}}
                                                                </td>
                                                                <td class="p-3 text-center">{{ $task->due_date?->format('d/m/Y') }}</td>
                                                                <td class="p-3 text-center">
                                                                    <button @click="open = !open" class="text-blue-500 hover:underline">
                                                                        Details <span x-text="open ? '▼' : '▶'"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                            <!-- Row mở rộng -->
                                                            <tr x-show="open" x-transition class="bg-gray-50">
                                                                <td colspan="5" class="p-4">
                                                                    <div class="space-y-2">
                                                                        <p><strong>Description:</strong></p>
                                                                        {{ $task->description }}
                                                                        <p><strong>Created At:</strong> {{ $task->created_at->format('d/m/Y') }}</p>
                                                                        <p><strong>Created By:</strong> {{ $task->creator->username}}</p>

                                                                        <div class="flex items-center space-x-4">
                                                                            <label><strong>Status:</strong></label>
                                                                            <select class="border p-1 rounded">
                                                                                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending
                                                                                </option>
                                                                                <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In
                                                                                    Progress
                                                                                </option>
                                                                                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed
                                                                                </option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="flex space-x-3 mt-3">
                                                                            <a href="{{ route('tasks.edit', $task->id) }}" class="text-green-500 hover:underline">Edit</a>
                                                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this task?')"
                                                                                    class="text-red-500 hover:underline">Delete</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection