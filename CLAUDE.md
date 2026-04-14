# CLAUDE.md — Senda Snap Backend (Livewire)

## Project Overview

| Property | Value |
|---|---|
| **Name** | Senda Snap |
| **Framework** | Laravel 12.x |
| **PHP** | 8.2+ |
| **Authentication** | Laravel Sanctum (API tokens) + Fortify |
| **Frontend** | Livewire + Flux + Volt |
| **Base URL** | https://snap.senda.fit |
| **API Prefix** | `/api/v1` |

---

## Architecture

```
app/
├── Http/
│   ├── Controllers/Api/V1/   ← 10 API controllers
│   ├── Requests/             ← 17 FormRequest validation classes
│   └── Resources/            ← 9 API resource transformers
├── Models/                   ← 15 Eloquent models
├── Services/                 ← 14 service classes (business logic layer)
├── Livewire/                 ← Web UI components
└── Actions/                  ← Fortify auth actions
routes/
├── api.php                   ← All REST API routes (versioned under v1)
└── web.php                   ← Livewire web routes
```

All business logic lives in `app/Services/` — controllers are thin and delegate to services.

---

## REST API Routes

### Public (No Authentication)

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/v1/auth/register` | Register new user |
| POST | `/api/v1/auth/login` | Login, returns Sanctum token |
| POST | `/api/v1/auth/forgot-password` | Initiate password reset |
| POST | `/api/v1/auth/reset-password` | Complete password reset |
| GET | `/api/v1/public/schedules` | List public schedules |
| GET | `/api/v1/public/schedules/{schedule}` | View public schedule |

### Protected — Requires `auth:sanctum` Header: `Authorization: Bearer {token}`

#### Authentication & Profile

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/v1/auth/logout` | Revoke current token |
| POST | `/api/v1/auth/refresh` | Refresh token |
| GET | `/api/v1/auth/me` | Get authenticated user |
| POST | `/api/v1/auth/change-password` | Change password |
| PUT | `/api/v1/auth/update-profile` | Update profile |
| GET | `/api/v1/profile` | Get profile |
| PUT | `/api/v1/profile` | Update profile |
| POST | `/api/v1/profile/avatar` | Upload avatar |
| DELETE | `/api/v1/profile/avatar` | Remove avatar |
| GET | `/api/v1/profile/task-stats` | Get user task statistics |
| GET | `/api/v1/users` | List all users |

#### Tasks

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/tasks` | List tasks (role-scoped, filterable by date) |
| POST | `/api/v1/tasks` | Create task |
| GET | `/api/v1/tasks/stats` | Count tasks by status |
| GET | `/api/v1/tasks/debug` | Debug task visibility |
| GET | `/api/v1/tasks/my-tasks` | Tasks created by current user |
| GET | `/api/v1/tasks/assigned-to-me` | Tasks assigned to current user |
| GET | `/api/v1/tasks/{task}` | Get task details |
| PUT | `/api/v1/tasks/{task}` | Update task |
| DELETE | `/api/v1/tasks/{task}` | Delete task *(admin/manager only)* |
| POST | `/api/v1/tasks/{task}/assign` | Assign task to users |
| POST | `/api/v1/tasks/{task}/status` | Update task status |
| POST | `/api/v1/tasks/{task}/attachments` | Upload attachment |
| DELETE | `/api/v1/tasks/{task}/attachments/{attachment}` | Delete attachment |

#### Schedules & Stopovers

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/schedules` | List schedules (filterable by vessel, voyage, ports) |
| POST | `/api/v1/schedules` | Create schedule |
| GET | `/api/v1/schedules/{schedule}` | Get schedule with stopovers |
| PUT | `/api/v1/schedules/{schedule}` | Update schedule |
| DELETE | `/api/v1/schedules/{schedule}` | Delete *(admin/manager only)* |
| POST | `/api/v1/schedules/{schedule}/stopovers` | Add stopover |
| GET | `/api/v1/stopovers/{stopover}` | Get stopover |
| PUT | `/api/v1/stopovers/{stopover}` | Update stopover |
| DELETE | `/api/v1/stopovers/{stopover}` | Delete stopover *(admin/manager only)* |

#### Ports

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/ports` | List ports (searchable, sortable) |
| POST | `/api/v1/ports` | Create port |
| GET | `/api/v1/ports/{port}` | Get port |
| PUT | `/api/v1/ports/{port}` | Update port |
| DELETE | `/api/v1/ports/{port}` | Delete port |

#### Shipping Companies

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/shipping-companies` | List shipping companies |
| POST | `/api/v1/shipping-companies` | Create |
| GET | `/api/v1/shipping-companies/{shippingCompany}` | Get |
| PUT | `/api/v1/shipping-companies/{shippingCompany}` | Update |
| DELETE | `/api/v1/shipping-companies/{shippingCompany}` | Delete |

