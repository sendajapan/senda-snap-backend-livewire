# System Architecture Documentation
## Laravel Service-Oriented Architecture - Patterns & Guidelines

This document outlines the system architecture, patterns, and conventions used throughout the application to ensure consistency, maintainability, and scalability.

---

## 🏗️ Architecture Overview

This application follows a **Service-Oriented Architecture (SOA)** where:

1. **Business logic** lives in dedicated Service classes
2. **Controllers** (Web + API) are thin and only handle:
   - Request validation
   - Service method calls
   - Response formatting
3. **Livewire components** call Service methods directly
4. **API Resources** provide consistent JSON responses
5. **Form Requests** handle validation logic

### Core Principles

✅ **Single Responsibility**: Each layer has one clear purpose  
✅ **DRY (Don't Repeat Yourself)**: Shared logic lives in services  
✅ **Separation of Concerns**: UI, business logic, and data are decoupled  
✅ **Testability**: Services can be tested independently  
✅ **Consistency**: Web and API share the same business logic  

---

## 📁 Directory Structure

```
app/
├── Console/
│   └── Commands/           # Artisan commands (auto-registered)
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── V1/         # API Controllers (version 1)
│   │           ├── AuthController.php
│   │           ├── ProfileController.php
│   │           ├── TaskController.php
│   │           ├── UsersController.php
│   │           └── VehicleController.php
│   ├── Requests/           # Form Request validation classes
│   │   ├── StoreTaskRequest.php
│   │   └── UpdateTaskRequest.php
│   └── Resources/          # API Resources for JSON transformation
│       ├── TaskResource.php
│       ├── UserResource.php
│       ├── VehicleResource.php
│       └── TaskAttachmentResource.php
├── Livewire/               # Livewire components (UI logic)
│   ├── Settings/
│   │   ├── Password.php
│   │   └── Profile.php
│   ├── Tasks/
│   │   ├── AllTasks.php
│   │   ├── TodayTasks.php
│   │   ├── TaskModal.php
│   │   └── TaskPreview.php
│   ├── Users/
│   │   ├── Index.php
│   │   ├── UserModal.php
│   │   └── UserPreview.php
│   └── Vehicles/
│       └── Index.php
├── Models/                 # Eloquent models
│   ├── Task.php
│   ├── User.php
│   ├── Vehicle.php
│   └── TaskAttachment.php
└── Services/               # Business logic layer ⭐
    ├── AuthService.php
    ├── ExternalVehicleService.php
    ├── ProfileService.php
    ├── TaskService.php
    ├── UserService.php
    └── VehicleService.php
```

---

## 🎯 Service Layer Pattern

### Purpose
Services encapsulate all business logic, database queries, and complex operations.

### Location
`app/Services/`

### Naming Convention
`{Model}Service.php` (e.g., `TaskService.php`, `UserService.php`)

### Structure Example

```php
<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class TaskService
{
    /**
     * List tasks with filters and pagination
     */
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments']);

        // Apply filters
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate($perPage);
    }

    /**
     * Create a new task
     */
    public function create(int $creatorId, array $data, array $assignedUserIds = []): Task
    {
        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'priority' => $data['priority'] ?? 'medium',
            'work_date' => $data['work_date'] ?? now(),
            'created_by' => $creatorId,
        ]);

        // Assign users
        if (! empty($assignedUserIds)) {
            $task->assignedUsers()->sync($assignedUserIds);
        }

        return $task->load(['assignedUsers', 'creator']);
    }

    /**
     * Update an existing task
     */
    public function update(Task $task, array $data, ?array $assignedUserIds = null): Task
    {
        $updateData = [];

        if (isset($data['title'])) {
            $updateData['title'] = $data['title'];
        }

        if (isset($data['description'])) {
            $updateData['description'] = $data['description'];
        }

        if (isset($data['status'])) {
            $updateData['status'] = $data['status'];
        }

        if (isset($data['priority'])) {
            $updateData['priority'] = $data['priority'];
        }

        if (isset($data['work_date'])) {
            $updateData['work_date'] = $data['work_date'];
        }

        if (! empty($updateData)) {
            $task->update($updateData);
        }

        // Update assigned users if provided
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
        // Delete all attachments
        foreach ($task->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }

        return $task->delete();
    }
}
```

### Service Method Guidelines

1. **Naming**: Use descriptive method names (`list`, `create`, `update`, `delete`, `search`, `export`)
2. **Parameters**: Accept all necessary data as parameters (don't access `request()` directly)
3. **Return Types**: Always specify return types
4. **Type Hints**: Use type hints for all parameters
5. **Documentation**: Add PHPDoc blocks for complex methods
6. **Dependencies**: Inject other services via constructor if needed
7. **Error Handling**: Throw exceptions for errors (use `\InvalidArgumentException`, `\RuntimeException`)

### When to Create a Service Method

✅ Database queries (Eloquent)  
✅ Complex business logic  
✅ File uploads/deletions  
✅ External API calls  
✅ Data transformations  
✅ Calculations or aggregations  
✅ Multi-step operations  

❌ Simple validation (use Form Requests)  
❌ View rendering (use Controllers)  
❌ Route-specific logic (use Controllers)  

---

## 🎮 API Controller Pattern

### Purpose
Handle HTTP requests for API endpoints, validate input, call services, return JSON responses.

### Location
`app/Http/Controllers/Api/V1/`

### Structure Example

```php
<?php

declare(strict_types=1);

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
            $request->user()->id,
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
        $task->load(['assignedUsers', 'creator', 'attachments']);

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
        $this->taskService->delete($task);

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully',
        ]);
    }
}
```

### API Controller Guidelines

1. **Constructor Injection**: Inject services via constructor with `protected` visibility
2. **Form Requests**: Use Form Request classes for validation
3. **Return Format**: Always return consistent JSON structure:
   ```php
   [
       'success' => true|false,
       'message' => 'Human readable message',
       'data' => Resource|ResourceCollection|null,
       'meta' => [...] // pagination, etc
   ]
   ```
4. **Status Codes**: Use appropriate HTTP status codes (200, 201, 204, 400, 401, 403, 404, 422)
5. **Resources**: Always use API Resources for data transformation
6. **No Direct Eloquent**: Never call Eloquent directly in controllers
7. **Thin Controllers**: Keep controllers as thin as possible

---

## 🖥️ Livewire Component Pattern

### Purpose
Handle UI interactions, call service methods, manage component state.

### Location
`app/Livewire/`

### Structure Example

```php
<?php

declare(strict_types=1);

namespace App\Livewire\Tasks;

use App\Services\TaskService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $priorityFilter = '';

    protected $listeners = ['task-saved' => '$refresh'];

    /**
     * Render the component with method injection
     */
    public function render(TaskService $taskService)
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'priority' => $this->priorityFilter,
        ];

        $tasks = $taskService->list($filters, 15);

        return view('livewire.tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Reset filters
     */
    public function resetFilters(): void
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->priorityFilter = '';
        $this->resetPage();
    }

    /**
     * Update search query and reset pagination
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }
}
```

### Modal Component Example

```php
<?php

declare(strict_types=1);

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
            $task = Task::with(['assignedUsers'])->findOrFail($taskId);
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
            $task = Task::findOrFail($this->taskId);
            $taskService->update($task, $this->form, $this->selectedUsers);
            $message = 'Task updated successfully';
        } else {
            $taskService->create(auth()->id(), $this->form, $this->selectedUsers);
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

### Preview Component Example

Preview components display read-only information in a center dialog modal. They provide a detailed view of an item without allowing direct editing (editing is done through the main modal).

```php
<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class UserPreview extends Component
{
    public bool $open = false;
    public ?User $user = null;

    #[On('open-user-preview')]
    public function openPreview(?int $userId, UserService $userService): void
    {
        if ($userId) {
            $this->user = $userService->getById($userId);
        } else {
            $this->user = null;
        }

        $this->open = true;
    }

    public function closePreview(): void
    {
        $this->open = false;
        $this->user = null;
    }

    public function editUser(): void
    {
        if ($this->user) {
            $this->dispatch('open-user-modal', userId: $this->user->id);
            $this->closePreview();
        }
    }

    public function deleteUser(UserService $userService): void
    {
        if ($this->user) {
            try {
                $userService->delete($this->user);
                $this->dispatch('user-saved');
                $this->dispatch('notify', message: __('User deleted successfully.'), type: 'success');
                $this->closePreview();
            } catch (\Exception $e) {
                \Log::error('User delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the user.'), type: 'error');
            }
        }
    }

    public function canDelete(): bool
    {
        $currentUser = Auth::user();
        if (! $currentUser || ! $this->user) {
            return false;
        }

        // Only admin or manager can delete
        if (! in_array($currentUser->role, ['admin', 'manager'])) {
            return false;
        }

        // Manager cannot delete their own account
        if ($currentUser->role === 'manager' && $currentUser->id === $this->user->id) {
            return false;
        }

        // Manager cannot delete admin accounts
        if ($currentUser->role === 'manager' && $this->user->role === 'admin') {
            return false;
        }

        return true;
    }

    public function render()
    {
        return view('livewire.users.user-preview');
    }
}
```

**Key Features**:
- Center dialog modal (not side panel)
- Read-only display of item details
- Edit button redirects to main modal
- Delete button with permission checks
- Permission method (`canDelete()`) for UI visibility
- Event-driven opening via `#[On('open-user-preview')]`

**Opening Preview** (from parent component):
```blade
<div x-data="{
    openPreview(itemId = null) {
        $wire.$dispatch('open-user-preview', { userId: itemId })
    }
}">
    <button @click="openPreview({{ $user->id }})">View</button>
</div>
```

### Permission System Pattern

The application implements role-based permission checks for delete actions. Permission logic is centralized in component methods.

**Permission Rules**:
- **Delete Users/Tasks**: Only `admin` or `manager` roles can delete
- **Manager Restrictions**:
  - Cannot delete their own account
  - Cannot delete admin accounts
- **UI Visibility**: Delete buttons are conditionally rendered based on `canDelete()` method

**Implementation Pattern**:
```php
public function canDelete(): bool
{
    $currentUser = Auth::user();
    if (! $currentUser || ! $this->item) {
        return false;
    }

    // Only admin or manager can delete
    if (! in_array($currentUser->role, ['admin', 'manager'])) {
        return false;
    }

    // Additional restrictions for managers
    if ($currentUser->role === 'manager') {
        // Manager-specific restrictions
        if ($currentUser->id === $this->item->id) {
            return false; // Cannot delete own account
        }
        if ($this->item->role === 'admin') {
            return false; // Cannot delete admin accounts
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

**In Table Rows and Cards**:
```blade
@php
    $currentUser = auth()->user();
    $canDelete = $currentUser && in_array($currentUser->role, ['admin', 'manager']) 
        && !($currentUser->role === 'manager' && ($currentUser->id === $item->id || $item->role === 'admin'));
@endphp
@if($canDelete)
    <button>Delete</button>
@endif
```

### Livewire Component Guidelines

1. **Method Injection**: Use method injection for services (NOT constructor injection)
2. **Service Injection Points**: Inject services in `render()`, `save()`, or any action method
3. **No Constructor Injection**: Livewire does not support constructor injection for services
4. **State Management**: Use public properties for component state
5. **Validation**: Validate in the component before calling service methods
6. **Events**: Use `$this->dispatch()` for events
7. **Listeners**: Use `#[On('event-name')]` attribute or `protected $listeners` property
8. **File Uploads**: Use `WithFileUploads` trait for file handling
9. **Pagination**: Use `WithPagination` trait for paginated lists
10. **Preview Components**: Use center dialog modals for read-only previews
11. **Permission Checks**: Implement `canDelete()` methods for conditional UI rendering

---

## 📦 API Resource Pattern

### Purpose
Transform Eloquent models into consistent JSON responses.

### Location
`app/Http/Resources/`

### Structure Example

```php
<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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
            
            // Relationships (conditionally loaded)
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

1. **Naming**: `{Model}Resource.php`
2. **Return Type**: Specify `array<string, mixed>` return type
3. **Relationships**: Use `whenLoaded()` for relationships
4. **Nested Resources**: Use other Resources for nested data
5. **Dates**: Format dates consistently (ISO 8601 or Y-m-d)
6. **URLs**: Include full URLs for images/files
7. **Conditional Fields**: Use `when()` for conditional fields
8. **No Sensitive Data**: Never include passwords, tokens, or sensitive data

---

## 📝 Form Request Pattern

### Purpose
Handle validation logic for API and Web requests.

### Location
`app/Http/Requests/`

### Structure Example

```php
<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Or implement authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
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

1. **Naming**: `{Action}{Model}Request.php` (e.g., `StoreTaskRequest`, `UpdateTaskRequest`)
2. **Authorization**: Implement `authorize()` method if needed
3. **Validation**: Use array syntax for rules (not pipe syntax)
4. **Messages**: Provide custom error messages
5. **Array Rules**: Use `.*` notation for array validation
6. **Reusable**: Check if validation can be shared between store/update

---

## 🔐 Authentication Pattern

### Web Authentication (Session-based)

**Middleware**: `auth`

**Usage**:
```php
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('tasks', TasksIndex::class)->name('tasks.index');
});
```

**In Controllers**:
```php
$user = auth()->user();
$userId = auth()->id();
```

**In Livewire**:
```php
$user = auth()->user();
```

### API Authentication (Token-based with Sanctum)

**Middleware**: `auth:sanctum`

**Usage**:
```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});
```

**Login Flow**:
```php
public function login(array $credentials): array
{
    if (! Auth::attempt($credentials)) {
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

**In API Controllers**:
```php
$user = $request->user();
$userId = $request->user()->id;
```

---

## 🚨 Error Handling Pattern

### Exception Handling Configuration

Located in `bootstrap/app.php`:

```php
->withExceptions(function (Exceptions $exceptions): void {
    // Handle authentication exceptions for API
    $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please login first.',
            ], 401);
        }

        // Let Laravel handle web route authentication (redirect to login)
    });

    // Handle not found exceptions for API
    $exceptions->render(function (NotFoundHttpException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found.',
            ], 404);
        }

        // Let Laravel handle web route 404 (show 404 page)
    });

    // Handle validation exceptions for API
    $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }

        // Let Laravel handle web route validation (redirect back with errors)
    });

    // Handle authorization exceptions for API
    $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have permission to perform this action.',
            ], 403);
        }

        // Let Laravel handle web route authorization (show 403 page)
    });

    // Handle model not found exceptions for API
    $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found.',
            ], 404);
        }

        // Let Laravel handle web route model not found (show 404 page)
    });
});
```

### Service Exception Handling

**In Services**: Throw exceptions for error cases:
```php
if (! Hash::check($currentPassword, $user->password)) {
    throw new \InvalidArgumentException('Current password is incorrect');
}
```

**In Controllers**: Catch and format as needed (or let global handler catch):
```php
try {
    $task = $this->taskService->create($data);
    return response()->json(['success' => true, 'data' => $task], 201);
} catch (\InvalidArgumentException $e) {
    return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
}
```

---

## 🧪 Testing Pattern

### Unit Tests (Service Layer)

**Location**: `tests/Unit/Services/`

**Example**:
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
        
        $task = $this->taskService->create($user->id, [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'pending',
            'priority' => 'high',
            'work_date' => now(),
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

### Feature Tests (API Endpoints)

**Location**: `tests/Feature/Api/`

**Example**:
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

### Livewire Component Tests

**Location**: `tests/Feature/Livewire/`

**Example**:
```php
<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Tasks\Index;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TaskIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_task_list(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(5)->create();

        Livewire::actingAs($user)
            ->test(Index::class)
            ->assertOk()
            ->assertViewHas('tasks');
    }

    public function test_can_search_tasks(): void
    {
        $user = User::factory()->create();
        Task::factory()->create(['title' => 'Important Task']);
        Task::factory()->create(['title' => 'Regular Task']);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->set('search', 'Important')
            ->assertSee('Important Task')
            ->assertDontSee('Regular Task');
    }
}
```

---

## 📋 Checklist for New Features

When implementing a new feature, follow these steps:

### 1. Create Model & Migration
```bash
php artisan make:model Feature -mf
```

### 2. Create Service Class
```bash
php artisan make:class Services/FeatureService
```

- [ ] Implement `list()` method
- [ ] Implement `create()` method
- [ ] Implement `update()` method
- [ ] Implement `delete()` method
- [ ] Add any custom business logic methods

### 3. Create API Resource
```bash
php artisan make:resource FeatureResource
```

- [ ] Define all exposed fields
- [ ] Use `whenLoaded()` for relationships
- [ ] Format dates consistently

### 4. Create Form Requests
```bash
php artisan make:request StoreFeatureRequest
php artisan make:request UpdateFeatureRequest
```

- [ ] Define validation rules
- [ ] Add custom error messages
- [ ] Implement authorization if needed

### 5. Create API Controller
```bash
php artisan make:controller Api/V1/FeatureController --api
```

- [ ] Inject service in constructor
- [ ] Implement all CRUD methods
- [ ] Use Form Requests for validation
- [ ] Return Resources for responses

### 6. Create Livewire Components
```bash
php artisan make:livewire Features/Index
php artisan make:livewire Features/FeatureModal
```

- [ ] Use method injection for services
- [ ] Implement filter logic
- [ ] Add modal open/close logic
- [ ] Dispatch events for notifications

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
php artisan make:test Livewire/FeatureIndexTest
```

