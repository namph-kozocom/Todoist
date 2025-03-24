@extends('layouts.app')

@section('title', $task ? 'Edit Task' : 'Create Task')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">{{ $task ? 'Edit Task' : 'Create New Task' }}</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-8 w-full">
        <form action="{{ $task ? route('tasks.update', $task->id) : route('tasks.store') }}" method="POST" class="space-y-6">
            @csrf
            @if ($task)
                @method('PUT')
            @endif

            <!-- Task Title -->
            <div>
                <label class="block text-lg font-medium mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}"
                    class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400">
            </div>

            <!-- Task description -->
            <div>
                <label class="block text-lg font-medium mb-1">Description</label>
                <input id="description" type="hidden" name="description" value="{{ old('description', $task->description ?? '') }}">
                <trix-editor input="description"
                    class="w-full h-[200px] border p-3 rounded-lg focus:ring focus:ring-blue-400"></trix-editor>
            </div>

            <!-- Due Date & Status -->
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block text-lg font-medium mb-1">Due Date</label>
                    <input type="date" name="due_date" value="{{ old('due_date', $task?->due_date?->format('Y-m-d') ?? '') }}"
                        class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400">
                </div>

                <div class="w-1/2">
                    <label class="block text-lg font-medium mb-1">Status</label>
                    <select name="status" class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400">
                        @foreach (['Pending', 'In Progress', 'Completed'] as $status)
                            <option value="{{ $status }}" {{ old('status', $task->status ?? '') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Assign Task -->
            <div x-data="taskAssignees()" class="relative">
                <label class="block text-lg font-medium mb-1">Assign To</label>
                <input type="text" x-model="search" @input="filterUsers" placeholder="Search for users..."
                    class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400">

                <div x-show="filteredUsers.length > 0" class="absolute w-full bg-white border rounded-lg mt-1 shadow-md z-10">
                    <ul>
                        <template x-for="user in filteredUsers" :key="user . id">
                            <li @click="toggleUser(user)" class="p-3 hover:bg-blue-100 cursor-pointer">
                                <span x-text="user.username"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <div class="flex flex-wrap gap-2 mt-2">
                    <template x-for="user in selectedUsers" :key="user . id">
                        <div class="flex items-center bg-blue-600 text-white px-3 py-1 rounded-lg">
                            <span x-text="user.username"></span>
                            <button @click="removeUser(user)" class="ml-2 text-white font-bold">&times;</button>
                        </div>
                    </template>
                </div>

                <template x-for="user in selectedUsers">
                    <input type="hidden" name="assignees[]" :value="user . id">
                </template>
            </div>

            @if ($errors->any())
                <div class="text-red-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>*{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Nút Submit -->
            <button type="submit"
                class="w-full bg-blue-600 text-white p-3 rounded-lg font-medium text-lg hover:bg-blue-700 transition">
                {{ $task ? 'Update Task' : 'Create Task' }}
            </button>
        </form>
    </div>

    {{-- Script --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    <script>
        function taskAssignees() {
            return {
                users: @json($users),
                search: "",
                filteredUsers: [],
                selectedUsers: @json(isset($task) ? $task->assigns->map(fn($a) => ['id' => $a->assigner->id, 'username' => $a->assigner->username]) : []),
                filterUsers() {
                    this.filteredUsers = this.users.filter(user =>
                        user.username.toLowerCase().includes(this.search.toLowerCase()) &&
                        !this.selectedUsers.some(u => u.id === user.id)
                    );
                },

                toggleUser(user) {
                    this.selectedUsers.push(user);
                    this.filteredUsers = [];
                    this.search = "";
                },

                removeUser(user) {
                    this.selectedUsers = this.selectedUsers.filter(u => u.id !== user.id);
                }
            };
        }
    </script>

@endsection