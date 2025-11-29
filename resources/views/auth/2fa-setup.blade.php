<x-dashboard-layout section_title="Autentikasi Dua Langkah" description="Kelola pengaturan keamanan 2FA">
    <div class="mb-4">
        <a href="{{ route('profile.show') }}" class="btn btn-ghost btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
    </div>
    <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Nonaktifkan 2FA</h3>
            <form id="delete_form" method="POST" class="mt-4 flex flex-col">
                @csrf
                @method("POST")
                <p>Menonaktifkan 2FA akan mengurangi keamanan akun anda</p>
                <input type="hidden" name="current_password" id="current_password">
                <button type="submit" class="btn btn-error self-end mt-4">Nonaktifkan</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    @if ($isTwoFactorEnabled)
    <!-- 2FA Already Enabled - Disable Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Status Section -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-sm border-2 border-success">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="badge badge-success gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            Aktif
                        </div>
                        <h2 class="card-title">Autentikasi Dua Langkah Sudah Diaktifkan</h2>
                    </div>

                    <!-- Status Info -->
                    <div class="alert alert-success mb-4">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                        <span>Akun Anda sudah dilindungi dengan autentikasi dua langkah. Anda akan diminta memasukkan
                            kode OTP saat login.</span>
                    </div>

                    <!-- Security Info -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold mb-2">Aplikasi yang Terhubung</h3>
                            <p class="text-sm text-base-content/70 mb-3">Gunakan salah satu aplikasi di bawah untuk
                                generate kode OTP:</p>
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2 text-sm">
                                    <i data-lucide="smartphone" class="w-4 h-4 text-primary"></i>
                                    Google Authenticator
                                </li>
                                <li class="flex items-center gap-2 text-sm">
                                    <i data-lucide="smartphone" class="w-4 h-4 text-primary"></i>
                                    Microsoft Authenticator
                                </li>
                                <li class="flex items-center gap-2 text-sm">
                                    <i data-lucide="smartphone" class="w-4 h-4 text-primary"></i>
                                    Authy
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disable 2FA Section -->
        <div>
            <div class="card bg-error/10 shadow-sm sticky top-4">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4 text-error">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                        Nonaktifkan 2FA
                    </h2>

                    <!-- Error Alert -->
                    @if ($errors->any())
                    <div class="alert alert-error mb-4">
                        <i data-lucide="circle-x"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                            <span class="text-sm">{{ $error }}</span><br>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Warning Alert -->
                    <div class="alert alert-warning mb-4">
                        <i data-lucide="alert-circle"></i>
                        <span class="text-sm">Menonaktifkan 2FA akan mengurangi keamanan akun Anda.</span>
                    </div>

                    <!-- Disable Form -->
                    <div class="space-y-4">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend text-sm">Konfirmasi Password</legend>
                            <input type="password" id="password_input"
                                class="input input-bordered w-full @error('current_password') input-error @enderror"
                                placeholder="Masukkan password Anda" required />
                            @error('current_password')
                            <p class="label text-error text-sm">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-base-content/60 mt-2">Masukkan password untuk konfirmasi</p>
                        </fieldset>

                        <button class="btn btn-error w-full" onclick="openDeleteModal()">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            Nonaktifkan 2FA
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- 2FA Not Enabled - Setup Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- QR Code Section -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">
                        <i data-lucide="qr-code" class="w-5 h-5"></i>
                        Langkah 1: Scan QR Code
                    </h2>

                    <!-- Instructions -->
                    <div class="alert alert-info mb-4">
                        <i data-lucide="info"></i>
                        <span>Gunakan aplikasi Google Authenticator, Authy, atau Microsoft Authenticator untuk scan QR
                            code di bawah ini.</span>
                    </div>

                    <!-- QR Code Display -->
                    <div class="flex justify-center bg-base-200 p-8 rounded-lg mb-4">
                        <img src="{!! $qrCodeUrl !!}" alt="2FA QR Code" class="w-64 h-64">
                    </div>

                    <!-- Manual Key Input -->
                    <div class="divider">atau</div>

                    <div class="mb-4">
                        <p class="text-sm text-base-content/70 mb-2">Jika Anda tidak bisa scan QR code, masukkan kunci
                            manual di bawah ke aplikasi Anda:</p>
                        <div class="flex items-center gap-2">
                            <input type="text" value="{{ $secretKey }}"
                                class="input input-bordered flex-1 font-mono text-sm" readonly>
                            <button type="button" class="btn btn-ghost btn-square" onclick="copyToClipboard()">
                                <i data-lucide="copy" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Form Section -->
        <div>
            <div class="card bg-base-100 shadow-sm sticky top-4">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Langkah 2: Verifikasi
                    </h2>

                    <!-- Error Alert -->
                    @if ($errors->any())
                    <div class="alert alert-error mb-4">
                        <i data-lucide="circle-x"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                            <span class="text-sm">{{ $error }}</span><br>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Verification Form -->
                    <form action="{{ route('2fa.enable') }}" method="POST" class="space-y-4">
                        @csrf

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Kode Verifikasi</legend>
                            <input type="text" name="otp"
                                class="input input-bordered w-full text-center text-2xl tracking-widest font-bold @error('otp') input-error @enderror"
                                placeholder="000000" maxlength="6" pattern="\d{6}" inputmode="numeric" required
                                autofocus />
                            @error('otp')
                            <p class="label text-error text-sm">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-base-content/60 mt-2">Masukkan 6 digit kode dari aplikator Anda</p>
                        </fieldset>

                        <button type="submit" class="btn btn-primary w-full">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                            Aktifkan 2FA
                        </button>
                    </form>

                    <!-- Security Warning -->
                    <div class="alert alert-warning mt-4">
                        <i data-lucide="alert-circle"></i>
                        <span class="text-xs">Simpan backup code Anda yang akan ditampilkan setelah aktivasi.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
        <div class="card bg-success/10">
            <div class="card-body">
                <h3 class="card-title text-base mb-2">
                    <i data-lucide="shield-check" class="w-5 h-5 text-success"></i>
                    Lebih Aman
                </h3>
                <p class="text-sm text-base-content/70">Perlindungan ekstra dengan kode yang berubah setiap 30 detik.
                </p>
            </div>
        </div>

        <div class="card bg-primary/10">
            <div class="card-body">
                <h3 class="card-title text-base mb-2">
                    <i data-lucide="smartphone" class="w-5 h-5 text-primary"></i>
                    Mudah Digunakan
                </h3>
                <p class="text-sm text-base-content/70">Cukup buka aplikasi dan masukkan kode saat login.</p>
            </div>
        </div>

        <div class="card bg-info/10">
            <div class="card-body">
                <h3 class="card-title text-base mb-2">
                    <i data-lucide="key" class="w-5 h-5 text-info"></i>
                    Backup Code
                </h3>
                <p class="text-sm text-base-content/70">Simpan backup code untuk akses jika hilang akses ke aplikasi.
                </p>
            </div>
        </div>
    </div>
    @endif
