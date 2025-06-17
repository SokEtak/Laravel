@extends('apiDocs.layout')

@section('content')
    <section id="inventory" class="prose prose-xl dark:prose-invert max-w-none">
        {{-- Main Section Title --}}
        <h2 class="text-4xl font-bold mb-8">📦 Inventory Documentation</h2>

        {{-- 1. Fillable Fields --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">1. Fillable Fields</h3>
        <ul class="list-disc list-inside text-xl space-y-2 leading-relaxed">
            <li><strong>quantity</strong>: The current stock quantity of a product.</li>
        </ul>

        {{-- 2. Data Validation --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">2. Data Validation</h3>
        <ul class="list-disc list-inside text-xl space-y-3 leading-relaxed">
            <li><strong>quantity</strong>: <code class="font-mono">required</code>, <code class="font-mono">integer</code>, <code class="font-mono">min:0</code> (cannot be negative).</li>
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
            <tr><td class="border px-4 py-3 font-semibold text-green-600 dark:text-green-400">GET</td><td class="border px-4 py-3"><code>/api/v1/inventories</code></td><td class="border px-4 py-3">Retrieve a list of all inventories.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-green-600 dark:text-green-400">GET</td><td class="border px-4 py-3"><code>/api/v1/inventories/{id}</code></td><td class="border px-4 py-3">Fetch details for a specific inventory by its ID.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-blue-600 dark:text-blue-400">POST</td><td class="border px-4 py-3"><code>/api/v1/inventories</code></td><td class="border px-4 py-3">Create and insert a new inventory record.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-yellow-600 dark:text-yellow-400">PUT</td><td class="border px-4 py-3"><code>/api/v1/inventories/{id}/edit</code></td><td class="border px-4 py-3">Update an existing inventory's details using its ID.</td></tr>
            <tr><td class="border px-4 py-3 font-semibold text-red-600 dark:text-red-400">DELETE</td><td class="border px-4 py-3"><code>/api/v1/inventories/{id}</code></td><td class="border px-4 py-3">Remove an inventory record by its ID.</td></tr>
            </tbody>
        </table>

        <h4 class="text-2xl font-medium mt-6 mb-4">👉 Client Routes</h4>
        <ul class="list-disc list-inside text-xl space-y-2 leading-relaxed">
            <li><code class="font-mono">GET /client/inventories</code> – View all inventories in the client interface.</li>
            <li><code class="font-mono">GET /client/inventories/{id}</code> – Display detailed information for a specific inventory.</li>
            <li><code class="font-mono">GET /client/inventories/create</code> – Show the form for creating a new inventory.</li>
            <li><code class="font-mono">POST /client/inventories</code> – Submit and store a new inventory via the client form.</li>
            <li><code class="font-mono">PUT /client/inventories/{id}/edit</code> – Update inventory details from the client interface.</li>
        </ul>

        {{-- 4. Status Codes --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">4. Status Codes</h3>
        <ul class="list-disc list-inside text-xl space-y-2 leading-relaxed">
            <li><code class="font-mono">200 OK</code>: The request was successful (e.g., data fetched or updated).</li>
            <li><code class="font-mono">201 Created</code>: A new resource has been successfully created.</li>
            <li><code class="font-mono">204 No Content</code>: The request was successful, but no content is returned (e.g., successful deletion).</li>
            <li><code class="font-mono">404 Not Found</code>: The requested resource (inventory) could not be found.</li>
            <li><code class="font-mono">500 Internal Server Error</code>: An unexpected error occurred on the server.</li>
        </ul>

        {{-- 5. Example Usage --}}
        <h3 class="text-3xl font-semibold mt-10 mb-3">5. Example Usage</h3>
        <p class="text-lg leading-relaxed">
            To test these API endpoints, we recommend using a tool like <strong class="text-indigo-600 dark:text-indigo-400">Postman</strong> or Insomnia. Select the appropriate HTTP method (GET, POST, PUT, DELETE), enter the full API URL, and click **Send** to execute the request.
        </p>

        <h4 class="text-2xl font-medium mt-6 mb-4">📥 Fetching List of Inventories</h4>
        <p class="text-lg leading-relaxed">
            Use the <code class="font-mono">GET</code> method with the following URL to retrieve all inventories:
        </p>
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>/api/v1/inventories</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>
        <p class="text-lg mt-4 leading-relaxed">To fetch a specific inventory, provide its ID in the URL:</p>
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>/api/v1/inventories/1</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>

        <h4 class="text-2xl font-medium mt-6 mb-4">📤 Inserting New Inventory</h4>
        <p class="text-lg leading-relaxed">
            Use the <code class="font-mono">POST</code> method to <code class="font-mono">/api/v1/inventories</code> and provide the following JSON in the request body (set Content-Type to `application/json`):
        </p>
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>{
    "quantity": 100
}</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>
        <p class="italic text-lg mt-4 leading-relaxed">A <code class="font-mono">201 Created</code> status code indicates that the inventory was successfully added.</p>

        <h4 class="text-2xl font-medium mt-6 mb-4">✏️ Editing a Specific Inventory</h4>
        <p class="text-lg leading-relaxed">
            Use the <code class="font-mono">PUT</code> method with the URL <code class="font-mono">/api/v1/inventories/{id}/edit</code>. Provide the updated inventory data in the request body.
        </p>
        <div class="relative">
            <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded overflow-auto text-sm"><code>{
    "quantity": 150
}</code></pre>
            <button class="absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyCode(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </button>
        </div>
        <p class="italic text-lg mt-4 leading-relaxed">A <code class="font-mono">200 OK</code> response indicates a successful update of the inventory details.</p>

        <h4 class="text-2xl font-medium mt-6 mb-4">🗑️ Deleting a Specific Inventory</h4>
        <p class="text-lg leading-relaxed">
            To remove an inventory, send a <code class="font-mono">DELETE</code> request to <code class="font-mono">/api/v1/inventories/{id}</code>.
        </p>
        <p class="italic text-lg mt-4 leading-relaxed">
            A <code class="font-mono">204 No Content</code> response means the inventory was successfully deleted from your database, and no content is returned in the response body.
        </p>
    </section>
@endsection
