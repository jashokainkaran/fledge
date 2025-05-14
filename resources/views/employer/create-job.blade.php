{{-- resources/views/employer/create-job.blade.php --}}
@extends('layouts.employerdashboard')

@section('content')
  <div class="max-w-4xl mx-auto py-12">
    <h1 class="text-2xl font-bold mb-6">Post a New Job</h1>
    @if(session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('employer.job.store') }}" method="POST" class="space-y-4 bg-white p-8 rounded-xl shadow-lg">
      @csrf

      <div>
        <label class="block text-sm font-medium">Title</label>
        <input type="text" name="title" class="w-full p-2 border rounded-lg" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Category</label>
        <input type="text" name="category" class="w-full p-2 border rounded-lg" required>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium">Job Type</label>
          <select name="job_type" class="w-full p-2 border rounded-lg" required>
            <option value="in-office">In Office</option>
            <option value="remote">Remote</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Working Hours</label>
          <select name="working_hours" class="w-full p-2 border rounded-lg" required>
            <option value="morning">Morning</option>
            <option value="evening">Evening</option>
            <option value="night">Night</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium">Location</label>
        <input type="text" name="location" class="w-full p-2 border rounded-lg" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Pay Rate</label>
        <input type="text" name="pay_rate" class="w-full p-2 border rounded-lg" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Description</label>
        <textarea name="description" rows="4" class="w-full p-2 border rounded-lg"></textarea>
      </div>

      <button type="submit"
              class="bg-purple-900 text-white px-6 py-2 rounded-lg hover:bg-purple-800 transition">
        Post Job
      </button>
    </form>
  </div>
@endsection
