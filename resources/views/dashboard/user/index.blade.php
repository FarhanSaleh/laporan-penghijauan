<x-dashboard-layout section_title="User" description="Kelola data user">
    {{-- alert: error --}}
    @error('error')
    <div role="alert" class="alert alert-error">
        <i data-lucide="circle-x"></i>
        <span>{{ $message }}</span>
    </div>
    @enderror

    <button class="btn btn-primary" onclick="create_modal.showModal()">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah User
    </button>

    {{-- create user modal --}}
    <dialog id="create_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="text-lg font-bold">Tambah User</h3>
            <form action="{{ route('dashboard.user.store') }}" method="POST" class="mt-4 flex flex-col">
                @csrf
                @method("POST")
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Nama</legend>
                    <input type="text" class="input w-full" placeholder="Nama" id="nama" name="nama" />
                    @error("nama")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Email</legend>
                    <input type="text" class="input w-full" placeholder="Email" id="email" name="email" />
                    @error("email")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Role</legend>
                    <select class="select w-full" name="role_id">
                        <option disabled selected>Pilih Role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error("role_id")
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

    {{-- update user modal --}}
    <dialog id="update_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="text-lg font-bold">Update User</h3>
            <form id="update_form" action="" method="POST" class="mt-4 flex flex-col">
                @csrf
                @method("PUT")
                <input type="hidden" id="update_id" name="id" />
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Nama</legend>
                    <input type="text" class="input w-full" placeholder="Nama" id="update_nama" name="nama" />
                    @error("nama")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Email</legend>
                    <input type="text" class="input w-full" placeholder="Email" id="update_email" name="email" />
                    @error("email")
                    <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Role</legend>
                    <select class="select w-full" name="role_id" id="update_role_id">
                        <option disabled selected>Pilih Role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error("role_id")
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

    {{-- delete user modal --}}
    <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Hapus User</h3>
            <form id="delete_form" method="POST" class="mt-4 flex flex-col">
                @csrf
                @method("DELETE")
                <p>Anda yakin ingin menghapus data ini?</p>
                <button type="submit" class="btn btn-error self-end mt-4">Hapus</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    {{-- table --}}
    <div class="card w-full bg-base-100 shadow-xl">
        <div class="card-body p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <!-- Head -->
                    <thead>
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
                        <tr class="hover:bg-base-300">
                            <th>{{ $loop->iteration }}</th>
                            <td> {{ $user->nama }} </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td class="text-center">
                                <div class="join">
                                    <button class="btn btn-sm btn-warning join-item text-white"
                                        onclick="openUpdateModal({{$user}})">
                                        <i data-lucide="square-pen" class="w-4 h-4"></i>
                                        Edit
                                    </button>
                                    <button class="btn btn-sm btn-error join-item text-white"
                                        onclick="openDeleteModal({{ $user->id }})">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- script --}}
    @if($errors->any() && !$errors->has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formType = "{{ session('form_type') }}"
            if (formType === "store") {
                create_modal.showModal();
            } else {
                openUpdateModal({
                    id:"{{ old('id') }}", 
                    nama: "{{ old('nama') }}", 
                    email: "{{ old('email') }}", 
                    role_id: "{{ old('role_id') }}",
                })    
            }
        });
    </script>
    @endif
    <script>
        function openUpdateModal(user) {
            const form = document.getElementById('update_form');
            form.action = `/user/${user.id}`;
            
            document.getElementById('update_id').value = user.id;
            document.getElementById('update_nama').value = user.nama;
            document.getElementById('update_email').value = user.email;
            document.getElementById('update_role_id').value = user.role_id;
            update_modal.showModal();
        }
        function openDeleteModal(id) {
            const form = document.getElementById('delete_form');
            form.action = `/user/${id}`;
            
            delete_modal.showModal();
        }
    </script>
</x-dashboard-layout>