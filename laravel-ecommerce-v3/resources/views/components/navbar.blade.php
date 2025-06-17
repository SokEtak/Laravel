<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">MyApp</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                 Products Menu
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('products.*') ? 'active' : '' }}"
                       href="#" id="productsDropdown" role="button" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                        <li><a class="dropdown-item" href="{{ route('products.index') }}">Product List</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.create') }}">Add Product</a></li>
                    </ul>
                </li>

                 Categories Menu
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                       href="#" id="categoriesDropdown" role="button" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        <li><a class="dropdown-item" href="{{ route('categories.index') }}">Category List</a></li>
                        <li><a class="dropdown-item" href="{{ route('categories.create') }}">Add Category</a></li>
                    </ul>
                </li>

                 Discounts Menu
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('discounts.*') ? 'active' : '' }}"
                       href="#" id="discountsDropdown" role="button" aria-expanded="false">
                        Discounts
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="discountsDropdown">
                        <li><a class="dropdown-item" href="{{ route('discounts.index') }}">Discount List</a></li>
                        <li><a class="dropdown-item" href="{{ route('discounts.create') }}">Add Discount</a></li>
                    </ul>
                </li>

                 Inventory Menu
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('inventories.*') ? 'active' : '' }}"
                       href="#" id="inventoriesDropdown" role="button" aria-expanded="false">
                        Inventory
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="inventoriesDropdown">
                        <li><a class="dropdown-item" href="{{ route('inventories.index') }}">Inventory List</a></li>
                        <li><a class="dropdown-item" href="{{ route('inventories.create') }}">Add Inventory</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        document.querySelectorAll('.nav-item.dropdown').forEach(function (dropdown) {
            dropdown.addEventListener('mouseenter', function () {
                this.classList.add('show');
                this.querySelector('.dropdown-menu').classList.add('show');
            });
            dropdown.addEventListener('mouseleave', function () {
                this.classList.remove('show');
                this.querySelector('.dropdown-menu').classList.remove('show');
            });
        });
    </script>
@endpush



{{--<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">--}}
{{--    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">--}}
{{--        <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">--}}
{{--            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo">--}}
{{--            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>--}}
{{--        </a>--}}
{{--        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">--}}
{{--            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Get started</button>--}}
{{--            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">--}}
{{--                <span class="sr-only">Open main menu</span>--}}
{{--                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">--}}
{{--                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>--}}
{{--                </svg>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">--}}
{{--            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">--}}
{{--                <li>--}}
{{--                    <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}
