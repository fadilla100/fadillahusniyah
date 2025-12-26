<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
   public function index()
{
    $cart = auth()->user()
        ->cart()
        ->with('items.product')
        ->first();

    if (!$cart) {
        return redirect()->route('catalog.index')
            ->with('error', 'Keranjang tidak ditemukan');
    }

    $subtotal = $cart->items->sum(function ($item) {
        return ($item->product->price ?? 0) * $item->quantity;
    });

    $shippingCost = 20000; // contoh ongkir flat

    return view('checkout.index', compact('cart', 'subtotal', 'shippingCost'));
}


    public function store(Request $request, OrderService $orderService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        try {
            $order = $orderService->createOrder(auth()->user(), $request->only(['name', 'phone', 'address']));

            // Redirect ke halaman pembayaran (akan dibuat besok)
            // Untuk sekarang, redirect ke detail order
            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat! Silahkan lakukan pembayaran.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}