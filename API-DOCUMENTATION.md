# API Documentation

Base URL: `https://senda-snap-backend-livewire.test/api/v1`

## Table of Contents
- [Authentication](#authentication)
- [Users](#users)
- [Tasks](#tasks)
- [Vehicles](#vehicles)
- [Profile](#profile)

---

## Authentication

### Register
**POST** `/auth/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "1234567890",
    "role": "client"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "role": "client"
        },
        "token": "1|abc123..."
    }
}
```

---

### Login
**POST** `/auth/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "role": "client"
        },
        "token": "2|xyz789..."
    }
}
```

---

### Logout
**POST** `/auth/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Logout successful"
}
```

---

### Get Current User
**GET** `/auth/me`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "User retrieved successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "role": "client",
            "phone": "1234567890",
            "avatar": null
        }
    }
}
```

---

### Change Password
**POST** `/auth/change-password`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "current_password": "oldpassword123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Password changed successfully"
}
```

---

## Users

### Get All Users
**GET** `/users`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
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
                "avis_id": "AV123",
                "avatar": "avatars/abc.jpg",
                "created_at": "2024-01-01T00:00:00.000000Z"
            }
        ]
    }
}
```

---

## Tasks

### Get All Tasks
**GET** `/tasks`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `status` (optional): pending, running, completed, cancelled
- `priority` (optional): low, medium, high, urgent

**Response (200):**
```json
{
    "success": true,
    "message": "Tasks retrieved successfully",
    "data": {
        "tasks": [
            {
                "id": 1,
                "title": "Complete inspection",
                "description": "Full vehicle inspection",
                "status": "pending",
                "priority": "high",
                "due_date": "2024-12-31",
                "vehicle": {
                    "id": 1,
                    "serial_number": "SN12345"
                },
                "assigned_user": {
                    "id": 2,
                    "name": "Jane Doe"
                }
            }
        ]
    }
}
```

---

### Create Task
**POST** `/tasks`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "title": "Vehicle Inspection",
    "description": "Complete vehicle inspection",
    "status": "pending",
    "priority": "high",
    "vehicle_id": 1,
    "assigned_to": 2,
    "due_date": "2024-12-31",
    "work_date": "2024-12-20",
    "work_time": "14:30"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Task created successfully",
    "data": {
        "task": {
            "id": 1,
            "title": "Vehicle Inspection",
            "status": "pending",
            "priority": "high"
        }
    }
}
```

---

### Get Single Task
**GET** `/tasks/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Task retrieved successfully",
    "data": {
        "task": {
            "id": 1,
            "title": "Vehicle Inspection",
            "description": "Complete inspection",
            "status": "pending",
            "priority": "high",
            "vehicle": {...},
            "assigned_user": {...},
            "creator": {...},
            "attachments": []
        }
    }
}
```

---

### Update Task
**PUT** `/tasks/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "title": "Updated Title",
    "description": "Updated description",
    "status": "running",
    "priority": "urgent"
}
```

---

### Delete Task
**DELETE** `/tasks/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Task deleted successfully"
}
```

---

### Assign Task
**POST** `/tasks/{id}/assign`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "assigned_to": 3
}
```

---

### Update Task Status
**POST** `/tasks/{id}/status`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "status": "completed"
}
```

---

### Upload Task Attachment
**POST** `/tasks/{id}/attachments`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body:**
```
file: [binary file]
```

---

## Vehicles

### Get All Vehicles
**GET** `/vehicles`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Vehicles retrieved successfully",
    "data": {
        "vehicles": [
            {
                "id": 1,
                "serial_number": "SN12345",
                "brand": "Toyota",
                "model": "Camry",
                "year": 2023,
                "color": "White",
                "status": "available"
            }
        ]
    }
}
```

---

### Create Vehicle
**POST** `/vehicles`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "serial_number": "SN12345",
    "brand": "Toyota",
    "model": "Camry",
    "year": 2023,
    "color": "White",
    "status": "available",
    "vin": "1HGBH41JXMN109186",
    "license_plate": "ABC-123"
}
```

---

### Get Single Vehicle
**GET** `/vehicles/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

---

### Update Vehicle
**PUT** `/vehicles/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "status": "in_use",
    "color": "Red"
}
```

---

### Delete Vehicle
**DELETE** `/vehicles/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

---

## Profile

### Get Profile
**GET** `/profile`

**Headers:**
```
Authorization: Bearer {token}
```

---

### Update Profile
**PUT** `/profile`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "name": "John Updated",
    "phone": "9876543210"
}
```

---

### Upload Avatar
**POST** `/profile/avatar`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body:**
```
avatar: [image file]
```

---

### Remove Avatar
**DELETE** `/profile/avatar`

**Headers:**
```
Authorization: Bearer {token}
```

---

### Get Task Statistics
**GET** `/profile/task-stats`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Task statistics retrieved successfully",
    "data": {
        "total": 10,
        "pending": 3,
        "running": 2,
        "completed": 5,
        "cancelled": 0
    }
}
```

---

## Error Responses

### Unauthenticated (401)
```json
{
    "success": false,
    "message": "Unauthenticated. Please login first."
}
```

### Unauthorized (403)
```json
{
    "success": false,
    "message": "Unauthorized. You do not have permission to perform this action."
}
```

### Not Found (404)
```json
{
    "success": false,
    "message": "Resource not found."
}
```

### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation failed.",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

---

## Testing in Postman

### Step 1: Register or Login
1. Make a POST request to `/api/v1/auth/login` or `/api/v1/auth/register`
2. Copy the `token` from the response

### Step 2: Set Authorization Header
For all protected endpoints, add this header:
```
Authorization: Bearer {paste_your_token_here}
```

### Step 3: Test Endpoints
Now you can test any protected endpoint like `/api/v1/users` and get JSON responses!

### Important Postman Settings
- Set `Content-Type: application/json` in Headers tab
- Use raw JSON in Body tab for POST/PUT requests
- For file uploads, use form-data in Body tab

---

## Notes
- All API responses follow the same structure with `success`, `message`, and `data` fields
- Authentication is required for all endpoints except login and register
- Tokens are generated using Laravel Sanctum
- All dates are in ISO 8601 format