- [ ] Test service methods
- [ ] Test API endpoints
- [ ] Test Livewire components
- [ ] Test validation rules
- [ ] Test authorization

### 9. Run Tests & Format Code
```bash
vendor/bin/pint
php artisan test
```

---

## 🎯 Best Practices

### Do's ✅

- Use services for all business logic
- Inject services via constructor in controllers
- Use method injection for services in Livewire components
- Always use Form Requests for validation
- Always use API Resources for JSON responses
- Keep controllers thin (< 50 lines per method)
- Write tests for all new features
- Use type hints and return types
- Use `declare(strict_types=1);` at the top of files
- Follow PSR-12 coding standards
- Use descriptive variable and method names
- Add PHPDoc blocks for complex methods
- Handle edge cases in services
- Use transactions for multi-step operations

### Don'ts ❌

- Don't put business logic in controllers
- Don't use constructor injection in Livewire components
- Don't access `request()` directly in services
- Don't use Eloquent directly in controllers
- Don't return models directly from API endpoints
- Don't skip validation
- Don't catch exceptions silently
- Don't use raw SQL queries without reason
- Don't expose sensitive data in API responses
- Don't modify database structure without migrations
- Don't remove existing functionality without approval
- Don't break existing route names
- Don't introduce new dependencies without approval

