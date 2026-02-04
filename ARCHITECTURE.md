# System Architecture Documentation
## Laravel Service-Oriented Architecture - Patterns & Guidelines

> **Version**: 2.1
> **Last Updated**: February 4, 2026
> **Project**: Senda Snap - Logistics Management System

---

## Table of Contents

### System Overview
- [Multi-Vendor Architecture](#multi-vendor-architecture)
- [Core Modules](#core-modules)
- [Architecture Principles](#architecture-principles)

### Core Patterns
- [Service Layer](#service-layer-pattern)
- [API Controllers](#api-controller-pattern)
- [Livewire Components](#livewire-component-pattern)
- [Form Requests](#form-request-pattern)
- [API Resources](#api-resource-pattern)

### Security & Access
- [Authentication](#authentication)
- [Multi-Tenancy](#multi-tenancy--vendor-scoping)
- [Authorization](#authorization--permissions)

### Feature Guides
- [CRUD Checklist](#crud-feature-checklist)
- [Testing Patterns](#testing-patterns)
- [Best Practices](#best-practices)

---

## Multi-Vendor Architecture

### Overview

This system supports multiple vendors (companies) using a clean multi-tenant architecture where:
- Each vendor has isolated data (tasks, vehicles)
- Global resources are shared (ports, shipping companies)
- Role-based access controls visibility

### Architecture Diagram

```
┌─────────────────────────────────────────┐
│              VENDORS                    │
│  - AUTOCRAFT JAPAN LTD (default)        │
│  - Additional vendors...                │
└─────────────────────────────────────────┘
           │ has many
           ▼
┌─────────────────────────────────────────┐
│              USERS                      │
│  - vendor_id (FK, nullable)             │
│  - role: admin|manager|employee|client  │
│  - Admin: vendor_id = null              │
└─────────────────────────────────────────┘
           │ creates/owns
           ▼
┌─────────────────────────────────────────┐
│         VENDOR-SCOPED DATA              │
│  TASKS         VEHICLES                 │
│  - Scoped by   - vendor_id (FK)         │
│    user role   - created_by (FK)        │
│  - Role-based  - Vendor scoped          │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│         GLOBAL RESOURCES                │
│  PORTS            SHIPPING COMPANIES    │
│  - created_by     - created_by          │
│  - Shared         - Shared              │
└─────────────────────────────────────────┘
```

### User Roles & Access

| Role | Tasks Access | Vehicles Access | Global Resources | Vendor Management |
|------|-------------|-----------------|------------------|-------------------|
| Admin | All vendors | All vendors | All | Yes |
| Manager | Own vendor | Own vendor | All | No |
| Employee | Own/assigned | Own vendor | All | No |
| Client | Own/assigned | Own vendor | All | No |

### Default Vendor

**AUTOCRAFT JAPAN LTD**
- Address: 〒110-0015 Tokyo, Taito City, Higashiueno, 3 Chome-18-7 上野駅前ビル 8F
- Phone: 03-5826-7885
- Website: https://autocraftjapan.com

---

## Core Modules

### 1. Tasks Management
- Multiple views: Today, All, Kanban
- Status: pending, running, completed, cancelled
- Priority: low, medium, high, urgent
- Assignments: many-to-many with users
- Attachments: file uploads
- Work scheduling: date + time

### 2. Users Management
- Roles: admin, manager, employee, client
- Avatar uploads
- Vendor assignment
- Task statistics
- Profile management

### 3. Vehicles Management
- Specifications tracking
- Multiple photos
- Consignee details
- Dimensions/weight
- Auction sheet storage
- External DB integration (SFTP)

### 4. Vendors Management (Admin only)
- Multi-tenancy core
- External DB config
- SFTP/image configuration
- Encrypted credentials
- Company information

### 5. Ports & Shipping
- **Ports**: Global shared resource
- **Shipping Companies**: Line info, rates
- **Schedules**: Vessel, voyage, carriers, ETA
- **Stopovers**: Port-specific timings

### 6. Notices (Admin)
- System announcements
- Time-based visibility (starts_at/ends_at)
- Active status

---

## Architecture Principles

### Core Principles

- **Single Responsibility**: Each layer has one clear purpose
- **DRY**: Shared logic lives in services
- **Separation of Concerns**: UI, business logic, data are decoupled
- **Testability**: Services tested independently
- **Consistency**: Web and API share business logic

### Layer Responsibilities

```
┌──────────────────┐
│   Controllers    │ <- HTTP handling, validation, responses
└──────────────────┘
         ↓
┌──────────────────┐
│    Services      │ <- Business logic, queries, operations
└──────────────────┘
         ↓
┌──────────────────┐
│     Models       │ <- Data access, relationships, scopes
└──────────────────┘
```

**Controllers/Components**: Request -> Service -> Response
**Services**: Business logic, database queries, external APIs
**Models**: Relationships, scopes, accessors/mutators

---

## Service Layer Pattern

### Purpose
Encapsulate all business logic, database queries, and complex operations.

### Standard Structure

```php
<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    /**
     * List tasks with filters and pagination
     */
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->forUserRole(); // Apply role-based scoping

        $this->applyFilters($query, $filters);

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate($perPage);
    }

    /**
     * Create a new task
     */
    public function create(array $data, array $assignedUserIds = []): Task
    {
        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'priority' => $data['priority'] ?? 'medium',
            'work_date' => $data['work_date'] ?? now(),
            'created_by' => $data['created_by'],
        ]);

        if (!empty($assignedUserIds)) {
            $task->assignedUsers()->sync($assignedUserIds);
        }

        return $task->load(['assignedUsers', 'creator']);
    }

    /**
     * Update an existing task
     */
    public function update(Task $task, array $data, ?array $assignedUserIds = null): Task
    {
        $task->update(array_filter([
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? null,
            'priority' => $data['priority'] ?? null,
            'work_date' => $data['work_date'] ?? null,
        ]));

        if ($assignedUserIds !== null) {
            $task->assignedUsers()->sync($assignedUserIds);
        }

        return $task->fresh(['assignedUsers', 'creator']);
    }

    /**
     * Delete a task
     */
    public function delete(Task $task): bool
    {
        // Delete attachments
        foreach ($task->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }

        return $task->delete();
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, array $filters): void
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['assigned_to'])) {
            $query->whereHas('assignedUsers', fn($q) => $q->where('users.id', $filters['assigned_to']));
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('work_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('work_date', '<=', $filters['date_to']);
        }
    }
}
```

### Service Guidelines

- **Naming**: Descriptive methods (`list`, `create`, `update`, `delete`)
- **Parameters**: Accept all data as parameters (no `request()` access)
- **Return Types**: Always specify return types
- **Type Hints**: Use for all parameters
- **Documentation**: PHPDoc for complex methods
- **Dependencies**: Inject via constructor if needed
- **Error Handling**: Throw exceptions (`InvalidArgumentException`, `RuntimeException`)

---

## API Controller Pattern

### Purpose
Handle HTTP requests, validate input, call services, return JSON responses.

### Standard Structure

```php
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    /**
     * List all tasks with filters
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
            'priority' => $request->input('priority'),
            'assigned_to' => $request->input('assigned_to'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'sort_by' => $request->input('sort_by', 'created_at'),
            'sort_direction' => $request->input('sort_direction', 'desc'),
        ];

        $perPage = (int) $request->input('per_page', 15);
        $tasks = $this->taskService->list($filters, $perPage);

        return response()->json([
            'success' => true,
            'data' => TaskResource::collection($tasks),
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    /**
     * Create a new task
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create(
            $request->validated(),
            $request->input('assigned_users', [])
        );

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully',
            'data' => new TaskResource($task),
        ], 201);
    }

    /**
     * Show a single task
     */
    public function show(Task $task): JsonResponse
    {
        // Re-fetch with vendor scoping
        $task = $this->taskService->getTaskById($task->id);

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
        ]);
    }

    /**
     * Update an existing task
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        // Re-fetch with vendor scoping
        $task = $this->taskService->getTaskById($task->id);

        $updatedTask = $this->taskService->update(
            $task,
            $request->validated(),
            $request->has('assigned_users') ? $request->input('assigned_users') : null
        );

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => new TaskResource($updatedTask),
        ]);
    }

    /**
     * Delete a task
     */
    public function destroy(Task $task): JsonResponse
    {
        $task = $this->taskService->getTaskById($task->id);
        $this->taskService->delete($task);

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully',
        ]);
    }
}
```

### API Controller Guidelines

- **Constructor Injection**: Inject services with `protected`
- **Form Requests**: Use for validation
- **Return Format**: Consistent JSON structure
- **Status Codes**: 200, 201, 204, 400, 401, 403, 404, 422
- **Resources**: Always use for transformation
- **No Direct Eloquent**: Never call Eloquent in controllers
- **Thin Controllers**: Keep as thin as possible

### JSON Response Format

```json
{
    "success": true,
    "message": "Human readable message",
    "data": {...},
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 15,
        "total": 73
    }
}
```

---

## Livewire Component Pattern

### Purpose
Handle UI interactions, call services, manage component state.

### Standard Structure

```php
<?php

namespace App\Livewire\Tasks;

use App\Services\TaskService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class AllTasks extends Component
{
    use WithPagination;

    public ?string $search = null;
    public ?string $statusFilter = null;
    public ?string $priorityFilter = null;

    /**
     * Normalize search input
     */
    public function updatedSearch($value): void
    {
        $this->search = trim((string) $value) === '' ? null : trim((string) $value);
        $this->resetPage();
    }

    /**
     * Normalize status filter
     */
    public function updatedStatusFilter($value): void
    {
        $this->statusFilter = ($value === '' || $value === null) ? null : $value;
        $this->resetPage();
    }

    /**
     * Clear all filters
     */
    public function clearFilters(): void
    {
        $this->search = null;
        $this->statusFilter = null;
        $this->priorityFilter = null;
        $this->resetPage();
    }

    /**
     * Delete task event handler
     */
    #[On('delete-task')]
    public function deleteTask($taskId = null, ?TaskService $taskService = null): void
    {
        // Handle flexible parameter formats
        if (is_array($taskId)) {
            $taskId = $taskId['taskId'] ?? null;
        } elseif (is_object($taskId)) {
            $taskId = $taskId->taskId ?? null;
        }

        if (!$taskId) {
            return;
        }

        try {
            if (!$taskService) {
                $taskService = app(TaskService::class);
            }

            $task = $taskService->getTaskById($taskId);
            $taskService->delete($task);

            $this->dispatch('notify', message: __('Task deleted successfully.'), type: 'success');
        } catch (\Exception $e) {
            \Log::error('Task delete error: ' . $e->getMessage());
            $this->dispatch('notify', message: __('An error occurred.'), type: 'error');
        }
    }

    /**
     * Render component with method injection
     */
    public function render(TaskService $taskService)
    {
        $filters = [];

        if ($this->search !== null && $this->search !== '') {
            $filters['search'] = $this->search;
        }

        if ($this->statusFilter !== null && $this->statusFilter !== '') {
            $filters['status'] = $this->statusFilter;
        }

        if ($this->priorityFilter !== null && $this->priorityFilter !== '') {
            $filters['priority'] = $this->priorityFilter;
        }

        $tasks = $taskService->list($filters, 15);

        return view('livewire.tasks.all-tasks', [
            'tasks' => $tasks,
        ])->layout('components.layouts.app', ['title' => __('All Tasks')]);
    }
}
```

### Livewire Guidelines

- **Method Injection**: Use for services (NOT constructor)
- **Nullable Properties**: Use `?string` for filters
- **Normalize Inputs**: Convert empty strings to null in `updatedXxx()`
- **Build Filters Explicitly**: Don't pass raw properties
- **State Management**: Public properties for state
- **Validation**: Validate before calling services
- **Events**: Use `dispatch()` for notifications
- **Listeners**: Use `#[On('event')]` attribute
- **Pagination**: Use `WithPagination` trait
- **Delete Pattern**: Flexible parameter handling

### Modal Component Pattern

```php
<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Services\TaskService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class TaskModal extends Component
{
    use WithFileUploads;

    public bool $open = false;
    public ?int $taskId = null;
    public array $form = [];
    public array $selectedUsers = [];

    #[On('open-task-modal')]
    public function openModal(?int $taskId, TaskService $taskService): void
    {
        $this->resetForm();
        $this->taskId = $taskId;

        if ($taskId) {
            $task = $taskService->getTaskById($taskId);
            $this->form = [
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'priority' => $task->priority,
                'work_date' => $task->work_date->format('Y-m-d'),
            ];
            $this->selectedUsers = $task->assignedUsers->pluck('id')->toArray();
        }

        $this->open = true;
    }

    public function save(TaskService $taskService): void
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'nullable|string',
            'form.status' => 'required|in:pending,running,completed,cancelled',
            'form.priority' => 'required|in:low,medium,high,urgent',
            'form.work_date' => 'required|date',
        ]);

        if ($this->taskId) {
            $task = $taskService->getTaskById($this->taskId);
            $taskService->update($task, $this->form, $this->selectedUsers);
            $message = 'Task updated successfully';
        } else {
            $this->form['created_by'] = auth()->id();
            $taskService->create($this->form, $this->selectedUsers);
            $message = 'Task created successfully';
        }

        $this->dispatch('notify', message: $message, type: 'success');
        $this->dispatch('task-saved');
        $this->closeModal();
    }

    public function closeModal(): void
    {
        $this->open = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->form = [
            'title' => '',
            'description' => '',
            'status' => 'pending',
            'priority' => 'medium',
            'work_date' => now()->format('Y-m-d'),
        ];
        $this->selectedUsers = [];
        $this->taskId = null;
    }

    public function render()
    {
        return view('livewire.tasks.task-modal');
    }
}
```

---

## Form Request Pattern

### Purpose
Handle validation logic for API and web requests.

### Standard Structure

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,running,completed,cancelled'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'work_date' => ['required', 'date'],
            'assigned_users' => ['nullable', 'array'],
            'assigned_users.*' => ['exists:users,id'],
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Task title is required',
            'title.max' => 'Task title cannot exceed 255 characters',
            'status.in' => 'Invalid status value',
            'priority.in' => 'Invalid priority value',
            'assigned_users.*.exists' => 'Selected user does not exist',
        ];
    }
}
```

### Form Request Guidelines

- **Naming**: `{Action}{Model}Request` (StoreTaskRequest, UpdateTaskRequest)
- **Authorization**: Implement if needed
- **Array Syntax**: Use for rules (not pipe)
- **Custom Messages**: Provide user-friendly errors
- **Array Validation**: Use `.*` notation

---

## API Resource Pattern

### Purpose
Transform Eloquent models into consistent JSON responses.

### Standard Structure

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform resource into array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'work_date' => $this->work_date?->format('Y-m-d'),
            'work_time' => $this->work_time,

            // Relationships
            'creator' => $this->whenLoaded('creator', function () {
                return [
                    'id' => $this->creator->id,
                    'name' => $this->creator->name,
                    'avatar_url' => $this->creator->avatar_url,
                ];
            }),

            'assigned_users' => UserResource::collection($this->whenLoaded('assignedUsers')),
            'attachments' => TaskAttachmentResource::collection($this->whenLoaded('attachments')),

            // Timestamps
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
```

### API Resource Guidelines

- **Naming**: `{Model}Resource`
- **Return Type**: `array<string, mixed>`
- **Relationships**: Use `whenLoaded()`
- **Nested Resources**: Use other Resources
- **Dates**: ISO 8601 or Y-m-d format
- **URLs**: Full URLs for images/files
- **Conditional Fields**: Use `when()`
- **Security**: Never include sensitive data

---

## Authentication

### Web Authentication (Session-based)

**Middleware**: `auth`

```php
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('tasks', TasksIndex::class)->name('tasks.index');
});

// In controllers/components
$user = auth()->user();
$userId = auth()->id();
```

### API Authentication (Sanctum Token)

**Middleware**: `auth:sanctum`

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});

// Login flow
public function login(array $credentials): array
{
    if (!Auth::attempt($credentials)) {
        throw new \InvalidArgumentException('Invalid credentials');
    }

    $user = Auth::user();
    $token = $user->createToken('api-token')->plainTextToken;

    return [
        'user' => $user,
        'token' => $token,
    ];
}
```

---

## Multi-Tenancy & Vendor Scoping

### Task Scoping (Role-Based)

Tasks are scoped by user role, not vendor_id column:

```php
// app/Models/Task.php
public function scopeForUserRole(Builder $query, ?User $user = null): Builder
{
    $user = $user ?? auth()->user();

    // Admin sees all tasks
    if ($user->role === 'admin') {
        return $query;
    }

    // Manager sees tasks from their vendor
    if ($user->role === 'manager' && $user->vendor_id) {
        return $query->where(function ($q) use ($user) {
            $q->whereHas('creator', fn($subQ) => $subQ->where('vendor_id', $user->vendor_id))
                ->orWhereHas('assignedUsers', fn($subQ) => $subQ->where('vendor_id', $user->vendor_id));
        });
    }

    // Regular users see tasks they created OR assigned to them
    return $query->where(function ($q) use ($user) {
        $q->where('created_by', $user->id)
            ->orWhereHas('assignedUsers', fn($subQ) => $subQ->where('users.id', $user->id));
    });
}
```

**Usage in Services**:
```php
public function list(array $filters = []): LengthAwarePaginator
{
    $query = Task::with(['assignedUsers', 'creator'])
        ->forUserRole(); // Apply role-based scoping

    // Apply filters...

    return $query->paginate(15);
}
```

### Vehicle Scoping (Vendor-Based)

Vehicles use the `BelongsToVendor` trait:

```php
// app/Models/Vehicle.php
use App\Models\Concerns\BelongsToVendor;

class Vehicle extends Model
{
    use BelongsToVendor;
}

// Available scopes
$query->forCurrentVendor();      // Filter by current user's vendor
$query->forVendor($vendorId);    // Filter by specific vendor
```

**Usage in Services**:
```php
public function list(array $filters = []): LengthAwarePaginator
{
    $query = Vehicle::with(['creator', 'photos', 'consignee'])
        ->forCurrentVendor(); // Apply vendor scoping

    // Apply filters...

    return $query->paginate(15);
}

public function create(array $data): Vehicle
{
    $user = auth()->user();
    $vendorId = $data['vendor_id'] ?? $user?->vendor_id;

    return Vehicle::create([
        'serial_number' => $data['serial_number'],
        'vendor_id' => $vendorId, // Auto-assigned
        'created_by' => auth()->id(),
        // ...
    ]);
}
```

### Global Resources

Ports and Shipping Companies are shared across all vendors:

```php
// No vendor scoping - visible to all users
$ports = Port::with('creator')->get();
$companies = ShippingCompany::with('creator')->get();
```

### Critical Scoping Rules

**IMPORTANT**: Always use Service methods, not direct model access.

**Correct**:
```php
// Livewire component
$task = $taskService->getTaskById($taskId); // Uses forUserRole()
$vehicle = $vehicleService->getById($vehicleId); // Uses forCurrentVendor()

// API controller
$task = $this->taskService->getTaskById($task->id); // Role-based scoping
```

**Incorrect**:
```php
// Route model binding bypasses scoping!
$task = Task::findOrFail($taskId); // No role-based filtering
$vehicle = Vehicle::find($vehicleId); // No vendor filtering
```

---

## Authorization & Permissions

### Permission Rules

**Delete Actions**:
- Only `admin` or `manager` can delete
- Manager cannot delete their own account
- Manager cannot delete admin accounts

**Implementation**:
```php
// In Livewire component or Blade
public function canDelete(): bool
{
    $currentUser = Auth::user();
    if (!$currentUser || !$this->item) {
        return false;
    }

    // Only admin or manager
    if (!in_array($currentUser->role, ['admin', 'manager'])) {
        return false;
    }

    // Manager restrictions
    if ($currentUser->role === 'manager') {
        if ($currentUser->id === $this->item->id) {
            return false; // Cannot delete own account
        }
        if ($this->item->role === 'admin') {
            return false; // Cannot delete admins
        }
    }

    return true;
}
```

**Usage in Blade**:
```blade
@if($this->canDelete())
    <button wire:click="deleteItem">Delete</button>
@endif
```

---

## CRUD Feature Checklist

### 1. Create Model & Migration
```bash
php artisan make:model Feature -mf
```

- [ ] Define table schema
- [ ] Add indexes for frequently queried columns
- [ ] Set up relationships
- [ ] Add scopes if needed (vendor, role-based)

### 2. Create Service Class
```bash
php artisan make:class Services/FeatureService
```

- [ ] Implement `create()`
- [ ] Implement `update()`
- [ ] Implement `delete()`
- [ ] Implement `list()` with filters
- [ ] Implement `getById()`
- [ ] Add vendor scoping if applicable

### 3. Create API Resource
```bash
php artisan make:resource FeatureResource
```

- [ ] Define exposed fields
- [ ] Use `whenLoaded()` for relationships
- [ ] Format dates consistently
- [ ] Hide sensitive data

### 4. Create Form Requests
```bash
php artisan make:request StoreFeatureRequest
php artisan make:request UpdateFeatureRequest
```

- [ ] Define validation rules
- [ ] Add custom messages
- [ ] Implement authorization if needed

### 5. Create API Controller
```bash
php artisan make:controller Api/V1/FeatureController --api
```

- [ ] Inject service in constructor
- [ ] Implement all CRUD methods
- [ ] Use Form Requests
- [ ] Return Resources
- [ ] Add vendor scoping verification

### 6. Create Livewire Components
```bash
php artisan make:livewire Features/Index
php artisan make:livewire Features/FeatureModal
```

- [ ] Use method injection for services
- [ ] Implement filter logic
- [ ] Add modal CRUD logic
- [ ] Dispatch events
- [ ] Add vendor scoping

### 7. Add Routes
```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('features', FeatureController::class);
});

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('features', FeaturesIndex::class)->name('features.index');
});
```

### 8. Write Tests
```bash
php artisan make:test Services/FeatureServiceTest --unit
php artisan make:test Api/FeatureApiTest
```

- [ ] Test service methods
- [ ] Test API endpoints
- [ ] Test Livewire components
- [ ] Test validation rules
- [ ] Test authorization
- [ ] Test vendor scoping

### 9. Run Quality Checks
```bash
vendor/bin/pint              # Format code
php artisan test             # Run tests
```

---

## Testing Patterns

### Unit Tests (Services)

```php
<?php

namespace Tests\Unit\Services;

use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TaskService $taskService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskService = app(TaskService::class);
    }

    public function test_can_create_task(): void
    {
        $user = User::factory()->create();

        $task = $this->taskService->create([
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'pending',
            'priority' => 'high',
            'work_date' => now(),
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Test Task', $task->title);
        $this->assertEquals($user->id, $task->created_by);
    }

    public function test_can_list_tasks_with_filters(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(5)->create(['status' => 'pending']);
        Task::factory()->count(3)->create(['status' => 'completed']);

        $tasks = $this->taskService->list(['status' => 'pending'], 15);

        $this->assertCount(5, $tasks);
    }
}
```

### Feature Tests (API)

```php
<?php

namespace Tests\Feature\Api;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tasks(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(5)->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/tasks');

        $response->assertSuccessful()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'title', 'status', 'priority'],
                ],
                'meta',
            ]);
    }

    public function test_can_create_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/tasks', [
                'title' => 'New Task',
                'status' => 'pending',
                'priority' => 'high',
                'work_date' => now()->format('Y-m-d'),
            ]);

        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'message' => 'Task created successfully',
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task',
            'created_by' => $user->id,
        ]);
    }
}
```

---

## Best Practices

### Do's

- Use services for all business logic
- Inject services via constructor in controllers
- Use method injection in Livewire
- Always use Form Requests for validation
- Always use API Resources for JSON responses
- Keep controllers thin (< 50 lines per method)
- Write tests for new features
- Use type hints and return types
- Use `declare(strict_types=1)`
- Follow PSR-12 standards
- Handle edge cases in services
- Use transactions for multi-step ops
- Apply vendor scoping consistently
- Use eager-loaded collection properties in Blade (e.g., `$model->relationship->count()`)

### Don'ts

- Don't put business logic in controllers
- Don't use constructor injection in Livewire
- Don't access `request()` in services
- Don't use Eloquent directly in controllers
- Don't return models directly from API
- Don't skip validation
- Don't catch exceptions silently
- Don't use raw SQL without reason
- Don't expose sensitive data in APIs
- Don't modify DB without migrations
- Don't remove functionality without approval
- Don't introduce dependencies without approval
- Don't bypass vendor scoping
- Don't use `$model->relationship()->count()` in Blade when the relationship is eager-loaded; use `$model->relationship->count()` instead (see DESIGN_SYSTEM.md Performance section)

---

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Pest Testing](https://pestphp.com)
- [Laravel Pint](https://laravel.com/docs/pint)

---

## Changelog

### Version 2.1 (February 4, 2026)
- Added best practice: use eager-loaded collection properties, not relationship query methods, in Blade templates
- Removed all emojis from documentation

### Version 2.0 (February 3, 2026)
- Complete architecture refactoring
- Streamlined service patterns
- Consolidated multi-vendor documentation
- Clarified task scoping (role-based)
- Improved Livewire patterns
- Enhanced CRUD checklist
- Removed overlap with DESIGN_SYSTEM.md
- Added comprehensive examples
- Improved navigation structure

### Version 1.9 (January 22, 2026)
- Added child record warnings for deletion
- Updated multi-vendor patterns
- Enhanced vendor scoping documentation

### Version 1.0 (November 12, 2025)
- Initial architecture documentation
- Service layer patterns established
- Multi-vendor architecture defined
