<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fledge Employer Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  {{-- Employer Navbar --}}
  <nav class="bg-white shadow px-6 py-4 md:px-10 md:py-5">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <!-- Home -->
        <a href="{{ route('home') }}"
           class="text-gray-700 hover:text-purple-800 font-medium px-4 py-2 rounded hover:bg-purple-100 transition">
          <i class="fas fa-home mr-1"></i> Home
        </a>

        <!-- Jobs -->
        <a href="{{ route('jobs.index') }}"
           class="text-gray-700 hover:text-purple-800 font-medium px-4 py-2 rounded hover:bg-purple-100 transition">
          <i class="fas fa-briefcase mr-1"></i> Jobs
        </a>

        <!-- Post Job -->
        <a href="{{ route('employer.job.create') }}"
           class="text-gray-700 hover:text-purple-800 font-medium px-4 py-2 rounded hover:bg-purple-100 transition">
          <i class="fas fa-plus mr-1"></i> Post Job
        </a>
      </div>

      <div class="flex items-center space-x-4">
        <!-- Profile -->
        <a href="#"
           class="bg-purple-100 text-purple-800 font-medium px-4 py-2 rounded-full shadow-sm hover:bg-purple-200 transition">
          <i class="fas fa-user mr-1"></i>
          {{ Auth::guard('employer')->user()->company_name }}
        </a>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
          @csrf
              <button type="submit">Logout</button>

        </form>
      </div>
    </div>
  </nav>

  {{-- Main Content Section --}}
  <main class="flex-grow p-6 container mx-auto">
    @yield('content') {{-- This is where your page-specific content will go --}}
  </main>

  {{-- Footer --}}
  @include('components.footer') {{-- Footer component can be placed in a separate file if needed --}}
  
</body>
</html>