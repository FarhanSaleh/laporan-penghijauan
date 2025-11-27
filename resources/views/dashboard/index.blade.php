<x-dashboard-layout section_title="Dashboard" description="Ringkasan data sistem">
    @if (auth()->user()->hasRole('admin'))
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Total User Card -->
        <div class="card bg-base-100 text-base-content shadow-sm">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-3xl font-bold">{{ $totalUsers }}</h2>
                        <p>Total Pengguna</p>
                    </div>
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <div class="mt-4 text-sm">
                    <i data-lucide="trending-up" class="w-4 h-4 inline"></i>
                    Pengguna aktif sistem
                </div>
            </div>
        </div>

        <!-- Total Laporan Card -->
        <div class="card bg-base-100 text-base-content shadow-sm">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-3xl font-bold">{{ $totalLaporan }}</h2>
                        <p>Total Laporan</p>
                    </div>
                    <i data-lucide="message-circle-warning" class="w-8 h-8"></i>
                </div>
                <div class="mt-4 text-sm">
                    <i data-lucide="file-text" class="w-4 h-4 inline"></i>
                    Laporan yang telah dibuat
                </div>
            </div>
        </div>

        <!-- Total Berita Card -->
        <div class="card bg-base-100 text-base-content shadow-sm">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-3xl font-bold">0</h2>
                        <p>Total Berita</p>
                    </div>
                    <i data-lucide="newspaper" class="w-8 h-8"></i>
                </div>
                <div class="mt-4 text-sm">
                    <i data-lucide="book-open" class="w-4 h-4 inline"></i>
                    Artikel berita publikasi
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- User Dashboard -->
    <div class="alert alert-info">
        <i data-lucide="info"></i>
        <span>Selamat datang di Laporan Penghijauan</span>
    </div>
    @endif
</x-dashboard-layout>