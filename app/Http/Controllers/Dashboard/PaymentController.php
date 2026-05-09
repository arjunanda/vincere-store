<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use DashboardHelpers;

    public function index()
    {
        $payments = PaymentMethod::orderBy('type')->paginate(10);
        return view('dashboard.payments.index', compact('payments'));
    }

    public function create()
    {
        return view('dashboard.payments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'           => 'required|in:ewallet,bank,qris',
            'name'           => 'required|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'account_name'   => 'nullable|string|max:255',
            'fee'            => 'required|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'qris_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'bank_name'      => 'nullable|string|max:100',
        ]);

        $data['code'] = \Illuminate\Support\Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadAndCompressImage($request->file('image'), 'payments');
        }

        if ($request->hasFile('qris_image')) {
            $data['qris_image'] = $this->uploadAndCompressImage($request->file('qris_image'), 'qris');
        }

        PaymentMethod::create($data);

        \Illuminate\Support\Facades\Cache::forget('active_payment_methods');

        return redirect()->route('dashboard.payments')->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function edit(PaymentMethod $payment)
    {
        return view('dashboard.payments.edit', compact('payment'));
    }

    public function update(Request $request, PaymentMethod $payment)
    {
        $data = $request->validate([
            'type'           => 'required|in:ewallet,bank,qris',
            'name'           => 'required|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'account_name'   => 'nullable|string|max:255',
            'fee'            => 'required|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'qris_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'bank_name'      => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadAndCompressImage($request->file('image'), 'payments');
        }

        if ($request->hasFile('qris_image')) {
            $data['qris_image'] = $this->uploadAndCompressImage($request->file('qris_image'), 'qris');
        }

        $payment->update($data);

        \Illuminate\Support\Facades\Cache::forget('active_payment_methods');

        return redirect()->route('dashboard.payments')->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    public function toggleStatus(PaymentMethod $payment)
    {
        $payment->update(['is_active' => !$payment->is_active]);
        $status = $payment->is_active ? 'diaktifkan' : 'dinonaktifkan';
        \Illuminate\Support\Facades\Cache::forget('active_payment_methods');

        $msg = "Metode $payment->name berhasil $status!";
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => $msg, 'is_active' => $payment->is_active]);
        }
        return back()->with('success', $msg);
    }

    public function destroy(PaymentMethod $payment)
    {
        $name = $payment->name;
        $payment->delete();
        \Illuminate\Support\Facades\Cache::forget('active_payment_methods');

        return back()->with('success', 'Metode pembayaran berhasil dihapus!');
    }
}
