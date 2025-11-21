<x-layouts.app title="{{ __('API Documentation') }}">
    <div class="flex h-full w-full flex-1 flex-col gap-4 p-6">
        <!-- Header Section -->
        <x-page-header
            :title="__('API Documentation')"
            :description="__('Complete REST API reference for your Android application')"
            variant="violet">
            <x-slot:icon>
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </x-slot:icon>
            <x-slot:actions>
                <div
                    class="flex items-center gap-2 rounded-lg bg-gray-900/80 px-3 py-2 backdrop-blur-sm border border-white/30 shadow-lg">
                    <span class="text-sm font-semibold text-white">Base URL:</span>
                    <code
                        class="rounded-md bg-gray-800 px-3 py-1.5 text-sm font-mono font-bold text-emerald-300 shadow-sm border border-emerald-500/30">{{ config('app.url') }}
                        /api/v1</code>
                </div>
            </x-slot:actions>
        </x-page-header>

        <!-- Quick Start Card -->
        <x-table-card variant="violet">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Quick Start Guide</h3>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div
                        class="rounded-xl bg-gradient-to-br from-violet-50 to-purple-50 p-6 dark:from-violet-900/20 dark:to-purple-900/20">
                        <div
                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-violet-500 text-white">
                            <span class="text-xl font-bold">1</span>
                        </div>
                        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Register/Login</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">Register or login to get your authentication
                            token</p>
                    </div>

                    <div
                        class="rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 p-6 dark:from-blue-900/20 dark:to-cyan-900/20">
                        <div
                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-blue-500 text-white">
                            <span class="text-xl font-bold">2</span>
                        </div>
                        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Add Token</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">Include the token in the Authorization
                            header for all protected endpoints</p>
                    </div>

                    <div
                        class="rounded-xl bg-gradient-to-br from-violet-50 to-purple-50 p-6 dark:from-violet-900/20 dark:to-purple-900/20">
                        <div
                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-violet-500 text-white">
                            <span class="text-xl font-bold">3</span>
                        </div>
                        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Use JSON</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">All requests and responses use JSON
                            format</p>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Authentication Section -->
        <x-table-card variant="blue">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Authentication</h3>
                </div>

                <!-- Register -->
                <div
                    class="space-y-3 rounded-xl border border-blue-200 bg-white/50 p-6 dark:border-blue-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Register</h4>
                        <div class="flex items-center gap-2">
                            <button
                                onclick="downloadEndpoint('register', 'POST', '/api/v1/auth/register', { name: 'John Doe', email: 'john@example.com', password: 'password123', password_confirmation: 'password123', phone: '1234567890', role: 'client' }, { success: true, message: 'User registered successfully', data: { user: { id: 1, name: 'John Doe', email: 'john@example.com' }, token: '1|abc123...' } })"
                                class="rounded-lg bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800 transition-colors hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                            <span
                                class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                        </div>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/auth/register</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                {
                                    "name": "John Doe",
                                    "email": "john@example.com",
                                    "password": "password123",
                                    "password_confirmation": "password123",
                                    "phone": "1234567890",
                                    "role": "client"
                                }
                            </code>
                        </pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (201):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                {
                                    "success": true,
                                    "message": "User registered successfully",
                                    "data": {
                                        "user": {
                                            "id": 1,
                                            "name": "John Doe",
                                            "email": "john@example.com",
                                            "phone": "1234567890",
                                            "role": "client",
                                            "avis_id": null,
                                            "avatar": null,
                                            "avatar_url": null,
                                            "email_verified_at": null,
                                            "created_at": "2024-01-01T08:00:00.000000Z",
                                            "updated_at": "2024-01-01T08:00:00.000000Z"
                                        },
                                        "token": "1|abc123..."
                                    }
                                }
                            </code>
                        </pre>
                    </div>
                </div>

                <!-- Login -->
                <div
                    class="space-y-3 rounded-xl border border-blue-200 bg-white/50 p-6 dark:border-blue-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Login</h4>
                        <div class="flex items-center gap-2">
                            <button
                                onclick="downloadEndpoint('login', 'POST', '/api/v1/auth/login', { email: 'john@example.com', password: 'password123' }, { success: true, message: 'Login successful', data: { user: { id: 1, name: 'John Doe', email: 'john@example.com' }, token: '2|xyz789...' } })"
                                class="rounded-lg bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800 transition-colors hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                            <span
                                class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                        </div>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/auth/login</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                {
                                    "email": "john@example.com",
                                    "password": "password123"
                                }
                            </code>
                        </pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                {
                                    "success": true,
                                    "message": "Login successful",
                                    "data": {
                                        "user": {
                                            "id": 1,
                                            "name": "John Doe",
                                            "email": "john@example.com",
                                            "phone": "1234567890",
                                            "role": "admin",
                                            "avis_id": "AV123456",
                                            "avatar": "avatars/user1.jpg",
                                            "avatar_url": "http://your-app.test/storage/avatars/user1.jpg",
                                            "email_verified_at": "2024-01-15T10:30:00.000000Z",
                                            "created_at": "2024-01-01T08:00:00.000000Z",
                                            "updated_at": "2024-01-15T10:30:00.000000Z"
                                        },
                                        "token": "2|xyz789..."
                                    }
                                }
                            </code>
                        </pre>
                    </div>
                </div>

                <!-- Logout -->
                <div
                    class="space-y-3 rounded-xl border border-blue-200 bg-white/50 p-6 dark:border-blue-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Logout</h4>
                        <div class="flex items-center gap-2">
                            <button
                                onclick="downloadEndpoint('logout', 'POST', '/api/v1/auth/logout', null, { success: true, message: 'Logged out successfully' })"
                                class="rounded-lg bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800 transition-colors hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                            <span
                                class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                        </div>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/auth/logout</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Users Section -->
        <x-table-card variant="blue">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Users</h3>
                </div>

                <!-- Get All Users -->
                <div
                    class="space-y-3 rounded-xl border border-blue-200 bg-white/50 p-6 dark:border-blue-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Get All Users</h4>
                        <div class="flex items-center gap-2">
                            <button
                                onclick="downloadEndpoint('get-all-users', 'GET', '/api/v1/users', null, { success: true, message: 'Users retrieved successfully', data: { users: [{ id: 1, name: 'John Doe', email: 'john@example.com', role: 'admin', phone: '1234567890' }] } })"
                                class="rounded-lg bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800 transition-colors hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                            <span
                                class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                        </div>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/users</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                {
                                    "success": true,
                                    "message": "Users retrieved successfully",
                                    "data": {
                                        "users": [
                                            {
                                                "id": 1,
                                                "name": "John Doe",
                                                "email": "john@example.com",
                                                "phone": "1234567890",
                                                "role": "admin",
                                                "avis_id": "AV123456",
                                                "avatar": "avatars/user1.jpg",
                                                "avatar_url": "http://your-app.test/storage/avatars/user1.jpg",
                                                "email_verified_at": "2024-01-15T10:30:00.000000Z",
                                                "created_at": "2024-01-01T08:00:00.000000Z",
                                                "updated_at": "2024-01-15T10:30:00.000000Z"
                                            }
                                        ]
                                    }
                                }
                            </code>
                        </pre>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Tasks Section -->
        <x-table-card variant="emerald">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Tasks</h3>
                </div>

                <!-- Get All Tasks -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Get All Tasks</h4>
                        <div class="flex items-center gap-2">
                            <button onclick="downloadEndpoint('get-all-tasks', 'GET', '/api/v1/tasks')"
                                    class="rounded-lg bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800 transition-colors hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                            <span
                                class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                        </div>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Query Parameters (Optional):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                from_date: YYYY-MM-DD (filter by work date)
                                to_date:   YYYY-MM-DD (filter by work date)
                                per_page:  number (default: 15)
                            </code>
                        </pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                {
                                    "success": true,
                                    "message": "Tasks retrieved successfully",
                                    "data": {
                                        "tasks": [
                                            {
                                                "id": 1,
                                                "title": "Complete inspection",
                                                "description": "Full vehicle inspection",
                                                "work_date": "2024-12-20",
                                                "work_time": "10:00",
                                                "status": "pending",
                                                "priority": "high",
                                                "due_date": "2024-12-31",
                                                "assigned_users": [
                                                    {
                                                        "id": 2,
                                                        "name": "John Doe",
                                                        "email": "john@example.com",
                                                        "phone": "1234567890",
                                                        "role": "employee",
                                                        "avis_id": "AV789012",
                                                        "avatar": "avatars/user2.jpg",
                                                        "avatar_url": "http://your-app.test/storage/avatars/user2.jpg",
                                                        "email_verified_at": "2024-01-10T09:00:00.000000Z",
                                                        "created_at": "2024-01-05T08:00:00.000000Z",
                                                        "updated_at": "2024-01-10T09:00:00.000000Z"
                                                    },
                                                    {
                                                        "id": 3,
                                                        "name": "Jane Smith",
                                                        "email": "jane@example.com",
                                                        "phone": "0987654321",
                                                        "role": "employee",
                                                        "avis_id": "AV345678",
                                                        "avatar": "avatars/user3.jpg",
                                                        "avatar_url": "http://your-app.test/storage/avatars/user3.jpg",
                                                        "email_verified_at": "2024-01-12T11:00:00.000000Z",
                                                        "created_at": "2024-01-08T08:00:00.000000Z",
                                                        "updated_at": "2024-01-12T11:00:00.000000Z"
                                                    }
                                                ],
                                                "creator": {
                                                    "id": 1,
                                                    "name": "Admin User",
                                                    "email": "admin@example.com",
                                                    "phone": "5551234567",
                                                    "role": "admin",
                                                    "avis_id": "AV123456",
                                                    "avatar": "avatars/admin.jpg",
                                                    "avatar_url": "http://your-app.test/storage/avatars/admin.jpg",
                                                    "email_verified_at": "2024-01-01T08:00:00.000000Z",
                                                    "created_at": "2024-01-01T08:00:00.000000Z",
                                                    "updated_at": "2024-01-15T10:30:00.000000Z"
                                                }
                                            }
                                        ],
                                        "pagination": {
                                            "current_page": 1,
                                            "last_page": 5,
                                            "per_page": 15,
                                            "total": 75
                                        }
                                    }
                                }
                            </code>
                        </pre>
                    </div>
                </div>

                <!-- Create Task -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Create Task</h4>
                        <div class="flex items-center gap-2">
                            <button onclick="downloadEndpoint('create-task', 'POST', '/api/v1/tasks')"
                                    class="rounded-lg bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800 transition-colors hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                            <span
                                class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                        </div>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                Authorization: Bearer {token} Content-Type: multipart/form-data
                            </code>
                        </pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request (multipart/form-data):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                title:         Complete inspection
                                description:   Full vehicle inspection required
                                work_date:     2024-12-20
                                work_time:     10:00
                                priority:      high
                                assigned_to[]: 2
                                assigned_to[]: 3
                                due_date:      2024-12-31
                                attachments[]: (file)
                                attachments[]: (file)
                            </code>
                        </pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Field Descriptions:</p>
                        <div class="rounded-lg bg-gray-900 p-4 dark:bg-gray-950">
                            <ul class="space-y-1 text-xs text-gray-100">
                                <li>• <code class="text-emerald-400">title</code> (required): Task title</li>
                                <li>• <code class="text-emerald-400">description</code> (optional): Task description
                                </li>
                                <li>• <code class="text-emerald-400">work_date</code> (optional): Date for task
                                    (YYYY-MM-DD)
                                </li>
                                <li>• <code class="text-emerald-400">work_time</code> (optional): Time for task (HH:MM
                                    or HH:MM:SS)
                                </li>
                                <li>• <code class="text-emerald-400">priority</code> (required): low, medium, high,
                                    urgent
                                </li>
                                <li>• <code class="text-emerald-400">assigned_to</code> (optional): Array of user IDs
                                </li>
                                <li>• <code class="text-emerald-400">attachments[]</code> (optional, files): Multiple
                                    attachments (max 10MB each)
                                </li>
                                <li>• <code class="text-emerald-400">due_date</code> (optional): Due date (YYYY-MM-DD)
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (201):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                {
                                    "success": true,
                                    "message": "Task created successfully",
                                    "data": {
                                        "task": {
                                            "id": 1,
                                            "title": "Complete inspection",
                                            "description": "Full vehicle inspection required",
                                            "work_date": "2024-12-20",
                                            "work_time": "10:00",
                                            "status": "pending",
                                            "priority": "high",
                                            "due_date": "2024-12-31",
                                            "assigned_users": [
                                                {
                                                    "id": 2,
                                                    "name": "John Doe",
                                                    "email": "john@example.com",
                                                    "phone": "1234567890",
                                                    "role": "employee",
                                                    "avis_id": "AV789012",
                                                    "avatar": "avatars/user2.jpg",
                                                    "avatar_url": "http://your-app.test/storage/avatars/user2.jpg",
                                                    "email_verified_at": "2024-01-10T09:00:00.000000Z",
                                                    "created_at": "2024-01-05T08:00:00.000000Z",
                                                    "updated_at": "2024-01-10T09:00:00.000000Z"
                                                },
                                                {
                                                    "id": 3,
                                                    "name": "Jane Smith",
                                                    "email": "jane@example.com",
                                                    "phone": "0987654321",
                                                    "role": "employee",
                                                    "avis_id": "AV345678",
                                                    "avatar": "avatars/user3.jpg",
                                                    "avatar_url": "http://your-app.test/storage/avatars/user3.jpg",
                                                    "email_verified_at": "2024-01-12T11:00:00.000000Z",
                                                    "created_at": "2024-01-08T08:00:00.000000Z",
                                                    "updated_at": "2024-01-12T11:00:00.000000Z"
                                                }
                                            ],
                                            "creator": {
                                                "id": 1,
                                                "name": "Admin User",
                                                "email": "admin@example.com",
                                                "phone": "5551234567",
                                                "role": "admin",
                                                "avis_id": "AV123456",
                                                "avatar": "avatars/admin.jpg",
                                                "avatar_url": "http://your-app.test/storage/avatars/admin.jpg",
                                                "email_verified_at": "2024-01-01T08:00:00.000000Z",
                                                "created_at": "2024-01-01T08:00:00.000000Z",
                                                "updated_at": "2024-01-15T10:30:00.000000Z"
                                            },
                                            "created_at": "2024-12-20T08:00:00.000000Z",
                                            "updated_at": "2024-12-20T08:00:00.000000Z"
                                        }
                                    }
                                }
                            </code>
                        </pre>
                    </div>
                </div>

                <!-- Update Task -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Update Task</h4>
                        <span
                            class="rounded-lg bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">PUT</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks/{id}</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: multipart/form-data</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request (multipart/form-data,
                            all fields optional):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>title:               Updated task title