#### Vendors *(Admin Only)*

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/vendors` | List vendors |
| POST | `/api/v1/vendors` | Create vendor |
| GET | `/api/v1/vendors/{vendor}` | Get vendor |
| PUT | `/api/v1/vendors/{vendor}` | Update vendor |
| DELETE | `/api/v1/vendors/{vendor}` | Delete vendor |

#### Vehicles

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/vehicles/search` | Search by ID or chassis (queries external DB) |
| POST | `/api/v1/vehicles/upload-images` | Upload vehicle images |

---

## API Response Format

All API responses use a standardized envelope from `Controller::successResponse()` / `Controller::errorResponse()`.

### Success
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {},
  "meta": { "timestamp": "..." }
}
```

### Error
```json
{
  "success": false,
  "message": "Error description",
  "errors": {},
  "meta": { "timestamp": "..." }
}
```

### HTTP Status Codes
| Code | Meaning |
|---|---|
| 200 | Success |
| 201 | Created |
| 401 | Unauthenticated (auth:sanctum failed) |
| 403 | Forbidden (insufficient role) |
| 404 | Not found |
| 422 | Validation error |
| 500 | Server error |

Exception handling is wired in `bootstrap/app.php` — all API exceptions return JSON automatically.

---

## Authentication

- **Mechanism**: Laravel Sanctum personal access tokens
- **Header**: `Authorization: Bearer {token}`
- **Token issued on**: `POST /api/v1/auth/login`
- **Token revoked on**: `POST /api/v1/auth/logout`
- **Password reset**: Stateless token via email link

---

## Role-Based Access Control

| Role | Access |
|---|---|
| `admin` | Full access to all vendors and all resources |
| `manager` | Scoped to own vendor's data |
| `employee` | Scoped to own vendor + only assigned tasks |
| `client` | Own profile + own tasks only |

Role checks are enforced in the service layer (`TaskService`, `ScheduleService`, etc.) and via controller-level middleware for vendor-only routes.

**Vendor scoping** is implemented via `vendor_id` on the `users` table — `hasVendorRestriction()` returns `true` for managers and employees, causing service queries to add `WHERE vendor_id = ?`.

---

## Models & Relationships

### User
```
vendor_id (FK) | name | email | role | phone | avatar | avis_id
→ vendor()           BelongsTo Vendor
→ assignedTasks()    HasMany Task (assigned_to)
→ createdTasks()     HasMany Task (created_by)
→ vehicles()         HasMany Vehicle
```

### Task
```
title | description | work_date | work_time | status | priority | created_by | due_date | completed_at
Status: pending | running | completed | cancelled
Priority: low | medium | high | urgent
→ assignedUsers()    BelongsToMany User (pivot: task_user)
→ creator()          BelongsTo User
→ attachments()      HasMany TaskAttachment
Scope: forUserRole() — role-based visibility
```

### Schedule
```
vessel_name | voyage_no | carrier_1_id | carrier_2_id | carrier_3_id
start_port_id | end_port_id | eta | etd | status | comment | is_public
Status: Waiting | Loading | On-Sea | Stop Over | Destination
→ carrier1/2/3()     BelongsTo ShipLine
→ startPort/endPort() BelongsTo Port
→ stopovers()        HasMany ScheduleStopover
→ addedBy()          BelongsTo User
```

### Vendor
```
name | email | phone | address | website | status
external_db_host | external_db_port | external_db_database
external_db_username | external_db_password (encrypted)
external_image_path | external_image_base_url
→ users()    HasMany User
→ tasks()    HasMany Task
→ vehicles() HasMany Vehicle
```

### Vehicle
```
serial_number | make | model | chassis_model | cc | year | color
dimensions (length/width/height) | pricing | status | vendor_id
→ photos()     HasMany VehiclePhoto
→ consignee()  HasOne ConsigneeDetail
→ creator()    BelongsTo User
```

### Port / ShipLine
```
Port: port_name | port_type | port_address | created_by
ShipLine (tbl_ship_line): line_name | status
Both are global — not scoped by vendor
```

---

## Database

- **Engine**: MySQL
- **Database**: `sendasnap_db`
- **Host**: `127.0.0.1:3306`

### Key Tables

| Table | Purpose |
|---|---|
| `users` | App users with role + vendor_id |
| `vendors` | Multi-tenant vendor config + external DB credentials |
| `tasks` | Task management |
| `task_user` | Many-to-many task assignments |
| `task_attachments` | Files attached to tasks |
| `vehicles` | Internal vehicle records |
| `vehicle_photos` | Vehicle images |
| `vehicle_search_logs` | Search analytics |
| `consignee_details` | Consignee info per vehicle |
| `ports` | Global port list |
| `tbl_ship_line` | Shipping companies/carriers |
| `schedules` | Shipment schedules |
| `schedule_stopovers` | Stopover waypoints |
| `notices` | System announcements |
| `personal_access_tokens` | Sanctum tokens |

> The `tbl_ship_line` table uses a legacy naming convention — the model is `ShipLine`.

---

## Services Layer

All business logic lives here. Controllers call services; services call models.

| Service | Responsibility |
|---|---|
| `AuthService` | Registration, login, token refresh, password flows |
| `TaskService` | Task CRUD, assignment, attachments, role-based filtering |
| `ScheduleService` | Schedule management, public/private visibility |
| `ScheduleStopoverService` | Stopover CRUD |
| `PortService` | Port management |
| `VendorService` | Vendor CRUD + external DB config |
| `VehicleService` | Vehicle search, image uploads |
| `ExternalVehicleService` | Queries per-vendor external vehicle databases |
| `ShipLineService` | Shipping company management |
| `ProfileService` | User profile + avatar |
| `UserService` | User listing |
| `SftpService` | SFTP file transfer (for external image access) |
| `NoticeService` | Notice management |

---

## Request Validation

Located in `app/Http/Requests/`. Follows Laravel FormRequest pattern.

| Class | Used By |
|---|---|
| `StoreTaskRequest` / `UpdateTaskRequest` | TaskController |
| `StoreScheduleRequest` / `UpdateScheduleRequest` | ScheduleController |
| `StoreScheduleStopoverRequest` / `UpdateScheduleStopoverRequest` | ScheduleStopoverController |
| `StorePortRequest` / `UpdatePortRequest` | PortController |
| `StoreShippingCompanyRequest` / `UpdateShippingCompanyRequest` | ShippingCompanyController |
| `StoreVendorRequest` / `UpdateVendorRequest` | VendorController |
| `StoreVehicleRequest` / `UpdateVehicleRequest` | VehicleController |
| `UpdateProfileRequest` | ProfileController |
| `StoreNoticeRequest` / `UpdateNoticeRequest` | NoticeController |

---

## API Resources (Transformers)

Located in `app/Http/Resources/`. Extend `JsonResource`.

| Resource | Transforms |
|---|---|
| `UserResource` | User model → JSON (hides password, exposes avatar_url) |
| `TaskResource` | Task with assigned_users, creator, attachments |
| `TaskAttachmentResource` | Attachment with file_url accessor |
| `ScheduleResource` | Schedule with carriers, ports, stopovers |
| `ScheduleStopoverResource` | Stopover with port |
| `PortResource` | Port with creator |
| `VendorResource` | Vendor (external_db_password hidden) |
| `VehicleResource` | Vehicle with photos, consignee |
| `ShippingCompanyResource` | Ship line details |

---

## File Storage

| Type | Path |
|---|---|
| Avatars | `storage/app/public/avatars/` |
| Task attachments | `storage/app/public/tasks/` |
| Vehicle photos | `storage/app/public/vehicles/` |

Access via: `Storage::url($path)` → `/storage/{path}`

Run `php artisan storage:link` if symlink is missing.

---

## Key Dependencies

```json
"laravel/framework": "^12.0"
"laravel/sanctum": "^4.0"
"laravel/fortify": "^1.30"
"livewire/flux": "^2.1.1"
"livewire/volt": "^1.7.0"
"league/flysystem-sftp-v3": "^3.30"
"maatwebsite/excel": "^3.1"
```

---

## Common Development Commands

```bash
# Run development server
php artisan serve

