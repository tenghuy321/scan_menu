<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1">
    <title>Menu | Dashboard</title>
    <link rel="icon" href="{{ asset('assets/images/logo.jpg') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.1/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.1.0/ckeditor5.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,100..900;1,9..144,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body style='font-family: "Kantumruy Pro", sans-serif'>
    <div class="hidden md:block">
        <nav class="sidebar close py-[2px] sm:py-[10px] px-[4px] sm:px-[14px]">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="">
                    </span>

                    <div class="text header-text">
                        <span class="name">មីនុយ</span>
                    </div>
                </div>

                <div class="hidden sm:block">
                    <i class="bx bx-chevron-right toggle"></i>
                </div>
            </header>

            <div class="menu-bar">
                <div class="menu max-h-[80vh] overflow-y-auto scrollbar-hidden">
                    <ul class="manu-links">
                        <li
                            class="nav-link {{ Route::is('dashboard') ? 'bg-[#9C1C1F] rounded-md !text-[#ffffff]' : '' }}">
                            <a href="{{ route('dashboard') }}"
                                class="{{ Route::is('dashboard') ? 'active' : '' }}">
                                <i class='bx bxs-dashboard icon'></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>
                        {{-- <li
                            class="nav-link {{ Request::is('category') ? 'bg-[#9C1C1F] rounded-md !text-[#ffffff]' : '' }}">
                            <a href="{{ url('category') }}">
                                <i class='bx bx-image icon'></i>
                                <span class="text nav-text">Category</span>
                            </a>
                        </li>
                        <li class="nav-link {{ Request::is('item') ? 'bg-[#9C1C1F] rounded-md !text-[#ffffff]' : '' }}">
                            <a href="{{ url('item') }}">
                                <i class='bx bx-image icon'></i>
                                <span class="text nav-text">Items</span>
                            </a>
                        </li> --}}
                        <li
                            class="nav-link {{ Request::is('order') ? 'bg-[#9C1C1F] rounded-md !text-[#ffffff]' : '' }}">
                            <a href="{{ url('order') }}">
                                <i class='bx bx-image icon'></i>
                                <span class="text nav-text">Order</span>
                            </a>
                        </li>


                    </ul>
                </div>


                <div class="bottom-content">
                    <li class="">
                        <a href="{{ route('profile.edit') }}">
                            <i class="bx bx-user-circle icon"></i>
                            <span class="text nav-text">Profile</span>
                        </a>
                    </li>

                    <li class="">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="bx bx-log-out icon"></i>
                                <span class="text nav-text">Logout</span>
                            </a>
                        </form>
                    </li>
                </div>
            </div>
        </nav>

        <section class="home">
            <div class="text px-[20px] py-[8px] text-[20px] sm:text-[25px] md:text-[30px]">
                @yield('header')
            </div>
            <hr>
            <div class="px-[10px] xl:px-[20px] py-[8px] text-[#707070]">
                @yield('content')
            </div>
        </section>
    </div>

    <div class="md:hidden w-full h-full bg-gray-700 flex flex-col items-center justify-center space-y-2">
        <img src="{{ asset('assets/images/window.png') }}" alt="" class="w-52 h-auto">
        <h1 class="text-[25px] text-[#fff] font-[600] tracking-wider">Window too small</h1>
    </div>

    @yield('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <!-- CKEditor 4 CDN -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/45.1.0/ckeditor5.umd.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        // delete message
        function deleteRecord(url) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF3217",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed || result.dismiss === Swal.DismissReason.backdrop) {
                            window.location.href = url;
                        }
                    })
                }
            });
        }
    </script>
</body>

</html>
