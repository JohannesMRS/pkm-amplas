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
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone ?: '—' }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->orders_count }}</td>
                        <td>Rp{{ number_format($customer->orders_sum_total_price ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:26px;">Belum ada pelanggan terdaftar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $customers->links() }}</div>
</div>
@endsection
