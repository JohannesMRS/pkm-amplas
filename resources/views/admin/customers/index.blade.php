@extends('layouts.admin')

@section('title', 'Data Pelanggan')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <h1>Data Pelanggan</h1>
        <p>Daftar pelanggan terdaftar beserta riwayat belanjanya.</p>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Jumlah Pesanan</th>
                    <th>Total Belanja</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td><a href="{{ route('admin.customers.show', $customer) }}" style="color:var(--ink);font-weight:600;">{{ $customer->name }}</a></td>
                        <td>{{ $customer->phone ?: '—' }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->orders_count }}</td>
                        <td>Rp{{ number_format($customer->orders_sum_total_price ?? 0, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge" data-s="{{ $customer->is_active ? 'ready' : 'canceled' }}">
                                {{ $customer->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td style="text-align:right;white-space:nowrap;">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn">Detail</a>
                            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:26px;">Belum ada pelanggan terdaftar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $customers->links() }}</div>
</div>
@endsection