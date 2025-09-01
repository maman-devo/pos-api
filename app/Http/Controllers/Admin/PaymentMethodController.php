<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->get();
        return view('admin.payment_methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:payment_methods,code|max:255',
            'provider' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'credentials.server_key' => 'nullable|string',
            'credentials.client_key' => 'nullable|string',
        ]);

        $data = $request->except('is_active');
        $data['is_active'] = $request->has('is_active');

        PaymentMethod::create($data);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:payment_methods,code,' . $paymentMethod->id,
            'provider' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'credentials.server_key' => 'nullable|string',
            'credentials.client_key' => 'nullable|string',
        ]);

        $data = $request->except('is_active');
        $data['is_active'] = $request->has('is_active');

        // Jangan update credentials jika tidak diisi
        if (empty($data['credentials']['server_key']) && empty($data['credentials']['client_key'])) {
            unset($data['credentials']);
        }

        $paymentMethod->update($data);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}