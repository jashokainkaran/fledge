@extends('layouts.employerdashboard')

@section('content')
  <div class="max-w-4xl mx-auto py-12">
    <h1 class="text-2xl font-bold mb-6">Edit Job</h1>

    @if(session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('employer.job.update', $job->id) }}" method="POST" class="space-y-4 bg-white p-8 rounded-xl shadow-lg">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-sm font-medium">Title</label>
        <input type="text" name="title" value="{{ $job->title }}" class="w-full p-2 border rounded-lg" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Category</label>
        <input type="text" name="category" value="{{ $job->category }}" class="w-full p-2 border rounded-lg" required>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium">Job Type</label>
          <select name="job_type" class="w-full p-2 border rounded-lg" required>
            <option value="in-office" {{ $job->job_type == 'in-office' ? 'selected' : '' }}>In Office</option>
            <option value="remote" {{ $job->job_type == 'remote' ? 'selected' : '' }}>Remote</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Working Hours</label>
          <select name="working_hours" class="w-full p-2 border rounded-lg" required>
            <option value="morning" {{ $job->working_hours == 'morning' ? 'selected' : '' }}>Morning</option>
            <option value="evening" {{ $job->working_hours == 'evening' ? 'selected' : '' }}>Evening</option>
            <option value="night" {{ $job->working_hours == 'night' ? 'selected' : '' }}>Night</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium">Location</label>
        <input type="text" name="location" value="{{ $job->location }}" class="w-full p-2 border rounded-lg" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Pay Rate</label>
        <input type="text" name="pay_rate" value="{{ $job->pay_rate }}" class="w-full p-2 border rounded-lg" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Description</label>
        <textarea name="description" rows="4" class="w-full p-2 border rounded-lg">{{ $job->description }}</textarea>
      </div>

      <button type="submit"
              class="bg-purple-900 text-white px-6 py-2 rounded-lg hover:bg-purple-800 transition">
        Update Job
      </button>
    </form>
  </div>
@endsection
