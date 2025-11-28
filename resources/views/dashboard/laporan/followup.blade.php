<x-dashboard-layout section_title="Tindak Lanjut Laporan" description="Lakukan tindak lanjut laporan">
    <div class="mb-4">
        @if (auth()->user()->hasRole('admin'))
        <a href="{{ route('dashboard.laporan.index') }}" class="btn btn-ghost btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
        @elseif (auth()->user()->hasRole('petugas'))
        <a href="{{ route('dashboard.laporan.petugas') }}" class="btn btn-ghost btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
        @elseif (auth()->user()->hasRole('user'))
        <a href="{{ route('dashboard.laporan.showByUser') }}" class="btn btn-ghost btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
        @else
        <a href="{{ route('dashboard.laporan.index') }}" class="btn btn-ghost btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
        @endif
    </div>

    <div class="grid xl:grid-cols-4 gap-4">
        <div class="card bg-base-100 shadow-sm xl:col-span-3">
            <div class="card-body">
                {{-- Display report info --}}
                <div class="bg-base-200 p-4 rounded-lg border border-gray-200 space-y-4">
                    <h4 class="font-semibold">Informasi Laporan</h4>
                    <div class="grid sm:grid-cols-2 gap-2 text-sm">
                        <div>
                            <span class="text-gray-500">Judul:</span>
                            <span id="followup_judul" class="font-medium ml-1">{{ $laporan->judul }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Pelapor:</span>
                            <span id="followup_pelapor" class="font-medium ml-1">{{ $laporan->user->nama }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Tanggal:</span>
                            <span id="followup_tanggal" class="font-medium ml-1">{{ $laporan->tanggal_laporan->format('d
                                M Y | H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Status Saat Ini:</span>
                            @php
                            $statusColor = match($laporan->status->name) {
                            'Pending' => 'badge-warning',
                            'Diproses' => 'badge-info',
                            'Selesai' => 'badge-success',
                            'Ditolak' => 'badge-error',
                            default => 'badge-ghost'
                            };
                            @endphp
                            <span id="followup_status_current"
                                class="badge {{ $statusColor }} ml-1">{{$laporan->status->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Alamat:</span>
                            <span id="followup_status_current" class="font-medium ml-1">{{ $laporan->alamat }}</span>
                        </div>
                    </div>
                    <hr class="text-gray-300">
                    <div>
                        <div class="text-gray-500">Deskripsi:</div>
                        <div id="followup_deskripsi">{{ $laporan->deskripsi }}</div>
                    </div>
                    <hr class="text-gray-300">
                    <div>
                        <div class="text-gray-500 mb-2">Lokasi di peta</div>
                        <div id="detail_map" class="w-full h-96 rounded-lg"></div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-2 text-sm">
                        <div>
                            <span class="text-gray-500">Latitude:</span>
                            <span id="followup_status_current" class="font-medium ml-1">{{ $laporan->latitude
                                }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Longitude:</span>
                            <span id="followup_status_current" class="font-medium ml-1">{{ $laporan->longitude }}</span>
                        </div>
                    </div>
                </div>

                {{-- Foto Laporan --}}
                <div class="bg-base-200 p-4 rounded-lg border border-gray-200">
                    <h4 class="font-semibold mb-3">Foto Laporan <span class="font-normal text-gray-500">(klik gambar
                            untuk melihat lebih jelas)</span></h4>
                    <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="{{ $laporan->judul }}"
                        class="w-full max-h-96 object-cover rounded-lg border border-gray-300 cursor-pointer"
                        onclick="window.open(this.src, '_blank')">
                </div>

                {{-- History Tindak Lanjut --}}
                @if ($laporan->tindakLanjut && $laporan->tindakLanjut->count() > 0)
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <h4 class="font-semibold mb-3 text-blue-900">Riwayat Tindak Lanjut</h4>
                    <div class="space-y-3">
                        @foreach ($laporan->tindakLanjut->sortByDesc('created_at') as $tindak)
                        <div class="bg-white p-3 rounded-lg border-l-4 border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">{{ $tindak->user->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ $tindak->tanggal_laporan->format('d M Y | H:i')
                                        }}
                                    </p>
                                </div>
                                @if ($tindak->foto_bukti)
                                <a href="{{ asset('storage/' . $tindak->foto_bukti) }}" target="_blank"
                                    class="text-xs link link-primary">Lihat Foto</a>
                                @endif
                            </div>
                            <div class="bg-gray-50 p-2 rounded">
                                <div class="text-gray-500">Catatan:</div>
                                <p class="text-sm">{{ $tindak->catatan }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <i data-lucide="info"></i>
                    <span>Belum ada tindak lanjut untuk laporan ini</span>
                </div>
                @endif
            </div>
        </div>
        @if (auth()->user()->hasRole('petugas'))
        <div class="card bg-base-100 shadow-sm self-start sticky top-4">
            <div class="card-body">
                <h2 class="text-xl font-semibold">Form Tindak Lanjut</h2>
                <form id="followup_form" action="{{ route('dashboard.laporan.followup', ['id' => $laporan->id]) }}"
                    method="POST" enctype="multipart/form-data" class="flex flex-col space-y-4">
                    @csrf
                    @method("POST")
                    {{-- Status selection --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Ubah Status</legend>
                        <select class="select select-bordered w-full" id="followup_status" name="status_id" required>
                            <option value="" selected disabled>Pilih Status</option>
                            @foreach ($statusLaporan as $status)
                            <option value="{{ $status->id }}">{{$status->name}}</option>
                            @endforeach
                        </select>
                        @error("status_id")
                        <p class="label text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    {{-- Notes --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Catatan Tindak Lanjut</legend>
                        <textarea class="textarea textarea-bordered w-full"
                            placeholder="Masukkan catatan atau alasan perubahan status..." id="followup_catatan"
                            name="catatan" rows="4">{{ old('catatan') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Catatan ini akan membantu pelapor memahami status laporan
                        </p>
                        @error("catatan")
                        <p class="label text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    {{-- Foto Bukti --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Foto Bukti (Opsional)</legend>
                        <input type="file" class="file-input file-input-bordered w-full" id="followup_foto_bukti"
                            name="foto_bukti" accept="image/*" />
                        <p class="text-xs text-gray-500 mt-1">Upload foto bukti tindak lanjut jika diperlukan</p>
                        @error("foto_bukti")
                        <p class="label text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <button type="submit" class="btn btn-primary mt-4">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        Simpan Tindak Lanjut
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        let detailMap;
        let detailMarker;

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                initDetailMap(parseFloat("{{ $laporan->latitude }}"), parseFloat("{{ $laporan->longitude }}"));
            }, 100);
        });

        function initDetailMap(lat, lng) {
            if (detailMap) {
                detailMap.remove();
            }

            detailMap = L.map('detail_map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(detailMap);

            // Add marker at the location
            detailMarker = L.marker([lat, lng])
                .addTo(detailMap)
                .bindPopup('Lokasi Laporan')
                .openPopup();
        }
    </script>
</x-dashboard-layout>