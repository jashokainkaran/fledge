@extends('layouts.app')

@section('title', 'Log In – Fledge')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white w-full max-w-md p-8 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-purple-900 mb-6 text-center">Student Login</h1>

    @if(session('error'))
      <div class="mb-4 text-red-600">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input
          type="email"
          name="email"
          id="email"
          value="{{ old('email') }}"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
          required
        >
        @error('email')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input
          type="password"
          name="password"
          id="password"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
          required
        >
        @error('password')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <button
        type="submit"
        class="w-full bg-purple-900 text-white py-3 rounded-lg hover:bg-purple-800 transition"
      >
        Sign In
      </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
      Don’t have an account?
      <a href="{{ route('register') }}" class="text-purple-900 hover:underline">Register</a>
    </p>
  </div>
</div>
@endsection