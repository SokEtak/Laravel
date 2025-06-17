<aside class="w-64 p-4 space-y-4 sticky
              bg-gray-100 text-gray-800    {{-- Light mode styles for sidebar --}}
              dark:bg-gray-800 dark:text-gray-100"> {{-- Dark mode styles for sidebar --}}
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">API Docs</h2>
        <button onclick="toggleDarkMode()">
            {{-- Sun icon (Moon icon when in Dark Mode) --}}
            <span id="icon-sun" class="hidden dark:inline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="#C0C0C0" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
            </span>
            {{-- Moon icon (Sun icon when in Light Mode) --}}
            <span id="icon-moon" class="dark:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="#FFD700" viewBox="0 0 24 24">
                    <path d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.36-6.36l-1.42 1.42M7.05 17.95l-1.42 1.42M17.95 17.95l-1.42-1.42M6.34 6.34L4.93 4.93"/>
                    <circle cx="12" cy="12" r="5"/>
                </svg>
            </span>
        </button>
    </div>
    <nav class="flex flex-col space-y-2">
        <ul>
            <li class="py-1"><a href="{{ route('api-docs') }}" class="block hover:text-indigo-400">📘 Introduction</a></li>
            <li class="py-1"><a href="{{ route('api-docs.products') }}" class="block hover:text-indigo-400">🛒 Products</a></li>
            <li class="py-1"><a href="{{ route('api-docs.discounts') }}" class="block hover:text-indigo-400">🏷️ Discounts</a></li>
            <li class="py-1"><a href="{{ route('api-docs.categories') }}" class="block hover:text-indigo-400">📂 Categories</a></li>
            <li class="py-1"><a href="{{ route('api-docs.inventories') }}" class="block hover:text-indigo-400">📦 Inventories</a></li>
            <li class="py-1"><a href="{{ route('api-docs.orderDetails') }}" class="block hover:text-indigo-400">🧾 Order Details</a></li>
           <li class="py-1"><a href="{{ route('api-docs.documents') }}" class="block hover:text-indigo-400 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                        <span>Download Document</span>
                    </a></li>
                    <li class="py-1"><a href="{{ route('products.index') }}" class="block hover:text-indigo-400 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-external-link"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                        <span>Live Demo</span>
                    </a></li>
        </ul>

    </nav>
</aside>