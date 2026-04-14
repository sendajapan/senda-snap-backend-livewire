# AGENTS.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

**Senda Snap** is a Laravel 12 + Livewire 3 + Flux UI application for managing vehicle shipments, tasks, and logistics operations. It implements a **Service-Oriented Architecture (SOA)** with multi-vendor support and provides both web (Livewire) and mobile (REST API with Sanctum) interfaces.

**Key Technologies:**
- Laravel 12 (PHP 8.2+)
- Livewire 3 with Volt
- Livewire Flux UI components
- Tailwind CSS 4
- Laravel Sanctum for API authentication
- Pest for testing
- Laravel Pint for code formatting

## Common Development Commands

### Development Server
```powershell
# Start development (runs server + queue + vite concurrently)
composer dev

# Or manually
php artisan serve
php artisan queue:listen --tries=1
npm run dev
```

### Testing
```powershell
# Run all tests with Pest
php artisan test

# Or use Pest directly
vendor/bin/pest

# Run specific test file
vendor/bin/pest tests/Feature/Tasks/KanbanBoardTest.php

# Run with coverage
vendor/bin/pest --coverage
```

### Code Quality
```powershell
# Format code with Pint (PSR-12)
vendor/bin/pint

# Format specific files
vendor/bin/pint app/Services/TaskService.php
```

### Database
```powershell
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migrations with seeding
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_example_table
```

### Asset Building
```powershell
# Build assets for production
npm run build

# Watch for changes (dev mode)
npm run dev
```

### Artisan Generators
```powershell
# Create service class
php artisan make:class Services/ExampleService

# Create Livewire component
php artisan make:livewire Examples/Index

# Create API controller
php artisan make:controller Api/V1/ExampleController --api

# Create API resource
php artisan make:resource ExampleResource

# Create form request
php artisan make:request StoreExampleRequest

# Create model with migration and factory
php artisan make:model Example -mf
```

## Architecture

This codebase follows **Service-Oriented Architecture** with clear separation of concerns:

### Layer Responsibilities

1. **Services** (`app/Services/`)
   - ALL business logic resides here
   - Database queries and Eloquent operations
   - File handling, external API calls
   - Multi-step operations and transactions
   - **Critical**: Always use Service methods instead of direct model access

2. **Controllers** (`app/Http/Controllers/Api/V1/`)
   - Thin layer for API endpoints only
   - Handle request validation (via Form Requests)
   - Call Service methods
   - Return API Resources
   - **Never** contain business logic

3. **Livewire Components** (`app/Livewire/`)
   - Handle web UI interactions
   - Call Service methods directly
   - Manage component state
   - Use **method injection** for services (NOT constructor injection)

4. **Models** (`app/Models/`)
   - Define relationships
   - Implement scopes
   - Use traits like `BelongsToVendor` for multi-tenancy
   - **Never** accessed directly from controllers/components

5. **API Resources** (`app/Http/Resources/`)
   - Transform models to JSON
   - Use `whenLoaded()` for relationships
   - Never expose sensitive data

6. **Form Requests** (`app/Http/Requests/`)
   - Validation rules for API endpoints
   - Authorization logic
   - Custom error messages

### Key Architectural Patterns