# Run migrations
php artisan migrate

# Fresh migration with seeds
php artisan migrate:fresh --seed

# Clear all caches
php artisan optimize:clear

# Link storage
php artisan storage:link

# Run tests
./vendor/bin/pest

# Format code
./vendor/bin/pint

# Tinker REPL
php artisan tinker
```

---

## Environment Variables (Critical)

```env
APP_URL=https://snap.senda.fit
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sendasnap_db

SANCTUM_STATEFUL_DOMAINS=...
SESSION_DRIVER=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public
```

---

## Multi-Tenancy Notes

- Each `Vendor` can have its own external MySQL database for vehicle data (`external_db_*` fields).
- `ExternalVehicleService` dynamically creates a DB connection using the vendor's credentials at runtime.
- The `external_db_password` is encrypted at rest using Laravel's `Crypt` facade.
- `SftpService` handles image retrieval from vendor SFTP servers using `external_image_path`.

---

## Exception Handling

Configured in `bootstrap/app.php`. All exceptions on API routes return JSON:

| Exception | HTTP Code | Response |
|---|---|---|
| `AuthenticationException` | 401 | `{"success":false,"message":"Unauthenticated"}` |
| `AuthorizationException` | 403 | `{"success":false,"message":"Forbidden"}` |
| `ModelNotFoundException` | 404 | `{"success":false,"message":"Not found"}` |
| `NotFoundHttpException` | 404 | `{"success":false,"message":"Not found"}` |
| `ValidationException` | 422 | `{"success":false,"errors":{...}}` |

CSRF is disabled for `POST /deploy/github` (webhook endpoint).
