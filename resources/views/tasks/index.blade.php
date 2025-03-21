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
                @foreach([1, 2, 3, 4, 5] as $i)
                        <tbody x-data="{ open: false }">
                            <!-- Row chính -->
                            <tr class="border-b">
                                <td class="p-3 text-center font-semibold">
                                    Task {{$i}}
                                </td>
                                <td class="p-3 text-center">
                                    @php
                                        $status = ['Pending', 'In Progress', 'Completed'];
                                        $statusColor = ['bg-yellow-100 text-yellow-700', 'bg-blue-100 text-blue-700', 'bg-green-100 text-green-700'];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor[$i % 3] }}">
                                        {{ $status[$i % 3] }}
                                    </span>
                                </td>
                                <td class="p-3 text-center">Unassigned</td>
                                <td class="p-3 text-center">12/12/2002</td>
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
                                        <p><strong>Description:</strong> Lorem ipsum dolor sit amet.</p>
                                        <p><strong>Created At:</strong> 10/10/2023</p>
                                        <p><strong>Created By:</strong> NamPham</p>

                                        <div class="flex items-center space-x-4">
                                            <label><strong>Status:</strong></label>
                                            <select class="border p-1 rounded">
                                                <option>Pending</option>
                                                <option>In Progress</option>
                                                <option>Completed</option>
                                            </select>
                                        </div>

                                        <div class="flex space-x-3 mt-3">
                                            <a href="#" class="text-green-500 hover:underline">Edit</a>
                                            <form action="#" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
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