@extends('apiDocs.layout')

@section('content')
    <section id="orders" class="prose prose-xl dark:prose-invert max-w-none">
        {{-- Main Section Title --}}
        <h2 class="text-4xl font-bold mb-8">🛒 Orders Documentation</h2>

        {{-- 1. Fillable Fields --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">1. Fillable Fields</h3>
        <ul class="list-disc list-inside text-xl space-y-2 leading-relaxed">
            <li><strong>user_id</strong>: The ID of the user who placed the order.</li>
            <li><strong>total</strong>: The total amount of the order, including all items.</li>
            <li><strong>items</strong>: An array containing the details of products within the order.</li>
            <li><strong>order_by</strong>: (Optional) The name of the person who placed the order (for display purposes).</li>
        </ul>

        {{-- 2. Data Validation --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">2. Data Validation</h3>
        <ul class="list-disc list-inside text-xl space-y-3 leading-relaxed">
            <li><strong>user_id</strong>: <code class="font-mono">required</code>, <code class="font-mono">integer</code>, <code class="font-mono">exists:users,id</code> (must refer to an existing user).</li>
            <li><strong>total</strong>: <code class="font-mono">required</code>, <code class="font-mono">numeric</code> (can include decimal values).</li>
            <li><strong>items</strong>: <code class="font-mono">required</code>, <code class="font-mono">array</code>. Each item in the array must contain:
                <ul class="list-disc ml-6 space-y-1">
                    <li><strong>product_id</strong>: <code class="font-mono">required</code>, <code class="font-mono">integer</code>, <code class="font-mono">exists:products,id</code> (must refer to an existing product).</li>
                    <li><strong>quantity</strong>: <code class="font-mono">required</code>, <code class="font-mono">integer</code>, <code class="font-mono">min:1</code> (must be at least 1).</li>
                </ul>
            </li>
            <li><strong>order_by</strong>: <code class="font-mono">nullable</code>, <code class="font-mono">string</code>, <code class="font-mono">max:255</code> (optional field for the name of the orderer).</li>
        </ul>

        {{-- 3. API Routes --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">3. API Routes</h3>

        <h4 class="text-2xl font-medium mt-6 mb-4">👉 API Endpoints</h4>
        <table class="table-auto w-full border border-gray-300 dark:border-gray-700 mb-8 text-lg">
            <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="border px-4 py-2 text-left">Method</th>
                <th class="border px-4 py-2 text-left">URL</th>
                <th class="border px-4 py-2 text-left">Description</th>
            </tr>
            </thead>
            <tbody>
            <tr><td class="border px-4 py-3 font-semibold text-green-600 dark:text-green-400">GET</td><td class="border px-4 py-3"><code>http://127.0.0.1:8000/api/v1/orderDetails</code></td><td class="border px-4 py-3">Retrieve a list of all orders.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-green-600 dark:text-green-400">GET</td><td class="border px-4 py-3"><code>http://127.0.0.1:8000/api/v1/orderDetails/{id}</code></td><td class="border px-4 py-3">Fetch details for a specific order by its ID.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-blue-600 dark:text-blue-400">POST</td><td class="border px-4 py-3"><code>http://127.0.0.1:8000/api/v1/orderDetails</code></td><td class="border px-4 py-3">Create and insert a new order record.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-yellow-600 dark:text-yellow-400">PUT</td><td class="border px-4 py-3"><code>http://127.0.0.1:8000/api/v1/orderDetails/{id}/edit</code></td><td class="border px-4 py-3">Update an existing order's details using its ID.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-red-600 dark:text-red-400">DELETE</td><td class="border px-4 py-3"><code>http://127.0.0.1:8000/api/v1/orderDetails/{id}</code></td><td class="border px-4 py-3">Remove an order record by its ID.</td></tr>
            </tbody>
        </table>

        <h4 class="text-2xl font-medium mt-6 mb-4">👉 Client Routes</h4>
        <ul class="list-disc list-inside text-xl space-y-2 leading-relaxed">
            <li><code class="font-mono">GET http://127.0.0.1:8090/client/orderDetails</code> – View all orders in the client interface.</li>
            <li><code class="font-mono">GET http://127.0.0.1:8090/client/orderDetails/{id}</code> – Display detailed information for a specific order.</li>
            <li><code class="font-mono">GET http://127.0.0.1:8090/client/orderDetails/create</code> – Show the form for creating a new order.</li>
            <li><code class="font-mono">POST http://127.0.0.1:8090/client/orderDetails</code> – Submit and store a new order via the client form.</li>
            <li><code class="font-mono">PUT http://127.0.0.1:8090/client/orderDetails/{id}/edit</code> – Update order details from the client interface.</li>
        </ul>

        {{-- 4. Status Codes --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">4. Status Codes</h3>
        <ul class="list-disc list-inside text-xl space-y-2 leading-relaxed">
            <li><code class="font-mono">200 OK</code>: The request was successful (e.g., data fetched or updated).</li>
            <li><code class="font-mono">201 Created</code>: A new resource has been successfully created.</li>
            <li><code class="font-mono">204 No Content</code>: The request was successful, but no content is returned (e.g., successful deletion).</li>
            <li><code class="font-mono">404 Not Found</code>: The requested resource (order) could not be found.</li>
            <li><code class="font-mono">422 Unprocessable Entity</code>: The request was well-formed but could not be followed due to semantic errors (e.g., invalid input data or non-existent related IDs).</li>
            <li><code class="font-mono">500 Internal Server Error</code>: An unexpected error occurred on the server.</li>
        </ul>

        {{-- 5. Example Usage --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">5. Example Usage</h3>
        <p class="text-lg leading-relaxed">
            To test these API endpoints, we recommend using a tool like <strong class="text-indigo-600 dark:text-indigo-400">Postman</strong> or Insomnia. Select the appropriate HTTP method (GET, POST, PUT, DELETE), enter the full API URL, and click **Send** to execute the request.
        </p>

        <h4 class="text-2xl font-medium mt-6 mb-4">📥 Fetching List of Orders</h4>
        <p class="text-lg leading-relaxed">Use the <code class="font-mono">GET</code> method:</p>
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>http://127.0.0.1:8000/api/v1/orderDetails</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>
        <p class="text-lg mt-4 leading-relaxed">To get a specific order, provide the ID:</p>
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>http://127.0.0.1:8000/api/v1/orderDetails/1</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>

        <h4 class="text-2xl font-medium mt-6 mb-4">📤 Inserting New Order</h4>
        <p class="text-lg leading-relaxed">
            Use <code class="font-mono">POST</code> with the following JSON (set Content-Type to `application/json`):
        </p>
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>{
    "user_id": 1,
    "order_by": "jojo",
    "total": 1249.00,
    "items": [
        { "product_id": 2, "quantity": 2 },
        { "product_id": 2, "quantity": 1 }
    ]
}</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>
        <p class="italic text-lg mt-4 leading-relaxed">
            A <code class="font-mono">201 Created</code> status code indicates the order was inserted successfully. If the <code class="font-mono">user_id</code> or <code class="font-mono">product_id</code> doesn’t exist, you’ll get a <code class="font-mono">422 Unprocessable Entity</code> error.
        </p>

        <h4 class="text-2xl font-medium mt-6 mb-4">✏️ Editing Specific Order</h4>
        <p class="text-lg leading-relaxed">
            Use <code class="font-mono">PUT</code> with this URL:
        </p>
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>http://127.0.0.1:8000/api/v1/orderDetails/{id}/edit</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>
        <p class="italic text-lg mt-4 leading-relaxed">
            Provide the updated JSON in the request body. A status code <code class="font-mono">200 OK</code> indicates the update was successful.
        </p>

        <h4 class="text-2xl font-medium mt-6 mb-4">🗑️ Deleting Specific Order</h4>
        <p class="text-lg leading-relaxed">
            Use <code class="font-mono">DELETE</code> with:
        </p>
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>http://127.0.0.1:8000/api/v1/orderDetails/{id}</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>
        <p class="italic text-lg mt-4 leading-relaxed">
            A status code <code class="font-mono">204 No Content</code> means deletion succeeded (no content will be returned in the response body).
        </p>
    </section>
@endsection