description:         Updated description
work_date:           2024-12-25
work_time:           14:00
priority:            urgent
assigned_to[]:       2
assigned_to[]:       5
due_date:            2024-12-31

attachments_update:  true | false
attachments[]:       (file)
attachments[]:       (file)</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-xs text-gray-600 dark:text-gray-400">If <code class="text-emerald-400">attachments_update</code>
                            is true and no files are sent, all existing attachments will be removed. If files are sent,
                            existing attachments are replaced with the new set.</p>
                    </div>
                </div>

                <!-- Delete Task -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Task</h4>
                        <span
                            class="rounded-lg bg-red-100 px-3 py-1 text-xs font-bold text-red-800 dark:bg-red-900/30 dark:text-red-400">DELETE</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks/{id}</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Note:</strong> This will permanently delete the task and all its attachments. This action cannot be undone.
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Authorization:</strong> Only users with <code class="text-emerald-400">admin</code> or <code class="text-emerald-400">manager</code> roles can delete tasks.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                {
                                    "success": true,
                                    "message": "Task deleted successfully",
                                    "data": []
                                }
                            </code>
                        </pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Error Response (403):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950">
                            <code>
                                {
                                    "success": false,
                                    "message": "Unauthorized. Only admin or manager can delete tasks.",
                                    "data": []
                                }
                            </code></pre>
                    </div>
                </div>

                <!-- Assign Users to Task -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Assign Users to Task</h4>
                        <span
                            class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks/{id}/assign</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: application/json</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "assigned_to": [2, 3, 5]
}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Note:</strong> This will replace all existing assignments with the new user list.
                        </p>
                    </div>
                </div>

                <!-- Update Task Status -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Update Task Status</h4>
                        <span
                            class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks/{id}/status</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: application/json</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "status": "completed"
}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Status Options:</p>
                        <div class="rounded-lg bg-gray-900 p-4 dark:bg-gray-950">
                            <ul class="space-y-1 text-xs text-gray-100">
                                <li>• <code class="text-emerald-400">pending</code> - Task is pending</li>
                                <li>• <code class="text-emerald-400">running</code> - Task is in progress</li>
                                <li>• <code class="text-emerald-400">completed</code> - Task is completed</li>
                                <li>• <code class="text-emerald-400">cancelled</code> - Task is cancelled</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Upload Task Attachment -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Upload Task Attachment</h4>
                        <span
                            class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks/{id}/attachments</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: multipart/form-data</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body (Form Data):</p>
                        <div class="rounded-lg bg-gray-900 p-4 dark:bg-gray-950">
                            <ul class="space-y-1 text-xs text-gray-100">
                                <li>• <code class="text-emerald-400">file</code> (required): File to upload (max 10MB)
                                </li>
                                <li>• <code class="text-emerald-400">file_name</code> (optional): Custom file name</li>
                            </ul>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (201):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": true,
    "message": "Attachment uploaded successfully",
    "data": {
        "attachment": {
            "id": 1,
            "task_id": 5,
            "file_name": "document.pdf",
            "file_path": "task-attachments/xyz.pdf",
            "file_type": "application/pdf",
            "uploaded_by": 1,
            "created_at": "2024-12-20T10:00:00.000000Z"
        }
    }
}</code></pre>
                    </div>
                </div>

                <!-- Delete Task Attachment -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Task Attachment</h4>
                        <span
                            class="rounded-lg bg-red-100 px-3 py-1 text-xs font-bold text-red-800 dark:bg-red-900/30 dark:text-red-400">DELETE</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks/{task_id}/attachments/{attachment_id}</code>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Note:</strong> Only the uploader, admin, or manager can delete an attachment.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": true,
    "message": "Attachment deleted successfully",
    "data": []
}</code></pre>
                    </div>
                </div>

                <!-- Get My Tasks -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Get My Created Tasks</h4>
                        <span
                            class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks/my-tasks</code>

                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Returns all tasks created by the
                            authenticated user.</p>
                    </div>
                </div>

                <!-- Get Tasks Assigned to Me -->
                <div
                    class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Get Tasks Assigned to Me</h4>
                        <span
                            class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/tasks/assigned-to-me</code>

                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Returns all tasks where the authenticated
                            user is one of the assignees.</p>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Vehicles Section -->
        <x-table-card variant="amber">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Vehicles</h3>
                </div>

                <!-- Search Vehicles -->
                <div
                    class="space-y-3 rounded-xl border border-amber-200 bg-white/50 p-6 dark:border-amber-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Search Vehicles</h4>
                        <div class="flex items-center gap-2">
                            <button
                                onclick="downloadEndpoint('search-vehicles', 'GET', '/api/v1/vehicles/search', null, { success: true, message: 'Search completed', data: { vehicles: [{ vehicle_id: 'V12345', veh_chassis_number: 'CH123456789', make: 'Toyota', model: 'Camry', year: 2023, color: 'White' }] } })"
                                class="rounded-lg bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-800 transition-colors hover:bg-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:hover:bg-amber-900/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                            <span
                                class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                        </div>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/vehicles/search</code>

                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Search for vehicles in external database by vehicle ID or chassis number.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Query Parameters:</p>
                        <div class="rounded-lg bg-gray-900 p-4 dark:bg-gray-950">
                            <ul class="space-y-1 text-xs text-gray-100">
                                <li>• <code class="text-emerald-400">search_type</code> (required): Type of search -
                                    <code class="text-amber-400">vehicle_id</code> or <code class="text-amber-400">veh_chassis_number</code>
                                </li>
                                <li>• <code class="text-emerald-400">search_query</code> (required): Search value
                                    (vehicle ID or chassis number)
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Example Request:</p>
                        <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/vehicles/search?search_type=vehicle_id&search_query=V12345</code>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": true,
    "message": "Search completed",
    "data": {
        "vehicles": [
            {
                "vehicle_id": "V12345",
                "veh_chassis_number": "CH123456789",
                "make": "Toyota",
                "model": "Camry",
                "year": 2023,
                "color": "White"
            }
        ]
    }
}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Error Response (422):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "search_type": ["The search type field is required."],
        "search_query": ["The search query field is required."]
    }
}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Error Response (502):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": false,
    "message": "External database query failed",
    "errors": {
        "error": "Database connection error"
    }
}</code></pre>
                    </div>
                </div>

                <!-- Upload Vehicle Images -->
                <div
                    class="space-y-3 rounded-xl border border-amber-200 bg-white/50 p-6 dark:border-amber-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Upload Vehicle Images</h4>
                        <div class="flex items-center gap-2">
                            <button
                                onclick="downloadEndpoint('upload-vehicle-images', 'POST', '/api/v1/vehicles/upload-images', { vehicle_id: 123, images: ['file1', 'file2'] }, { success: true, message: 'Images uploaded successfully', data: { vehicle: { id: 123, vehicle_id: 'V12345', images: ['uploads/vehicle1.jpg', 'uploads/vehicle2.jpg'] } } })"
                                class="rounded-lg bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-800 transition-colors hover:bg-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:hover:bg-amber-900/50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                            <span
                                class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                        </div>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/v1/vehicles/upload-images</code>

                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Upload multiple images for a vehicle to external database.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: multipart/form-data</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body (Form Data):</p>
                        <div class="rounded-lg bg-gray-900 p-4 dark:bg-gray-950">
                            <ul class="space-y-1 text-xs text-gray-100">
                                <li>• <code class="text-emerald-400">vehicle_id</code> (required): Vehicle ID (integer)
                                    from external database
                                </li>
                                <li>• <code class="text-emerald-400">images</code> (required): Array of image files
                                    (min: 1 image)
                                </li>
                                <li>• <code class="text-emerald-400">images.*</code>: Each image must be a valid image
                                    file, max 2MB per file
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Accepted Image Formats:</p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="rounded-lg bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">JPEG</span>
                            <span
                                class="rounded-lg bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">JPG</span>
                            <span
                                class="rounded-lg bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">PNG</span>
                            <span
                                class="rounded-lg bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">GIF</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": true,
    "message": "Images uploaded successfully",
    "data": {
        "vehicle": {
            "id": 123,
            "vehicle_id": "V12345",
            "make": "Toyota",
            "model": "Camry",
            "images": [
                "uploads/vehicle_123_image1.jpg",
                "uploads/vehicle_123_image2.jpg"
            ],
            "uploaded_at": "2024-12-20T10:30:00.000000Z"
        }
    }
}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Error Response (422):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "vehicle_id": ["The vehicle id field is required."],
        "images": ["The images field is required."],
        "images.0": ["The images.0 must be an image.", "The images.0 must not be greater than 2048 kilobytes."]
    }
}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Error Response (404):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": false,
    "message": "Vehicle not found in external database",
    "errors": []
}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Error Response (502):</p>
                        <pre
                            class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": false,
    "message": "External database query failed",
    "errors": {
        "error": "Database connection error"
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Error Responses -->
        <x-table-card variant="violet">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-pink-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Error Responses</h3>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <!-- 401 -->
                    <div
                        class="space-y-2 rounded-xl border border-red-200 bg-red-50/50 p-4 dark:border-red-900/50 dark:bg-red-900/10">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-red-900 dark:text-red-400">Unauthenticated</h4>
                            <span
                                class="rounded bg-red-200 px-2 py-1 text-xs font-bold text-red-900 dark:bg-red-900/50 dark:text-red-400">401</span>
                        </div>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-3 text-xs text-gray-100"><code>{
    "success": false,
    "message": "Unauthenticated. Please login first."
}</code></pre>
                    </div>

                    <!-- 403 -->
                    <div
                        class="space-y-2 rounded-xl border border-orange-200 bg-orange-50/50 p-4 dark:border-orange-900/50 dark:bg-orange-900/10">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-orange-900 dark:text-orange-400">Unauthorized</h4>
                            <span
                                class="rounded bg-orange-200 px-2 py-1 text-xs font-bold text-orange-900 dark:bg-orange-900/50 dark:text-orange-400">403</span>
                        </div>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-3 text-xs text-gray-100"><code>{
    "success": false,
    "message": "Unauthorized."
}</code></pre>
                    </div>

                    <!-- 404 -->
                    <div
                        class="space-y-2 rounded-xl border border-yellow-200 bg-yellow-50/50 p-4 dark:border-yellow-900/50 dark:bg-yellow-900/10">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-yellow-900 dark:text-yellow-400">Not Found</h4>
                            <span
                                class="rounded bg-yellow-200 px-2 py-1 text-xs font-bold text-yellow-900 dark:bg-yellow-900/50 dark:text-yellow-400">404</span>
                        </div>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-3 text-xs text-gray-100"><code>{
    "success": false,
    "message": "Resource not found."
}</code></pre>
                    </div>

                    <!-- 422 -->
                    <div
                        class="space-y-2 rounded-xl border border-purple-200 bg-purple-50/50 p-4 dark:border-purple-900/50 dark:bg-purple-900/10">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-purple-900 dark:text-purple-400">Validation Error</h4>
                            <span
                                class="rounded bg-purple-200 px-2 py-1 text-xs font-bold text-purple-900 dark:bg-purple-900/50 dark:text-purple-400">422</span>
                        </div>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-3 text-xs text-gray-100"><code>{
    "success": false,
    "message": "Validation failed.",
    "errors": { ... }
}</code></pre>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Postman Testing Guide -->
        <x-table-card variant="violet">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Testing with Postman</h3>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div
                        class="rounded-xl bg-gradient-to-br from-violet-50 to-purple-50 p-6 dark:from-violet-900/20 dark:to-purple-900/20">
                        <div
                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-violet-500 text-white">
                            <span class="text-xl font-bold">1</span>
                        </div>
                        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Login First</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">Make a POST request to <code
                                class="rounded bg-white/50 px-1 dark:bg-gray-800">/api/v1/auth/login</code> with your
                            credentials</p>
                    </div>

                    <div
                        class="rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 p-6 dark:from-blue-900/20 dark:to-cyan-900/20">
                        <div
                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-blue-500 text-white">
                            <span class="text-xl font-bold">2</span>
                        </div>
                        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Copy Token</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">Copy the token from the response data
                            object</p>
                    </div>

                    <div
                        class="rounded-xl bg-gradient-to-br from-violet-50 to-purple-50 p-6 dark:from-violet-900/20 dark:to-purple-900/20">
                        <div
                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-violet-500 text-white">
                            <span class="text-xl font-bold">3</span>
                        </div>
                        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Add Header</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">Add <code
                                class="rounded bg-white/50 px-1 dark:bg-gray-800">Authorization: Bearer {token}</code>
                            to headers</p>
                    </div>
                </div>
            </div>
        </x-table-card>
    </div>

    <script>
        function downloadEndpoint(name, method, endpoint, requestBody = null, responseBody = null) {
            const data = {
                name: name,
                method: method,
                endpoint: endpoint,
                baseUrl: "{{ config('app.url') }}/api/v1",
                fullUrl: "{{ config('app.url') }}" + endpoint,
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Bearer {your_token_here}"
                }
            };

            if (requestBody) {
                data.requestBody = requestBody;
            }

            if (responseBody) {
                data.exampleResponse = responseBody;
            }

            const jsonString = JSON.stringify(data, null, 2);
            const blob = new Blob([jsonString], {type: 'application/json'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${name.toLowerCase().replace(/\s+/g, '-')}-endpoint.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    </script>

    @push('scripts')
        <script>
            (function() {
                const canvas = document.getElementById('particle-canvas');
                if (!canvas) return;

                // Show canvas for API documentation
                canvas.style.display = 'block';

                const ctx = canvas.getContext('2d');
                let particles = [];
                let animationId;

                // Set canvas size
                function resizeCanvas() {
                    canvas.width = window.innerWidth;
                    canvas.height = window.innerHeight;
                }
                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);

                // Color palette matching design system
                const colorPalettes = {
                    light: {
                        violet: '124, 58, 237',
                        blue: '59, 130, 246',
                        emerald: '16, 185, 129',
                        amber: '245, 158, 11',
                        purple: '168, 85, 247',
                        cyan: '6, 182, 212',
                        teal: '20, 184, 166',
                        orange: '249, 115, 22'
                    },
                    dark: {
                        violet: '139, 92, 246',
                        blue: '96, 165, 250',
                        emerald: '52, 211, 153',
                        amber: '251, 191, 36',
                        purple: '192, 132, 252',
                        cyan: '34, 211, 238',
                        teal: '45, 212, 191',
                        orange: '251, 146, 60'
                    }
                };

                // Particle class
                class Particle {
                    constructor() {
                        this.x = Math.random() * canvas.width;
                        this.y = Math.random() * canvas.height;
                        this.size = Math.random() * 2 + 0.5;
                        this.speedX = (Math.random() - 0.5) * 0.5;
                        this.speedY = (Math.random() - 0.5) * 0.5;
                        this.opacity = Math.random() * 0.5 + 0.2;

                        // Randomly assign a color from the palette
                        const isDark = document.documentElement.classList.contains('dark');
                        const palette = isDark ? colorPalettes.dark : colorPalettes.light;
                        const colors = Object.values(palette);
                        this.color = colors[Math.floor(Math.random() * colors.length)];
                    }

                    update() {
                        this.x += this.speedX;
                        this.y += this.speedY;

                        if (this.x > canvas.width) this.x = 0;
                        if (this.x < 0) this.x = canvas.width;
                        if (this.y > canvas.height) this.y = 0;
                        if (this.y < 0) this.y = canvas.height;
                    }

                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                        ctx.fillStyle = `rgba(${this.color}, ${this.opacity})`;
                        ctx.fill();
                    }
                }

                // Create particles
                function initParticles() {
                    particles = [];
                    const particleCount = Math.floor((canvas.width * canvas.height) / 15000);
                    for (let i = 0; i < particleCount; i++) {
                        particles.push(new Particle());
                    }
                }

                // Draw connections
                function drawConnections() {
                    for (let i = 0; i < particles.length; i++) {
                        for (let j = i + 1; j < particles.length; j++) {
                            const dx = particles[i].x - particles[j].x;
                            const dy = particles[i].y - particles[j].y;
                            const distance = Math.sqrt(dx * dx + dy * dy);

                            if (distance < 120) {
                                ctx.beginPath();
                                // Use gradient between two particle colors - darker opacity
                                const gradient = ctx.createLinearGradient(
                                    particles[i].x, particles[i].y,
                                    particles[j].x, particles[j].y
                                );
                                gradient.addColorStop(0, `rgba(${particles[i].color}, ${0.3 * (1 - distance / 120)})`);
                                gradient.addColorStop(1, `rgba(${particles[j].color}, ${0.3 * (1 - distance / 120)})`);
                                ctx.strokeStyle = gradient;
                                ctx.lineWidth = 0.5;
                                ctx.moveTo(particles[i].x, particles[i].y);
                                ctx.lineTo(particles[j].x, particles[j].y);
                                ctx.stroke();
                            }
                        }
                    }
                }

                // Animation loop
                function animate() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    particles.forEach(particle => {
                        particle.update();
                        particle.draw();
                    });

                    drawConnections();

                    animationId = requestAnimationFrame(animate);
                }

                // Initialize and start
                initParticles();
                animate();

                // Cleanup on page unload
                window.addEventListener('beforeunload', () => {
                    if (animationId) {
                        cancelAnimationFrame(animationId);
                    }
                });
            })();
        </script>
    @endpush
</x-layouts.app>

