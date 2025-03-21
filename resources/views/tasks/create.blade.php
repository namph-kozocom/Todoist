@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Create New Task</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-8 w-full">
        <form action="#" method="POST" class="space-y-6">
            @csrf

            <!-- Tiêu đề Task -->
            <div>
                <label class="block text-lg font-medium mb-1">Title</label>
                <input type="text" name="title" class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400">
            </div>

            <!-- Mô tả Task -->
            <div>
                <label class="block text-lg font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400"></textarea>
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
            <div>
                <label class="block text-lg font-medium mb-1">Assign To</label>
                <select name="assignee" class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-400">
                    <option value="">Unassigned</option>
                    <option value="1">John Doe</option>
                    <option value="2">Jane Smith</option>
                    <option value="3">Alice Johnson</option>
                </select>
            </div>

            <!-- Nút Submit -->
            <button type="submit"
                class="w-full bg-blue-600 text-white p-3 rounded-lg font-medium text-lg hover:bg-blue-700 transition">
                Create Task
            </button>
        </form>
    </div>
@endsection