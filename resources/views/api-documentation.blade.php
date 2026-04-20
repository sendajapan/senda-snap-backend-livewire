<x-layouts.app title="{{ __('API Documentation') }}">
    <div class="flex h-full w-full flex-1 flex-col gap-3 p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 dark:border-gray-800">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Senda Snap API Documentation</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">REST API reference for Senda Snap — complete endpoint reference with request/response examples</p>
            <div class="flex items-center gap-3 flex-wrap">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Base URL:</span>
                <code class="bg-gray-100 dark:bg-gray-900 px-3 py-1.5 rounded-md text-sm font-mono text-emerald-600 dark:text-emerald-400 border border-gray-200 dark:border-gray-800">{{ config('app.url') }}/api/v1</code>
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-auto">Version:</span>
                <span class="text-sm font-mono text-gray-600 dark:text-gray-400">v1</span>
            </div>
        </div>

        <!-- Authentication Info -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <h3 class="font-semibold text-blue-900 dark:text-blue-100 text-sm mb-2">Authentication Required</h3>
            <p class="text-xs text-blue-800 dark:text-blue-200 mb-2">All protected endpoints require the <code class="bg-white dark:bg-gray-900 px-1.5 py-0.5 rounded font-mono">Authorization</code> header:</p>
            <code class="block bg-blue-100 dark:bg-blue-900/40 text-blue-900 dark:text-blue-100 px-3 py-2 rounded text-xs font-mono border border-blue-300 dark:border-blue-700">Authorization: Bearer &lt;token&gt;</code>
        </div>

        <!-- Authentication Endpoints -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700 bg-white dark:bg-gray-950">
            <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 text-sm font-semibold bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-900/50 dark:hover:to-blue-800/50 border-b dark:border-gray-700">
                <span class="text-gray-900 dark:text-white">Authentication</span>
                <span class="text-xs font-normal text-gray-600 dark:text-gray-400 mr-3">(4 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-5 w-5 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-800">
                <!-- Register -->
                <div class="px-5 py-4 border-b dark:border-gray-800">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded">POST</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/auth/register</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Public</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Register a new user account</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Request Body</p>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 overflow-auto text-xs"><code>{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secure_password",
  "password_confirmation": "secure_password",
  "phone": "+81312345678"
}</code></pre>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (201)</p>
                            <pre class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 overflow-auto text-xs"><code>{
  "success": true,
  "message": "User registered",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "token": "abc123..."
  }
}</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Login -->
                <div class="px-5 py-4 border-b dark:border-gray-800">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded">POST</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/auth/login</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Public</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Login and receive authentication token</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Request Body</p>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 overflow-auto text-xs"><code>{
  "email": "john@example.com",
  "password": "secure_password"
}</code></pre>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (200)</p>
                            <pre class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 overflow-auto text-xs"><code>{
  "success": true,
  "message": "Login successful",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "token": "abc123xyz..."
  }
}</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Logout -->
                <div class="px-5 py-4 border-b dark:border-gray-800">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded">POST</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/auth/logout</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Protected</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Revoke the current authentication token</p>
                    <div class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 text-xs">
                        <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (200)</p>
                        <pre class="overflow-auto"><code>{ "success": true, "message": "Logged out successfully" }</code></pre>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="px-5 py-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded">POST</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/auth/change-password</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Protected</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Change password for authenticated user</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Request Body</p>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 overflow-auto text-xs"><code>{
  "current_password": "old_password",
  "password": "new_password",
  "password_confirmation": "new_password"
}</code></pre>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (200)</p>
                            <pre class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 overflow-auto text-xs"><code>{
  "success": true,
  "message": "Password changed"
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Endpoints -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700 bg-white dark:bg-gray-950">
            <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 text-sm font-semibold bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/30 hover:from-emerald-100 hover:to-emerald-200 dark:hover:from-emerald-900/50 dark:hover:to-emerald-800/50 border-b dark:border-gray-700">
                <span class="text-gray-900 dark:text-white">Tasks</span>
                <span class="text-xs font-normal text-gray-600 dark:text-gray-400 mr-3">(9 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-5 w-5 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-800">
                <!-- Create Task -->
                <div class="px-5 py-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded">POST</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/tasks</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Protected</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Create a new task</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Request Body</p>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 overflow-auto text-xs"><code>{
  "title": "Prepare documents",
  "description": "Prepare shipping documents",
  "work_date": "2026-04-25",
  "work_time": "09:00",
  "priority": "high",
  "due_date": "2026-04-28"
}</code></pre>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (201)</p>
                            <pre class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 overflow-auto text-xs"><code>{
  "success": true,
  "message": "Task created",
  "data": {
    "id": 42,
    "title": "Prepare documents",
    "status": "pending",
    "priority": "high"
  }
}</code></pre>
                        </div>
                    </div>
                </div>

                <!-- List Tasks -->
                <div class="px-5 py-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-blue-500 text-white text-xs font-bold px-2.5 py-1 rounded">GET</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/tasks?status=pending&date=2026-04-25</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Protected</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">List tasks (filterable by status, date, role). Role-scoped visibility</p>
                    <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 text-xs">
                        <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (200)</p>
                        <pre class="overflow-auto"><code>{ "success": true, "data": [ { "id": 1, "title": "Task 1", "status": "pending", "priority": "high" } ] }</code></pre>
                    </div>
                </div>

                <!-- Update Task Status -->
                <div class="px-5 py-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-orange-500 text-white text-xs font-bold px-2.5 py-1 rounded">POST</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/tasks/{id}/status</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Protected</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Update task status (pending → running → completed)</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Request Body</p>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 overflow-auto text-xs"><code>{
  "status": "running"
}</code></pre>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (200)</p>
                            <pre class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 overflow-auto text-xs"><code>{
  "success": true,
  "data": { "id": 42, "status": "running" }
}</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Other Task Endpoints (Compact) -->
                <div class="px-5 py-3 bg-gray-50 dark:bg-gray-900/30 text-sm space-y-2">
                    <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/tasks</code> <span class="text-xs text-gray-500">List all tasks</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/tasks/{id}</code> <span class="text-xs text-gray-500">Get task details</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded">PUT</span> <code class="font-mono text-sm">/tasks/{id}</code> <span class="text-xs text-gray-500">Update task</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">DELETE</span> <code class="font-mono text-sm">/tasks/{id}</code> <span class="text-xs text-gray-500">Delete task</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded">POST</span> <code class="font-mono text-sm">/tasks/{id}/assign</code> <span class="text-xs text-gray-500">Assign to users</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded">POST</span> <code class="font-mono text-sm">/tasks/{id}/attachments</code> <span class="text-xs text-gray-500">Upload attachment</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">DELETE</span> <code class="font-mono text-sm">/tasks/{id}/attachments/{id}</code> <span class="text-xs text-gray-500">Delete attachment</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/tasks/my-tasks</code> <span class="text-xs text-gray-500">My created tasks</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/tasks/assigned-to-me</code> <span class="text-xs text-gray-500">Assigned to me</span></div>
                </div>
            </div>
        </div>

        <!-- Vehicles Endpoints -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700 bg-white dark:bg-gray-950">
            <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 text-sm font-semibold bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/30 hover:from-amber-100 hover:to-amber-200 dark:hover:from-amber-900/50 dark:hover:to-amber-800/50 border-b dark:border-gray-700">
                <span class="text-gray-900 dark:text-white">Vehicles</span>
                <span class="text-xs font-normal text-gray-600 dark:text-gray-400 mr-3">(3 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-5 w-5 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-800">
                <!-- Search Vehicles -->
                <div class="px-5 py-4 border-b dark:border-gray-800">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-blue-500 text-white text-xs font-bold px-2.5 py-1 rounded">GET</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/vehicles/search</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Protected</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Search vehicles by ID or chassis number. Routes to specified company external database</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Query Parameters</p>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 overflow-auto text-xs"><code>?search_type=vehicle_id
&search_query=12345
&company=acjl

// OR
?search_type=veh_chassis_number
&search_query=ABC123
&company=karmen</code></pre>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (200)</p>
                            <pre class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 overflow-auto text-xs"><code>{
  "success": true,
  "data": {
    "vehicles": [
      {
        "vehicle_id": 12345,
        "make": "Toyota",
        "model": "Land Cruiser",
        "chassis": "ABC123XYZ"
      }
    ],
    "company": "acjl"
  }
}</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Upload Images -->
                <div class="px-5 py-4 border-b dark:border-gray-800">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded">POST</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/vehicles/upload-images</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Protected</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Upload vehicle images to remote SFTP server. Images are stored in vendor SFTP path and indexed in database</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Request (multipart/form-data)</p>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 overflow-auto text-xs"><code>Content-Type: multipart/form-data