</x-dashboard-layout>

<script>
    function openDeleteModal() {
        const form = document.getElementById('delete_form');
        const pw = document.getElementById('password_input').value;
        document.getElementById('current_password').value = pw;
        form.action = `/2fa/disable`;
        
        delete_modal.showModal();
    }
    // Auto-format OTP input
    const otpInput = document.querySelector('input[name="otp"]');
    if (otpInput) {
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').substring(0, 6);
        });
    }

    // Copy secret key to clipboard
    function copyToClipboard() {
        const secretInput = document.querySelector('input[readonly]');
        if (secretInput) {
            secretInput.select();
            document.execCommand('copy');
            
            const button = event.target.closest('button');
            const originalContent = button.innerHTML;
            button.innerHTML = '<i data-lucide="check" class="w-5 h-5"></i>';
            lucide.createIcons();
            
            setTimeout(() => {
                button.innerHTML = originalContent;
                lucide.createIcons();
            }, 2000);
        }
    }

    // Copy backup codes to clipboard
    function copyBackupCodes() {
        const modal = document.getElementById('backup-codes-modal');
        const codesDiv = modal.querySelector('.bg-base-200');
        const text = codesDiv.innerText;
        
        navigator.clipboard.writeText(text).then(() => {
            const button = event.target;
            const originalContent = button.innerHTML;
            button.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i> Tersalin!';
            lucide.createIcons();
            
            setTimeout(() => {
                button.innerHTML = originalContent;
                lucide.createIcons();
            }, 2000);
        });
    }
</script>