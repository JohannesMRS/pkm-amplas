<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', auth()->id())
            ->orderByRaw('COALESCE(is_primary, false) DESC')
            ->latest()
            ->get();

        return view('customer.addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'full_address' => ['required', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        DB::transaction(function () use ($request, $validated) {
            $userId = auth()->id();

            // Alamat pertama otomatis jadi alamat utama
            $makePrimary = $request->boolean('is_primary') || ! Address::where('user_id', $userId)->exists();

            if ($makePrimary) {
                Address::where('user_id', $userId)->update(['is_primary' => false]);
            }

            Address::create($validated + [
                'user_id' => $userId,
                'is_primary' => $makePrimary,
            ]);
        });

        return redirect()
            ->route('customer.addresses.index')
            ->with('status', 'Alamat berhasil disimpan.');
    }

    public function setPrimary(Address $address)
    {
        $this->authorizeOwner($address);

        DB::transaction(function () use ($address) {
            Address::where('user_id', auth()->id())->update(['is_primary' => false]);
            $address->update(['is_primary' => true]);
        });

        return back()->with('status', "Alamat {$address->label} dijadikan alamat utama.");
    }

    public function destroy(Address $address)
    {
        $this->authorizeOwner($address);

        $wasPrimary = (bool) $address->is_primary;
        $address->delete();

        // Kalau yang dihapus alamat utama, promosikan alamat terbaru yang tersisa
        if ($wasPrimary) {
            Address::where('user_id', auth()->id())->latest()->first()?->update(['is_primary' => true]);
        }

        return back()->with('status', 'Alamat dihapus.');
    }

    private function authorizeOwner(Address $address): void
    {
        abort_unless($address->user_id === auth()->id(), 403);
    }
}