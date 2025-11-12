<x-layouts.app title="{{ __('API Documentation') }}">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <!-- Header Section -->
        <x-page-header
            :title="__('API Documentation')"
            :description="__('Complete REST API reference for your Android application')"
            variant="emerald">
            <x-slot:icon>
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
            <x-slot:actions>
                <div class="flex items-center gap-2 rounded-lg bg-white/20 px-4 py-2 backdrop-blur-sm">
                    <span class="text-sm font-medium text-white">Base URL:</span>
                    <code class="rounded bg-white/30 px-2 py-1 text-xs font-mono text-white">{{ config('app.url') }}/api/v1</code>
                </div>
            </x-slot:actions>
        </x-page-header>

        <!-- Quick Start Card -->
        <x-table-card variant="violet">
            <div class="prose prose-sm max-w-none dark:prose-invert">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Quick Start Guide
                </h3>
                <div class="mt-4 space-y-4">
                    <div class="rounded-lg bg-gradient-to-r from-violet-50 to-purple-50 p-4 dark:from-violet-900/20 dark:to-purple-900/20">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            <strong>Step 1:</strong> Register or login to get your authentication token
                        </p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">
                            <strong>Step 2:</strong> Include the token in the Authorization header for all protected endpoints
                        </p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">
                            <strong>Step 3:</strong> All requests and responses use JSON format
                        </p>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Authentication Section -->
        <x-table-card variant="blue">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Authentication</h3>
                </div>

                <!-- Register -->
                <div class="space-y-3 rounded-xl border border-blue-200 bg-white/50 p-6 dark:border-blue-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Register</h4>
                        <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/auth/register</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "1234567890",
    "role": "client"
}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (201):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": { "id": 1, "name": "John Doe", "email": "john@example.com" },
        "token": "1|abc123..."
    }
}</code></pre>
                    </div>
                </div>

                <!-- Login -->
                <div class="space-y-3 rounded-xl border border-blue-200 bg-white/50 p-6 dark:border-blue-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Login</h4>
                        <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/auth/login</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "email": "john@example.com",
    "password": "password123"
}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": { "id": 1, "name": "John Doe", "email": "john@example.com" },
        "token": "2|xyz789..."
    }
}</code></pre>
                    </div>
                </div>

                <!-- Logout -->
                <div class="space-y-3 rounded-xl border border-blue-200 bg-white/50 p-6 dark:border-blue-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Logout</h4>
                        <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/auth/logout</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Users Section -->
        <x-table-card variant="blue">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Users</h3>
                </div>

                <!-- Get All Users -->
                <div class="space-y-3 rounded-xl border border-blue-200 bg-white/50 p-6 dark:border-blue-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Get All Users</h4>
                        <span class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/users</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": true,
    "message": "Users retrieved successfully",
    "data": {
        "users": [
            {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com",
                "role": "admin",
                "phone": "1234567890"
            }
        ]
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Tasks Section -->
        <x-table-card variant="emerald">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Tasks</h3>
                </div>

                <!-- Get All Tasks -->
                <div class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Get All Tasks</h4>
                        <span class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/tasks</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Query Parameters (Optional):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>from_date: YYYY-MM-DD (filter by work date)
to_date:   YYYY-MM-DD (filter by work date)
per_page:  number (default: 15)</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
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
                    { "id": 2, "name": "John Doe", "role": "employee" },
                    { "id": 3, "name": "Jane Smith", "role": "employee" }
                ],
                "creator": { "id": 1, "name": "Admin User", "role": "admin" }
            }
        ],
        "pagination": {
            "current_page": 1,
            "last_page": 5,
            "per_page": 15,
            "total": 75
        }
    }
}</code></pre>
                    </div>
                </div>

                <!-- Create Task -->
                <div class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Create Task</h4>
                        <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/tasks</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: multipart/form-data</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request (multipart/form-data):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>title:         Complete inspection
