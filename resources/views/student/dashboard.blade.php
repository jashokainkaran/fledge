{{-- resources/views/student/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Dashboard – Fledge</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  @include('components.navbar')

  <div class="flex">
    <div class="flex-1 p-8">

      {{-- Hero --}}
      <header class="relative h-72 bg-cover bg-center mb-8" style="background-image:url('{{ asset('images/bg.jpg') }}')">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative text-center text-white py-20">
          <h1 class="text-4xl font-bold">Explore Opportunities</h1>
          <p class="mt-2">Find the perfect part-time job that fits your academic schedule.</p>
        </div>
      </header>

      {{-- Latest Jobs --}}
      <section class="max-w-4xl mx-auto mb-12">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-2xl font-semibold">Latest Job Listings</h2>
          <!-- <a href="{{ route('student.applied_jobs') }}" class="text-purple-900 hover:underline flex items-center">
            View All Lastest Job Listings <i class="fas fa-arrow-right ml-1"></i>
          </a> -->
        </div>
        <div class="grid gap-6">
          @forelse($latestJobs->take(3) as $job)
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
              <div class="flex justify-between items-center">
                <div>
                  <h3 class="text-xl font-bold mb-1">{{ $job->title }}</h3>
                  <p class="text-sm text-gray-600">
                    {{ ucfirst($job->category) }} &middot; {{ ucfirst($job->working_hours) }} shift
                  </p>
                  <p class="text-sm text-gray-600">
                    <i class="fas fa-map-marker-alt mr-1"></i>{{ ucfirst($job->location) }}
                  </p>
                </div>
                <a
                  href="{{ route('student.jobs.apply_form', $job) }}"
                  class="bg-purple-900 hover:bg-purple-800 text-white font-medium py-2 px-6 rounded-lg transition-colors"
                >
                  Apply Now
                </a>
              </div>
            </div>
          @empty
            <p class="text-center text-gray-600">No job listings available right now.</p>
          @endforelse
        </div>
      </section>

      {{-- Applied Jobs --}}
      <section class="max-w-4xl mx-auto mb-12">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-2xl font-semibold">Applied Jobs</h2>
          <a href="{{ route('student.applied_jobs') }}" class="text-purple-900 hover:underline flex items-center">
            View All Applied Jobs <i class="fas fa-arrow-right ml-1"></i>
          </a>
        </div>
        <div class="grid gap-6">
          @if($appliedJobs->isEmpty())
            <p class="text-center text-gray-600">You haven't applied for any jobs yet.</p>
          @else
            @foreach($appliedJobs->take(2) as $application)
              @if($application->job)
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                  <div class="flex justify-between items-center">
                    <div>
                      <h3 class="text-lg font-bold">{{ $application->job->title }}</h3>
                      <p class="text-sm text-gray-600">{{ ucfirst($application->job->location) }}</p>
                    </div>
                    <span class="inline-block text-sm font-medium px-3 py-1 rounded-full
                            {{ $application->status === 'Pending'  ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $application->status === 'Accepted' ? 'bg-green-100  text-green-800' : '' }}
                            {{ $application->status === 'Rejected' ? 'bg-red-100    text-red-800' : '' }} ">
                      {{ ucfirst($application->status) }}
                    </span>
                  </div>
                </div>
              @endif
            @endforeach
          @endif
        </div>
      </section>

      {{-- Completed Jobs & Reviews --}}
      <section class="max-w-4xl mx-auto mt-12">
        <h2 class="text-2xl font-semibold mb-4">Completed Jobs & Reviews</h2>
        @if($completed->isEmpty())
          <p class="text-gray-600">No completed jobs yet.</p>
        @else
          <ul class="space-y-4">
            @foreach($completed as $app)
              @if($app->job)
                <li class="bg-white p-4 rounded shadow flex justify-between items-center">
                  <div>
                    <h3 class="font-bold">{{ $app->job->title }}</h3>
                    <p class="text-sm text-gray-500">
                      Completed on {{ $app->updated_at->format('M j, Y') }}
                    </p>
                  </div>
                  <a href="{{ route('review.create', $app->id) }}"
                     class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700"
                  >
                    @if($app->review) View Your Review @else Rate &amp; Review @endif
                  </a>
                </li>
              @endif
            @endforeach
          </ul>
        @endif
      </section>

    </div>
  </div>

  @include('components.footer')
</body>
</html>
