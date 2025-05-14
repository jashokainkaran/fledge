@extends('layouts.employerdashboard')

@section('content')
  <div class="text-center py-20">
    <h1 class="text-3xl font-bold">We're sorry, {{ Auth::guard('employer')->user()->company_name }}</h1>
    <p class="mt-4 text-gray-600">
      Your registration has been rejected. If you believe this is a mistake, please contact our support team at
      <a href="mailto:support@fledge.com" class="text-purple-700 underline">support@fledge.com</a>.
    </p>
    <div class="mt-8">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded">
          Logout
        </button>
      </form>
    </div>
  </div>
@endsection
