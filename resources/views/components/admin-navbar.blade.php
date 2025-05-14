<nav class="bg-white shadow-lg px-4 py-3 md:px-4 md:py-4">
    <div class="mx-auto flex justify-between items-center gap-4">
        <!-- Mobile menu button (hidden on desktop) -->
        <button id="mobile-menu-button" class="sm:hidden text-gray-700 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Logo with hover effects -->
        <a href="/" class="transform transition-all duration-300 hover:scale-110">
            <img src="{{ asset('images/logo.png') }}" alt="Fledge Logo" class="h-10 md:h-12 hover:brightness-110">
        </a>

        <!-- Navigation Links -->
        <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">
            <!-- Main Links (hidden on mobile) -->
            <div class="hidden sm:flex space-x-3">
                <a href="/" class="nav-link hover:scale-105 hover:text-purple-800 hover:bg-purple-50">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
                <a href="/jobs" class="nav-link hover:scale-105 hover:text-purple-800 hover:bg-purple-50">
                    <i class="fas fa-briefcase mr-1"></i> Jobs
                </a>
            </div>

            <!-- Authentication Section -->
            <div class="border-l border-gray-200 pl-3 md:pl-4 flex items-center space-x-2 md:space-x-3">
                @auth
                <!-- Profile Dropdown with Visible Logout -->
                <div x-data="{ open: false }" class="relative flex items-center space-x-3">
                    <!-- Standalone Logout Button -->
                    <<form method="POST" action="{{ route('admin.logout') }}">
    @csrf
    <button type="submit" class="dropdown-item">Logout</button>
</form>

                    <!-- Profile Picture -->
                    <button @click="open = !open" class="flex items-center space-x-1 focus:outline-none group">
                        <div class="w-8 h-8 md:w-9 md:h-9 rounded-full overflow-hidden border-2 border-purple-100 group-hover:border-purple-400 transition-all duration-300 transform group-hover:scale-110">
                            @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 group-hover:brightness-110">
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-purple-900 to-purple-600 flex items-center justify-center text-white group-hover:from-purple-800 group-hover:to-purple-500">
                                <i class="fas fa-user text-sm md:text-lg group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            @endif
                        </div>
                        <span class="hidden md:inline text-gray-700 text-sm group-hover:text-purple-800 transition-colors duration-300">{{ Auth::user()->first_name }}</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 top-full mt-2 w-44 bg-white rounded-md shadow-lg py-1 z-50">
                        <!-- <a href="{{ route('profile') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-purple-100 hover:text-purple-900 transform hover:scale-[1.02] transition-all duration-200">
                            <i class="fas fa-user-circle mr-2 text-purple-700"></i> My Profile
                        </a> -->
                    </div>
                </div>
                @else
                <!-- Register Button (Moved to the Logout section) -->
                <div class="relative">
                    <a href="{{ route('register') }}" class="auth-btn bg-gradient-to-r text-white from-purple-900 to-purple-700 hover:from-purple-800 hover:to-purple-600 text-sm px-3 py-1.5 transform hover:scale-105 hover:shadow-lg flex items-center space-x-1">
                        <span><i class="fas fa-user-plus mr-1"></i> Register</span>
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar Navigation -->
<div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl z-50 transform -translate-x-full transition-transform duration-300 ease-in-out sm:hidden">
    <div class="flex items-center justify-between px-4 py-5 border-b border-gray-200">
        <a href="/" class="transform transition-all duration-300 hover:scale-110">
            <img src="{{ asset('images/logo.png') }}" alt="Fledge Logo" class="h-10 hover:brightness-110">
        </a>
        <button id="close-mobile-menu" class="text-gray-700 text-xl">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="p-4 space-y-4">
        <a href="/" class="text-gray-700">Home</a>
        <a href="/jobs" class="text-gray-700">Jobs</a>
        <a href="{{ route('login') }}" class="text-gray-700">Login</a>
        <a href="{{ route('register') }}" class="text-gray-700">Register</a>
    </div>
</div>

<!-- Mobile Menu Toggle JS -->
<script>
    const menuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('mobile-sidebar');
    const closeButton = document.getElementById('close-mobile-menu');

    menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    closeButton.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
    });
</script>