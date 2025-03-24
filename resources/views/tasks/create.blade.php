@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Create New Task</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-8 w-full">
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Tiêu đề Task -->
            <div>
                <label class="block text-lg font-medium mb-1">Title</label>
                <input type="text" name="title" class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400">
            </div>

            <!-- Mô tả Task (Hỗ trợ dán hình ảnh) -->
            <div>
                <label class="block text-lg font-medium mb-1">Description</label>
                <input id="description" type="hidden" name="description">
                <trix-editor input="description"
                    class="w-full h-[200px] border p-3 rounded-lg focus:ring focus:ring-blue-400"></trix-editor>
            </div>

            <!-- Ngày Hạn -->
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block text-lg font-medium mb-1">Due Date</label>
                    <input type="date" name="due_date" class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400">
                </div>

                <!-- Chọn Trạng Thái -->
                <div class="w-1/2">
                    <label class="block text-lg font-medium mb-1">Status</label>
                    <select name="status" class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
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
                                <span x-text="user.name"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <div class="flex flex-wrap gap-2 mt-2">
                    <template x-for="user in selectedUsers" :key="user . id">
                        <div class="flex items-center bg-blue-600 text-white px-3 py-1 rounded-lg">
                            <span x-text="user.name"></span>
                            <button @click="removeUser(user)" class="ml-2 text-white font-bold">&times;</button>
                        </div>
                    </template>
                </div>

                <template x-for="user in selectedUsers">
                    <input type="hidden" name="assignees[]" :value="user . id">
                </template>
            </div>


            <!-- Nút Submit -->
            <button type="submit"
                class="w-full bg-blue-600 text-white p-3 rounded-lg font-medium text-lg hover:bg-blue-700 transition">
                Create Task
            </button>
        </form>
    </div>
    {{-- Script --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    <script>
        function taskAssignees() {
            return {
                users: [
                    { id: 1, name: "John Doe" },
                    { id: 2, name: "Jane Smith" },
                    { id: 3, name: "Alice Johnson" },
                    { id: 4, name: "Michael Brown" },
                    { id: 5, name: "Emma Davis" }
                ],
                search: "",
                filteredUsers: [],
                selectedUsers: [],

                filterUsers() {
                    this.filteredUsers = this.users.filter(user =>
                        user.name.toLowerCase().includes(this.search.toLowerCase()) &&
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