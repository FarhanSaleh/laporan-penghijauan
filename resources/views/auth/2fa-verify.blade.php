<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="emerald">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verifikasi 2FA - Laporan Penghijauan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Card Verifikasi 2FA -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <div class="flex justify-center mb-4">
                            <div class="bg-primary/10 p-4 rounded-full">
                                <i data-lucide="shield-check" class="w-12 h-12 text-primary"></i>
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-primary">Verifikasi 2FA</h1>
                        <p class="text-base-content/60 mt-2">Masukkan kode dari aplikasi authenticator Anda</p>
                    </div>

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

                    <!-- Form Verifikasi -->
                    <form action="{{ route('2fa.check') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- OTP Input -->
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Kode OTP</legend>
                            <div class="flex justify-between gap-2">
                                <input type="text" name="otp"
                                    class="input input-bordered w-full text-center text-2xl tracking-widest font-bold @error('otp') input-error @enderror"
                                    placeholder="000000" maxlength="6" pattern="\d{6}" inputmode="numeric" required
                                    autofocus />
                            </div>
                            @error('otp')
                            <p class="label text-error text-sm mt-2">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-base-content/60 mt-2">Masukkan 6 digit kode dari aplikasi
                                authenticator Anda</p>
                        </fieldset>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-full mt-6">
                            <i data-lucide="check" class="w-5 h-5"></i>
                            Verifikasi
                        </button>
                    </form>

                    <!-- Back to Login -->
                    <div class="text-center mt-6">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm link link-primary">
                                <i data-lucide="arrow-left" class="w-3 h-3 inline"></i>
                                Kembali ke Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Security Info -->
            <div class="alert alert-info mt-6">
                <i data-lucide="info"></i>
                <span class="text-sm">Jangan bagikan kode OTP Anda kepada siapa pun. Laporan Penghijauan tidak akan
                    pernah meminta kode ini.</span>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        // Auto-format OTP input
        const otpInput = document.querySelector('input[name="otp"]');
        if (otpInput) {
            otpInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/\D/g, '').substring(0, 6);
            });
        }
    </script>
</body>

</html>