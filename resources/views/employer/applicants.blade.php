@extends('layouts.employerdashboard')

@section('content')
  <h1 class="text-2xl font-bold mb-6">Applicants for: {{ $job->title }}</h1>

  @if($applications->isEmpty())
    <p class="text-gray-600">No one has applied yet.</p>
  @else
    <ul class="space-y-4">
      @foreach($applications as $app)
        <li class="bg-white p-4 rounded shadow flex justify-between items-center">
          <div>
            <p class="font-semibold">
              {{ $app->student->first_name }} {{ $app->student->last_name }}
            </p>
            <p class="text-sm text-gray-500">
              Applied on {{ $app->created_at->format('M j, Y') }}
            </p>
          </div>
          <a href="{{ route('employer.job.view-application', ['job'=>$job->id,'application'=>$app->id]) }}"
             class="text-purple-600 hover:underline">
            View Submission
          </a>
        </li>
      @endforeach
    </ul>
  @endif

  <div class="mt-6">
    <a href="{{ route('employer.dashboard') }}"
       class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
      Back to Dashboard
    </a>
  </div>
@endsection
