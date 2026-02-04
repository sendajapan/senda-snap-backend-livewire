# Design System Documentation
## Laravel Livewire SaaS Application - UI/UX Patterns & Component Library

> **Version**: 2.2
> **Last Updated**: February 4, 2026
> **Project**: Senda Snap - Logistics Management System

---

## Table of Contents

### Design Foundations
- [Color System](#color-system)
- [Typography](#typography)
- [Shadows & Depth](#shadows--depth)

### Component Library
- [Page Components](#page-components)
- [Table Components](#table-components)
- [Card Components](#card-components)
- [Modal Components](#modal-components)
- [Status & Badges](#status--badges)

### Layout Patterns
- [Standard Page Layout](#standard-page-layout)
- [Dashboard Layout](#dashboard-layout)
- [Kanban Board](#kanban-board)

### Best Practices
- [Responsive Design](#responsive-design)
- [Dark Mode](#dark-mode)
- [Accessibility](#accessibility)
- [Performance](#performance)

---

## Color System

### Module Color Assignments

**CRITICAL RULE**: Each module uses ONE color variant consistently across all pages/components.

| Module | Color | Usage |
|--------|-------|-------|
| **Users** | `blue` | User management, authentication |
| **Tasks** | `emerald` | All task views (Today, All, Kanban) |
| **Vehicles** | `amber` | Vehicle inventory, tracking |
| **Ports** | `indigo` | Port management |
| **Shipment Schedule** | `cyan` | Schedules, stopovers |
| **Shipping Companies** | `indigo` | Shipping line management |
| **Vendors** | `violet` | Vendor management (admin) |
| **Notices** | `violet` | System announcements |
| **API Docs** | `violet` | API documentation |

### Color Variants

Each color variant includes these shades:

```css
/* Blue (Users) */
Primary: blue-500 → cyan-500
Light: blue-50/30 → cyan-50/30
Border: blue-200
Shadow: blue-400/20 → cyan-400/20

/* Emerald (Tasks) */
Primary: emerald-500 → teal-500
Light: emerald-50/30 → teal-50/30
Border: emerald-200
Shadow: emerald-400/20 → teal-400/20

/* Amber (Vehicles) */
Primary: amber-500 → orange-500
Light: amber-50/30 → orange-50/30
Border: amber-200
Shadow: amber-400/20 → orange-400/20

/* Violet (Vendors/Notices/API) */
Primary: violet-500 → purple-500
Light: violet-50/30 → purple-50/30
Border: violet-200
Shadow: violet-400/20 → purple-400/20

/* Indigo (Ports/Shipping) */
Primary: indigo-500 → purple-500
Light: indigo-50/30 → purple-50/30
Border: indigo-200
Shadow: indigo-400/20 → purple-400/20

/* Cyan (Schedules) */
Primary: cyan-500 → blue-500
Light: cyan-50/30 → blue-50/30
Border: cyan-200
Shadow: cyan-400/20 → blue-400/20
```

### Usage Rules

**Correct**: Same module, same color
```blade
<!-- Users module -->
<x-page-header variant="blue" />
<x-table-card variant="blue" />
```

**Incorrect**: Same module, different colors
```blade
<!-- WRONG: Mixing colors in Users module -->
<x-page-header variant="blue" />
<x-table-card variant="violet" /> <!-- Should be blue -->
```

---

## Shadows & Depth

### Standard Shadow Levels

**Dashboard Cards** (Recommended):
```css
/* Default */
shadow-xl shadow-{color}-200/40 dark:shadow-{color}-900/30

/* Hover */
hover:shadow-2xl hover:shadow-{color}-300/50 dark:hover:shadow-{color}-800/40
```

**Standard Cards**:
```css
/* Default */
shadow-md shadow-{color}-100/50 dark:shadow-{color}-900/20

/* Hover */
hover:shadow-lg hover:shadow-{color}-200/50 dark:hover:shadow-{color}-800/30
```

**Small Elements** (badges, indicators):
```css
shadow-sm shadow-{color}-500/50
```

---

## Typography

### Headings
```css
Page Title:    text-2xl font-bold text-gray-900 dark:text-white
Section Title: text-xl font-bold text-gray-900 dark:text-white
Card Title:    text-lg font-semibold text-gray-900 dark:text-white
Stat Title:    text-sm font-medium text-accent
Stat Count:    text-4xl font-bold text-accent
```

### Body Text
```css
Primary:   text-sm text-gray-900 dark:text-white
Secondary: text-sm text-gray-600 dark:text-gray-400
Muted:     text-xs text-gray-500 dark:text-gray-400
```

### Table Text
```css
Header: text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300
Label:  text-sm font-medium text-gray-700 dark:text-gray-300
```

---

## Page Components

### 1. Page Header

Consistent header with icon, title, description, and actions.

```blade
<x-page-header
    :title="__('Page Title')"
    :description="__('Page description')"
    variant="blue">
    <x-slot:icon>
        <svg class="h-7 w-7 text-white">...</svg>
    </x-slot:icon>
    <x-slot:actions>
        <flux:button icon="plus">Add New</flux:button>
    </x-slot:actions>
</x-page-header>
```

**Features**:
- Glass morphism background (`bg-white/50 backdrop-blur-sm`)
- Decorative blur circles
- Icon badge with gradient (h-14 w-14)
- Responsive padding
- Dark mode support

---

### 2. Table Card

Card wrapper for tables with gradient effects.

```blade
<x-table-card variant="emerald">
    <!-- Filters -->
    <div class="mb-4 flex gap-4">
        <flux:input wire:model.live.debounce.300ms="search" />
    </div>

    <!-- Table -->
    <div class="overflow-x-auto border rounded-xl bg-white/50 dark:bg-gray-800/50">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <!-- Table content -->
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">{{ $items->links() }}</div>
</x-table-card>
```

---

### 3. Stats Card

Display statistics with animated bubble particles.

```blade
<x-stats-card
    :title="__('Total Users')"
    :count="$totalUsers"
    :description="__('All registered users')"
    variant="blue">
    <x-slot:icon>
        <svg class="h-6 w-6 text-white">...</svg>
    </x-slot:icon>
</x-stats-card>
```

**Features**:
- Frosted glass background
- Animated floating bubbles
- Decorative blur circles
- Gradient icon container
- Variant-based colors

---

## Card Components

### Task Card (for Kanban)

```blade
<x-task-card-kanban :task="$task" status="pending" />
```

**Props**:
- `task`: Task model
- `status`: pending|running|completed|cancelled

**Features**:
- Gradient background (50% opacity)
- Priority badge
- Assigned users (max 2 + count)
- Attachment indicator
- Created time highlight
- Drag-and-drop enabled

---

### User Card (for grids)

```blade
@forelse($users as $user)
    <x-user-card :user="$user" :rounded="true" wire:key="user-card-{{ $user->id }}" />
@empty
```

**Props**:
- `user`: User model
- `rounded`: true|false (controls border radius)

**Features**:
- Avatar with fallback initials
- Role badge
- Vendor information
- Hover effects
- Action buttons

**Card Component Pattern**:

```blade
@props(['user', 'rounded' => true])

<div class="group relative overflow-hidden {{ $rounded ? 'rounded-xl' : '' }} border border-blue-200 bg-white/50 p-4 transition-shadow duration-200 hover:shadow-lg dark:bg-gray-800/50">
    <!-- Card content -->

    <!-- Action buttons with transition-shadow -->
    <button class="transition-shadow duration-200 hover:shadow-lg">...</button>
</div>
```

See [Performance Rules](#performance) for all performance-related constraints on cards.

---

## Table Components

### Standard Table Structure

**Requirements**:
1. **S/N Column**: Always first column (w-16, centered)
2. **Actions Column**: Always last column (w-32, centered)
3. **Performance**: Always use `wire:key` in loops (see [Performance Rules](#performance))

```blade
<div class="overflow-x-auto border rounded-xl bg-white/50 dark:bg-gray-900/20">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <!-- Header -->
        <thead>
            <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                <th class="px-6 py-4 text-center text-xs font-bold uppercase w-16">
                    {{ __('S/N') }}
                </th>
                <th class="px-6 py-4 text-left text-xs font-bold uppercase">
                    {{ __('Name') }}
                </th>
                <th class="px-6 py-4 text-center text-xs font-bold uppercase w-32">
                    {{ __('Actions') }}
                </th>
            </tr>
        </thead>

        <!-- Body -->
        <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
            @forelse($items as $index => $item)
                <x-item-table-row :item="$item" :index="$items->firstItem() + $index" wire:key="item-row-{{ $item->id }}" />
            @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400">...</svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">{{ __('No items found') }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
```

### Table Row Component Pattern

**File**: `resources/views/components/item-table-row.blade.php`

```blade
@props(['item', 'index'])

<tr class="group hover:bg-blue-50/30 dark:hover:bg-blue-900/10">
    <!-- S/N -->
    <td class="px-6 py-5 text-center">
        <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">
            {{ $index }}
        </span>
    </td>

    <!-- Content columns -->
    <td class="px-6 py-5">
        <div class="text-sm font-bold text-gray-900 dark:text-white">
            {{ $item->name }}
        </div>
    </td>

    <!-- Actions -->
    <td class="px-6 py-5 w-32">
        <div class="flex justify-center items-center gap-2">
            <button class="transition-shadow duration-200 hover:shadow-lg">...</button>
        </div>
    </td>
</tr>
```

See [Performance Rules](#performance) for all performance-related constraints on table rows.

---

## Modal Components

### CRUD Modal (Side Panel)

Full-height right-side slide-in modal for create/edit operations.

```blade
<div x-data="{ open: @entangle('open') }" x-show="open" class="fixed inset-0 z-50">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

    <!-- Panel -->
    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
        <div class="w-screen max-w-xl bg-white/60 backdrop-blur-xl">
            <div class="flex h-full flex-col border-l border-{color}-300/50 shadow-xl">
                <!-- Decorative blur circles -->
                <div class="absolute -right-8 -top-8 h-64 w-64 rounded-full bg-gradient-to-br from-{color}-400/20 blur-3xl"></div>

                <!-- Header -->
                <div class="relative border-b bg-white/50 px-6 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-{color}-500 to-{color2}-600 flex items-center justify-center">
                                <svg class="h-6 w-6 text-white">...</svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold">Modal Title</h2>
                                <p class="text-sm text-gray-600">Description</p>
                            </div>
                        </div>
                        <button wire:click="closeModal" class="rounded-lg p-2 hover:bg-gray-100">
                            <svg class="h-6 w-6">...</svg>
                        </button>
                    </div>
                </div>

                <!-- Form -->
                <form wire:submit="save" class="flex-1 overflow-y-auto">
                    <div class="space-y-6 p-6">
                        <!-- Form fields -->
                    </div>

                    <!-- Footer -->
                    <div class="border-t px-6 py-4">
                        <div class="flex justify-end gap-3">
                            <flux:button wire:click="closeModal" variant="ghost">Cancel</flux:button>
                            <flux:button type="submit" variant="primary">Save</flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
```

**Features**:
- Slides in from right (500ms animation)
- Max width: 40rem (xl)
- Glass morphism effects
- Decorative blur circles
- Icon badge header
- Click outside does NOT close

---

### Preview Modal (Center Dialog)

Center dialog for read-only item preview.

```blade
<div x-data="{ open: @entangle('open') }" x-show="open" class="fixed inset-0 z-50">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-4xl rounded-2xl bg-gradient-to-br from-{color}-50 via-white to-{color2}-50 shadow-2xl">
            <!-- Decorative elements -->
            <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-{color}-400/20 blur-2xl"></div>

            <!-- Content -->
            <div class="relative max-h-[90vh] overflow-y-auto p-6 pb-20">
                <div class="rounded-xl border border-{color}-200/50 bg-white/50 p-6 backdrop-blur-sm">
                    <!-- Preview content -->
                </div>
            </div>

            <!-- Actions (fixed bottom) -->
            <div class="absolute bottom-0 left-0 right-0 flex justify-between border-t bg-white/60 px-4 py-3 backdrop-blur-md">
                <!-- Close (left) -->
                <button wire:click="closePreview" class="rounded-lg border-2 border-gray-500/60 bg-gray-600/20 px-3 py-2">
                    <svg class="h-4 w-4">...</svg>
                    <span class="text-xs font-semibold">Close</span>
                </button>

                <!-- Edit/Delete (right) -->
                <div class="flex gap-2">
                    <button wire:click="editItem" class="rounded-lg border-2 border-cyan-500/70 bg-cyan-600/20 px-3 py-2">
                        <svg class="h-4 w-4">...</svg>
                        <span class="text-xs font-semibold">Edit</span>
                    </button>
                    @if($this->canDelete())
                        <button @click="confirmDelete(...)" class="rounded-lg border-2 border-red-500/70 bg-red-600/20 px-3 py-2">
                            <svg class="h-4 w-4">...</svg>
                            <span class="text-xs font-semibold">Delete</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
```

**Features**:
- Center positioned, max-width 64rem (4xl)
- Scale animation (300ms)
- Gradient on parent container
- Transparent preview card shows gradient through
- Separated button layout: Close (left), Actions (right)
- Smaller buttons with glowing borders
- High contrast text on blurry backgrounds

---

## Status & Badges

### Design Variants

**1. Compact Glass** (Recommended for status labels):
```blade
<div class="group relative flex items-center justify-between overflow-hidden rounded-xl border border-{color}-400/50 bg-gradient-to-r from-{color}-500/10 via-{color}-400/5 to-white/40 px-3 py-2 shadow-lg backdrop-blur-xl">
    <!-- Blur glow -->
    <div class="absolute -left-3 top-1/2 h-12 w-12 -translate-y-1/2 rounded-full bg-{color}-500/20 blur-xl"></div>

    <div class="relative flex items-center gap-2">
        <!-- Icon (h-7 w-7) -->
        <div class="h-7 w-7 rounded-lg bg-gradient-to-br from-{color}-400 to-{color2}-500 flex items-center justify-center shadow-md">
            <svg class="h-3.5 w-3.5 text-white">...</svg>
        </div>
        <span class="text-xs font-bold text-{color}-900">Label</span>
    </div>

    <!-- Badge -->
    <span class="rounded-full bg-gradient-to-r from-{color}-500 to-{color2}-500 px-2.5 py-0.5 text-xs font-bold text-white">{{ $count }}</span>
</div>
```

**2. Neon Glow** (For role counters with subtitles):
```blade
<div class="group relative flex items-center justify-between overflow-hidden rounded-xl border border-{color}-400/50 bg-gradient-to-r from-{color}-500/10 px-4 py-3 shadow-lg">
    <!-- Larger blur glow -->
    <div class="absolute -left-4 top-1/2 h-16 w-16 -translate-y-1/2 rounded-full bg-{color}-500/30 blur-2xl"></div>

    <div class="relative flex items-center gap-3">
        <!-- Icon (h-8 w-8) -->
        <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-{color}-400 to-{color2}-500 flex items-center justify-center shadow-lg">
            <svg class="h-4 w-4 text-white">...</svg>
        </div>
        <div>
            <span class="text-sm font-bold text-{color}-900">Label</span>
            <p class="text-xs text-{color}-600/80">Subtitle</p>
        </div>
    </div>

    <span class="rounded-full bg-gradient-to-r from-{color}-500 to-{color2}-500 px-3 py-1 text-sm font-bold text-white shadow-lg">{{ $count }}</span>
</div>
```

### Color Combinations

| Status | Primary | Secondary |
|--------|---------|-----------|
| Pending | amber | orange |
| Running | blue | indigo |
| Completed | emerald | green |
| Cancelled | red | rose |
| Admin | red | rose |
| Manager | blue | indigo |
| Employee | emerald | green |
| Client | violet | purple |

---

## Action Buttons

### Button Pattern (Table rows & cards)

```blade
<div class="flex items-center gap-2">
    <!-- View Button -->
    <button @click="openPreview({{ $item->id }})"
            class="rounded-lg border-2 border-{color}-700/60 bg-{color}-500/10 p-1.5 hover:border-{color}-700 hover:bg-{color}-500/20 hover:shadow-lg">
        <svg class="h-4 w-4 text-{color}-700">...</svg>
    </button>

    <!-- Edit Button -->
    <button @click="openModal({{ $item->id }})"
            class="rounded-lg border-2 border-cyan-700/60 bg-cyan-500/10 p-1.5 hover:border-cyan-700 hover:bg-cyan-500/20 hover:shadow-lg">
        <svg class="h-4 w-4 text-cyan-700">...</svg>
    </button>

    <!-- Delete Button (with permission check) -->
    @if($canDelete)
        <button @click="confirmDelete({{ $item->id }}, '{{ $item->name }}', @js($warnings))"
                class="rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 hover:border-red-700 hover:bg-red-500/20 hover:shadow-lg">
            <svg class="h-4 w-4 text-red-700">...</svg>
        </button>
    @endif
</div>
```

**Features**:
- Small, icon-only buttons (p-1.5, h-4 w-4)
- Outline border with semi-transparent background
- Hover: darker border, increased opacity, shadow
- No opacity transitions (always visible)
- Integrated with SweetAlert2 for confirmations
- Permission checks in Blade

**Permission Rules**:
- Admin + Manager can delete
- Manager cannot delete own account
- Manager cannot delete admin accounts

**Child Record Warnings**:
```php
// Example: Check cascade delete relationships
$warnings = [];
$stopoverCount = $schedule->stopovers()->count();
if ($stopoverCount > 0) {
    $warnings[] = __(':count stopover(s)', ['count' => $stopoverCount]);
}

// Example: Check nullOnDelete relationships
$userCount = $vendor->users()->count();
if ($userCount > 0) {
    $warnings[] = __(':count user(s) will have their vendor association removed', ['count' => $userCount]);
}
```

---

## Layout Patterns

### Standard Page Layout

```blade
<div class="flex h-full w-full flex-1 flex-col gap-4 p-6" x-data="{
    openModal(itemId = null) {
        $wire.$dispatch('open-item-modal', { itemId: itemId })
    }
}">
    <!-- 1. Page Header -->
    <x-page-header variant="blue" :title="__('Items')" :description="__('Manage items')">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white">...</svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline">
                {{ __('Add New') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- 2. Table Card -->
    <x-table-card variant="blue">
        <!-- Filters -->
        <div class="mb-4 flex gap-4">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search..." />
            <flux:select wire:model.live="statusFilter" placeholder="All Status">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </flux:select>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto border rounded-xl bg-white/50 dark:bg-gray-800/50">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <tbody>
                    @forelse($items as $index => $item)
                        <x-item-table-row :item="$item" :index="$index" wire:key="item-row-{{ $item->id }}" />
                    @empty
                        <!-- Empty state -->
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">{{ $items->links() }}</div>
    </x-table-card>

    <!-- 3. Modal Component -->
    <livewire:items.item-modal />
</div>
```

**Key Points**:
- Uses `gap-4` for automatic spacing (no manual spacers)
- Alpine.js for modal opening
- Consistent component structure
- Filters inside table-card

---

### Dashboard Layout

```blade
<div class="flex h-full w-full flex-1 flex-col gap-4">
    <!-- Welcome Section (2 columns) -->
    <div class="grid gap-4 md:grid-cols-2">
        <div class="dashboard-card">Welcome Card</div>
        <div class="dashboard-card">Date/Time Card</div>
    </div>

    <!-- Stats Cards (4 columns) -->
    <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
        <x-stats-card variant="blue" :title="__('Users')" :count="$userCount" />
        <x-stats-card variant="emerald" :title="__('Tasks')" :count="$taskCount" />
        <x-stats-card variant="amber" :title="__('Vehicles')" :count="$vehicleCount" />
        <x-stats-card variant="violet" :title="__('Notices')" :count="$noticeCount" />
    </div>

    <!-- Charts Section (2 columns) -->
    <div class="grid gap-4 md:grid-cols-2">
        <div class="dashboard-card">Task Chart</div>
        <div class="dashboard-card">Members List</div>
    </div>
</div>
```

---

### Kanban Board

Drag-and-drop board with status-based columns.

**Minimum Width**: `min-w-[1280px]` (fixed 4-column layout)

```blade
<div class="flex h-full w-full flex-1 flex-col gap-4 min-w-[1280px]">
    <x-page-header variant="emerald" />

    <x-table-card variant="emerald" class="flex flex-col flex-1 min-h-0 min-w-[1280px]">
        <!-- Filters -->
        <div class="mb-4 flex gap-4">
            <flux:input wire:model.live.debounce.300ms="search" />
            <flux:select wire:model.live="priorityFilter" />
            <flux:input type="date" wire:model.live="fromDate" />
            <flux:input type="date" wire:model.live="toDate" />
        </div>

        <flux:separator class="my-4" />

        <!-- Kanban Board -->
        <div class="flex-1 overflow-x-auto overflow-y-hidden min-h-0"
             wire:key="kanban-{{ $refreshKey }}-{{ md5($priorityFilter . $assignedToFilter) }}">
            <div class="h-full">
                <div class="grid grid-cols-4 gap-0 h-full">
                    <!-- Pending Column -->
                    <div class="flex flex-col border-r pr-3 h-full overflow-hidden"
                         @dragover.prevent="handleDragOver($event, 'pending')"
                         @drop.prevent="handleDrop($event, 'pending')">
                        <!-- Column header (solid color) -->
                        <div class="flex-shrink-0 mb-3 rounded-lg border border-emerald-200 bg-emerald-50 p-3 shadow-md">
                            <h3>Pending ({{ $tasksByStatus['pending']->count() }})</h3>
                        </div>
                        <!-- Task cards (gradient, 50% opacity) -->
                        <div class="flex flex-col gap-2 flex-1 overflow-y-auto">
                            @foreach($tasksByStatus['pending'] as $task)
                                <div draggable="true" @dragstart="handleDragStart($event, {{ $task->id }}, 'pending')">
                                    <x-task-card-kanban :task="$task" status="pending" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Repeat for: Running, Completed, Cancelled -->
                </div>
            </div>
        </div>
    </x-table-card>
</div>
```

**Critical Requirements**:
- Fixed 4-column grid (no responsive)
- Minimum width 1280px
- Column headers: solid colors
- Task cards: gradients with 50% opacity
- Use `refreshKey` pattern for filter updates
- Force refresh after drag-and-drop

---

## Responsive Design

### Breakpoint Strategy

```css
/* Mobile First */
Default: < 640px (mobile)
sm: 640px (small tablets)
md: 768px (tablets)
lg: 1024px (small desktops)
xl: 1280px (desktops)
2xl: 1536px (large screens)
```

### Table Responsiveness

**2XL+ (1536px+)**: Full table view
```blade
<div class="hidden 2xl:block overflow-x-auto border rounded-xl bg-white/50 dark:bg-gray-900/20">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <tbody>
            @forelse($items as $index => $item)
                <x-item-table-row :item="$item" :index="$index" wire:key="item-row-{{ $item->id }}" />
            @empty
            @endforelse
        </tbody>
    </table>
</div>
```

**Below 2XL**: Card grid view
```blade
<div class="2xl:hidden bg-white/50 dark:bg-gray-900/20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @forelse($items as $item)
            <x-item-card :item="$item" wire:key="item-card-{{ $item->id }}" />
        @empty
        @endforelse
    </div>
</div>
```

---

## Dark Mode

### Color Adjustments

```css
/* Backgrounds */
bg-white           -> dark:bg-gray-800
bg-gray-50         -> dark:bg-gray-900
bg-white/60        -> dark:bg-gray-800/60

/* Text */
text-gray-900      -> dark:text-white
text-gray-600      -> dark:text-gray-400
text-gray-500      -> dark:text-gray-400

/* Borders */
border-gray-200    -> dark:border-gray-700
border-{color}-200 -> dark:border-{color}-800

/* Shadows */
shadow-{color}-200/40 -> dark:shadow-{color}-900/30
shadow-{color}-300/50 -> dark:shadow-{color}-800/40
```

### Testing Checklist

- [ ] All text is readable in dark mode
- [ ] Borders are visible in dark mode
- [ ] Shadows work with dark backgrounds
- [ ] Hover states are clear in dark mode
- [ ] Form inputs have proper contrast

---

## Accessibility

### Required Attributes

```blade
<!-- Images -->
<img src="..." alt="Descriptive text" />

<!-- Buttons -->
<button type="button" aria-label="Close" title="Close">
    <svg>...</svg>
</button>

<!-- Form fields -->
<flux:input
    id="email"
    name="email"
    type="email"
    placeholder="Enter email"
    required />

<!-- Links -->
<a href="..." aria-current="page">Current Page</a>
```

### Keyboard Navigation

- All interactive elements must be keyboard accessible
- Focus states must be visible: `focus:ring focus:border-blue-300`
- Tab order should follow visual layout
- Modals should trap focus when open

---

## Performance

### Critical Performance Rules

**IMPORTANT**: Follow these rules to prevent UI flashing and performance issues.

#### 1. Always Use `wire:key` in Livewire Loops

**Required for all @forelse loops** to prevent full DOM re-renders:

```blade
<!-- CORRECT: Table rows -->
@forelse($items as $index => $item)
    <x-item-table-row :item="$item" :index="$index" wire:key="item-row-{{ $item->id }}" />
@empty

<!-- CORRECT: Card grids -->
@forelse($items as $item)
    <x-item-card :item="$item" wire:key="item-card-{{ $item->id }}" />
@empty

<!-- INCORRECT: Missing wire:key causes flashing -->
@forelse($items as $item)
    <x-item-card :item="$item" />
@empty
```

**Why**: Without `wire:key`, Livewire re-renders the entire list on every update (search, filter, pagination), causing visible flashing on tablets/smaller screens.

---

#### 2. Never Use `backdrop-blur-sm` on Dynamic Content

**Avoid backdrop-blur on tables and card grids that update frequently:**

```blade
<!-- CORRECT: No backdrop-blur on dynamic content -->
<div class="overflow-x-auto border rounded-xl bg-white/50 dark:bg-gray-900/20">
    <table>...</table>
</div>

<!-- INCORRECT: backdrop-blur-sm causes expensive repaints -->
<div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-900/20">
    <table>...</table>
</div>
```

**Why**: `backdrop-blur-sm` forces GPU compositing and expensive repaints on every Livewire update. Only use on static elements like modals or headers.

---

#### 3. Use `transition-shadow` Instead of `transition-all`

**Specific transitions are faster than animating everything:**

```blade
<!-- CORRECT: Transition only what changes -->
<button class="transition-shadow duration-200 hover:shadow-lg">

<!-- INCORRECT: Animates everything including layout -->
<button class="transition-all duration-200 hover:shadow-lg">
```

**Why**: `transition-all` tries to animate properties that can't be animated (like gradients), causing janky performance.

---

#### 4. Simplify Hover Effects on Table Rows

**Use solid colors instead of gradients for hover states:**

```blade
<!-- CORRECT: Simple solid hover (recommended) -->
<tr class="group hover:bg-blue-50/30 dark:hover:bg-blue-900/10">

<!-- INCORRECT: Complex gradient hover causes paint issues -->
<tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-teal-50/50">
```

**Why**: Gradient hover effects with transitions cause expensive paint operations, especially on touch devices.

---

#### 5. Never Run Database Queries in Blade Components

**Database queries belong in the Livewire component, not in Blade components:**

```blade
<!-- INCORRECT: Queries inside component (runs N times!) -->
@php
    $relatedCount = \App\Models\Related::where('user_id', $user->id)->count();
@endphp

<!-- CORRECT: Pass data from Livewire component -->
<!-- In UserIndex.php: -->
public function render()
{
    $users = User::with('relatedCounts')->paginate(10);
    return view('livewire.users.index', compact('users'));
}
```

**Why**: Queries in components run on every render for every item (N+1 problem), causing severe performance degradation.

---

#### 6. Use Eager-Loaded Collections, Not Relationship Queries

**When relationships are eager-loaded via `::with()`, access the collection property, not the relationship method:**

```php
// CORRECT: Uses the already eager-loaded collection (no query)
$attachmentCount = $task->attachments->count();

// INCORRECT: Calls the relationship method, runs a NEW database query
$attachmentCount = $task->attachments()->count();
```

**The difference**: `$model->relationship` (no parentheses) accesses the loaded collection. `$model->relationship()` (with parentheses) creates a new query builder, bypassing the eager-loaded data entirely.

**Common mistake in Blade `@php` blocks**:
```blade
<!-- INCORRECT: Runs a query per row even though attachments are eager-loaded -->
@php
    $attachmentCount = $task->attachments()->count();
    $warnings = [];
    if ($attachmentCount > 0) {
        $warnings[] = __(':count attachment(s)', ['count' => $attachmentCount]);
    }
@endphp

<!-- CORRECT: Uses the already-loaded collection -->
@php
    $attachmentCount = $task->attachments->count();
    $warnings = [];
    if ($attachmentCount > 0) {
        $warnings[] = __(':count attachment(s)', ['count' => $attachmentCount]);
    }
@endphp
```

**Why**: If your service uses `Task::with(['attachments'])`, the attachments are already loaded into memory. Using `->attachments()->count()` ignores that and runs a separate `SELECT COUNT(*)` query for every row, causing N+1 performance issues and UI flashing.

---

#### 7. Do Not Put `wire:key` on Wrapper Containers

**Only use `wire:key` on individual loop items, not on their parent wrappers:**

```blade
<!-- INCORRECT: wire:key on wrapper forces full DOM rebuild on filter change -->
<div class="overflow-x-auto border rounded-xl bg-white/50"
     wire:key="table-{{ md5($search . $statusFilter) }}">
    <table>...</table>
</div>

<!-- CORRECT: wire:key only on individual items inside the loop -->
<div class="overflow-x-auto border rounded-xl bg-white/50">
    <table>
        @forelse($items as $item)
            <x-item-row :item="$item" wire:key="item-row-{{ $item->id }}" />
        @endforelse
    </table>
</div>
```

**Why**: Putting `wire:key` with a filter hash on a wrapper div causes Livewire to destroy and recreate the entire container (and all its children) whenever filters change, producing a visible flash. The `wire:key` on individual items is sufficient for Livewire to diff efficiently.

---

### Image Optimization

```blade
<!-- Lazy loading -->
<img src="..." alt="..." loading="lazy" />

<!-- Responsive images -->
<img
    srcset="image-320w.jpg 320w,
            image-640w.jpg 640w,
            image-1280w.jpg 1280w"
    sizes="(max-width: 640px) 100vw, 640px"
    src="image-640w.jpg"
    alt="..." />
```

### Component Loading

```blade
<!-- Defer non-critical components -->
<livewire:charts.task-chart wire:loading.remove />

<!-- Loading placeholder -->
<div wire:loading class="animate-pulse">
    <div class="h-64 bg-gray-200 rounded-xl"></div>
</div>
```

### Performance Checklist

Before deploying any table or list view:

- [ ] All @forelse loops have unique `wire:key` attributes
- [ ] No `backdrop-blur-sm` on table wrappers or card grids
- [ ] Using `transition-shadow` instead of `transition-all`
- [ ] Table row hover uses solid colors (not gradients)
- [ ] No database queries in Blade component `@php` blocks
- [ ] Using `$model->relationship->count()` not `$model->relationship()->count()`
- [ ] No `wire:key` with filter hashes on wrapper containers
- [ ] Tested on tablet screen sizes (768px - 1024px)
- [ ] No flashing during search, filter, or pagination updates

---

## Additional Resources

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Livewire Documentation](https://livewire.laravel.com)
- [Flux UI Components](https://flux.laravel.com)
- [Heroicons](https://heroicons.com)
- [SweetAlert2](https://sweetalert2.github.io)

---

## Changelog

### Version 2.2 (February 4, 2026)
- Added performance rule: use eager-loaded collections (`->relationship->count()`) not relationship queries (`->relationship()->count()`)
- Added performance rule: do not put `wire:key` with filter hashes on wrapper containers
- Updated performance checklist with new rules
- Removed redundant performance warnings from Card Components and Table Components sections (consolidated in Performance section)
- Removed all emojis from documentation

### Version 2.1 (February 3, 2026)
- **CRITICAL**: Added performance rules section to prevent UI flashing
- **Required**: `wire:key` usage on all @forelse loops (tables & cards)
- **Removed**: `backdrop-blur-sm` from dynamic table/card wrappers
- **Updated**: Table row hover from gradients to solid colors
- **Updated**: Transitions from `transition-all` to `transition-shadow`
- **Warning**: No database queries allowed in Blade components
- Added performance checklist for tablet screen testing
- Updated table component patterns with performance guidelines
- Updated card component patterns with performance guidelines
- Enhanced responsive design section with tablet-specific warnings

### Version 2.0 (February 3, 2026)
- Complete documentation refactoring
- Consolidated component patterns
- Removed deprecated patterns
- Improved organization and navigation
- Added comprehensive examples
- Fixed color variant conflicts
- Enhanced responsive design guidelines
- Added accessibility section
- Improved dark mode documentation

### Version 1.0 (November 12, 2025)
- Initial design system documentation
- Component library established
- Color system defined
- Layout patterns documented
