@extends('layouts.admin')

@section('title', 'Pengeluaran')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <h1>Pengeluaran</h1>
        <p>Catatan biaya operasional toko.</p>
    </div>

    <div class="card" style="margin-bottom:18px;">
        <div class="section-title">Tambah Pengeluaran</div>
        <form method="POST" action="{{ route('admin.expenses.store') }}" class="form-row">
            @csrf
            <input type="text" name="category" placeholder="Kategori (cth. Listrik)" required>
            <input type="number" name="amount" placeholder="Jumlah (Rp)" required>
            <input type="text" name="note" placeholder="Keterangan">
            <button type="submit" class="btn accent">Tambah</button>
        </form>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $expense->category }}</td>
                        <td>Rp{{ number_format($expense->amount, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($expense->created_at)->translatedFormat('d M Y') }}</td>
                        <td>{{ $expense->note ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:26px;">Belum ada pengeluaran tercatat</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $expenses->links() }}</div>
</div>
@endsection