**Multi-Vendor (Multi-Tenant) Architecture:**
- Users belong to vendors via `vendor_id`
- Tasks: Role-based scoping (Admin sees all, Manager sees vendor's tasks, Users see assigned/created tasks)
- Vehicles: Vendor-scoped using `BelongsToVendor` trait
- Ports/Shipping Companies: Global resources shared across vendors
- Always use Service methods to enforce scoping (see ARCHITECTURE.md section "Task and Vehicle Scoping Best Practices")

**Route Model Binding Considerations:**
- Route model binding bypasses scoping
- Always re-fetch through Service methods in components/controllers:
  ```php
  // ❌ WRONG: Bypasses scoping
  public function mount(Task $task) { $this->task = $task; }
  
  // ✅ CORRECT: Enforces scoping
  public function mount(int $task, TaskService $taskService) {
      $this->task = $taskService->getTaskById($task);
  }
  ```

**Livewire Service Injection:**
- Use **method injection** in Livewire (never constructor injection)
- Inject services in `render()`, action methods, or `mount()`:
  ```php
  public function render(TaskService $taskService): View {
      $tasks = $taskService->list($filters);
      return view('livewire.tasks.index', compact('tasks'));
  }
  ```

**Filter Refresh Pattern (Critical for Livewire):**
- When filters update component state, increment a `refreshKey` property to force re-renders
- Required for complex layouts (Kanban boards, tables, grids)
  ```php
  public int $refreshKey = 0;
  
  public function updatedPriorityFilter($value): void {
      $this->priorityFilter = $value;
      $this->refreshKey++; // Force refresh
  }
  ```
- Use `refreshKey` in `wire:key` attributes

**Delete Event Listener Pattern:**
- Event listeners with `#[On('delete-*')]` cannot use dependency injection with array payloads
- Use flexible parameter handling:
  ```php
  #[On('delete-item')]
  public function deleteItem($itemId = null, ?Service $service = null): void {
      if (is_array($itemId)) $itemId = $itemId['itemId'] ?? null;
      if (!$service) $service = app(Service::class);
      // ...
  }
  ```

## Important Files

### Architecture Documentation
- **ARCHITECTURE.md**: Comprehensive architecture patterns, service layer guidelines, multi-vendor scoping rules
- **DESIGN_SYSTEM.md**: UI/UX patterns, color variants per module, component usage guidelines

### Configuration
- `composer.json`: PHP dependencies (Laravel 12, Livewire Flux, Sanctum)
- `package.json`: Frontend dependencies (Vite, Tailwind CSS 4)
- `phpunit.xml`: Pest test configuration
- `routes/web.php`: Livewire routes (authenticated web UI)
- `routes/api.php`: Sanctum-protected API routes (v1)

### Key Directories
- `app/Services/`: Business logic layer (AuthService, TaskService, VehicleService, UserService, etc.)
- `app/Livewire/`: Livewire components for web UI
- `app/Http/Controllers/Api/V1/`: RESTful API controllers
- `app/Http/Resources/`: API response transformers
- `app/Models/`: Eloquent models with relationships and scopes
- `database/migrations/`: Database schema

## Code Standards

### Naming Conventions
- Services: `{Model}Service.php` (e.g., `TaskService.php`)
- API Controllers: `{Model}Controller.php` in `Api/V1/`
- Resources: `{Model}Resource.php`
- Form Requests: `{Action}{Model}Request.php` (e.g., `StoreTaskRequest.php`)
- Livewire: `{Module}/{Component}.php` (e.g., `Tasks/Index.php`)

### Code Style
- Use `declare(strict_types=1);` at the top of all PHP files
- Follow PSR-12 standards (enforced by Laravel Pint)
- Type hints for all parameters and return types
- PHPDoc blocks for complex methods
- Service method names: `list()`, `create()`, `update()`, `delete()`, `getById()`

### Module Color Assignments (UI Consistency)
Each module has a unique color variant for visual consistency:
- **Users**: `blue`
- **Tasks**: `emerald`
- **Vehicles**: `amber`
- **Ports**: `indigo`
- **Shipment Schedule**: `cyan`
- **Shipping Companies**: `indigo`
- **Vendors**: `violet`
- **Notices**: `violet`

Use the same variant for all components within a module (page headers, table cards, modals).

## Testing Strategy

Tests are written in **Pest** (located in `tests/`):
- **Feature Tests** (`tests/Feature/`): Test full request/response cycles, API endpoints, Livewire interactions
- **Unit Tests** (if added): Test individual service methods in isolation

Example test command patterns:
```powershell
vendor/bin/pest                                    # All tests
vendor/bin/pest tests/Feature/Tasks/               # Specific directory
vendor/bin/pest --filter=KanbanBoard               # Filter by name
```

## Development Workflow

### Adding a New Feature (Complete Checklist)
See ARCHITECTURE.md "Checklist for New Features" section for full details. Summary:

1. Create Model & Migration (`php artisan make:model Feature -mf`)
2. Create Service Class (`app/Services/FeatureService.php`)
3. Implement CRUD methods in Service
4. Create API Resource (`app/Http/Resources/FeatureResource.php`)
5. Create Form Requests (`StoreFeatureRequest`, `UpdateFeatureRequest`)
6. Create API Controller (`Api/V1/FeatureController`)
7. Create Livewire Components (`Features/Index`, `Features/FeatureModal`)
8. Add routes to `routes/api.php` and `routes/web.php`
9. Write tests (Service, API, Livewire)
10. Run `vendor/bin/pint` and `php artisan test`

### Multi-Vendor Feature Implementation
When adding vendor-scoped features:
- Add `vendor_id` foreign key to migration
- Use `BelongsToVendor` trait in model or implement custom scoping
- Service methods should apply vendor scoping automatically
- Admin users (vendor_id = null) see all data

### API Development
- All API routes prefixed with `/api/v1/`
- Protected by `auth:sanctum` middleware
- Return consistent JSON structure:
  ```json
  {
    "success": true,
    "message": "...",
    "data": { ... },
    "meta": { ... }
  }
  ```
- Use API Resources for all responses

## Critical Rules

### DOs ✅
- **Always** use Service methods for business logic
- **Always** apply vendor/role scoping in Services
- **Always** validate using Form Requests in API controllers
- **Always** use API Resources for JSON responses
- **Always** use method injection for Livewire services
- **Always** run `vendor/bin/pint` before committing
- **Always** write tests for new features
- **Always** check ARCHITECTURE.md for patterns before implementing

### DON'Ts ❌
- **Never** put business logic in Controllers or Livewire components
- **Never** use Eloquent directly in Controllers/Livewire (always go through Services)
- **Never** use constructor injection in Livewire components
- **Never** bypass vendor/role scoping (always use Service methods)
- **Never** return raw models from API endpoints (use Resources)
- **Never** skip Form Request validation in API controllers
- **Never** commit without running Pint and tests

## Common Patterns Reference

For detailed patterns and examples, see **ARCHITECTURE.md**:
- Service Layer Pattern (lines 396-550)
- API Controller Pattern (lines 553-697)
- Livewire Component Pattern (lines 700-1225)
- Multi-Vendor Architecture (lines 8-316)
- Preview Component Pattern (lines 865-977)
- Permission System Pattern (lines 979-1036)
- Filter Refresh Pattern (lines 1054-1138)
- Delete Event Listener Pattern (lines 1139-1224)
- Child Record Warning Pattern (lines 1226-1377)

## Database

- **Connection**: MySQL (see `.env.example`)
- **Migrations**: Located in `database/migrations/`
- **Key Tables**: users, vendors, tasks, vehicles, ports, schedules, shipping_companies
- **Multi-tenancy**: `vendor_id` foreign key in users/vehicles tables

## Additional Resources

- **Comprehensive Architecture**: See `ARCHITECTURE.md` for full service patterns, scoping rules, and best practices
- **Design System**: See `DESIGN_SYSTEM.md` for UI/UX guidelines and component patterns
- **Laravel Docs**: https://laravel.com/docs/12.x
- **Livewire Docs**: https://livewire.laravel.com/docs
- **Flux UI Docs**: https://flux.laravel.com
- **Pest Docs**: https://pestphp.com

---

**Version**: 1.0  
**Last Updated**: February 2, 2026  
**Project**: Senda Snap Backend (Laravel + Livewire)
