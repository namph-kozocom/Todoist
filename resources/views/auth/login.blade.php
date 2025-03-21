@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h2 class="text-2xl font-bold mb-5">Login</h2>

    <form action="#" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
    </form>

    <p class="mt-4 text-center">
        Don't have an account? <a href="{{ route('auth.registerPage') }}" class="text-blue-500">Register</a>
    </p>
@endsection