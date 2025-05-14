{{-- resources/views/admin/jobs/pending.blade.php --}}
@extends('layouts.admin')

@section('content')
  <h1 class="text-2xl mb-4">Pending Job Posts</h1>
  @if(session('success'))<div class="bg-green-100 p-2 rounded mb-3">{{ session('success') }}</div>@endif
  @foreach($jobs as $job)
    <div x‑data="{open:false}" class="bg-white p-4 rounded shadow mb-4">
      <div class="flex justify-between items-center">
        <button @click="open = !open">
          <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
        </button>
        <div>
          <strong>{{ $job->title }}</strong><br>
          <small class="text-gray-600">{{ $job->employer->company_name }}</small>
        </div>
        <div class="space-x-2">
          <form method="POST" action="{{ route('admin.jobs.approve',$job->id) }}">@csrf
            <button class="bg-green-600 text-white px-2 py-1 rounded">Approve</button>
          </form>
          <form method="POST" action="{{ route('admin.jobs.reject',$job->id) }}">@csrf
            <button class="bg-red-600 text-white px-2 py-1 rounded">Reject</button>
          </form>
        </div>
      </div>
      <div x-show="open" class="mt-2 text-sm text-gray-700">
        Category: {{ $job->category }}<br>
        Type/Shift: {{ $job->job_type }} / {{ $job->working_hours }}<br>
        Location: {{ $job->location }}<br>
        Pay Rate: {{ $job->pay_rate }}<br>
        Posted: {{ $job->created_at->format('M j, Y') }}
      </div>
    </div>
  @endforeach
@endsection
