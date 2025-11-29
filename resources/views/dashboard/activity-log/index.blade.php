<x-dashboard-layout section_title="Log Aktivitas" description="Pantau semua aktivitas sistem">
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="card-title text-lg mb-4">Riwayat Aktivitas Semua User</h2>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Pelaku</th>
                            <th>Aksi</th>
                            <th>Deskripsi</th>
                            <th>Target</th>
                            <th>Perubahan Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                        <tr>
                            <td class="text-sm">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="font-medium">{{ $log->user->nama ?? 'Unknown' }}</td>
                            <td>
                                @php
                                $badgeColor = match($log->action) {
                                'created' => 'success',
                                'updated' => 'warning',
                                'deleted' => 'error',
                                default => 'info'
                                };
                                @endphp
                                <span class="badge badge-{{ $badgeColor }}">{{ $log->action }}</span>
                            </td>
                            <td>{{ $log->description ?? '-' }}</td>
                            <td>
                                <span class="badge badge-primary text-dark border">
                                    {{ class_basename($log->subject_type) }}
                                </span>
                                <br>
                                <small>ID: {{ $log->subject_id }}</small>
                            </td>
                            <td>
                                @if(!empty($log->properties))
                                <ul class="list-unstyled mb-0 smal-text">
                                    @foreach($log->properties as $key => $value)
                                    <li>
                                        <strong>{{ ucfirst($key) }}:</strong>
                                        @if(is_array($value))
                                        {{ json_encode($value) }}
                                        @else
                                        <span class="text-primary">{{ $value }}</span>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-6">
                                Tidak ada log aktivitas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>