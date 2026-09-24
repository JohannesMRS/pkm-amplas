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
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->role }}</td>
                        <td>{{ $employee->phone ?: '—' }}</td>
                        <td>
                            <span class="badge" data-s="{{ $employee->status === 'Aktif' ? 'ready' : 'pending' }}">
                                {{ $employee->status }}
                            </span>
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
