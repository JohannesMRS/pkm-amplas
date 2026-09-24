<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Pesanan Masuk: daftar pesanan yang masih pending, menunggu ditimbang & diberi harga
    public function incoming()
    {
        $orders = Order::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        $products = Product::where('is_active', true)->get();

        return view('admin.orders.incoming', compact('orders', 'products'));
    }

    // Admin menimbang cucian, menentukan harga, dan mengirim harga ke pelanggan
    public function process(Request $request, Order $order)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'numeric', 'min:0.1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $subtotal = $product->price * $validated['quantity'];

        $order->orderDetails()->create([
            'user_id' => $order->user_id,
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'price' => $product->price,
            'subtotal' => $subtotal,
        ]);

        $order->update([
            'status' => 'proccessing',
            'total_price' => $order->orderDetails()->sum('subtotal'),
        ]);

        $order->order_status_histories()->create([
            'status' => 'proccessing',
            'changed_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.orders.incoming')
            ->with('status', "Pesanan {$order->order_numbers} diproses, harga Rp" . number_format($subtotal, 0, ',', '.') . ' dikirim ke pelanggan.');
    }

    // Daftar Transaksi: seluruh pesanan, bisa difilter berdasarkan status
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'orderDetails.products'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    // Admin mengubah status pembayaran pesanan secara manual
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => ['required', 'in:unpaid,paid,refunded'],
        ]);

        $order->update($validated);

        return back()->with('status', "Status pembayaran {$order->order_numbers} diperbarui.");
    }
}