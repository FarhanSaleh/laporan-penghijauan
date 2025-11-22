@props(["section_title", "description"])
<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />

        <!-- KONTEN HALAMAN -->
        <div class="drawer-content flex flex-col bg-base-200 min-h-screen">

            <!-- Navbar (Header Dashboard) -->
            <div class="navbar bg-base-100 shadow-sm lg:hidden">
                <div class="flex-none">
                    <label for="my-drawer-2" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <i data-lucide="hamburger"></i>
                    </label>
                </div>
                <div class="flex-1">
                    <a class="btn btn-ghost text-xl">Admin Panel</a>
                </div>
            </div>

            <main class="p-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $section_title }}</h1>
                    <p class="text-sm text-gray-500">{{ $description }}</p>
                </div>
                <div class="mt-6 space-y-4">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- SIDEBAR (Drawer Side) -->
        <div class="drawer-side z-20">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>

            <aside class="bg-base-100 w-64 min-h-screen flex flex-col">
                <!-- Sidebar Logo/Header -->
                <div class="h-16 flex items-center justify-center">
                    <div class="flex items-center gap-2 font-bold text-xl text-primary">
                        <i data-lucide="trees"></i>
                        <span>Laporan Penghijauan</span>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                
                <ul class="menu w-full text-base-content gap-2">
                    Menu
                    <!-- Menu 1: Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="font-medium {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                            <i data-lucide="layout-dashboard"></i>
                            Dashboard
                        </a>
                    </li>

                    <!-- Menu 2: Users -->
                    {{-- @if (auth()->user()->hasRole('admin')) --}}
                    <li>
                        <a href="{{ route('dashboard.user.index') }}"
                            class="font-medium {{ request()->routeIs('dashboard.user.*') ? 'menu-active' : '' }}">
                            <i data-lucide="users-round"></i>
                            Data Pengguna
                        </a>
                    </li>
                    {{-- @endif --}}

                    <!-- Menu 3: Laporan -->
                    <li>
                        <a href="{{ route('dashboard.laporan.index') }}"
                            class="font-medium {{ request()->routeIs('dashboard.laporan.*') ? 'menu-active' : '' }}">
                            <i data-lucide="message-circle-warning"></i>
                            Laporan
                        </a>
                    </li>

                    <!-- Menu 4: Berita -->
                    <li>
                        <a href="{{ route('dashboard.berita.index') }}"
                            class="font-medium {{ request()->routeIs('dashboard.berita.*') ? 'menu-active' : '' }}">
                            <i data-lucide="newspaper"></i>
                            Berita
                        </a>
                    </li>
                </ul>

                <div class="mt-auto bg-neutral-content h-0.5 mx-2"></div>
                <!-- User Profile Bottom -->
                <div class=" mb-4 p-2">
                    <div class="dropdown dropdown-top w-full">
                        <div tabindex="0" role="button"
                            class="flex gap-2 items-center py-2 px-4 rounded-sm hover:cursor-pointer hover:bg-base-300">
                            <i data-lucide="user-round"></i>
                            <div class="font-semibold text-sm line-clamp-1">
                                {{ auth()->user()->nama }} | {{ auth()->user()->role->name }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <ul tabindex="-1"
                                class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-md border border-dashed gap-2">
                                <li><a class="btn">Profile</a></li>
                                <li>
                                    <button class="btn btn-soft btn-error">Logout</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </aside>

        </div>
    </div>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>