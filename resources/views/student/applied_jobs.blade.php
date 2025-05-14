<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Your Applied Jobs — Fledge</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
  @include('components.navbar')

  <div class="container mx-auto px-4 py-8">
    <div class="text-center mb-10">
      <h1 class="text-3xl md:text-4xl font-bold text-purple-900 mb-3">
        Your Applied Jobs
      </h1>
      <p class="text-gray-600 max-w-2xl mx-auto">
        Here’s a list of jobs you’ve applied to. Track your applications and stay updated.
      </p>
    </div>

    <div class="grid gap-6">
      @forelse($applications as $app)
        @php $job = $app->job; @endphp
        <div class="bg-white shadow rounded-xl p-6 flex flex-col md:flex-row justify-between">
          <div class="md:flex-1">
            <h2 class="text-xl font-semibold text-purple-900">{{ $job->title }}</h2>
            <p class="text-gray-700 mb-2">
              {{ Str::limit($job->description, 100) }}
            </p>
            <div class="flex flex-wrap text-sm text-gray-600 space-x-4">
              <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }}</span>
              <span><i class="fas fa-briefcase mr-1"></i>{{ ucfirst($job->job_type) }}</span>
              <span><i class="fas fa-clock mr-1"></i>{{ $job->working_hours }}</span>
            </div>
          </div>

          <div class="mt-4 md:mt-0 md:text-right flex flex-col items-start md:items-end space-y-2">
            <span class="text-xs text-gray-500">
              Applied {{ $app->created_at->diffForHumans() }}
            </span>

            {{-- Status Badge --}}
            <span class="inline-block px-3 py-1 rounded-full text-sm
               @if($app->status==='pending') bg-yellow-100 text-yellow-800
               @elseif($app->status==='accepted') bg-green-100 text-green-800
               @elseif($app->status==='rejected') bg-red-100 text-red-800
               @elseif($app->status==='completed') bg-blue-100 text-blue-800
               @endif
            ">
              {{ ucfirst($app->status) }}
            </span>

            {{-- Rate & Review --}}
            @if($app->status === 'completed')
              <a href="{{ route('student.review.create', $app->id) }}"
                 class="mt-2 inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-star mr-1"></i> Rate &amp; Review
              </a>
            @endif
          </div>
        </div>
      @empty
        <div class="text-center text-gray-500">
          You haven’t applied to any jobs yet.
        </div>
      @endforelse
    </div>

    <div class="mt-8 text-center">
      <a href="{{ route('student.dashboard') }}"
         class="text-purple-600 hover:underline">
        ← Back to Dashboard
      </a>
    </div>
  </div>

  @include('components.footer')
</body>
</html>