<x-layouts.app title="{{ __('API Documentation') }}">
    <div class="flex h-full w-full flex-1 flex-col gap-2 p-4">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-200 pb-2 dark:border-gray-800">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">API Documentation</h1>
            <code class="rounded px-2 py-1 text-xs font-mono bg-gray-100 dark:bg-gray-800">{{ config('app.url') }}/api/v1</code>
        </div>

        <!-- Quick Start -->
        <div class="flex flex-wrap gap-2 text-xs p-2 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-800">
            <span class="font-semibold text-blue-900 dark:text-blue-100">Quick Start:</span>
            <code class="bg-white dark:bg-gray-900 rounded px-1.5 py-0.5 font-mono">1. POST /api/v1/auth/login</code>
            <code class="bg-white dark:bg-gray-900 rounded px-1.5 py-0.5 font-mono">2. Add token to Authorization header</code>
            <code class="bg-white dark:bg-gray-900 rounded px-1.5 py-0.5 font-mono">3. JSON requests/responses</code>
        </div>

        <!-- Authentication Section -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-sm font-semibold bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50">
                <span>Authentication (4 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-4 w-4 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-700 bg-white dark:bg-gray-950">
                <!-- POST Register -->
                <div class="px-4 py-2 text-sm">
                    <div class="flex items-start gap-2 mb-2">
                        <span class="bg-green-500 text-white text-xs px-1.5 py-0.5 rounded font-bold">POST</span>
                        <code class="text-gray-700 dark:text-gray-300">/auth/register</code>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">Register new user</p>
                    <details class="text-xs">
                        <summary class="cursor-pointer text-blue-600 dark:text-blue-400">Show example</summary>
                        <pre class="mt-1 p-2 bg-gray-100 dark:bg-gray-900 rounded text-xs overflow-auto"><code>{ "name": "John", "email": "john@example.com", "password": "secret", "password_confirmation": "secret" }</code></pre>
                    </details>
                </div>

                <!-- POST Login -->
                <div class="px-4 py-2 text-sm">
                    <div class="flex items-start gap-2 mb-2">
                        <span class="bg-green-500 text-white text-xs px-1.5 py-0.5 rounded font-bold">POST</span>
                        <code class="text-gray-700 dark:text-gray-300">/auth/login</code>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">Login, returns Sanctum token</p>
                    <details class="text-xs">
                        <summary class="cursor-pointer text-blue-600 dark:text-blue-400">Show example</summary>
                        <pre class="mt-1 p-2 bg-gray-100 dark:bg-gray-900 rounded text-xs overflow-auto"><code>Request: { "email": "user@example.com", "password": "secret" }
Response: { "success": true, "data": { "token": "..." } }</code></pre>
                    </details>
                </div>

                <!-- POST Logout -->
                <div class="px-4 py-2 text-sm">
                    <div class="flex items-start gap-2 mb-2">
                        <span class="bg-green-500 text-white text-xs px-1.5 py-0.5 rounded font-bold">POST</span>
                        <code class="text-gray-700 dark:text-gray-300">/auth/logout</code>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Revoke current token. Requires: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">Authorization: Bearer {token}</code></p>
                </div>

                <!-- POST Change Password -->
                <div class="px-4 py-2 text-sm">
                    <div class="flex items-start gap-2 mb-2">
                        <span class="bg-green-500 text-white text-xs px-1.5 py-0.5 rounded font-bold">POST</span>
                        <code class="text-gray-700 dark:text-gray-300">/auth/change-password</code>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Change password. Requires: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">Authorization: Bearer {token}</code></p>
                </div>
            </div>
        </div>

        <!-- Tasks Section -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-sm font-semibold bg-emerald-50 dark:bg-emerald-900/30 hover:bg-emerald-100 dark:hover:bg-emerald-900/50">
                <span>Tasks (9 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-4 w-4 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-700 bg-white dark:bg-gray-950">
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/tasks</code> — List tasks (role-scoped, filterable by date)</div>
                <div class="px-4 py-2 text-sm"><span class="bg-green-500 text-white text-xs px-1 py-0.5 rounded font-bold">POST</span> <code class="text-gray-700 dark:text-gray-300">/tasks</code> — Create task</div>
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/tasks/stats</code> — Count tasks by status</div>
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/tasks/my-tasks</code> — Tasks created by current user</div>
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/tasks/assigned-to-me</code> — Tasks assigned to current user</div>
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/tasks/{id}</code> — Get task details</div>
                <div class="px-4 py-2 text-sm"><span class="bg-orange-500 text-white text-xs px-1 py-0.5 rounded font-bold">PUT</span> <code class="text-gray-700 dark:text-gray-300">/tasks/{id}</code> — Update task</div>
                <div class="px-4 py-2 text-sm"><span class="bg-red-500 text-white text-xs px-1 py-0.5 rounded font-bold">DELETE</span> <code class="text-gray-700 dark:text-gray-300">/tasks/{id}</code> — Delete task (admin/manager only)</div>
                <div class="px-4 py-2 text-sm"><span class="bg-green-500 text-white text-xs px-1 py-0.5 rounded font-bold">POST</span> <code class="text-gray-700 dark:text-gray-300">/tasks/{id}/assign</code> — Assign task to users</div>
            </div>
        </div>

        <!-- Vehicles Section -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-sm font-semibold bg-amber-50 dark:bg-amber-900/30 hover:bg-amber-100 dark:hover:bg-amber-900/50">
                <span>Vehicles (3 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-4 w-4 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-700 bg-white dark:bg-gray-950">
                <div class="px-4 py-2 text-sm">
                    <div class="flex items-start gap-2 mb-1">
                        <span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span>
                        <code class="text-gray-700 dark:text-gray-300">/vehicles/search</code>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Search by vehicle_id or chassis. Required params: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded text-xs">search_type, search_query, company</code></p>
                </div>
                <div class="px-4 py-2 text-sm"><span class="bg-green-500 text-white text-xs px-1 py-0.5 rounded font-bold">POST</span> <code class="text-gray-700 dark:text-gray-300">/vehicles/upload-images</code> — Upload vehicle images (multipart/form-data)</div>
                <div class="px-4 py-2 text-sm"><span class="bg-green-500 text-white text-xs px-1 py-0.5 rounded font-bold">POST</span> <code class="text-gray-700 dark:text-gray-300">/vehicles/yard</code> — Get yard vehicles. Required: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded text-xs">yard_id, company</code></div>
            </div>
        </div>

        <!-- Schedules Section -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-sm font-semibold bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50">
                <span>Schedules (8 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-4 w-4 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-700 bg-white dark:bg-gray-950">
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/schedules</code> — List (filterable by vessel, voyage, ports)</div>
                <div class="px-4 py-2 text-sm"><span class="bg-green-500 text-white text-xs px-1 py-0.5 rounded font-bold">POST</span> <code class="text-gray-700 dark:text-gray-300">/schedules</code> — Create</div>
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/schedules/{id}</code> — Get with stopovers</div>
                <div class="px-4 py-2 text-sm"><span class="bg-orange-500 text-white text-xs px-1 py-0.5 rounded font-bold">PUT</span> <code class="text-gray-700 dark:text-gray-300">/schedules/{id}</code> — Update</div>
                <div class="px-4 py-2 text-sm"><span class="bg-red-500 text-white text-xs px-1 py-0.5 rounded font-bold">DELETE</span> <code class="text-gray-700 dark:text-gray-300">/schedules/{id}</code> — Delete (admin/manager only)</div>
                <div class="px-4 py-2 text-sm"><span class="bg-green-500 text-white text-xs px-1 py-0.5 rounded font-bold">POST</span> <code class="text-gray-700 dark:text-gray-300">/schedules/{id}/stopovers</code> — Add stopover</div>
                <div class="px-4 py-2 text-sm"><span class="bg-orange-500 text-white text-xs px-1 py-0.5 rounded font-bold">PUT</span> <code class="text-gray-700 dark:text-gray-300">/stopovers/{id}</code> — Update stopover</div>
                <div class="px-4 py-2 text-sm"><span class="bg-red-500 text-white text-xs px-1 py-0.5 rounded font-bold">DELETE</span> <code class="text-gray-700 dark:text-gray-300">/stopovers/{id}</code> — Delete stopover</div>
            </div>
        </div>

        <!-- Ports Section -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-sm font-semibold bg-purple-50 dark:bg-purple-900/30 hover:bg-purple-100 dark:hover:bg-purple-900/50">
                <span>Ports (5 endpoints)</span>
                <svg :class="open && 'rotate-180'" class="h-4 w-4 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-700 bg-white dark:bg-gray-950">
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/ports</code> — List (searchable, sortable)</div>
                <div class="px-4 py-2 text-sm"><span class="bg-green-500 text-white text-xs px-1 py-0.5 rounded font-bold">POST</span> <code class="text-gray-700 dark:text-gray-300">/ports</code> — Create</div>
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/ports/{id}</code> — Get</div>
                <div class="px-4 py-2 text-sm"><span class="bg-orange-500 text-white text-xs px-1 py-0.5 rounded font-bold">PUT</span> <code class="text-gray-700 dark:text-gray-300">/ports/{id}</code> — Update</div>
                <div class="px-4 py-2 text-sm"><span class="bg-red-500 text-white text-xs px-1 py-0.5 rounded font-bold">DELETE</span> <code class="text-gray-700 dark:text-gray-300">/ports/{id}</code> — Delete</div>
            </div>
        </div>

        <!-- Vendors Section -->
        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden dark:border-gray-700">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-sm font-semibold bg-violet-50 dark:bg-violet-900/30 hover:bg-violet-100 dark:hover:bg-violet-900/50">
                <span>Vendors (5 endpoints) — Admin Only</span>
                <svg :class="open && 'rotate-180'" class="h-4 w-4 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div x-show="open" class="divide-y dark:divide-gray-700 bg-white dark:bg-gray-950">
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/vendors</code> — List vendors</div>
                <div class="px-4 py-2 text-sm"><span class="bg-green-500 text-white text-xs px-1 py-0.5 rounded font-bold">POST</span> <code class="text-gray-700 dark:text-gray-300">/vendors</code> — Create</div>
                <div class="px-4 py-2 text-sm"><span class="bg-blue-500 text-white text-xs px-1 py-0.5 rounded font-bold">GET</span> <code class="text-gray-700 dark:text-gray-300">/vendors/{id}</code> — Get</div>
                <div class="px-4 py-2 text-sm"><span class="bg-orange-500 text-white text-xs px-1 py-0.5 rounded font-bold">PUT</span> <code class="text-gray-700 dark:text-gray-300">/vendors/{id}</code> — Update</div>
                <div class="px-4 py-2 text-sm"><span class="bg-red-500 text-white text-xs px-1 py-0.5 rounded font-bold">DELETE</span> <code class="text-gray-700 dark:text-gray-300">/vendors/{id}</code> — Delete</div>
            </div>
        </div>

        <!-- Error Codes -->
        <div class="border rounded-lg overflow-hidden dark:border-gray-700">
            <button @click="$el.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between px-4 py-2 text-sm font-semibold bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50">
                <span>Error Codes</span>
                <svg class="h-4 w-4 transition-transform text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </button>
            <div class="divide-y dark:divide-gray-700 bg-white dark:bg-gray-950">
                <div class="px-4 py-2 text-xs"><span class="font-bold text-red-600">401</span> — Unauthenticated (missing/invalid token)</div>
                <div class="px-4 py-2 text-xs"><span class="font-bold text-red-600">403</span> — Forbidden (insufficient role/permissions)</div>
                <div class="px-4 py-2 text-xs"><span class="font-bold text-red-600">404</span> — Not found</div>
                <div class="px-4 py-2 text-xs"><span class="font-bold text-red-600">422</span> — Validation error (check response.errors)</div>
                <div class="px-4 py-2 text-xs"><span class="font-bold text-red-600">502</span> — External database query failed</div>
            </div>
        </div>

        <!-- Response Format -->
        <div class="border-t pt-2 mt-2 text-xs text-gray-600 dark:text-gray-400">
            <p class="font-semibold text-gray-900 dark:text-white mb-1">Response Format</p>
            <p><strong>Success:</strong> <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">{ "success": true, "message": "...", "data": {...}, "meta": {...} }</code></p>
            <p><strong>Error:</strong> <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">{ "success": false, "message": "...", "errors": {...}, "meta": {...} }</code></p>
        </div>
    </div>
</x-layouts.app>
