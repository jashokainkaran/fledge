@extends('layouts.employerdashboard')

@section('content')
  <div class="text-center py-20">
    <h1 class="text-3xl font-bold">
      Hello, {{ Auth::guard('employer')->user()->company_name }}
    </h1>
    <p class="mt-4 text-gray-600">
      Your account is still <strong>pending verification</strong>. 
      Once an admin approves you, you’ll be able to post jobs.
    </p>
    <form method="POST" action="{{ route('logout') }}" class="mt-6">
      @csrf
      <button type="submit"
              class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
        Logout
      </button>
    </form>
  </div>
@endsection
