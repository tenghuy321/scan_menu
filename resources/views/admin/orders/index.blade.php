@extends('admin.layouts.app')

@section('content')
    @forelse ($orders as $order)
        <div class="border rounded-lg mb-6 p-4 shadow text-[#000]">

            <div class="flex justify-between mb-2 items-center">
                <div>
                    {{-- <span class="font-semibold">Invoice #{{ $loop->iteration }}</span> --}}
                    <span class="font-semibold">Invoice #{{ $order->invoice_number }}</span>
                    <span> | <span class="font-semibold">Table</span> : {{ $order->table_number }}</span>
                    <span> | <span class="font-semibold">Date</span> : {{ $order->created_at->format('Y-m-d H:i') }}</span>
                </div>

                <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this order?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline text-sm">Delete Order</button>
                </form>
            </div>

            <table class="w-full text-left border-t border-b mt-2 mb-2 text-sm">
                <thead>
                    <tr>
                        <th class="py-1">Item</th>
                        <th class="py-1">Qty</th>
                        <th class="py-1">Price</th>
                        <th class="py-1">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="py-1">{{ $item->food_name }}</td>
                            <td class="py-1">{{ $item->quantity }}</td>
                            <td class="py-1">${{ number_format($item->price, 2) }}</td>
                            <td class="py-1">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-end font-bold text-sm mb-2">
                <span>Total: ${{ number_format($order->total, 2) }}</span>
            </div>

            {{-- <button onclick="printInvoice('invoice-{{ $order->id }}')"
                    class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                Print 🖨️
            </button> --}}

            {{-- <div id="invoice-{{ $order->id }}" class="hidden">
                <div style="width: 250px; font-size: 12px; padding: 10px;">
                    <h3 style="text-align:center;">My Restaurant</h3>
                    <p>Date: {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p>Table: {{ $order->table_number }}</p>
                    <hr>
                    @foreach ($order->items as $item)
                        <div style="display:flex; justify-content:space-between;">
                            <span>{{ $item->food_name }} x{{ $item->quantity }}</span>
                            <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div style="display:flex; justify-content:space-between; font-weight:bold;">
                        <span>Total</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                    <hr>
                    <p style="text-align:center;">Thank you!</p>
                </div>
            </div> --}}
        </div>
    @empty
        <p>No orders yet.</p>
    @endforelse

    {{-- <script>
        function printInvoice(id) {
            const printContents = document.getElementById(id).innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script> --}}
@endsection
