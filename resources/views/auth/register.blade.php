@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <h2 class="text-2xl font-bold mb-5">Register</h2>

    <form action="{{ route('auth.register') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block">Username</label>
            <input type="text" name="username" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Register</button>
    </form>

    <p class="mt-4 text-center">
        Already have an account? <a href="{{ route('auth.loginPage') }}" class="text-blue-500">Login</a>
    </p>
@endsection