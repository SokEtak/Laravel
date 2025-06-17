@extends('apiDocs.layout')

@section('content')
    <div class="prose prose-xl dark:prose-invert max-w-none">
        {{-- h1 will be scaled by prose-xl, but we can make it even larger --}}
        <h1 class="text-5xl font-bold mb-6">📘 API Documentation</h1> 
        
        {{-- p will be scaled by prose-xl, but we can make it slightly larger and adjust line height --}}
        <p class="text-xl text-gray-700 dark:text-gray-300 mb-8 leading-relaxed">
            Welcome to the E-Commerce API! This documentation provides all the details you need to integrate your applications with our powerful backend services.
        </p>

        {{-- h2 will be scaled by prose-xl, but we can make it larger and adjust margins --}}
        <h2 class="text-3xl font-semibold mt-12 mb-3">🚀 What You Can Do</h2>
        
        {{-- ul and li will be scaled by prose-xl, but we can explicitly set text size and space --}}
        <ul class="list-disc list-inside text-xl text-gray-700 dark:text-gray-300 space-y-4"> {{-- Increased space-y to space-y-4 for more vertical separation --}}
            <li>Create and manage products, categories, and discounts with robust endpoints for full control.</li>
            <li>Efficiently handle orders, manage inventories, and streamline customer interactions for a seamless experience.</li>
            <li>Integrate secure payment workflows, ensuring safe and reliable transactions for your users.</li>
        </ul>

        {{-- h2 will be scaled by prose-xl, but we can make it larger and adjust margins --}}
        <h2 class="text-3xl font-semibold mt-12 mb-3">🛠️ How to Use</h2>
        
        {{-- p will be scaled by prose-xl, but we can explicitly set text size and adjust line height --}}
        <p class="text-xl text-gray-700 dark:text-gray-300 leading-relaxed">
            Navigate through the sections using the sidebar to explore each part of the API. Within each section, you’ll find detailed usage examples, endpoint specifications, and clear request/response formats to guide your integration.
        </p>
    </div>
@endsection