description:   Full vehicle inspection required
work_date:     2024-12-20
work_time:     10:00
priority:      high
assigned_to[]: 2
assigned_to[]: 3
due_date:      2024-12-31
attachments[]: (file)
attachments[]: (file)</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Field Descriptions:</p>
                        <div class="rounded-lg bg-gray-900 p-4 dark:bg-gray-950">
                            <ul class="space-y-1 text-xs text-gray-100">
                                <li>• <code class="text-emerald-400">title</code> (required): Task title</li>
                                <li>• <code class="text-emerald-400">description</code> (optional): Task description</li>
                                <li>• <code class="text-emerald-400">work_date</code> (optional): Date for task (YYYY-MM-DD)</li>
                                <li>• <code class="text-emerald-400">work_time</code> (optional): Time for task (HH:MM or HH:MM:SS)</li>
                                <li>• <code class="text-emerald-400">priority</code> (required): low, medium, high, urgent</li>
                                <li>• <code class="text-emerald-400">assigned_to</code> (optional): Array of user IDs</li>
                                <li>• <code class="text-emerald-400">attachments[]</code> (optional, files): Multiple attachments (max 10MB each)</li>
                                <li>• <code class="text-emerald-400">due_date</code> (optional): Due date (YYYY-MM-DD)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (201):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": true,
    "message": "Task created successfully",
    "data": {
        "task": {
            "id": 1,
            "title": "Complete inspection",
            "assigned_users": [
                { "id": 2, "name": "John Doe" },
                { "id": 3, "name": "Jane Smith" }
            ],
            "creator": { "id": 1, "name": "Admin User" }
        }
    }
}</code></pre>
                    </div>
                </div>

                <!-- Update Task -->
                <div class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Update Task</h4>
                        <span class="rounded-lg bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">PUT</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/tasks/{id}</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: multipart/form-data</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request (multipart/form-data, all fields optional):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>title:               Updated task title
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
                    <div class="space-y-2">
                        <p class="text-xs text-gray-600 dark:text-gray-400">If <code class="text-emerald-400">attachments_update</code> is true and no files are sent, all existing attachments will be removed. If files are sent, existing attachments are replaced with the new set.</p>
                    </div>
                </div>

                <!-- Assign Users to Task -->
                <div class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Assign Users to Task</h4>
                        <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/tasks/{id}/assign</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: application/json</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
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
                <div class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Update Task Status</h4>
                        <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/tasks/{id}/status</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: application/json</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
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
                <div class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Upload Task Attachment</h4>
                        <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/tasks/{id}/attachments</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}
