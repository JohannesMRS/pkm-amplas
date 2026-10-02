<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total_price')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    // Detail pelanggan + riwayat pesanannya
    public function show(User $customer)
    {
        $this->ensureIsCustomer($customer);

        $orders = Order::where('user_id', $customer->id)
            ->latest()
            ->paginate(10);

        return view('admin.customers.show', compact('customer', 'orders'));
    }

    public function edit(User $customer)
    {
        $this->ensureIsCustomer($customer);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $this->ensureIsCustomer($customer);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($customer->id)],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $customer->update($validated);

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with('status', "Data {$customer->name} berhasil diperbarui.");
    }

    // Nonaktifkan / aktifkan kembali akun pelanggan (bukan hapus permanen)
    public function toggleActive(User $customer)
    {
        $this->ensureIsCustomer($customer);

        $customer->update(['is_active' => ! $customer->is_active]);

        return back()->with('status', $customer->is_active
            ? "Akun {$customer->name} diaktifkan kembali."
            : "Akun {$customer->name} dinonaktifkan. Pelanggan tidak bisa login sampai diaktifkan lagi.");
    }

    private function ensureIsCustomer(User $customer): void
    {
        abort_unless($customer->role === 'customer', 404);
    }
}