@extends('layouts.employerdashboard')

@section('content')
  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-6">
      {{ session('success') }}
    </div>
  @endif

  {{-- Posted Jobs --}}
  <section id="posted-jobs" class="mb-12">
    <h2 class="text-2xl font-semibold mb-4">Posted Jobs</h2>

    @forelse($jobs as $job)
      <div class="bg-white p-5 rounded shadow mb-6">
        <div class="flex items-center justify-between mb-2">
          <div class="flex items-center space-x-4">
            <h3 class="text-xl font-bold">{{ $job->title }}</h3>
            @if($job->status==='pending')
              <span class="px-2 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">Pending</span>
            @elseif($job->status==='approved')
              <span class="px-2 py-1 rounded-full text-sm bg-green-100 text-green-800">Approved</span>
            @elseif($job->status==='rejected')
              <span class="px-2 py-1 rounded-full text-sm bg-red-100 text-red-800">Rejected</span>
            @endif
          </div>
          <div class="space-x-3 text-sm">
            <a href="{{ route('employer.job.edit', $job) }}" class="text-purple-600 hover:underline">Edit</a>
            <form action="{{ route('employer.job.delete', $job) }}" method="POST" class="inline" onsubmit="return confirm('Delete this job?');">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline">Delete</button>
            </form>
          
          </div>
        </div>
        <p class="text-gray-700">{{ Str::limit($job->description, 200) }}</p>
      </div>
    @empty
      <p class="text-gray-600">You have not posted any jobs yet. <a href="{{ route('employer.job.create') }}" class="text-purple-600 hover:underline">Post one now.</a></p>
    @endforelse
  </section>

  {{-- All Applications for All Jobs --}}
  <section id="job-applications">
    <h2 class="text-2xl font-semibold mb-4">Recent Applications</h2>

    @php $hasAny = false; @endphp

    @foreach($jobs as $job)
      @foreach($job->applications as $app)
        @php $hasAny = true; @endphp
        <div class="bg-white p-5 rounded shadow mb-4">
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-lg font-bold">{{ $job->title }}</h3>
              <p class="text-sm text-gray-600">
                Applicant: {{ $app->student->first_name }} {{ $app->student->last_name }}
              </p>
              <p class="text-xs text-gray-500">
                Applied on {{ $app->created_at->format('M j, Y') }}
              </p>
            </div>
            <a href="{{ route('employer.job.view_application', [$job->id, $app->id]) }}">
  View Application
</a>
          </div>
        </div>
      @endforeach
    @endforeach

    @unless($hasAny)
      <div class="bg-white p-6 text-center text-gray-600 rounded shadow">
        No applications received yet.
      </div>
    @endunless
  </section>
@endsection