Content-Type: multipart/form-data</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body (Form Data):</p>
                        <div class="rounded-lg bg-gray-900 p-4 dark:bg-gray-950">
                            <ul class="space-y-1 text-xs text-gray-100">
                                <li>• <code class="text-emerald-400">file</code> (required): File to upload (max 10MB)</li>
                                <li>• <code class="text-emerald-400">file_name</code> (optional): Custom file name</li>
                            </ul>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (201):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
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
                <div class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Task Attachment</h4>
                        <span class="rounded-lg bg-red-100 px-3 py-1 text-xs font-bold text-red-800 dark:bg-red-900/30 dark:text-red-400">DELETE</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/tasks/{task_id}/attachments/{attachment_id}</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Headers:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>Authorization: Bearer {token}</code></pre>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Note:</strong> Only the uploader, admin, or manager can delete an attachment.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Response (200):</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "success": true,
    "message": "Attachment deleted successfully",
    "data": []
}</code></pre>
                    </div>
                </div>

                <!-- Get My Tasks -->
                <div class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Get My Created Tasks</h4>
                        <span class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/tasks/my-tasks</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Returns all tasks created by the authenticated user.</p>
                    </div>
                </div>

                <!-- Get Tasks Assigned to Me -->
                <div class="space-y-3 rounded-xl border border-emerald-200 bg-white/50 p-6 dark:border-emerald-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Get Tasks Assigned to Me</h4>
                        <span class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/tasks/assigned-to-me</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Returns all tasks where the authenticated user is one of the assignees.</p>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Vehicles Section -->
        <x-table-card variant="amber">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Vehicles</h3>
                </div>

                <!-- Get All Vehicles -->
                <div class="space-y-3 rounded-xl border border-amber-200 bg-white/50 p-6 dark:border-amber-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Get All Vehicles</h4>
                        <span class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/vehicles</code>
                </div>

                <!-- Create Vehicle -->
                <div class="space-y-3 rounded-xl border border-amber-200 bg-white/50 p-6 dark:border-amber-900/50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Create Vehicle</h4>
                        <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
                    </div>
                    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/vehicles</code>
                    
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "serial_number": "SN12345",
    "brand": "Toyota",
    "model": "Camry",
    "year": 2023,
    "color": "White",
    "status": "available"
}</code></pre>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Error Responses -->
        <x-table-card variant="violet">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-pink-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Error Responses</h3>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <!-- 401 -->
                    <div class="space-y-2 rounded-xl border border-red-200 bg-red-50/50 p-4 dark:border-red-900/50 dark:bg-red-900/10">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-red-900 dark:text-red-400">Unauthenticated</h4>
                            <span class="rounded bg-red-200 px-2 py-1 text-xs font-bold text-red-900 dark:bg-red-900/50 dark:text-red-400">401</span>
                        </div>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-3 text-xs text-gray-100"><code>{
    "success": false,
    "message": "Unauthenticated. Please login first."
}</code></pre>
                    </div>

                    <!-- 403 -->
                    <div class="space-y-2 rounded-xl border border-orange-200 bg-orange-50/50 p-4 dark:border-orange-900/50 dark:bg-orange-900/10">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-orange-900 dark:text-orange-400">Unauthorized</h4>
                            <span class="rounded bg-orange-200 px-2 py-1 text-xs font-bold text-orange-900 dark:bg-orange-900/50 dark:text-orange-400">403</span>
                        </div>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-3 text-xs text-gray-100"><code>{
    "success": false,
    "message": "Unauthorized."
}</code></pre>
                    </div>

                    <!-- 404 -->
                    <div class="space-y-2 rounded-xl border border-yellow-200 bg-yellow-50/50 p-4 dark:border-yellow-900/50 dark:bg-yellow-900/10">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-yellow-900 dark:text-yellow-400">Not Found</h4>
                            <span class="rounded bg-yellow-200 px-2 py-1 text-xs font-bold text-yellow-900 dark:bg-yellow-900/50 dark:text-yellow-400">404</span>
                        </div>
                        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-3 text-xs text-gray-100"><code>{
    "success": false,
    "message": "Resource not found."
}</code></pre>
                    </div>

                    <!-- 422 -->
                    <div class="space-y-2 rounded-xl border border-purple-200 bg-purple-50/50 p-4 dark:border-purple-900/50 dark:bg-purple-900/10">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-purple-900 dark:text-purple-400">Validation Error</h4>
                            <span class="rounded bg-purple-200 px-2 py-1 text-xs font-bold text-purple-900 dark:bg-purple-900/50 dark:text-purple-400">422</span>
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
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Testing with Postman</h3>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-xl bg-gradient-to-br from-violet-50 to-purple-50 p-6 dark:from-violet-900/20 dark:to-purple-900/20">
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-violet-500 text-white">
                            <span class="text-xl font-bold">1</span>
                        </div>
                        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Login First</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">Make a POST request to <code class="rounded bg-white/50 px-1 dark:bg-gray-800">/auth/login</code> with your credentials</p>
                    </div>

                    <div class="rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 p-6 dark:from-blue-900/20 dark:to-cyan-900/20">
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-blue-500 text-white">
                            <span class="text-xl font-bold">2</span>
                        </div>
                        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Copy Token</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">Copy the token from the response data object</p>
                    </div>

                    <div class="rounded-xl bg-gradient-to-br from-violet-50 to-purple-50 p-6 dark:from-violet-900/20 dark:to-purple-900/20">
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-violet-500 text-white">
                            <span class="text-xl font-bold">3</span>
                        </div>
                        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Add Header</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">Add <code class="rounded bg-white/50 px-1 dark:bg-gray-800">Authorization: Bearer {token}</code> to headers</p>
                    </div>
                </div>
            </div>
        </x-table-card>
    </div>
</x-layouts.app>

