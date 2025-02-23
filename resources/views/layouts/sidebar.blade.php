<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media (max-width: 1024px) {
            .sidebar-hidden {
                transform: translateX(-100%);
            }
            .content-shifted {
                margin-left: 0;
            }
        }
        .toggle-button {
            transition: all 0.3s ease;
        }
        .toggle-button.active {
            transform: translateX(250px);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Mobile Toggle Button -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-white lg:hidden">
        <div class="flex items-center p-4">
            <button id="sidebarToggle" class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-bars text-xl text-gray-600"></i>
            </button>
            <span class="ml-4 text-lg font-semibold text-gray-800">User Dashboard</span>
        </div>
    </div>

    <!-- Enhanced Sidebar -->
    <aside id="sidebar" class="w-72 bg-white shadow-xl fixed h-screen flex flex-col transition-all duration-300 ease-in-out z-40 lg:translate-x-0 sidebar-hidden">
        <!-- Logo Section -->
        <div class="px-6 py-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-user text-2xl text-blue-600"></i>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                        UserDashboard
                    </h1>
                </div>
                <button id="closeSidebar" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-times text-lg text-gray-500"></i>
                </button>
            </div>
        </div>
        
        <!-- Navigation Section -->
        <nav class="flex-1 py-4 px-4 overflow-y-auto">
            <!-- Main Navigation -->
            <div class="space-y-2">
                <h2 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                    Main Menu
                </h2>
                
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-home text-lg w-8 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('userprofile') }}"
                    class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group {{ request()->routeIs('userprofile') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-user text-lg w-8 {{ request()->routeIs('userprofile') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                    <span class="font-medium">Profile</span>
                </a>
            </div>

            <!-- Certifications Section -->
            <div class="mt-6 space-y-2">
                <h2 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                    Certifications
                </h2>

                <a href="{{route('addcertify')}}"
                    class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group {{ request()->routeIs('add.certification') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-plus-circle text-lg w-8 {{ request()->routeIs('add.certification') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                    <span class="font-medium">Add Certification</span>
                </a>

                <a href="{{route('viewcertify')}}"
                    class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group {{ request()->routeIs('view.certification') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-award text-lg w-8 {{ request()->routeIs('view.certification') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                    <span class="font-medium">View Certifications</span>
                </a>

                <a href="{{route('userintern')}}"
                    class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group {{ request()->routeIs('view.certification') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-certificate text-lg w-8 {{ request()->routeIs('view.certification') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                    <span class="font-medium">Available Internships</span>
                </a>

            </div>
        </nav>

        <!-- Footer Section -->
        <div class="border-t border-gray-100 p-4">
            <a href="{{ route('logout') }}"
                class="flex items-center px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 group">
                <i class="fas fa-sign-out-alt text-lg w-8 text-red-400 group-hover:text-red-600"></i>
                <span class="font-medium">Logout</span>
            </a>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    <!-- Main Content -->
    <main id="mainContent" class="transition-all duration-300 lg:ml-72">
        <!-- Content wrapper with mobile header spacing -->
        <div class="pt-16 lg:pt-8 px-4 lg:px-8">
            @yield('content')
        </div>
    </main>

    <script>
        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const closeSidebar = document.getElementById('closeSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        // Toggle Functions
        function showSidebar() {
            sidebar.classList.remove('sidebar-hidden');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            sidebarToggle.classList.add('active');
        }

        function hideSidebar() {
            sidebar.classList.add('sidebar-hidden');
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
            sidebarToggle.classList.remove('active');
        }

        // Event Listeners
        sidebarToggle.addEventListener('click', () => {
            if (sidebar.classList.contains('sidebar-hidden')) {
                showSidebar();
            } else {
                hideSidebar();
            }
        });
        
        closeSidebar.addEventListener('click', hideSidebar);
        overlay.addEventListener('click', hideSidebar);

        // Handle resize events
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
                sidebarToggle.classList.remove('active');
            } else {
                if (!sidebar.classList.contains('sidebar-hidden')) {
                    overlay.classList.remove('hidden');
                }
            }
        });

        // Close sidebar when clicking a link (mobile)
        const sidebarLinks = sidebar.getElementsByTagName('a');
        Array.from(sidebarLinks).forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    hideSidebar();
                }
            });
        });
    </script>
</body>
</html>