<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Log In</title>
    @vite(['resources/css/app.css', 'resources/js/login.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const e = document.getElementById('email');
    const p = document.getElementById('password');
    if (e) e.value = '';
    if (p) p.value = '';
  });
</script>

<body class="bg-gradient-to-br from-purple-50 to-white min-h-screen font-['Inter']">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm p-4 flex max-w mx-auto px-4 sm:px-6 lg:px-8">
        <img src="{{ asset('images/logo.png') }}" alt="Fledge Logo" class="h-10 hover:scale-105 transition-transform duration-200">
    </nav>

    <!-- Centered Login Box -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden w-full max-w-md">
            <!-- Decorative purple header -->
            <div class="bg-purple-900 py-6 px-8 text-center">
                <h2 class="text-2xl font-bold text-white">Admin Portal</h2>
                <p class="text-purple-200 mt-1">Sign in with your administrator credentials</p>
            </div>

            <!-- Form content -->
            <div class="p-8 sm:p-10">
                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                @if($errors->has('login'))
  <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
    {{ $errors->first('login') }}
  </div>
@endif

<form action="{{ url('admin/login') }}"
      method="POST"
      autocomplete="off"        {{-- disable autocomplete for the whole form --}}
      class="space-y-6">
    @csrf

    {{-- show error if login failed --}}
    @if($errors->has('login'))
      <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
        {{ $errors->first('login') }}
      </div>
    @endif

    <div>
      <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input type="email"
             name="email"
             id="email"
             value="{{ $errors->has('login') ? old('email') : '' }}"
             autocomplete="off"          {{-- prevent saved emails --}}
             required
             class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input type="password"
             name="password"
             id="password"
             autocomplete="new-password" {{-- prevent saved passwords --}}
             required
             class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
    </div>

    <div>
      <button type="submit"
              class="w-full bg-purple-900 text-white py-3 rounded-lg">
        Sign In
      </button>
    </div>
</form>

                <div class="mt-6 text-center text-sm">
                    <p class="text-gray-600">
                        Back to <a href="/" class="font-medium text-purple-900 hover:text-purple-700 hover:underline transition duration-200">Home</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
