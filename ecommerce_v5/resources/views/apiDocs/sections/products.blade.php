@extends('apiDocs.layout')

@section('content')
    <section id="product" class="prose prose-xl dark:prose-invert max-w-none">
        {{-- Main Section Title --}}
        <h2 class="text-4xl font-bold mb-8">🛒 Product Documentation</h2>

        {{-- 1. Fillable Fields --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">1. Fillable Fields</h3>
        <ul class="list-disc list-inside text-xl space-y-2 leading-relaxed">
            <li><strong>product_name</strong>: The primary name of the product.</li>
            <li><strong>product_description</strong>: A detailed description explaining the product's features and benefits.</li>
            <li><strong>SKU</strong>: Stock Keeping Unit, a unique identifier for inventory management.</li>
            <li><strong>discount_id</strong>: (Optional) ID of an applied discount, if any.</li>
            <li><strong>category_id</strong>: The ID of the category this product belongs to.</li>
            <li><strong>price</strong>: The current selling price of the product.</li>
            <li><strong>inventory_id</strong>: ID linking to the product's stock information.</li>
        </ul>

        {{-- 2. Data Validation --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">2. Data Validation</h3>
        <ul class="list-disc list-inside text-xl space-y-3 leading-relaxed">
            <li><strong>product_name</strong>: <code class="font-mono">required</code>, <code class="font-mono">string</code>, <code class="font-mono">max:255</code> characters.</li>
            <li><strong>product_description</strong>: <code class="font-mono">required</code>, <code class="font-mono">string</code>.</li>
            <li><strong>SKU</strong>: <code class="font-mono">required</code>, <code class="font-mono">string</code>, <code class="font-mono">max:255</code> characters.</li>
            <li><strong>category_id</strong>: <code class="font-mono">required</code>, <code class="font-mono">exists:categories,id</code> (must refer to an existing category).</li>
            <li><strong>discount_id</strong>: <code class="font-mono">nullable</code>, <code class="font-mono">exists:discounts,id</code> (optional, but if provided, must refer to an existing discount).</li>
            <li><strong>price</strong>: <code class="font-mono">required</code>, <code class="font-mono">numeric</code>, <code class="font-mono">min:0</code> (cannot be negative).</li>
            <li><strong>inventory_id</strong>: <code class="font-mono">required</code>, <code class="font-mono">exists:inventories,id</code> (must refer to an existing inventory record).</li>
        </ul>

        {{-- 3. API Routes --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">3. API Routes</h3>

        <h4 class="text-2xl font-medium mt-6 mb-4">API Endpoints</h4>
        <table class="table-auto w-full border border-gray-300 dark:border-gray-700 mb-8 text-lg">
            <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="border px-4 py-2 text-left">Method</th>
                <th class="border px-4 py-2 text-left">URL</th>
                <th class="border px-4 py-2 text-left">Description</th>
            </tr>
            </thead>
            <tbody>
            <tr><td class="border px-4 py-3 font-semibold text-green-600 dark:text-green-400">GET</td><td class="border px-4 py-3"><code>/api/v1/products</code></td><td class="border px-4 py-3">Retrieve a list of all products.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-green-600 dark:text-green-400">GET</td><td class="border px-4 py-3"><code>/api/v1/products/edit/{id}</code></td><td class="border px-4 py-3">Fetch details for a specific product by its ID.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-blue-600 dark:text-blue-400">POST</td><td class="border px-4 py-3"><code>/api/v1/products</code></td><td class="border px-4 py-3">Create and insert a new product record.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-yellow-600 dark:text-yellow-400">PUT</td><td class="border px-4 py-3"><code>/api/v1/products/{id}/edit</code></td><td class="border px-4 py-3">Update an existing product's details using its ID.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-red-600 dark:text-red-400">DELETE</td><td class="border px-4 py-3"><code>/api/v1/products/{id}</code></td><td class="border px-4 py-3">Remove a product record by its ID.</td></tr>
            </tbody>
        </table>

        <h4 class="text-2xl font-medium mt-6 mb-4">Client Routes</h4>
        <table class="table-auto w-full border border-gray-300 dark:border-gray-700 mb-8 text-lg">
            <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="border px-4 py-2 text-left">Method</th>
                <th class="border px-4 py-2 text-left">URL</th>
                <th class="border px-4 py-2 text-left">Description</th>
            </tr>
            </thead>
            <tbody>
            <tr><td class="border px-4 py-3 font-semibold text-green-600 dark:text-green-400">GET</td><td class="border px-4 py-3"><code>/client/products</code></td><td class="border px-4 py-3">View all products in the client interface.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-green-600 dark:text-green-400">GET</td><td class="border px-4 py-3"><code>/client/products/{id}</code></td><td class="border px-4 py-3">Display detailed information for a specific product.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-green-600 dark:text-green-400">GET</td><td class="border px-4 py-3"><code>/client/products/create</code></td><td class="border px-4 py-3">Show the form for creating a new product.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-blue-600 dark:text-blue-400">POST</td><td class="border px-4 py-3"><code>/client/products</code></td><td class="border px-4 py-3">Submit and store a new product via the client form.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-yellow-600 dark:text-yellow-400">PUT</td><td class="border px-4 py-3"><code>/client/products/{id}/edit</code></td><td class="border px-4 py-3">Update product details from the client interface.</td></tr>
            </tbody>
        </table>

        {{-- 4. Status Codes --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">4. Status Codes</h3>
        <ul class="list-disc list-inside text-xl space-y-2 leading-relaxed">
            <li><code class="font-mono">200 OK</code>: The request was successful (e.g., data fetched or updated).</li>
            <li><code class="font-mono">201 Created</code>: A new resource has been successfully created.</li>
            <li><code class="font-mono">204 No Content</code>: The request was successful, but no content is returned (e.g., successful deletion).</li>
            <li><code class="font-mono">404 Not Found</code>: The requested resource (product) could not be found.</li>
            <li><code class="font-mono">422 Unprocessable Entity</code>: The request was well-formed but could not be followed due to semantic errors (e.g., invalid input data or non-existent related IDs).</li>
            <li><code class="font-mono">500 Internal Server Error</code>: An unexpected error occurred on the server.</li>
        </ul>

        {{-- 5. Example Usage --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">5. Example Usage</h3>
        <p class="text-lg leading-relaxed">
            We recommend using a tool like <strong class="text-indigo-600 dark:text-indigo-400">Postman</strong> or Insomnia for testing these API endpoints.
        </p>
        <ol class="list-decimal list-inside text-lg mt-4 space-y-2 leading-relaxed">
            <li>Open your API testing client (e.g., Postman).</li>
            <li>Select the appropriate HTTP method (GET, POST, PUT, DELETE) for your request.</li>
            <li>Enter the full API URL into the request field.</li>
            <li>For POST/PUT requests, ensure you include the required data in the request body (usually as JSON).</li>
            <li>Click the <strong class="font-bold">Send</strong> button to execute the request.</li>
        </ol>

        <p class="italic text-lg mt-4 leading-relaxed">A response with the appropriate HTTP status code and data (if applicable) will be returned in the client.</p>

        <h4 class="text-2xl font-medium mt-6 mb-4">Fetch Example (GET)</h4>
        <p class="text-lg leading-relaxed">
            When fetching data, a <code class="font-mono">200 OK</code> status indicates success. If you receive a <code class="font-mono">422 Unprocessable Entity</code>, please verify that all related foreign keys such as <code class="font-mono">discount_id</code>, <code class="font-mono">category_id</code>, or <code class="font-mono">inventory_id</code> exist in your database.
        </p>

        <h5 class="text-xl font-semibold mt-6 mb-3">Sample Response Structure</h5>
        {{-- Code Block with Copy Button --}}
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>{
    "data": {
        "id": 1,
        "cate_id": 1,
        "product_name": "16 Pro Max",
        "product_description": "Desc",
        "SKU": "SP-123456",
        "price": "10.00",
        "discount_id": 1,
        "discount": {
            "id": 1,
            "discount_name": "No Discount",
            "discount_description": "Discount Desc",
            "discount_percent": 0,
            "active": 1
        },
        "category": {
            "id": 1,
            "category_name": "Electornic",
            "category_description": "Desc"
        },
        "inventory": {
            "id": 1,
            "quantity": 90,
            "created_at": "2025-05-28T13:51:33.000000Z",
            "updated_at": "2025-05-28T13:51:33.000000Z"
        }
    }
}</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>

        <h4 class="text-2xl font-medium mt-6 mb-4">Insert Example (POST)</h4>
        <p class="text-lg leading-relaxed">
            Use the <code class="font-mono">POST</code> method to <code class="font-mono">/api/v1/products</code> with a <strong class="font-bold">raw JSON</strong> body containing the new product's details.
        </p>
        {{-- Code Block with Copy Button --}}
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>{
    "product_name": "Laptop 5090",
    "product_description": "A powerful laptop for professional use.",
    "SKU": "LPT-5090-ABC",
    "category_id": 1,
    "discount_id": 1,
    "price": 990.99,
    "inventory_id": 2
}</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>
        <p class="italic text-lg mt-4 leading-relaxed">A <code class="font-mono">201 Created</code> status code indicates that the product was successfully added to your catalog.</p>

        <h4 class="text-2xl font-medium mt-6 mb-4">Update Example (PUT)</h4>
        <p class="text-lg leading-relaxed">
            Send a <code class="font-mono">PUT</code> request to <code class="font-mono">/api/v1/products/{id}/edit</code> with the updated product data in the request body.
        </p>
        <p class="italic text-lg mt-4 leading-relaxed">
            A <code class="font-mono">200 OK</code> response indicates a successful update of the product details.
        </p>

        <h4 class="text-2xl font-medium mt-6 mb-4">Delete Example (DELETE)</h4>
        <p class="text-lg leading-relaxed">
            To remove a product, send a <code class="font-mono">DELETE</code> request to <code class="font-mono">/api/v1/products/{id}</code>.
        </p>
        <p class="italic text-lg mt-4 leading-relaxed">
            A <code class="font-mono">204 No Content</code> response means the product was successfully deleted from your database, and no content is returned in the response body.
        </p>
    </section>
@endsection