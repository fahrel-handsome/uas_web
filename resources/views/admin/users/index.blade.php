@extends('layout')
@section('title', 'Kelola User — Admin CerdasFin')

@section('content')
<div class="container-cf py-10">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="btn-ghost text-sm">← Admin Panel</a>
        <h1 class="text-2xl font-bold text-rich-black">👥 Kelola User</h1>
        <div class="ml-auto badge-gray">{{ $users->total() }} user</div>
    </div>

    <div class="card">
        <table class="table-cf">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Poin</th>
                    <th>Kursus</th>
                    <th>Sertifikat</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center gap-2">
                            <div class="avatar w-8 h-8 text-xs flex-shrink-0">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <span class="font-medium text-rich-black">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-xs">{{ $user->email }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.role', $user) }}" class="inline">
                            @csrf @method('PATCH')
                            <select name="role" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded-lg px-2 py-1 bg-white">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="mentor" {{ $user->role === 'mentor' ? 'selected' : '' }}>Mentor</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td class="font-bold text-deep-fern-green">{{ $user->userPoints?->total_points ?? 0 }}</td>
                    <td>{{ $user->progress_data_count ?? 0 }}</td>
                    <td>{{ $user->certificates_count ?? 0 }}</td>
                    <td class="text-xs">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-deep-fern-green text-xs hover:underline">Detail</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs hover:underline">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection
