<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">MyApp</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
            aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="productsDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-box"></i> Products
                    </a>
                    <ul class="dropdown-menu modern-dropdown" aria-labelledby="productsDropdown">
                        <li><a class="dropdown-item" href="{{ route('products.index') }}"><i class="bi bi-list-check"></i> Product List</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.create') }}"><i class="bi bi-plus-circle"></i> Add Product</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="categoriesDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-tags"></i> Categories
                    </a>
                    <ul class="dropdown-menu modern-dropdown" aria-labelledby="categoriesDropdown">
                        <li><a class="dropdown-item" href="{{ route('categories.index') }}"><i class="bi bi-list"></i> Category List</a></li>
                        <li><a class="dropdown-item" href="{{ route('categories.create') }}"><i class="bi bi-plus-circle"></i> Add Category</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="discountsDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-percent"></i> Discounts
                    </a>
                    <ul class="dropdown-menu modern-dropdown" aria-labelledby="discountsDropdown">
                        <li><a class="dropdown-item" href="{{ route('discounts.index') }}"><i class="bi bi-list-ul"></i> Discount List</a></li>
                        <li><a class="dropdown-item" href="{{ route('discounts.create') }}"><i class="bi bi-plus-circle"></i> Add Discount</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="inventoriesDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-archive"></i> Inventories
                    </a>
                    <ul class="dropdown-menu modern-dropdown" aria-labelledby="inventoriesDropdown">
                        <li><a class="dropdown-item" href="{{ route('inventories.index') }}"><i class="bi bi-list-columns"></i> Inventory List</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="orderDetailsDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-receipt"></i> Orders
                    </a>
                    <ul class="dropdown-menu modern-dropdown" aria-labelledby="orderDetailsDropdown">
                        <li><a class="dropdown-item" href="{{ route('orderDetails.index') }}"><i class="bi bi-card-list"></i> Order List</a></li>
                        <li><a class="dropdown-item" href="{{ route('orderDetails.create') }}"><i class="bi bi-plus-circle"></i> Add Order</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="orderItemsDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-clipboard-data"></i> Order Items
                    </a>
                    <ul class="dropdown-menu modern-dropdown" aria-labelledby="orderItemsDropdown">
                        <li><a class="dropdown-item" href="{{ route('orderItems.index') }}"><i class="bi bi-card-list"></i> Order List</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="paymentsDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-credit-card"></i> Payments
                    </a>
                    <ul class="dropdown-menu modern-dropdown" aria-labelledby="paymentsDropdown">
                        <li><a class="dropdown-item" href="{{ route('payments.index') }}"><i class="bi bi-list-ol"></i> Payment List</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> Users
                    </a>
                    <ul class="dropdown-menu modern-dropdown" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="bi bi-list-ol"></i> Users List</a></li>
                        <li><a class="dropdown-item" href="{{ route('users.create') }}"><i class="bi bi-plus-circle"></i> Add User</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start bg-primary text-white" tabindex="-1" id="sidebarMenu"
    aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold" id="sidebarMenuLabel">MyApp Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="sidebarProductsDropdown"
                    role="button" data-bs-toggle="collapse" data-bs-target="#sidebarProductsCollapse"
                    aria-expanded="false">
                    <i class="bi bi-box"></i> Products
                </a>
                <div class="collapse dropdown-menu-collapse" id="sidebarProductsCollapse">
                    <ul class="list-unstyled ps-3">
                        <li><a class="dropdown-item" href="{{ route('products.index') }}"><i class="bi bi-list-check"></i> Product List</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.create') }}"><i class="bi bi-plus-circle"></i> Add Product</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="sidebarCategoriesDropdown"
                    role="button" data-bs-toggle="collapse" data-bs-target="#sidebarCategoriesCollapse"
                    aria-expanded="false">
                    <i class="bi bi-tags"></i> Categories
                </a>
                <div class="collapse dropdown-menu-collapse" id="sidebarCategoriesCollapse">
                    <ul class="list-unstyled ps-3">
                        <li><a class="dropdown-item" href="{{ route('categories.index') }}"><i class="bi bi-list"></i> Category List</a></li>
                        <li><a class="dropdown-item" href="{{ route('categories.create') }}"><i class="bi bi-plus-circle"></i> Add Category</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="sidebarDiscountsDropdown"
                    role="button" data-bs-toggle="collapse" data-bs-target="#sidebarDiscountsCollapse"
                    aria-expanded="false">
                    <i class="bi bi-percent"></i> Discounts
                </a>
                <div class="collapse dropdown-menu-collapse" id="sidebarDiscountsCollapse">
                    <ul class="list-unstyled ps-3">
                        <li><a class="dropdown-item" href="{{ route('discounts.index') }}"><i class="bi bi-list-ul"></i> Discount List</a></li>
                        <li><a class="dropdown-item" href="{{ route('discounts.create') }}"><i class="bi bi-plus-circle"></i> Add Discount</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="sidebarInventoriesDropdown"
                    role="button" data-bs-toggle="collapse" data-bs-target="#sidebarInventoriesCollapse"
                    aria-expanded="false">
                    <i class="bi bi-archive"></i> Inventories
                </a>
                <div class="collapse dropdown-menu-collapse" id="sidebarInventoriesCollapse">
                    <ul class="list-unstyled ps-3">
                        <li><a class="dropdown-item" href="{{ route('inventories.index') }}"><i class="bi bi-list-columns"></i> Inventory List</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="sidebarOrdersDropdown"
                    role="button" data-bs-toggle="collapse" data-bs-target="#sidebarOrdersCollapse"
                    aria-expanded="false">
                    <i class="bi bi-receipt"></i> Orders
                </a>
                <div class="collapse dropdown-menu-collapse" id="sidebarOrdersCollapse">
                    <ul class="list-unstyled ps-3">
                        <li><a class="dropdown-item" href="{{ route('orderDetails.index') }}"><i class="bi bi-card-list"></i> Order List</a></li>
                        <li><a class="dropdown-item" href="{{ route('orderDetails.create') }}"><i class="bi bi-plus-circle"></i> Add Order</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="sidebarOrderItemsDropdown"
                    role="button" data-bs-toggle="collapse" data-bs-target="#sidebarOrderItemsCollapse"
                    aria-expanded="false">
                    <i class="bi bi-clipboard-data"></i> Order Items
                </a>
                <div class="collapse dropdown-menu-collapse" id="sidebarOrderItemsCollapse">
                    <ul class="list-unstyled ps-3">
                        <li><a class="dropdown-item" href="{{ route('orderItems.index') }}"><i class="bi bi-card-list"></i> Order List</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="sidebarPaymentsDropdown"
                    role="button" data-bs-toggle="collapse" data-bs-target="#sidebarPaymentsCollapse"
                    aria-expanded="false">
                    <i class="bi bi-credit-card"></i> Payments
                </a>
                <div class="collapse dropdown-menu-collapse" id="sidebarPaymentsCollapse">
                    <ul class="list-unstyled ps-3">
                        <li><a class="dropdown-item" href="{{ route('payments.index') }}"><i class="bi bi-list-ol"></i> Payment List</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="sidebarUserDropdown"
                    role="button" data-bs-toggle="collapse" data-bs-target="#sidebarUserCollapse"
                    aria-expanded="false">
                    <i class="bi bi-person-circle"></i> Users
                </a>
                <div class="collapse dropdown-menu-collapse" id="sidebarUserCollapse">
                    <ul class="list-unstyled ps-3">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="bi bi-list-ol"></i> Users List</a></li>
                        <li><a class="dropdown-item" href="{{ route('users.create') }}"><i class="bi bi-plus-circle"></i> Add User</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>

