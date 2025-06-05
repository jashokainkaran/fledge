<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job - Fledge</title>
    <!-- Direct link to your external JS file -->
    <script src="{{ asset('js/apply.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    @include('components.navbar')

    <div class="container mx-auto px-4 py-10">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-purple-900 mb-6">Apply for {{ $job->title }}</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Job details --}}
            <div class="mb-6 space-y-2 text-gray-800">
                <p><strong>Category:</strong> {{ $job->category }}</p>
                <p><strong>Job Type:</strong> {{ ucfirst($job->job_type) }}</p>
                <p><strong>Working Hours:</strong> {{ ucfirst($job->working_hours) }}</p>
                <p><strong>Location:</strong> {{ $job->location }}</p>
                <p><strong>Pay Rate:</strong> {{ $job->pay_rate }}</p>
                <p><strong>Description:</strong> {{ $job->description }}</p>
            </div>

            {{-- Application form --}}
                <form action="{{ route('student.jobs.submit_application', $job->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    method="POST" 
                    enctype="multipart/form-data"
                    class="space-y-5">        
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cover Letter</label>
                    <textarea name="message" rows="5" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Write your cover letter here..." required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload CV (PDF only)</label>
                    <input type="file" name="cv" accept="application/pdf" class="w-full p-2 border border-gray-300 rounded-lg bg-white" required>
                    <p class="text-xs text-gray-500 mt-1">Only PDF files allowed. Max size: 2MB.</p>
                </div>

                <button type="submit" class="bg-purple-900 text-white px-6 py-2 rounded-lg hover:bg-purple-800 transition">
                    Submit Application
                </button>
            </form>
        </div>
    </div>

    @include('components.footer')
</body>
</html>
