<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,paid,refunded',
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'تم تحديث حالة الدفع بنجاح');
    }

    /**
     * Set the shipping cost for a single order and refresh its total.
     */
    public function updateShipping(Request $request, Order $order)
    {
        $mode = (string) $request->input('shipping_mode');

        $validated = $request->validate([
            'shipping_mode' => 'required|in:' . Order::SHIPPING_DETERMINED . ',' . Order::SHIPPING_FREE . ',' . Order::SHIPPING_FIXED,
            'shipping_cost' => ($mode === Order::SHIPPING_FIXED ? 'required' : 'nullable') . '|numeric|min:0',
        ], [
            'shipping_cost.required' => 'مطلوب إدخال قيمة الشحن عند اختيار قيمة ثابتة.',
            'shipping_cost.numeric'  => 'قيمة الشحن يجب أن تكون رقماً.',
            'shipping_cost.min'      => 'قيمة الشحن لا يمكن أن تكون سالبة.',
        ]);

        $shipping = $mode === Order::SHIPPING_FIXED ? round((float) $validated['shipping_cost'], 2) : 0;

        $order->update([
            'shipping'      => $shipping,
            'shipping_mode' => $mode,
            'total'         => $order->subtotal + $shipping,
        ]);

        return back()->with('success', 'تم تحديث الشحن وإجمالي الطلب بنجاح');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }
}