<style>
    /* Navbar */
    .navbar {
        padding: 12px 20px;
        background: linear-gradient(to right, #221636, #ad71bb);
        box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.1);
    }

    .navbar-dark .navbar-nav .nav-link {
        font-size: 1.2rem;
        padding: 12px;
        transition: transform 0.1s ease-in-out, color 0.1s ease-in-out;
    }

    .navbar-dark .navbar-nav .nav-link:hover {
        transform: scale(1.05);
        color: #2355b9 !important;
    }

    /* Dropdown Menu (for desktop navbar) */
    .modern-dropdown {
        border-radius: 12px;
        padding: 10px;
        background: linear-gradient(135deg, #17a1bd, #a91da7); /* gradient added */
        box-shadow: 0px 4px 8px rgba(83, 18, 141, 0.15);
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        opacity: 0;
        transform: translateY(-10px);
        visibility: hidden;
        position: absolute;
    }

    .nav-item.dropdown:hover .dropdown-menu {
        opacity: 1;
        transform: translateY(0);
        visibility: visible;
    }

    .dropdown-item {
        padding: 10px 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: background 0.3s ease-in-out, transform 0.2s ease-in-out;
    }

    .dropdown-item i {
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .dropdown-item:hover {
        background: rgba(255, 204, 128, 0.3);
        color: #ffcc80;
        border-radius: 8px;
        transform: scale(1.05);
        text-shadow: 0 0 8px #ffcc80, 0 0 12px #ffcc80, 0 0 16px #ffcc80; /* Neon glow effect */
        box-shadow: 0 0 10px rgba(255, 204, 128, 0.7); /* Outer glow */
    }

    .active-dropdown > .nav-link {
        background: #ffcc80;
        color: #252636 !important;
        transform: scale(1.1);
        box-shadow: 0 0 12px rgba(255, 204, 128, 0.7), 0 0 18px rgba(255, 204, 128, 0.5);
        transition: all 0.3s ease-in-out;
    }

    /* Offcanvas Sidebar Styles */
    .offcanvas-header {
        background-color: #2f2f62; /* Match navbar background */
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .offcanvas-title {
        color: #fff;
    }

    .offcanvas-body {
        background: linear-gradient(135deg, #2f545b, #2e3876); /* Match dropdown background */
        padding-top: 0;
    }

    .offcanvas .navbar-nav .nav-item {
        width: 100%;
    }

    .offcanvas .navbar-nav .nav-link {
        color: #fff !important;
        padding: 15px 20px;
        font-size: 1.1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .offcanvas .navbar-nav .nav-link:hover {
        background: rgba(255, 204, 128, 0.1);
        color: #ffcc80 !important;
        transform: none; /* Remove scale effect for sidebar links */
    }

    /* Styles for sidebar dropdowns (using Bootstrap collapse) */
    .dropdown-menu-collapse {
        background: rgba(0, 0, 0, 0.2); /* Slightly darker background for open sub-menus */
        padding-left: 0;
    }

    .dropdown-menu-collapse .dropdown-item {
        color: #fff;
        padding: 10px 20px 10px 35px; /* Indent child items */
        font-size: 1rem;
        border-bottom: none;
    }

    .dropdown-menu-collapse .dropdown-item:hover {
        background: rgba(255, 204, 128, 0.15);
        color: #ffcc80;
        text-shadow: none;
        box-shadow: none;
        transform: none;
    }

    /* Hide main navbar on small screens and show offcanvas toggle */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            display: none !important;
        }
        .navbar-toggler {
            display: block;
        }
    }

    /* Show main navbar on large screens and hide offcanvas toggle */
    @media (min-width: 992px) {
        .navbar-toggler {
            display: none;
        }
        .navbar-collapse {
            display: flex !important;
        }
    }
</style>

<script>
    // Existing script for desktop dropdowns (keep this)
    document.querySelectorAll('.nav-item.dropdown').forEach(function (dropdown) {
        dropdown.addEventListener('mouseenter', function () {
            // Only apply this for the main navbar, not the offcanvas
            if (window.innerWidth >= 992) {
                this.classList.add('show');
                this.querySelector('.dropdown-menu').classList.add('show');
            }
        });

        dropdown.addEventListener('mouseleave', function () {
            if (window.innerWidth >= 992) {
                this.classList.remove('show');
                this.querySelector('.dropdown-menu').classList.remove('show');
            }
        });
    });

    document.querySelectorAll('.dropdown-item').forEach(function (item) {
        item.addEventListener('click', function () {
            // Remove active class from all dropdown parents in the main navbar
            document.querySelectorAll('#navbarNav .nav-item.dropdown').forEach(function (dropdown) {
                dropdown.classList.remove('active-dropdown');
            });
            // Add active class to the clicked item's parent dropdown in the main navbar
            const closestNavDropdown = this.closest('#navbarNav .nav-item.dropdown');
            if (closestNavDropdown) {
                closestNavDropdown.classList.add('active-dropdown');
            }

            // Handle active class for sidebar items (if needed, this can be more complex)
            document.querySelectorAll('#sidebarMenu .nav-item.dropdown').forEach(function (dropdown) {
                dropdown.classList.remove('active-dropdown');
            });
            const closestSidebarDropdown = this.closest('#sidebarMenu .nav-item.dropdown');
            if (closestSidebarDropdown) {
                closestSidebarDropdown.classList.add('active-dropdown');
            }

            // Close offcanvas when an item is clicked
            const offcanvasElement = document.getElementById('sidebarMenu');
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
            if (offcanvas) {
                offcanvas.hide();
            }
        });
    });
</script>