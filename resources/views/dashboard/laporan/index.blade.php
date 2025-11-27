<x-dashboard-layout section_title="Laporan" description="Kelola data laporan">
    {{-- alert: error --}}
    @error('error')
    <div role="alert" class="alert alert-error">
        <i data-lucide="circle-x"></i>
        <span>{{ $message }}</span>
    </div>
    @enderror

    @if (auth()->user()->hasRole('user'))
    <button class="btn btn-primary" onclick="openCreateModal()">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Buat Laporan
    </button>
    @endif

    {{-- create laporan modal --}}
    <dialog id="create_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box max-w-3xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="text-lg font-bold">Tambah Laporan</h3>
            <form action="{{ route('dashboard.laporan.store') }}" method="POST" enctype="multipart/form-data"
                class="mt-4 flex flex-col">
                @csrf
                @method("POST")
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Judul</legend>
                    <input type="text" class="input w-full" placeholder="Judul Laporan" id="judul" name="judul" />
                    @error("judul")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Deskripsi</legend>
                    <textarea class="textarea w-full" placeholder="Deskripsi Laporan" id="deskripsi" name="deskripsi"
                        rows="3"></textarea>
                    @error("deskripsi")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Alamat</legend>
                    <input type="text" class="input w-full" placeholder="Alamat Lokasi" id="alamat" name="alamat" />
                    @error("alamat")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Lokasi (Klik pada peta untuk memilih)</legend>
                    <div id="map" class="w-full h-64 rounded-lg mb-2"></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <input type="text" class="input input-sm w-full" placeholder="Latitude" id="latitude"
                                name="latitude" readonly />
                        </div>
                        <div>
                            <input type="text" class="input input-sm w-full" placeholder="Longitude" id="longitude"
                                name="longitude" readonly />
                        </div>
                    </div>
                    @error("latitude")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                    @error("longitude")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Foto Laporan</legend>
                    <input type="file" class="file-input w-full" id="foto_laporan" name="foto_laporan"
                        accept="image/*" />
                    @error("foto_laporan")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Tanggal Laporan</legend>
                    <input type="date" class="input w-full" id="tanggal_laporan" name="tanggal_laporan" />
                    @error("tanggal_laporan")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <button type="submit" class="btn btn-primary self-end mt-4">Simpan</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    {{-- update laporan modal --}}
    <dialog id="update_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box max-w-3xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="text-lg font-bold">Update Laporan</h3>
            <form id="update_form" action="" method="POST" enctype="multipart/form-data" class="mt-4 flex flex-col">
                @csrf
                @method("PUT")
                <input type="hidden" id="update_id" name="id" />
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Judul</legend>
                    <input type="text" class="input w-full" placeholder="Judul Laporan" id="update_judul"
                        name="judul" />
                    @error("judul")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Deskripsi</legend>
                    <textarea class="textarea w-full" placeholder="Deskripsi Laporan" id="update_deskripsi"
                        name="deskripsi" rows="3"></textarea>
                    @error("deskripsi")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Alamat</legend>
                    <input type="text" class="input w-full" placeholder="Alamat Lokasi" id="update_alamat"
                        name="alamat" />
                    @error("alamat")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Lokasi (Klik pada peta untuk memilih)</legend>
                    <div id="update_map" class="w-full h-64 rounded-lg mb-2"></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <input type="text" class="input input-sm w-full" placeholder="Latitude" id="update_latitude"
                                name="latitude" readonly />
                        </div>
                        <div>
                            <input type="text" class="input input-sm w-full" placeholder="Longitude"
                                id="update_longitude" name="longitude" readonly />
                        </div>
                    </div>
                    @error("latitude")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                    @error("longitude")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Foto Laporan</legend>
                    <input type="file" class="file-input w-full" id="update_foto_laporan" name="foto_laporan"
                        accept="image/*" />
                    <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto</p>
                    @error("foto_laporan")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Tanggal Laporan</legend>
                    <input type="date" class="input w-full" id="update_tanggal_laporan" name="tanggal_laporan" />
                    @error("tanggal_laporan")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <button type="submit" class="btn btn-primary self-end mt-4">Simpan</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    {{-- delete laporan modal --}}
    <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Hapus Laporan</h3>
            <form id="delete_form" method="POST" class="mt-4 flex flex-col">
                @csrf
                @method("DELETE")
                <p>Anda yakin ingin menghapus laporan ini?</p>
                <button type="submit" class="btn btn-error self-end mt-4">Hapus</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <div class="card w-full bg-base-100 shadow-xl mt-6">
        <div class="card-body p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <!-- Head -->
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Alamat</th>
                            <th>Tanggal Laporan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $l)
                        <tr class="hover:bg-base-300">
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $l->judul }}</td>
                            <td>{{ $l->alamat }}</td>
                            <td>{{ $l->tanggal_laporan->format('d M Y | H:i') }}</td>
                            <td>
                                @php
                                $statusColor = match($l->status->name) {
                                'Pending' => 'badge-warning',
                                'Diproses' => 'badge-info',
                                'Selesai' => 'badge-success',
                                'Ditolak' => 'badge-error',
                                default => 'badge-ghost'
                                };
                                @endphp
                                <span class="badge {{ $statusColor }}">{{ $l->status->name }}</span>
                            </td>
                            <td class="text-center">
                                <div class="join">
                                    @if (auth()->user()->hasRole('user'))
                                    <button class="btn btn-sm btn-warning join-item text-white"
                                        onclick="openUpdateModal({{$l}})">
                                        <i data-lucide="square-pen" class="w-4 h-4"></i>
                                        Edit
                                    </button>
                                    <button class="btn btn-sm btn-error join-item text-white"
                                        onclick="openDeleteModal({{ $l->id }})">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                        Hapus
                                    </button>
                                    @endif
                                    <a href="{{ route('dashboard.laporan.showFollowup', ['id' => $l->id]) }}">
                                        <button class="btn btn-sm btn-info join-item text-white">
                                            @if (auth()->user()->hasRole('petugas'))
                                            <i data-lucide="clipboard-check" class="w-4 h-4"></i>
                                            Tindak Lanjut
                                            @else
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                            Detail
                                            @endif
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Laporan kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Leaflet CSS and JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- script --}}
    @if($errors->any() && !$errors->has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formType = "{{ session('form_type') }}"
            if (formType === "store") {
                document.getElementById('judul').value = "{{ old('judul') }}";
                document.getElementById('deskripsi').value = "{{ old('deskripsi') }}";
                document.getElementById('alamat').value = "{{ old('alamat') }}";
                document.getElementById('latitude').value = "{{ old('latitude') }}";
                document.getElementById('longitude').value = "{{ old('longitude') }}";
                document.getElementById('tanggal_laporan').value = "{{ old('tanggal_laporan') }}";
                create_modal.showModal();
                setTimeout(() => {
                    if (document.getElementById('map')) {
                        initCreateMap();
                    }
                }, 100);
            } else {
                openUpdateModal({
                    id:"{{ old('id') }}",
                    judul: "{{ old('judul') }}",
                    deskripsi: "{{ old('deskripsi') }}",
                    alamat: "{{ old('alamat') }}",
                    latitude: "{{ old('latitude') }}",
                    longitude: "{{ old('longitude') }}",
                    tanggal_laporan: "{{ old('tanggal_laporan') }}"
                })
            } 
        });
    </script>
    @endif

    <script>
        let createMap, updateMap;
        let createMarker, updateMarker;

        // Initialize map for create modal
        function initCreateMap() {
            if (createMap) {
                createMap.remove();
            }

            // Default coordinates (Jakarta)
            let defaultLat = -6.200000;
            let defaultLng = 106.816666;

            createMap = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(createMap);

            // Try to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;

                        // Center map on user's location
                        createMap.setView([userLat, userLng], 15);

                        // Optionally add a marker at user's location
                        // L.marker([userLat, userLng])
                        //     .addTo(createMap)
                        //     .bindPopup('Lokasi Anda')
                        //     .openPopup();
                    },
                    function(error) {
                        console.log('Geolocation error:', error.message);
                        // Map stays at default location
                    }
                );
            }

            createMap.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(8);
                const lng = e.latlng.lng.toFixed(8);

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                if (createMarker) {
                    createMap.removeLayer(createMarker);
                }

                createMarker = L.marker([lat, lng]).addTo(createMap);
            });
        }

        // Initialize map for update modal
        function initUpdateMap(lat, lng) {
            if (updateMap) {
                updateMap.remove();
            }

            const latitude = lat || -6.200000;
            const longitude = lng || 106.816666;

            updateMap = L.map('update_map').setView([latitude, longitude], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(updateMap);

            if (lat && lng) {
                updateMarker = L.marker([latitude, longitude]).addTo(updateMap);
            } else if (navigator.geolocation) {
                // If no coordinates provided, try to get user's location
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        updateMap.setView([userLat, userLng], 15);
                    },
                    function(error) {
                        console.log('Geolocation error:', error.message);
                    }
                );
            }

            updateMap.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(8);
                const lng = e.latlng.lng.toFixed(8);

                document.getElementById('update_latitude').value = lat;
                document.getElementById('update_longitude').value = lng;

                if (updateMarker) {
                    updateMap.removeLayer(updateMarker);
                }

                updateMarker = L.marker([lat, lng]).addTo(updateMap);
            });
        }

        // Show create modal
        function openCreateModal() {
            create_modal.showModal();
            setTimeout(() => {
                if (document.getElementById('map')) {
                    initCreateMap();
                }
            }, 100);
        }

        function openUpdateModal(laporan) {
            const form = document.getElementById('update_form');
            form.action = `/laporan/${laporan.id}`;

            document.getElementById('update_id').value = laporan.id;
            document.getElementById('update_judul').value = laporan.judul;
            document.getElementById('update_deskripsi').value = laporan.deskripsi;
            document.getElementById('update_alamat').value = laporan.alamat;
            document.getElementById('update_latitude').value = laporan.latitude;
            document.getElementById('update_longitude').value = laporan.longitude;
            document.getElementById('update_tanggal_laporan').value = laporan.tanggal_laporan;

            update_modal.showModal();

            setTimeout(() => {
                initUpdateMap(parseFloat(laporan.latitude), parseFloat(laporan.longitude));
            }, 100);
        }

        function openDeleteModal(id) {
            const form = document.getElementById('delete_form');
            form.action = `/laporan/${id}`;

            delete_modal.showModal();
        }
    </script>
</x-dashboard-layout>