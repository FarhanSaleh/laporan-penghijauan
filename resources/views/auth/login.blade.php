<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="emerald">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Laporan Penghijauan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Card Login -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold text-primary">Welcome</h1>
                        <p class="text-base-content/60 mt-2">Silakan login ke akun Anda</p>
                    </div>

                    <!-- Alert Success -->
                    @if (session('success'))
                    <div class="alert alert-success mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    <!-- Alert Error -->
                    @if ($errors->any())
                    <div class="alert alert-error mb-4">
                        <i data-lucide="circle-x"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span><br>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Form Login -->
                    <form method="POST" action="{{ url('/login') }}">
                        @csrf
                        @method("POST")
                        <!-- Email Input -->
                        <div class="form-control w-full mb-4 space-y-2">
                            <label class="label">
                                <span class="label-text font-semibold">Email</span>
                            </label>
                            <input type="email" name="email" placeholder="nama@email.com"
                                class="input input-bordered w-full" value="{{ old('email') }}" required autofocus />
                        </div>

                        <!-- Password Input -->
                        <div class="form-control w-full mb-4 space-y-2">
                            <label class="label">
                                <span class="label-text font-semibold">Password</span>
                            </label>
                            <input type="password" name="password" placeholder="Masukkan password"
                                class="input input-bordered w-full" required />
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="form-control mb-6">
                            <label class="label cursor-pointer justify-start gap-3">
                                <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm" />
                                <span class="label-text">Ingat saya</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Login
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="divider">atau</div>

                    <!-- Additional Links -->
                    <div class="text-center space-y-2">
                        <p class="text-sm text-base-content/60">
                            Belum punya akun? <a href="{{ route('register') }}" class="link link-primary font-semibold">Daftar sekarang</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>