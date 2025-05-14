@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto py-8">
  <h1 class="text-2xl font-bold mb-4">Rate & Review: {{ $application->job->title }}</h1>

  <form method="POST" action="{{ route('student.review.store', $application->id) }}" class="space-y-4">
    @csrf

    {{-- Rating --}}
    <div>
      <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1–5)</label>
      <select name="rating" id="rating" class="mt-1 block w-full border-gray-300 rounded-md">
        @for ($i = 1; $i <= 5; $i++)
          <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
      </select>
      @error('rating')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>

    {{-- Comment --}}
    <div>
      <label for="comment" class="block text-sm font-medium text-gray-700">Comments (optional)</label>
      <textarea name="comment" id="comment" rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md">{{ old('comment') }}</textarea>
      @error('comment')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="pt-4">
      <button type="submit"
              class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
        Submit Review
      </button>
    </div>
  </form>

  <div class="mt-4 text-center">
    <a href="{{ route('student.applied_jobs') }}"
       class="text-gray-600 hover:underline">← Back to Applications</a>
  </div>
</div>
@endsection