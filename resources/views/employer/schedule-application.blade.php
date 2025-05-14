  <!-- resources/views/employer/schedule-application.blade.php -->
  @extends('layouts.employerdashboard')

  @section('content')
    <div class="bg-white p-6 rounded shadow mb-6 max-w-lg mx-auto">
      <h1 class="text-2xl font-bold mb-4">Schedule Job: {{ $app->job->title }}</h1>
      <form action="{{ route('employer.job.application.schedule.submit', [$app->job->id, $app->id]) }}" method="POST" class="space-y-4">
        @csrf

        {{-- Start Date --}}
        <div>
          <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
          <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $app->start_date?->format('Y-m-d')) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
          @error('start_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- End Date --}}
        <div>
          <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
          <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $app->end_date?->format('Y-m-d')) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
          @error('end_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="pt-4">
          <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700">Save Schedule</button>
        </div>
      </form>

      <div class="mt-4">
        <a href="{{ route('employer.job.view-application', [$app->job->id, $app->id]) }}"
          class="text-gray-600 hover:underline">Cancel</a>
      </div>
    </div>
  @endsection
