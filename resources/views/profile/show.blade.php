<x-dashboard-layout section_title="Profil Saya" description="Kelola profil dan password">
    @if (session('success'))
    <div role="alert" class="alert alert-success mb-4">
        <i data-lucide="check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Profile Info Card --}}
        <div class="lg:col-span-1">
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body items-center text-center">
                    <div class="w-20 h-20 rounded-full bg-primary text-white flex items-center justify-center text-2xl font-bold">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold mt-4">{{ $user->nama }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    <div class="badge badge-primary mt-2">{{ $user->role->name }}</div>
                    <div class="text-xs text-gray-400 mt-4">
                        <p>Bergabung: {{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Form --}}
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body">
                    <h2 class="text-lg font-bold mb-4">Edit Profil</h2>

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Nama Lengkap</legend>
                            <input type="text" class="input input-bordered w-full @error('nama') input-error @enderror"
                                name="nama" value="{{ old('nama', $user->nama) }}" placeholder="Masukkan nama lengkap" />
                            @error('nama')
                            <p class="label text-error">{{ $message }}</p>
                            @enderror
                        </fieldset>

                        {{-- Email --}}
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Email</legend>
                            <input type="email" class="input input-bordered w-full @error('email') input-error @enderror"
                                name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan email" />
                            @error('email')
                            <p class="label text-error">{{ $message }}</p>
                            @enderror
                        </fieldset>

                        <div class="divider">Ubah Password (Opsional)</div>

                        {{-- Password --}}
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Password Baru</legend>
                            <input type="password"
                                class="input input-bordered w-full @error('password') input-error @enderror"
                                name="password" placeholder="Masukkan password baru (kosongkan jika tidak ingin mengubah)" />
                            @error('password')
                            <p class="label text-error">{{ $message }}</p>
                            @enderror
                        </fieldset>

                        {{-- Password Confirmation --}}
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Konfirmasi Password</legend>
                            <input type="password"
                                class="input input-bordered w-full @error('password_confirmation') input-error @enderror"
                                name="password_confirmation" placeholder="Ulangi password baru" />
                            @error('password_confirmation')
                            <p class="label text-error">{{ $message }}</p>
                            @enderror
                        </fieldset>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('dashboard') }}" class="btn btn-ghost">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