vehicle_id: 12345
images: (binary file 1)
images: (binary file 2)

Constraints:
- vehicle_id: required, integer
- images: required array, min 1
- Max 2MB per image
- Formats: jpg, jpeg, png, gif
</code></pre>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (200)</p>
                            <pre class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 overflow-auto text-xs"><code>{
  "success": true,
  "message": "Images uploaded successfully",
  "data": {
    "vehicle_id": 12345,
    "make": "Toyota",
    "model": "Land Cruiser",
    "images": [
      "https://sftp-path.com/vehicles/2026/04/img_001.jpg",
      "https://sftp-path.com/vehicles/2026/04/img_002.jpg"
    ]
  }
}</code></pre>
                        </div>
                    </div>
                    <div class="mt-3 p-2 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-800">
                        <p class="text-xs font-semibold text-blue-900 dark:text-blue-100 mb-1">Example (cURL)</p>
                        <pre class="bg-white dark:bg-gray-900 p-2 rounded text-xs overflow-auto"><code>curl -X POST https://snap.senda.fit/api/v1/vehicles/upload-images \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "vehicle_id=12345" \
  -F "images=@/path/to/image1.jpg" \
  -F "images=@/path/to/image2.jpg"</code></pre>
                    </div>
                </div>

                <!-- Yard Vehicles -->
                <div class="px-5 py-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded">POST</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/vehicles/yard</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Protected</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Get vehicles by yard ID from specified company database</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Request Body</p>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 overflow-auto text-xs"><code>{
  "yard_id": 5,
  "company": "acjl"
}</code></pre>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (200)</p>
                            <pre class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 overflow-auto text-xs"><code>{
  "success": true,
  "data": {
    "vehicles": [ { "vehicle_id": 101, "make": "Toyota" } ],
    "count": 1
  }
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedules Endpoints -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700 bg-white dark:bg-gray-950">
            <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 text-sm font-semibold bg-gradient-to-r from-cyan-50 to-cyan-100 dark:from-cyan-900/30 dark:to-cyan-800/30 hover:from-cyan-100 hover:to-cyan-200 dark:hover:from-cyan-900/50 dark:hover:to-cyan-800/50 border-b dark:border-gray-700">
                <span class="text-gray-900 dark:text-white">Schedules</span>
                <span class="text-xs font-normal text-gray-600 dark:text-gray-400 mr-3">(8 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-5 w-5 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-800">
                <!-- Create Schedule -->
                <div class="px-5 py-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-block bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded">POST</span>
                        <code class="text-gray-800 dark:text-gray-200 font-mono text-sm">/schedules</code>
                        <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">Protected</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Create a new shipment schedule</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Request Body</p>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-800 overflow-auto text-xs"><code>{
  "vessel_name": "MV Alpha",
  "voyage_no": "VOY001",
  "carrier_1_id": 1,
  "start_port_id": 5,
  "end_port_id": 12,
  "eta": "2026-05-10",
  "etd": "2026-04-28",
  "status": "Loading",
  "is_public": true
}</code></pre>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Response (201)</p>
                            <pre class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800 overflow-auto text-xs"><code>{
  "success": true,
  "message": "Schedule created",
  "data": {
    "id": 42,
    "vessel_name": "MV Alpha",
    "status": "Loading"
  }
}</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Other Schedule Endpoints (Compact) -->
                <div class="px-5 py-3 bg-gray-50 dark:bg-gray-900/30 text-sm space-y-2">
                    <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/schedules</code> <span class="text-xs text-gray-500">List schedules (filterable)</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/schedules/{id}</code> <span class="text-xs text-gray-500">Get with stopovers</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded">PUT</span> <code class="font-mono text-sm">/schedules/{id}</code> <span class="text-xs text-gray-500">Update schedule</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">DELETE</span> <code class="font-mono text-sm">/schedules/{id}</code> <span class="text-xs text-gray-500">Delete (admin only)</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded">POST</span> <code class="font-mono text-sm">/schedules/{id}/stopovers</code> <span class="text-xs text-gray-500">Add stopover</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded">PUT</span> <code class="font-mono text-sm">/stopovers/{id}</code> <span class="text-xs text-gray-500">Update stopover</span></div>
                    <div class="flex items-center gap-2"><span class="inline-block bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">DELETE</span> <code class="font-mono text-sm">/stopovers/{id}</code> <span class="text-xs text-gray-500">Delete stopover</span></div>
                </div>
            </div>
        </div>

        <!-- Ports & Vendors (Compact Sections) -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700 bg-white dark:bg-gray-950">
            <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 text-sm font-semibold bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 hover:from-purple-100 hover:to-purple-200 dark:hover:from-purple-900/50 dark:hover:to-purple-800/50 border-b dark:border-gray-700">
                <span class="text-gray-900 dark:text-white">Ports & Vendors</span>
                <span class="text-xs font-normal text-gray-600 dark:text-gray-400 mr-3">(10 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-5 w-5 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="px-5 py-3 space-y-3 divide-y dark:divide-gray-800">
                <div>
                    <p class="font-semibold text-gray-700 dark:text-gray-300 text-sm mb-2">Ports (5 endpoints)</p>
                    <div class="space-y-1.5 text-sm">
                        <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/ports</code> <span class="text-xs text-gray-500">List (searchable)</span></div>
                        <div class="flex items-center gap-2"><span class="inline-block bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded">POST</span> <code class="font-mono text-sm">/ports</code> <span class="text-xs text-gray-500">Create</span></div>
                        <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/ports/{id}</code> <span class="text-xs text-gray-500">Get</span></div>
                        <div class="flex items-center gap-2"><span class="inline-block bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded">PUT</span> <code class="font-mono text-sm">/ports/{id}</code> <span class="text-xs text-gray-500">Update</span></div>
                        <div class="flex items-center gap-2"><span class="inline-block bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">DELETE</span> <code class="font-mono text-sm">/ports/{id}</code> <span class="text-xs text-gray-500">Delete</span></div>
                    </div>
                </div>

                <div class="pt-3">
                    <p class="font-semibold text-gray-700 dark:text-gray-300 text-sm mb-2">Vendors (5 endpoints) — Admin Only</p>
                    <div class="space-y-1.5 text-sm">
                        <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/vendors</code> <span class="text-xs text-gray-500">List</span></div>
                        <div class="flex items-center gap-2"><span class="inline-block bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded">POST</span> <code class="font-mono text-sm">/vendors</code> <span class="text-xs text-gray-500">Create</span></div>
                        <div class="flex items-center gap-2"><span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">GET</span> <code class="font-mono text-sm">/vendors/{id}</code> <span class="text-xs text-gray-500">Get</span></div>
                        <div class="flex items-center gap-2"><span class="inline-block bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded">PUT</span> <code class="font-mono text-sm">/vendors/{id}</code> <span class="text-xs text-gray-500">Update</span></div>
                        <div class="flex items-center gap-2"><span class="inline-block bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">DELETE</span> <code class="font-mono text-sm">/vendors/{id}</code> <span class="text-xs text-gray-500">Delete</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Codes -->
        <div class="border rounded-lg overflow-hidden dark:border-gray-700 bg-white dark:bg-gray-950">
            <div class="px-5 py-3 text-sm font-semibold bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/30 border-b dark:border-gray-700">
                <span class="text-gray-900 dark:text-white">HTTP Status Codes & Error Responses</span>
            </div>
            <div class="px-5 py-3 space-y-3 text-xs">
                <div class="flex gap-3 pb-3 border-b dark:border-gray-800">
                    <span class="font-bold text-red-600 dark:text-red-400 min-w-12">401</span>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Unauthenticated</p>
                        <p class="text-gray-600 dark:text-gray-400">Missing or invalid <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">Authorization</code> header</p>
                    </div>
                </div>
                <div class="flex gap-3 pb-3 border-b dark:border-gray-800">
                    <span class="font-bold text-red-600 dark:text-red-400 min-w-12">403</span>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Forbidden</p>
                        <p class="text-gray-600 dark:text-gray-400">User lacks required role or permissions</p>
                    </div>
                </div>
                <div class="flex gap-3 pb-3 border-b dark:border-gray-800">
                    <span class="font-bold text-red-600 dark:text-red-400 min-w-12">404</span>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Not Found</p>
                        <p class="text-gray-600 dark:text-gray-400">Resource does not exist</p>
                    </div>
                </div>
                <div class="flex gap-3 pb-3 border-b dark:border-gray-800">
                    <span class="font-bold text-red-600 dark:text-red-400 min-w-12">422</span>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Validation Error</p>
                        <p class="text-gray-600 dark:text-gray-400">Request validation failed. Check <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">response.errors</code></p>
                        <pre class="mt-2 bg-gray-100 dark:bg-gray-900 p-2 rounded border border-gray-200 dark:border-gray-800 overflow-auto"><code>{ "success": false, "errors": { "email": ["Email required"] } }</code></pre>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="font-bold text-red-600 dark:text-red-400 min-w-12">502</span>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">External Database Error</p>
                        <p class="text-gray-600 dark:text-gray-400">Vehicle search/query to external database failed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-800 text-xs text-gray-600 dark:text-gray-400">
            <p><strong>API Version:</strong> v1</p>
            <p><strong>Last Updated:</strong> April 2026</p>
            <p><strong>For Support:</strong> Contact the development team</p>
        </div>
    </div>
</x-layouts.app>
