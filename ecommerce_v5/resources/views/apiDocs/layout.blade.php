<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'API Documentation' }}</title>
    <style>
        /* Prevent horizontal overflow */
        html, body {
            overflow-x: hidden;
        }

        /* Optional: Constrain code blocks or preformatted text */
        pre, code {
            white-space: pre-wrap; /* Wrap long lines */
            word-break: break-word;
        }

        /* Custom styles for the copy button */
        .copy-button {
            position: absolute;
            top: 2px;
            right: 2px;
            background-color: #e2e8f0; /* Light gray */
            color: #1a202c; /* Dark gray */
            padding: 0.5rem;
            border-radius: 0.375rem; /* Rounded corners */
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .copy-button:hover {
            background-color: #cbd5e0; /* Darker gray on hover */
        }
        .copy-button svg {
            width: 1.25rem; /* 20px */
            height: 1.25rem; /* 20px */
        }
        /* Toast notification styles */
        #copy-toast {
            transition: opacity 0.3s ease;
            opacity: 0;
        }
        #copy-toast:not(.hidden) {
            opacity: 1;
        }
        #copy-toast #toast-message {
            font-size: 1rem; /* 16px */
            font-weight: 500; /* Medium weight */
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .copy-button {
                padding: 0.25rem; /* Smaller padding on mobile */
            }
            #copy-toast {
                width: 90%; /* Full width on small screens */
                left: 5%;
            }
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' };

        // Reusable function to show toast notification
        function showToast(message, duration = 2000) {
            const toast = document.getElementById('copy-toast');
            const messageElement = document.getElementById('toast-message');
            messageElement.textContent = message;
            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, duration);
        }

        // Reusable function to copy code
        function copyCode(button) {
            const codeBlock = button.previousElementSibling;
            const codeText = codeBlock.textContent;

            navigator.clipboard.writeText(codeText).then(() => {
                showToast('Code copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy text: ', err);
                showToast('Failed to copy code.', 3000);
            });
        }
    </script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">

<header class="md:hidden flex justify-between items-center p-4 bg-gray-100 dark:bg-gray-800 shadow">
    <h1 class="text-lg font-bold">{{ $title ?? 'API Docs' }}</h1>
    <div class="flex items-center gap-3">
        <button onclick="toggleDarkMode()" class="text-xl">
            <span id="icon-sun">🌞</span>
            <span id="icon-moon">🌙</span>
        </button>

        <button id="mobileSidebarToggle" class="text-2xl focus:outline-none">☰</button>
    </div>
</header>

<div class="flex flex-col md:flex-row min-h-screen">
    <aside id="sidebar"
           class="md:block hidden w-full md:w-64 bg-gray-100 dark:bg-gray-800 border-r border-gray-300 dark:border-gray-700 md:h-auto fixed md:static inset-y-0 z-50 md:z-auto overflow-y-auto overflow-x-hidden transition-transform transform md:translate-x-0">
        @include('apiDocs.sidebar')
    </aside>

    <main class="flex-1 p-4 md:p-8 mt-16 md:mt-0">
        @yield('content')
    </main>
</div>

{{-- Toast Notification Container (hidden by default) --}}
<div id="copy-toast" class="fixed bottom-6 right-6 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg hidden z-50">
    <span id="toast-message"></span>
</div>

<script>
    function updateIconVisibility(isDark) {
        const iconSun = document.getElementById('icon-sun');
        const iconMoon = document.getElementById('icon-moon');

        if (iconSun && iconMoon) { // Ensure elements exist before manipulating
            if (isDark) {
                iconSun.classList.remove('hidden');
                iconMoon.classList.add('hidden');
            } else {
                iconSun.classList.add('hidden');
                iconMoon.classList.remove('hidden');
            }
        }
    }

    function toggleDarkMode() {
        const html = document.documentElement;
        // Toggle the 'dark' class
        const isDark = html.classList.toggle('dark');

        // Store the preference
        localStorage.setItem('theme', isDark ? 'dark' : 'light');

        // Update icon visibility based on the new theme
        updateIconVisibility(isDark);
    }

    window.addEventListener('DOMContentLoaded', () => {
        const html = document.documentElement;
        // Get stored theme or default to 'light'
        const storedTheme = localStorage.getItem('theme');
        const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

        let initialIsDark;
        if (storedTheme) {
            initialIsDark = storedTheme === 'dark';
        } else {
            initialIsDark = systemPrefersDark; // Use system preference if no theme is stored
        }

        html.classList.toggle('dark', initialIsDark);

        // Set initial icon visibility based on the theme applied
        updateIconVisibility(initialIsDark);

        // Mobile sidebar toggle
        document.getElementById('mobileSidebarToggle')?.addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            // Optional: You might want to toggle a class for better visual feedback,
            // like adding 'translate-x-full' and removing it on open for sliding effect
            // if you later decide to animate the sidebar opening.
        });
    });
</script>
</body>
</html>