{{-- resources/views/admin/review/index.blade.php --}}
@extends('layouts.admin')

@section('content')
  <h1 class="text-2xl font-bold mb-6">Student Reviews</h1>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  @forelse($reviews as $r)
    <div class="bg-white shadow rounded p-4 mb-4 flex justify-between items-center">
      <div>
        <p><strong>ID:</strong> {{ $r->id }}</p>
        <p><strong>Student:</strong> {{ $r->student->name ?? 'Unknown' }}</p>
        <p><strong>Rating:</strong> {{ $r->rating }} / 5</p>
      </div>
      <form method="POST" action="{{ route('admin.review.delete', $r->id) }}">
        @csrf
        @method('DELETE')
        <button onclick="return confirm('Delete this review?')"
                class="bg-red-600 text-white px-3 py-1 rounded">
          Delete
        </button>
      </form>
    </div>
  @empty
    <p class="text-gray-600">No reviews yet.</p>
  @endforelse

  {{ $reviews->links() }}
@endsection