---

## 🔄 Common Patterns

### Pagination Pattern
```php
// Service
public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
{
    return Model::query()->paginate($perPage);
}

// Controller
public function index(Request $request): JsonResponse
{
    $perPage = (int) $request->input('per_page', 15);
    $items = $this->service->list([], $perPage);

    return response()->json([
        'success' => true,
        'data' => ResourceCollection::collection($items),
        'meta' => [
            'current_page' => $items->currentPage(),
            'last_page' => $items->lastPage(),
            'per_page' => $items->perPage(),
            'total' => $items->total(),
        ],
    ]);
}
```

### Search/Filter Pattern
```php
// Service
public function list(array $filters = []): LengthAwarePaginator
{
    $query = Model::query();

    if (! empty($filters['search'])) {
        $query->where('name', 'like', "%{$filters['search']}%");
    }

    if (! empty($filters['status'])) {
        $query->where('status', $filters['status']);
    }

    return $query->paginate(15);
}
```

### File Upload Pattern
```php
// Service
public function uploadFile(Model $model, UploadedFile $file): string
{
    // Delete old file if exists
    if ($model->file_path) {
        Storage::disk('public')->delete($model->file_path);
    }

    // Store new file
    $filePath = $file->store('uploads', 'public');
    
    $model->update(['file_path' => $filePath]);

    return $filePath;
}

// Controller
public function upload(Request $request, Model $model): JsonResponse
{
    $request->validate(['file' => 'required|file|max:10240']);
    
    $filePath = $this->service->uploadFile($model, $request->file('file'));

    return response()->json([
        'success' => true,
        'message' => 'File uploaded successfully',
        'file_url' => Storage::disk('public')->url($filePath),
    ]);
}
```

