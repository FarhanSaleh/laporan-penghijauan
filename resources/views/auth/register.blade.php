<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="emerald">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - Laporan Penghijauan</title>

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
                        <h1 class="text-3xl font-bold text-primary">Daftar Akun</h1>
                        <p class="text-base-content/60 mt-2">Buat akun baru untuk melaporkan penghijauan</p>
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

                    <!-- Form Register -->
                    <form method="POST" action="{{ url('/register') }}">
                        @csrf
                        @method("POST")

                        <!-- Nama Input -->
                        <div class="form-control w-full mb-4 space-y-2">
                            <label class="label">
                                <span class="label-text font-semibold">Nama Lengkap</span>
                            </label>
                            <input type="text" name="nama" placeholder="Nama lengkap Anda"
                                class="input input-bordered w-full @error('nama') input-error @enderror"
                                value="{{ old('nama') }}" required autofocus />
                            @error('nama')
                            <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="form-control w-full mb-4 space-y-2">
                            <label class="label">
                                <span class="label-text font-semibold">Email</span>
                            </label>
                            <input type="email" name="email" placeholder="nama@email.com"
                                class="input input-bordered w-full @error('email') input-error @enderror"
                                value="{{ old('email') }}" required />
                            @error('email')
                            <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-control w-full mb-4 space-y-2">
                            <label class="label">
                                <span class="label-text font-semibold">Password</span>
                            </label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter"
                                class="input input-bordered w-full @error('password') input-error @enderror" required />
                            @error('password')
                            <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Confirmation Input -->
                        <div class="form-control w-full mb-6 space-y-2">
                            <label class="label">
                                <span class="label-text font-semibold">Konfirmasi Password</span>
                            </label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password"
                                class="input input-bordered w-full @error('password_confirmation') input-error @enderror"
                                required />
                            @error('password_confirmation')
                            <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Daftar
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="divider">atau</div>

                    <!-- Additional Links -->
                    <div class="text-center space-y-2">
                        <p class="text-sm text-base-content/60">
                            Sudah punya akun? <a href="{{ route('login') }}"
                                class="link link-primary font-semibold">Login di sini</a>
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