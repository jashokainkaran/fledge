<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Profile</title>
  @vite('resources/js/profile.js')
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
  @include('components.navbar')

  <div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-4xl mx-auto">
      <!-- Profile Header -->
      <div class="bg-purple-900 px-6 py-4">
        <h2 class="text-2xl font-semibold text-white">
          <i class="fas fa-user-circle mr-2"></i> My Profile
        </h2>
      </div>

      <!-- Profile Completion Section -->
      <div class="mx-auto max-w-4xl mb-6 p-6">
        <div class="mb-2 flex justify-between text-sm text-gray-700">
          <span>Profile Completion</span>
          <span id="completionText" class="font-semibold text-purple-700">40% Complete</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4 relative overflow-hidden">
          <div id="progressBar" class="h-4 rounded-full bg-gradient-to-r from-purple-500 to-purple-700 transition-all duration-500 ease-in-out" style="width:40%"></div>
          <div class="absolute inset-0 flex items-center justify-end pr-2 text-xs text-white font-semibold">
            <span id="progressTooltip" class="bg-purple-800 bg-opacity-75 px-2 py-1 rounded"></span>
          </div>
        </div>
        <div id="completionSuggestions" class="text-sm text-gray-600 mt-4 space-y-3">
          <div id="suggestion-profile-picture" class="flex items-center {{ $student->profile_picture ? 'text-green-600' : 'text-gray-600' }}">
            <i class="fas {{ $student->profile_picture ? 'fa-check-circle' : 'fa-circle-notch' }} mr-2"></i>
            <span>{{ $student->profile_picture ? 'Profile picture added (25%)' : 'Add a profile picture (25%)' }}</span>
          </div>
          <div id="suggestion-cv" class="flex items-center {{ $student->cv ? 'text-green-600' : 'text-gray-600' }}">
            <i class="fas {{ $student->cv ? 'fa-check-circle' : 'fa-circle-notch' }} mr-2"></i>
            <span>{{ $student->cv ? 'CV uploaded (35%)' : 'Upload your CV (35%)' }}</span>
          </div>
          <div id="suggestion-personal" class="flex items-center {{ $student->first_name && $student->last_name && $student->email ? 'text-green-600' : 'text-gray-600' }}">
            <i class="fas {{ $student->first_name && $student->last_name && $student->email ? 'fa-check-circle' : 'fa-circle-notch' }} mr-2"></i>
            <span>{{ $student->first_name && $student->last_name && $student->email ? 'Personal information completed (40%)' : 'Add your personal information (40%)' }}</span>
          </div>
        </div>
      </div>

      <!-- Form Container -->
      <div class="p-6 md:p-8">
        <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @method('PUT')

          <!-- Profile Picture Section -->
          <div class="flex flex-col items-center md:flex-row md:items-start space-y-6 md:space-y-0 md:space-x-8 mb-8">
            <div class="relative">
              <img id="preview" src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : asset('images/user.png') }}"
                   alt="Profile"
                   class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow-sm">
              <label id="profilePictureLabel" for="profilePicture" class="absolute bottom-0 right-0 bg-purple-700 text-white p-2 rounded-full cursor-pointer opacity-0 transition-opacity duration-300">
                <i class="fas fa-camera"></i>
                <input type="file" id="profilePicture" name="profile_picture" class="hidden" accept="image/*">
              </label>
            </div>
            <div class="text-center md:text-left">
              <h3 class="text-xl font-semibold text-gray-800">{{ $student->first_name }} {{ $student->last_name }}</h3>
              <p class="text-gray-600">{{ $student->email }}</p>
              <p class="text-gray-600 mt-1">{{ $student->phone }}</p>
            </div>
          </div>

          <!-- Form Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1">
              <label class="block text-sm font-medium text-gray-700"><i class="fas fa-user mr-1 text-purple-700"></i> First Name</label>
              <input type="text" id="firstName" name="first_name" value="{{ old('first_name', $student->first_name) }}"
                     class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-500 disabled:cursor-not-allowed" disabled>
            </div>
            <div class="space-y-1">
              <label class="block text-sm font-medium text-gray-700"><i class="fas fa-user mr-1 text-purple-700"></i> Last Name</label>
              <input type="text" id="lastName" name="last_name" value="{{ old('last_name', $student->last_name) }}"
                     class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-500 disabled:cursor-not-allowed" disabled>
            </div>
            <div class="space-y-1">
              <label class="block text-sm font-medium text-gray-700"><i class="fas fa-envelope mr-1 text-purple-700"></i> Email</label>
              <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}"
                     class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-500 disabled:cursor-not-allowed" disabled>
            </div>
            <div class="space-y-1">
              <label class="block text-sm font-medium text-gray-700"><i class="fas fa-phone mr-1 text-purple-700"></i> Phone</label>
              <input type="tel" id="contact" name="phone" value="{{ old('phone', $student->phone) }}"
                     class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-500 disabled:cursor-not-allowed" disabled>
            </div>
            <div class="md:col-span-2 space-y-1">
              <label class="block text-sm font-medium text-gray-700"><i class="fas fa-file-pdf mr-1 text-purple-700"></i> CV/Resume (PDF only)</label>
              <div class="flex items-center space-x-4">
                <label class="flex-1">
                  <div class="flex items-center justify-between px-4 py-2 border rounded-lg bg-gray-100 hover:bg-gray-50 cursor-pointer transition">
                    <span id="cvFileName" class="truncate text-gray-500">{{ $student->cv ? basename($student->cv) : 'No file chosen' }}</span>
                    <span class="px-3 py-1 rounded text-sm bg-gray-200 hover:bg-gray-300"><i class="fas fa-upload mr-1"></i> Browse</span>
                  </div>
                  <input type="file" id="cv" name="cv" accept="application/pdf" class="hidden" disabled>
                </label>
                @if($student->cv)
                  <button type="button" onclick="openCV('{{ asset('storage/' . $student->cv) }}')" class="p-2 rounded-full text-purple-700 hover:bg-purple-50 transition" title="View CV"><i class="fas fa-eye"></i></button>
                  <a href="{{ asset('storage/' . $student->cv) }}" download class="p-2 rounded-full text-purple-700 hover:bg-purple-50 transition" title="Download CV"><i class="fas fa-download"></i></a>
                @endif
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
            <button type="button" id="editButton" class="flex items-center px-6 py-2 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition">
              <i class="fas fa-edit mr-2"></i> Edit Profile
            </button>
            <button type="submit" id="saveButton" class="hidden flex items-center px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
              <i class="fas fa-save mr-2"></i> Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function openCV(url) {
      window.open(url, '_blank');
    }
    @error('cv')
      alert("{{ $message }}");
    @enderror
  </script>
</body>
</html>