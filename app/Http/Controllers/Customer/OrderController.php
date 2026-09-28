<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();

        $addresses = Address::where('user_id', auth()->id())
            ->orderByRaw('COALESCE(is_primary, false) DESC')
            ->latest()
            ->get();

        return view('customer.orders.create', compact('products', 'addresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'address_id' => ['required', Rule::exists('addresses', 'id')->where('user_id', auth()->id())],
            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
            'delivery_date' => ['required', 'date', 'after_or_equal:pickup_date'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $address = Address::findOrFail($validated['address_id']);

        // Tabel orders tidak punya kolom layanan/alamat, jadi keduanya dicatat di note
        $note = "Layanan: {$product->name}\nAlamat jemput: {$address->label} - {$address->full_address}";
        if (! empty($validated['note'])) {
            $note .= "\nCatatan: {$validated['note']}";
        }

        $order = DB::transaction(function () use ($validated, $note) {
            do {
                $number = 'LK-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
            } while (Order::where('order_numbers', $number)->exists());

            $order = Order::create([
                'order_numbers' => $number,
                'user_id' => auth()->id(),
                'pickup_date' => $validated['pickup_date'],
                'delivery_date' => $validated['delivery_date'],
                'note' => $note,
            ]);

            $order->order_status_histories()->create([
                'status' => 'pending',
                'changed_by' => auth()->id(),
            ]);

            return $order;
        });

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('status', "Pesanan {$order->order_numbers} berhasil dibuat. Kurir akan segera menjemput cucianmu.");
    }

    public function show(Order $order)
    {
        $this->authorizeOwner($order);

        $order->load([
            'orderDetails.products',
            'payments',
            'order_status_histories' => fn ($query) => $query->orderBy('created_at'),
        ]);

        return view('customer.orders.show', compact('order'));
    }

    // Customer hanya boleh membatalkan pesanan miliknya yang masih pending
    public function cancel(Order $order)
    {
        $this->authorizeOwner($order);

        if ($order->status !== 'pending') {
            return back()->withErrors(['cancel' => 'Pesanan yang sudah diproses tidak dapat dibatalkan.']);
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'canceled']);

            $order->order_status_histories()->create([
                'status' => 'canceled',
                'changed_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('customer.orders.index')
            ->with('status', "Pesanan {$order->order_numbers} dibatalkan.");
    }

    // Upload bukti transfer; status lunas tetap dikonfirmasi admin
    public function uploadPaymentProof(Request $request, Order $order)
    {
        $this->authorizeOwner($order);

        $request->validate([
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        if ($order->status === 'canceled' || $order->payment_status !== 'unpaid' || $order->total_price <= 0) {
            return back()->withErrors(['proof' => 'Pesanan ini belum bisa dibayar.']);
        }

        $path = $request->file('proof')->store('payment-proofs', 'public');
        $payment = $order->payments()->latest()->first();

        if ($payment) {
            if ($payment->proof) {
                Storage::disk('public')->delete($payment->proof);
            }

            $payment->update([
                'amount' => $order->total_price,
                'method' => 'transfer',
                'proof' => $path,
            ]);
        } else {
            $order->payments()->create([
                'amount' => $order->total_price,
                'method' => 'transfer',
                'proof' => $path,
            ]);
        }

        return back()->with('status', 'Bukti pembayaran terkirim. Admin akan segera mengonfirmasi.');
    }

    private function authorizeOwner(Order $order): void
    {
        abort_unless($order->user_id === auth()->id(), 403);
    }
}