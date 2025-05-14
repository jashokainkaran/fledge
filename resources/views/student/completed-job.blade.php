<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied Jobs - Fledge</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar Include -->
    @include('components.navbar')

    <!-- Main Container -->
    <div class="container mx-auto px-4 py-8">
        <!-- Page Heading -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-purple-900 mb-3">Applied Jobs</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Here are the jobs you’ve applied to.</p>
        </div>

        <!-- Applied Job Listings -->
        <div class="grid gap-6">
            @forelse($applications as $app)
                @php $job = $app->job; @endphp
                @if ($job)
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
                    </div>
                @endif
            @empty
                <p>No applications found.</p>
            @endforelse
        </div>
    </div>

    <!-- Footer Include -->
    @include('components.footer')

</body>
</html>