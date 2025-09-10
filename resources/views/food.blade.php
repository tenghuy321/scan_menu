@extends('layouts.master')

@section('content')
    @php
        $tableNumber = request()->query('table', 1);
    @endphp

    <div x-data="cartDrawer('{{ $tableNumber }}')" class="max-w-6xl mx-auto p-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">🍽️ មីនុយ</h2>
            <div class="relative cursor-pointer" @click="open = true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5
                        14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3
                        2.1-4.684 2.924-7.138a60.114 60.114 0
                        0 0-16.536-1.84M7.5 14.25 5.106
                        5.272M6 20.25a.75.75 0 1 1-1.5
                        0 .75.75 0 0 1 1.5 0Zm12.75
                        0a.75.75 0 1 1-1.5 0 .75.75
                        0 0 1 1.5 0Z" />
                </svg>
                <span x-show="cartCount > 0" x-text="cartCount"
                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full"></span>
            </div>
        </div>

        <!-- Category Buttons -->
        <div class="mb-6 flex space-x-4">
            <button :class="selectedCategory === 'Food' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
                class="px-4 py-2 rounded" @click="selectedCategory = 'Food'">អាហារ</button>
            <button :class="selectedCategory === 'Drink' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
                class="px-4 py-2 rounded" @click="selectedCategory = 'Drink'">ភេសជ្ជ</button>
        </div>

        <!-- Menu Items -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <template x-for="food in menu[selectedCategory]" :key="food.id">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <img :src="food.image" :alt="food.name" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h5 class="font-semibold text-lg" x-text="food.name"></h5>
                        <p class="text-gray-600 text-sm mb-2" x-text="food.description"></p>
                        <p class="font-bold text-gray-800 mb-3">$<span x-text="food.price.toFixed(2)"></span></p>
                        <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
                            @click="addItem(food.id, food.name, food.price, food.image)">
                            ដាក់ក្នុងកន្រ្តក់ 🛒
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Cart Drawer & Overlay -->
        <div x-show="open" class="fixed inset-0 bg-black bg-opacity-40 z-40" @click="open=false"></div>

        <div class="fixed top-0 left-0 w-80 h-full bg-white shadow-lg z-50 transform transition-transform duration-300"
            :class="open ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-bold">កន្រ្តក់របស់អ្នក</h3>
                <button class="text-gray-600 hover:text-gray-900" @click="open=false">✖</button>
            </div>

            <div class="p-4 overflow-y-auto h-[calc(100%-200px)]">
                <template x-for="(item, id) in cart" :key="id">
                    <div class="flex items-center justify-between border-b py-3 space-x-2">
                        <img :src="item.image" alt="" class="w-16 h-16 object-cover rounded">
                        <div class="flex-1">
                            <p class="font-medium" x-text="item.name"></p>
                            <p class="font-semibold">$<span x-text="(item.price * item.qty).toFixed(2)"></span></p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="px-2 border rounded" @click="updateQty(id, -1)">-</button>
                            <span x-text="item.qty"></span>
                            <button class="px-2 border rounded" @click="updateQty(id, 1)">+</button>
                        </div>
                        <div class="flex flex-col items-end space-y-1">
                            <button class="text-red-600 text-xs hover:underline" @click="removeItem(id)">លុប</button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="p-4 border-t space-y-4">
                <div class="flex justify-between font-bold text-lg">
                    <span>សរុប:</span>
                    <span>$<span x-text="total.toFixed(2)"></span></span>
                </div>

                <button @click="checkout()"
                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                    បញ្ជាទិញ ✅
                </button>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function cartDrawer(tableNumber) {
            return {
                open: false,
                table: tableNumber,
                cart: {},
                total: 0,
                cartCount: 0,
                selectedCategory: 'Food',
                menu: @json($menu),

                addItem(id, name, price, image) {
                    if (!this.cart[id]) this.cart[id] = {
                        name,
                        price: parseFloat(price),
                        qty: 1,
                        image
                    };
                    else this.cart[id].qty++;
                    this.calculateTotal();
                    this.open = true;
                },

                updateQty(id, delta) {
                    if (this.cart[id]) {
                        this.cart[id].qty += delta;
                        if (this.cart[id].qty <= 0) delete this.cart[id];
                        this.calculateTotal();
                    }
                },

                removeItem(id) {
                    if (this.cart[id]) delete this.cart[id];
                    this.calculateTotal();
                },

                calculateTotal() {
                    this.total = Object.values(this.cart).reduce((sum, item) => sum + item.price * item.qty, 0);
                    this.cartCount = Object.values(this.cart).reduce((sum, item) => sum + item.qty, 0);
                },

                async checkout() {
                    if (!Object.keys(this.cart).length) return this.showToast('Cart is empty!', true);

                    try {
                        // Small delay for mobile taps
                        await new Promise(r => setTimeout(r, 50));

                        const res = await fetch('{{ route('order.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }

                            body: JSON.stringify({
                                cart: this.cart,
                                table: this.table
                            })
                        });

                        if (!res.ok) throw new Error('Network error');

                        this.showToast('ការកម្មង់បានបញ្ចប់ដោយជោគជ័យ!');
                        this.cart = {};
                        this.calculateTotal();
                        this.open = false;

                    } catch (err) {
                        console.error(err);
                        this.showToast('Something went wrong!', true);
                    }
                },

                showToast(msg, error = false) {
                    const toast = document.createElement('div');
                    toast.textContent = msg;
                    toast.className =
                        `fixed bottom-5 right-5 px-4 py-2 rounded shadow-lg text-white ${error ? 'bg-red-600' : 'bg-green-600'}`;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                }
            }
        }
    </script>
@endsection
