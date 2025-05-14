<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings - Fledge</title>
    @vite('resources/js/jobs.js')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">
    @include('components.navbar')

    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-purple-900 mb-3">Find Your Next Opportunity</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Browse through our latest job openings and find the perfect fit for your skills and schedule.</p>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-xl shadow-md p-5 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter Jobs</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Category, Job Type, Shift, Location, Buttons -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="category" name="category" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        <option value="">All Categories</option>
                        <option value="it">IT</option>
                        <option value="management">Management</option>
                        <option value="call center">Call Center</option>
                        <option value="audit">Audit</option>
                    </select>
                </div>
                <div>
                    <label for="jobType" class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                    <select id="jobType" name="job_type" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        <option value="">All Types</option>
                        <option value="in-office">In Office</option>
                        <option value="remote">Remote</option>
                    </select>
                </div>
                <div>
                    <label for="workingHours" class="block text-sm font-medium text-gray-700 mb-1">Shift</label>
                    <select id="workingHours" name="working_hours" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        <option value="">All Shifts</option>
                        <option value="morning">Morning</option>
                        <option value="evening">Evening</option>
                        <option value="night">Night</option>
                    </select>
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <select id="location" name="location" class="w-full p-2 border	border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        <option value="">All Locations</option>
                        @foreach(range(1, 15) as $i)
                            <option value="colombo {{ $i }}">Colombo {{ $i }}</option>
                        @endforeach
                        <option value="remote">Remote</option>
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <button id="searchButton" class="flex-1 bg-purple-900 hover:bg-purple-800 text-white py-2 px-4 rounded-lg transition-colors">
                        Search
                    </button>
                    <button id="resetButton" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg transition-colors">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Job Listings -->
        <section class="grid gap-6">
            @forelse($jobs as $job)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-5 md:p-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                            <!-- Left: Job details -->
                            <div class="flex-1">
                                <!-- Badges -->
                                <div class="flex flex-wrap	items-center gap-2 mb-3 text-xs font-medium text-gray-700">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full">
                                        {{ ucfirst($job->category) }}
                                    </span>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">
                                        {{ $job->job_type === 'in-office' ? 'On-site' : 'Remote' }}
                                    </span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full">
                                        {{ ucfirst($job->working_hours) }} Shift
                                    </span>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $job->location)) }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-1">
                                    <a href="{{ route('jobs.show', $job) }}" class="hover:underline text-purple-900">
                                        {{ $job->title }}
                                    </a>
                                </h3>

                                <!-- Company -->
                                <p class="flex items-center gap-1 text-blue-600 text-sm mb-2">
                                    <i class="fas fa-check-circle text-blue-500"></i>
                                    {{ $job->employer->company_name ?? 'Company Name' }}
                                </p>

                                <!-- Pay -->
                                <p class="text-sm text-purple-800 font-semibold">
                                    💰 Pay: LKR {{ number_format($job->pay_rate, 0) }}
                                </p>
                            </div>

                            <!-- Right: Apply button -->
                            <div class="md:text-right">
                                <button class="bg-purple-900 hover:bg-purple-800 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    Apply Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-600">No job listings found.</p>
                </div>
            @endforelse
        </section>
    </div>

    @include('components.footer')
</body>

</html>
