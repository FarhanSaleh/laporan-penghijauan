<x-dashboard-layout section_title="Dashboard" description="Ringkasan data sistem">
    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('petugas'))
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @if (auth()->user()->hasRole('admin'))
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
        @endif

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

    <!-- Laporan Terbaru Table -->
    <div class="card bg-base-100 shadow-sm mt-6">
        <div class="card-body">
            <h2 class="card-title text-lg mb-4">Laporan Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Pelapor</th>
                            <th>Alamat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($laporan) > 0)
                        @forelse ($laporan->take(10) as $item)
                        <tr>
                            <td class="font-medium">{{ $item->judul }}</td>
                            <td>{{ $item->user->nama }}</td>
                            <td>{{ Str::limit($item->alamat, 30) }}</td>
                            <td>{{ $item->tanggal_laporan->format('d M Y') }}</td>
                            <td>
                                @php
                                $statusColor = match($item->status->name) {
                                'Pending' => 'badge-warning',
                                'Diproses' => 'badge-info',
                                'Selesai' => 'badge-success',
                                'Ditolak' => 'badge-error',
                                default => 'badge-ghost'
                                };
                                @endphp
                                <span class="badge {{ $statusColor }}">{{ $item->status->name }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500">Tidak ada laporan</td>
                        </tr>
                        @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <!-- User Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Total Laporan Card -->
        <div class="card bg-blue-50 text-base-content shadow-sm">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-3xl font-bold">{{ $totalLaporanUser ?? 0 }}</h2>
                        <p class="text-sm">Total Laporan</p>
                    </div>
                    <i data-lucide="file-text" class="w-8 h-8 text-blue-500"></i>
                </div>
            </div>
        </div>

        <!-- Laporan Pending Card -->
        <div class="card bg-yellow-50 text-base-content shadow-sm">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-3xl font-bold">{{ $laporanPending ?? 0 }}</h2>
                        <p class="text-sm">Menunggu Verifikasi</p>
                    </div>
                    <i data-lucide="clock" class="w-8 h-8 text-yellow-500"></i>
                </div>
            </div>
        </div>

        <!-- Laporan Diproses Card -->
        <div class="card bg-sky-50 text-base-content shadow-sm">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-3xl font-bold">{{ $laporanDiproses ?? 0 }}</h2>
                        <p class="text-sm">Sedang Diproses</p>
                    </div>
                    <i data-lucide="loader" class="w-8 h-8 text-sky-500"></i>
                </div>
            </div>
        </div>

        <!-- Laporan Selesai Card -->
        <div class="card bg-green-50 text-base-content shadow-sm">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-3xl font-bold">{{ $laporanSelesai ?? 0 }}</h2>
                        <p class="text-sm">Selesai</p>
                    </div>
                    <i data-lucide="check-circle" class="w-8 h-8 text-green-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Saya Terbaru Table -->
    <div class="card bg-base-100 shadow-sm mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-lg">Laporan Saya</h2>
                <a href="{{ route('dashboard.laporan.showByUser') }}" class="btn btn-sm btn-primary">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Laporan Baru
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Alamat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanUser ?? [] as $item)
                        <tr class="cursor-pointer hover:bg-base-200" onclick="window.location.href='#'">
                            <td class="font-medium">{{ $item->judul }}</td>
                            <td>{{ Str::limit($item->alamat, 25) }}</td>
                            <td>{{ $item->tanggal_laporan->format('d M Y') }}</td>
                            <td>
                                @php
                                $statusColor = match($item->status->name) {
                                'Pending' => 'badge-warning',
                                'Diproses' => 'badge-info',
                                'Selesai' => 'badge-success',
                                'Ditolak' => 'badge-error',
                                default => 'badge-ghost'
                                };
                                @endphp
                                <span class="badge {{ $statusColor }}">{{ $item->status->name }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-6">
                                <div class="flex flex-col items-center gap-2">
                                    <i data-lucide="inbox" class="w-8 h-8"></i>
                                    <span>Anda belum membuat laporan</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</x-dashboard-layout>