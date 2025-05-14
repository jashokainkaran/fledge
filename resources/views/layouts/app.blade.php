<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Fledge')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script>
  window.jobsIndexUrl = "{{ route('jobs.index') }}";
  console.log('→ Inline: jobsIndexUrl is', window.jobsIndexUrl);
</script>
@vite('resources/js/app.js')
  <!-- Tailwind & FontAwesome -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <!-- Alpine.js (single import) -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

  <!-- x-cloak helper -->
  <style>[x-cloak] { display: none !important; }</style>

  
</head>
<body class="flex flex-col min-h-screen bg-gray-100">

  {{-- Site Navbar --}}
  @include('components.navbar')

  {{-- Page Content --}}
  <main class="flex-grow container mx-auto px-4 py-8">
    @yield('content')
  </main>

  {{-- Site Footer --}}
  @include('components.footer')

  {{-- Page‑specific scripts --}}
  @stack('scripts')
</body>
</html>