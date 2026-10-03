@extends('layouts.admin')

@section('title', 'Data Karyawan')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <h1>Data Karyawan</h1>
        <p>Daftar staf yang bertugas di operasional laundry.</p>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->role }}</td>
                        <td>{{ $employee->phone ?: '—' }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>
                            {{-- <span class="badge" data-s="{{ $employee->is_active ? 'ready' : 'pending' }}">
                                {{ $employee->is_active }}
                            </span> --}}

                            @if ($employee->is_active)
                                <span class = "badge bg-green-300 text-gray-600" >Aktif</span>
                            @else
                                <span class = "badge bg-red-300 text-gray-600">Tidak Aktif</span>
                            @endif
                        </td>
                        <td style="text-align:right;white-space:nowrap;">
                            <a href="{{ route('admin.employees.show', $employee) }}" class="btn">Detail</a>
                            <a href="{{ route('admin.employees.edit', $employee) }}" class="btn">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:26px;">Belum ada data karyawan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $employees->links() }}</div>
</div>
@endsection