### Relationship Sync Pattern
```php
// Service
public function assignUsers(Task $task, array $userIds): Task
{
    $task->assignedUsers()->sync($userIds);
    return $task->fresh(['assignedUsers']);
}
```

---

## 📊 Performance Considerations

### N+1 Query Prevention
Always eager load relationships:
```php
// Good
Task::with(['assignedUsers', 'creator', 'attachments'])->get();

// Bad
Task::all(); // Causes N+1 queries when accessing relationships
```

### Caching Strategy
```php
// Cache expensive queries
public function getStats(): array
{
    return Cache::remember('dashboard.stats', 300, function () {
        return [
            'total_tasks' => Task::count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            // ... more stats
        ];
    });
}
```

### Database Indexing
Add indexes for frequently queried columns:
```php
$table->index('status');
$table->index('created_by');
$table->index(['status', 'priority']);
```

---

## 📊 Dashboard Query Patterns

### Role Counts Query
For displaying user counts by role in dashboard cards:

```php
$adminCount = \App\Models\User::where('role', 'admin')->count();
$managerCount = \App\Models\User::where('role', 'manager')->count();
$employeeCount = \App\Models\User::where('role', 'employee')->count();
$clientCount = \App\Models\User::where('role', 'client')->count();
```

**Usage**: Display role counts above member/user tables in dashboard cards.

