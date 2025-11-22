<x-dashboard-layout section_title="Laporan" description="Kelola data laporan">
    <button class="btn btn-primary btn-sm md:btn-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                clip-rule="evenodd" />
        </svg>
        Tambah User
    </button>
    <div class="card w-full bg-base-100 shadow-xl mt-6">
        <div class="card-body p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <!-- Head -->
                    {{-- <thead class="bg-base-200 text-base-content">
                        <tr>
                            <th>#</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="hover">
                            <th>{{ $loop->iteration }}</th>
                            <td>
                                <span class="font-bold">{{ $user->nama }}</span>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td class="text-center">
                                <div class="join">
                                    <button class="btn btn-sm btn-info join-item text-white">Edit</button>
                                    <button class="btn btn-sm btn-error join-item text-white"
                                        onclick="deleteRow(this)">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody> --}}
                </table>
            </div>
        </div>

    </div>
</x-dashboard-layout>