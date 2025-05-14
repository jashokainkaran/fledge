<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings - Fledge</title>

    <!-- Expose the AJAX endpoint URL -->
    <script>
        window.jobsIndexUrl = "{{ route('jobs.index') }}";
    </script>

    <!-- Tailwind & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">
    @include('components.navbar')

    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-purple-900 mb-3">
                Find Your Next Opportunity
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Browse through our latest job openings and find the perfect fit for your skills and schedule.
            </p>
        </div>

        <!-- Search Bar -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center max-w-3xl mx-auto">
                <div class="relative flex-1">
                    <input
                        type="text"
                        id="keyword"
                        placeholder="Search by job title, keywords, or company"
                        class="w-full p-3 pl-10 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-purple-500 focus:border-purple-500
                               transition-all"
                    />
                    <i class="fas fa-search absolute left-3 top-1/2
                              transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button
                    id="searchButton"
                    class="ml-4 bg-purple-600 hover:bg-purple-700 text-white
                           font-medium py-3 px-6 rounded-lg transition-colors"
                >
                    Search
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-5">
                Refine Your Search
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                        Category
                    </label>
                    <select id="category"
                            class="w-full p-3 border border-gray-300 rounded-lg
                                   focus:ring-2 focus:ring-purple-500 focus:border-purple-500
                                   transition-all">
                        <option value="">All Categories</option>
                        <option value="it">IT</option>
                        <option value="management">Management</option>
                        <option value="call center">Call Center</option>
                        <option value="audit">Audit</option>
                        <option value="retailing">Retailing</option>
                        <option value="bakery">Bakery</option>
                        <option value="waitering">Waitering</option>
                    </select>
                </div>

                <!-- Job Type -->
                <div>
                    <label for="jobType" class="block text-sm font-medium text-gray-700 mb-1">
                        Job Type
                    </label>
                    <select id="jobType"
                            class="w-full p-3 border border-gray-300 rounded-lg
                                   focus:ring-2 focus:ring-purple-500 focus:border-purple-500
                                   transition-all">
                        <option value="">All Types</option>
                        <option value="in-office">In Office</option>
                        <option value="remote">Remote</option>
                    </select>
                </div>

                <!-- Shift -->
                <div>
                    <label for="workingHours" class="block text-sm font-medium text-gray-700 mb-1">
                        Shift
                    </label>
                    <select id="workingHours"
                            class="w-full p-3 border border-gray-300 rounded-lg
                                   focus:ring-2 focus:ring-purple-500 focus:border-purple-500
                                   transition-all">
                        <option value="">All Shifts</option>
                        <option value="morning">Morning</option>
                        <option value="evening">Evening</option>
                        <option value="night">Night</option>
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                        Location
                    </label>
                    <select id="location"
                            class="w-full p-3 border border-gray-300 rounded-lg
                                   focus:ring-2 focus:ring-purple-500 focus:border-purple-500
                                   transition-all">
                        <option value="">All Locations</option>
                        @foreach(range(1, 15) as $i)
                            <option value="colombo {{ $i }}">Colombo {{ $i }}</option>
                        @endforeach
                        <option value="remote">Remote</option>
                    </select>
                </div>

                <!-- Reset -->
                <div class="flex items-end">
                    <button
                        id="resetButton"
                        class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800
                               font-medium py-3 px-4 rounded-lg transition-colors"
                    >
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Job Listings -->
        <div id="job-listings" class="grid gap-6">
            @include('partials.job_listings', ['jobs' => $jobs])
        </div>
    </div>

    @include('components.footer')

    <!-- Reset filters script -->
    <script>
        document.getElementById("resetButton").addEventListener("click", function () {
            document.getElementById("keyword").value = "";
            document.getElementById("category").value = "";
            document.getElementById("jobType").value = "";
            document.getElementById("workingHours").value = "";
            document.getElementById("location").value = "";
            document.getElementById("searchButton").click();
        });
    </script>

    <!-- Your only Vite JS include, loaded last -->
    @vite('resources/js/app.js')
</body>
</html>