### Upcoming Tasks Query
For displaying upcoming tasks in dashboard tables:

```php
$upcomingTasks = \App\Models\Task::whereNotIn('status', ['completed', 'cancelled'])
    ->whereNotNull('work_date')
    ->where('work_date', '>=', now()->toDateString())
    ->with(['assignedUsers', 'creator'])
    ->orderBy('work_date', 'ASC')
    ->orderBy('work_time', 'ASC')
    ->limit(3)
    ->get();
```

**Key Points**:
- Excludes completed and cancelled tasks
- Only shows tasks with `work_date` set
- Filters to future dates only (`work_date >= today`)
- Sorted by work date then work time (both ascending)
- Eager loads relationships to prevent N+1 queries
- Limits results for dashboard display (typically 3-5)

**Display**: Shows "Work Date & Time" with date and time displayed separately with icons.

### Today's Tasks Query
For displaying today's tasks sorted by time:

```php
// TaskService::getTodayTasksAll()
$todayTasks = \App\Models\Task::with(['assignedUsers', 'creator', 'attachments'])
    ->whereDate('work_date', today())
    ->orderByRaw('CASE WHEN work_time IS NULL THEN 1 ELSE 0 END')
    ->orderBy('work_time', 'asc')
    ->get();
```

**Key Points**:
- Filters tasks where `work_date` equals today
- Sorts by `work_time` in ascending order (earliest first)
- Tasks without time (`work_time IS NULL`) are placed at the end
- Uses `orderByRaw()` to handle NULL values properly
- Eager loads relationships to prevent N+1 queries
- Returns a Collection (not paginated) for full day's tasks

