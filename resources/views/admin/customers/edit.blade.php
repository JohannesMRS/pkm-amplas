@extends('layouts.admin')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <h1>Edit Pelanggan</h1>
        <p>Perbarui data kontak {{ $customer->name }}.</p>
    </div>

    @if ($errors->any())
        <div style="margin-bottom:16px;font-size:13.5px;font-weight:600;color:var(--canceled);background:var(--canceled-bg);border-radius:8px;padding:10px 14px;">
            <ul style="margin:0;padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="max-width:520px;">
        <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
            @csrf
            @method('PATCH')

            <div class="field" style="margin-bottom:14px;">
                <label style="display:block;font-size:12.5px;font-weight:600;color:var(--muted);margin-bottom:5px;">Nama</label>
                <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                       style="width:100%;padding:9px 11px;border-radius:8px;border:1px solid var(--line);background:var(--bg);font-size:13.5px;">
            </div>

            <div class="field" style="margin-bottom:14px;">
                <label style="display:block;font-size:12.5px;font-weight:600;color:var(--muted);margin-bottom:5px;">Email</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}" required
                       style="width:100%;padding:9px 11px;border-radius:8px;border:1px solid var(--line);background:var(--bg);font-size:13.5px;">
            </div>

            <div class="field" style="margin-bottom:14px;">
                <label style="display:block;font-size:12.5px;font-weight:600;color:var(--muted);margin-bottom:5px;">No. HP</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required
                       style="width:100%;padding:9px 11px;border-radius:8px;border:1px solid var(--line);background:var(--bg);font-size:13.5px;">
            </div>

            <div class="field" style="margin-bottom:18px;">
                <label style="display:block;font-size:12.5px;font-weight:600;color:var(--muted);margin-bottom:5px;">Alamat</label>
                <textarea name="address" style="width:100%;padding:9px 11px;border-radius:8px;border:1px solid var(--line);background:var(--bg);font-size:13.5px;min-height:70px;">{{ old('address', $customer->address) }}</textarea>
            </div>

            <button type="submit" class="btn primary">Simpan Perubahan</button>
            <a href="{{ route('admin.customers.show', $customer) }}" class="btn">Batal</a>
        </form>
    </div>
</div>
@endsection