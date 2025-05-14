<!-- resources/views/employer/view-application.blade.php -->
@extends('layouts.employerdashboard')

@section('content')
  <div class="bg-white p-6 rounded shadow mb-6">
    <h1 class="text-2xl font-bold mb-4">Application Details</h1>

    {{-- Job Info --}}
    <div class="mb-4">
      <h2 class="text-xl font-semibold">Job: {{ $job->title }}</h2>
      <p class="text-sm text-gray-600">Posted on {{ $job->created_at->format('M j, Y') }}</p>
    </div>

    {{-- Applicant Info --}}
    <div class="mb-4">
      <h3 class="text-lg font-semibold">Applicant</h3>
      <p>{{ $application->student->first_name }} {{ $application->student->last_name }}</p>
      <p class="text-sm text-gray-600">
        Applied on {{ $application->created_at->format('M j, Y, g:ia') }}
      </p>
    </div>

    {{-- Cover Message --}}
    @if(!empty($application->message))
      <div class="mb-4">
        <h3 class="font-semibold">Cover Message</h3>
        <p class="whitespace-pre-wrap">{{ $application->message }}</p>
      </div>
    @endif

    {{-- CV Download --}}
    @if(!empty($application->cv_path))
      <div class="mb-4">
        <h3 class="font-semibold">CV</h3>
        <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank"
           class="text-purple-600 hover:underline">
          Download CV
        </a>
      </div>
    @endif
    <div class="mt-6 space-x-3">
  <a href="{{ route('employer.dashboard') }}"
     class="px-4 py-2 bg-gray-200 rounded">← Job List</a>

  @if($application->status==='pending')
    {{-- Approve button --}}
    <form method="POST" action="{{ route('employer.job.application.approve',[$job->id,$application->id]) }}">
      @csrf
      <button class="px-4 py-2 bg-green-600 text-white rounded">Approve</button>
    </form>

    {{-- Reject button --}}
    <form method="POST" action="{{ route('employer.job.application.reject',[$job->id,$application->id]) }}">
      @csrf @method('DELETE')
      <button class="px-4 py-2 bg-red-600 text-white rounded">Reject</button>
    </form>

  @elseif($application->status==='approved')
    {{-- Go to schedule form --}}
    <a href="{{ route('employer.job.application.schedule',[$job->id,$application->id]) }}"
       class="px-4 py-2 bg-blue-600 text-white rounded">
      Set Schedule
    </a>

  @elseif($application->status==='scheduled')
    <p class="text-gray-700">
      Start: {{ $application->start_date->toFormattedDateString() }}<br>
      End:   {{ $application->end_date->toFormattedDateString() }}
    </p>
    {{-- Complete button --}}
    <form method="POST" action="{{ route('employer.job.application.complete',[$job->id,$application->id]) }}">
      @csrf
      <button class="px-4 py-2 bg-indigo-600 text-white rounded">Mark Complete</button>
    </form>

  @elseif($application->status==='completed')
    <p class="text-green-700 font-semibold">Completed on {{ $application->updated_at->toFormattedDateString() }}</p>
    {{-- At this point, you could show a link to a student-rating page --}}
  @endif
</div>

      </form>
    </div>
  </div>
@endsection