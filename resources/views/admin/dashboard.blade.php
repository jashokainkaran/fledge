{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
  <div class="max-w-7xl mx-auto space-y-8">

    @include('components.admin-navbar')

    {{-- Pending Employers --}}
    <section>
      <h2 class="text-2xl font-semibold mb-4">Pending Employers</h2>
      <div class="space-y-4">
        @forelse($pendingEmployers as $emp)
          <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
            <div>
              <p class="text-lg font-medium">{{ $emp->company_name }}</p>
              <p class="text-gray-600 text-sm">{{ $emp->email }}</p>
            </div>
            <div class="space-x-2">
              <form action="{{ route('admin.employer.verify', $emp->id) }}" method="POST" class="inline">
                @csrf
                <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Verify</button>
              </form>
              <form action="{{ route('admin.employer.reject', $emp->id) }}" method="POST" class="inline">
                @csrf
                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Reject</button>
              </form>
            </div>
          </div>
        @empty
          <p class="text-gray-500">No pending employers.</p>
        @endforelse
      </div>
    </section>

    {{-- Pending Jobs --}}
    <section>
      <h2 class="text-2xl font-semibold mb-4">Pending Jobs</h2>
      <div class="space-y-4">
        @forelse($pendingJobs as $job)
          <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
            <div>
              <p class="text-lg font-medium">{{ $job->title }}</p>
              <p class="text-gray-600 text-sm">{{ Str::limit($job->description, 80) }}</p>
            </div>
            <div class="space-x-2">
              <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST" class="inline">
                @csrf
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Approve</button>
              </form>
              <form action="{{ route('admin.jobs.reject', $job->id) }}" method="POST" class="inline">
                @csrf
                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Reject</button>
              </form>
            </div>
          </div>
        @empty
          <p class="text-gray-500">No pending jobs.</p>
        @endforelse
      </div>
    </section>

    {{-- Student Reviews --}}
    <section>
      <h2 class="text-2xl font-semibold mb-4">Recent Student Reviews</h2>
      <div class="space-y-4">
        @forelse($recentReviews as $r)
          <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
            <div>
              <p class="text-gray-800"><strong>{{ $r->student->name ?? 'Student #' . $r->student_id }}</strong> rated <strong>{{ $r->rating }}/5</strong></p>
              <p class="text-gray-600 text-sm">on {{ $r->created_at->format('M j, Y') }}</p>
            </div>
            <form action="{{ route('admin.review.delete', $r->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                      onclick="return confirm('Delete this review?')">
                Delete
              </button>
            </form>
          </div>
        @empty
          <p class="text-gray-500">No recent reviews.</p>
        @endforelse
      </div>
    </section>

      @include('components.footer')


  </div>
@endsection
