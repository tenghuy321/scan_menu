<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu</title>
    <link rel="icon" href="{{ asset('assets/images/logo.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
</head>

<body class="" style='font-family: "Kantumruy Pro", sans-serif;'>
    @yield('content')

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
                    if (!this.cart[id]) {
                        this.cart[id] = {
                            id,
                            name,
                            price: parseFloat(price),
                            qty: 1,
                            image
                        };
                    } else {
                        this.cart[id].qty++;
                    }
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
                    this.total = Object.values(this.cart)
                        .reduce((sum, item) => sum + item.price * item.qty, 0);
                    this.cartCount = Object.values(this.cart)
                        .reduce((sum, item) => sum + item.qty, 0);
                },

                async checkout() {
                    if (!Object.keys(this.cart).length) {
                        return this.showToast('Cart is empty!', true);
                    }

                    try {
                        // Small delay for mobile taps
                        await new Promise(r => setTimeout(r, 50));

                        const csrf = document.querySelector('meta[name="csrf-token"]').content;
                        console.log("CSRF:", csrf);

                        const res = await fetch("{{ url('/order') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({
                                cart: Object.values(this.cart), // send as array
                                table: this.table
                            })
                        });

                        if (!res.ok) {
                            let errMsg = 'Network error';
                            try {
                                const errData = await res.json();
                                console.error('Validation/Server Error:', errData);
                                if (errData?.message) {
                                    errMsg = errData.message;
                                }
                            } catch (e) {
                                console.error('Response parse failed', e);
                            }
                            throw new Error(errMsg);
                        }

                        const data = await res.json();
                        console.log('Order response:', data);

                        this.showToast('ការកម្មង់បានបញ្ចប់ដោយជោគជ័យ!');
                        this.cart = {};
                        this.calculateTotal();
                        this.open = false;

                    } catch (err) {
                        console.error(err);
                        this.showToast(err.message || 'Something went wrong!', true);
                    }
                },

                showToast(msg, error = false) {
                    const toast = document.createElement('div');
                    toast.textContent = msg;
                    toast.className =
                        `fixed bottom-5 right-5 px-4 py-2 rounded shadow-lg text-white z-50 ${error ? 'bg-red-600' : 'bg-green-600'}`;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                }
            }
        }
    </script>


</body>

</html>