**Sorting Logic**:
1. First, tasks with `work_time` set are sorted by time (ASC)
2. Then, tasks without `work_time` (NULL) are placed at the end
3. This ensures scheduled tasks appear first, followed by unscheduled tasks

**Usage**: Used in `TodayTasks` Livewire component to display all tasks for the current day, sorted chronologically by work time.

---

## 🔍 Debugging Tips

### Service Layer Debugging
```php
// Add logging in services
Log::info('Creating task', ['data' => $data]);

// Use dump and die
dd($query->toSql(), $query->getBindings());
```

### API Debugging
```php
// Enable query logging
DB::enableQueryLog();
// ... perform operations
dd(DB::getQueryLog());
```

### Livewire Debugging
```php
// In Livewire component
public function render()
{
    logger()->info('Rendering component', [
        'search' => $this->search,
        'filters' => $this->filters,
    ]);

    return view('livewire.component');
}
```

---

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Laravel Sanctum Documentation](https://laravel.com/docs/sanctum)
- [Pest Testing Framework](https://pestphp.com/)
- [Laravel Pint](https://laravel.com/docs/pint)

---

**Version**: 1.3  
**Last Updated**: November 12, 2025  
**Project**: Senda Snap Backend - Service-Oriented Architecture  

---

## 📝 Changelog

### Version 1.3 (November 12, 2025)
- Added Preview Component Pattern documentation
- Documented center dialog modal pattern for read-only previews
- Added Permission System Pattern with role-based delete restrictions
- Documented `canDelete()` method pattern for conditional UI rendering
- Updated Livewire directory structure to include Preview components
- Added permission-based UI visibility guidelines

### Version 1.2 (November 12, 2025)
- Added Today's Tasks Query pattern documentation
- Documented time-based sorting for today's tasks
- Clarified NULL time handling in sorting logic

### Version 1.1 (November 12, 2025)
- Added dashboard query patterns section
- Documented role counts query pattern
- Documented upcoming tasks query pattern with future date filtering
- Added work date and time sorting guidelines

### Version 1.0 (November 12, 2025)
- Initial architecture documentation
- Service layer pattern defined
- API controller pattern defined
- Livewire component pattern defined
- API Resource pattern defined
- Form Request pattern defined
- Authentication patterns documented
- Error handling patterns documented
- Testing patterns documented
- Best practices and guidelines established

