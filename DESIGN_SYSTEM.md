# Design System Documentation
## Laravel Livewire Project - Design Patterns & Guidelines

This document outlines the design patterns, components, and styling guidelines used throughout the application to ensure consistency across all pages.

---

## 🎨 Color Variants

The design system uses 4 primary color variants:

### **Blue** (Users & Authentication)
- Primary: `blue-500` → `cyan-500`
- Light: `blue-50/30` → `cyan-50/30`
- Border: `blue-200`
- Decorative: `blue-400/20` → `cyan-400/20`
- Use for: User management, authentication pages

### **Emerald** (Tasks)
- Primary: `emerald-500` → `teal-500`
- Light: `emerald-50/30` → `teal-50/30`
- Border: `emerald-200`
- Decorative: `emerald-400/20` → `teal-400/20`
- Use for: Task management, assignments

### **Amber** (Vehicles)
- Primary: `amber-500` → `orange-500`
- Light: `amber-50/30` → `orange-50/30`
- Border: `amber-200`
- Decorative: `amber-400/20` → `orange-400/20`
- Use for: Vehicle inventory, tracking

### **Violet** (General & API)
- Primary: `violet-500` → `purple-500`
- Light: `violet-50/30` → `purple-50/30`
- Border: `violet-200`
- Decorative: `violet-400/20` → `purple-400/20`
- Use for: Data tables, analytics, API documentation

**Base URL Badge (API Docs Header):**
```blade
<div class="flex items-center gap-2 rounded-lg bg-gray-900/80 px-3 py-2 backdrop-blur-sm border border-white/30 shadow-lg">
    <span class="text-sm font-semibold text-white">Base URL:</span>
    <code class="rounded-md bg-gray-800 px-3 py-1.5 text-sm font-mono font-bold text-emerald-300 shadow-sm border border-emerald-500/30">{{ config('app.url') }}/api/v1</code>
</div>
```

---

## 📦 Reusable Components

### 1. **Page Header Component** (`<x-page-header>`)

**Purpose**: Consistent page header with icon, title, description, and actions

**Usage**:
```blade
<x-page-header 
    :title="__('Page Title')" 
    :description="__('Page description text')"
    variant="blue|emerald|violet|amber">
    <x-slot:icon>
        <svg class="h-7 w-7 text-white">...</svg>
    </x-slot:icon>
    <x-slot:actions>
        <flux:button>Action Button</flux:button>
    </x-slot:actions>
</x-page-header>
```

**Features**:
- Gradient background with decorative blur circles
- Rounded 2xl corners
- Icon badge with gradient (14x14)
- Title (text-2xl font-bold)
- Description (text-sm)
- Optional actions slot
- Hover shadow effect (hover:shadow-2xl)

---

### 2. **Table Card Component** (`<x-table-card>`)

**Purpose**: Beautiful card wrapper for tables with gradient background

**Usage**:
```blade
<x-table-card variant="emerald">
    <!-- Search & Filters -->
    <div class="mb-4 flex gap-4">
        <flux:input wire:model.live.debounce.300ms="search" />
        <flux:select wire:model.live="filter" />
    </div>

    <!-- Table -->
    <div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
        <table>...</table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $items->links() }}
    </div>
</x-table-card>
```

**Features**:
- Same gradient style as dashboard charts
- Decorative blur circles
- Rounded 2xl corners
- Responsive padding
- Dark mode support
- Border on table container

---

### 3. **Stats Card Component** (`<x-stats-card>`)

**Purpose**: Display statistics with gradient background and icon

**Usage**:
```blade
<x-stats-card 
    :title="__('Total Items')" 
    :count="$totalCount" 
    :description="__('Description text')"
    topCircleColor="bg-blue-300"
    bottomCircleColor="bg-blue-400">
    <x-slot:icon>
        <svg class="h-8 w-8 text-white">...</svg>
    </x-slot:icon>
</x-stats-card>
```

**Features**:
- Neutral background (bg-zink-200 dark:bg-zinc-900)
- Colored decorative circles (top-right and bottom-right)
- Text uses `text-accent` class
- Rounded 2xl corners
- Icon container with backdrop blur
- Hover scale effect

**Color Combinations**:
- Users: `bg-blue-300` / `bg-blue-400`
- Tasks: `bg-emerald-300` / `bg-emerald-400`
- Vehicles: `bg-amber-300` / `bg-amber-400`
- Notifications: `bg-red-300` / `bg-red-400`

---

### 4. **Table Row Components** (Model-specific)

**Purpose**: Consistent table row styling for each model

**Examples**: `<x-user-table-row>`, `<x-task-table-row>`, `<x-vehicle-table-row>`

**Pattern to Follow**:
```blade
<tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-teal-50/50 dark:hover:from-blue-900/10 dark:hover:to-teal-900/10">
    <td class="whitespace-nowrap px-6 py-5">
        <!-- Avatar/Image Column -->
        <div class="flex items-center">
            <div class="relative size-12 flex-shrink-0">
                @if($item->image)
                    <img src="{{ $item->image_url }}" class="size-12 rounded-xl object-cover ring-2 ring-blue-200">
                @else
                    <div class="flex size-12 items-center justify-center rounded-xl bg-blue-400/20 shadow-lg ring-2 ring-blue-300">
                        <span class="text-base font-bold text-blue-900">{{ $item->initials() }}</span>
                    </div>
                @endif
                <!-- Optional status indicator -->
                <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white bg-green-500"></div>
            </div>
            <div class="ml-4">
                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->name }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->meta }}</div>
            </div>
        </div>
    </td>
    
    <!-- Icon + Text Column -->
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex items-center gap-2">
            <svg class="h-4 w-4 text-gray-400">...</svg>
            <span class="text-sm text-gray-900 dark:text-white">{{ $item->field }}</span>
        </div>
    </td>
    
    <!-- Badge column -->
    <td class="whitespace-nowrap px-6 py-5">
        <flux:badge :color="$color" size="sm" class="font-semibold">
            {{ ucfirst($item->status) }}
        </flux:badge>
    </td>
    
    <!-- Date column -->
    <td class="whitespace-nowrap px-6 py-5">
        <span class="text-sm text-gray-900 dark:text-gray-500">{{ $item->created_at->format('Y-m-d') }}</span>
    </td>
    
    <!-- Actions column (hover-revealed) -->
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex items-center gap-2">
            <flux:button size="sm" variant="ghost" @click="openModal({{ $item->id }})" icon="pencil" 
                class="opacity-50 transition-opacity group-hover:opacity-100">
                {{ __('Edit') }}
            </flux:button>
        </div>
    </td>
</tr>
```

**Key Features**:
- Gradient hover effect matching variant color
- Avatar with initials fallback
- Status indicator badge
- Icons with text
- Hover-revealed edit buttons (opacity-50 to opacity-100)

---

### 5. **Modal Component Pattern** (Livewire)

**Purpose**: Full-height right-side slide-in modal for CRUD operations

**Structure**:
```blade
<div>
    <!-- Backdrop -->
    <div x-data="{ open: @entangle('open') }"
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-hidden"
         style="display: none;">

        <!-- Background overlay -->
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div x-show="open"
                 x-transition:enter="transform transition ease-in-out duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-xl bg-white/90">

                <div class="flex h-full flex-col overflow-y-auto border-l border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 shadow-2xl dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20">
                    <!-- Decorative Elements -->
                    <div class="pointer-events-none absolute -right-8 -top-8 h-64 w-64 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-400/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-8 -left-8 h-64 w-64 rounded-full bg-gradient-to-br from-teal-400/20 to-emerald-400/20 blur-3xl"></div>

                    <!-- Header -->
                    <div class="relative border-b border-gray-200/50 bg-white/50 px-6 py-6 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                                    <svg class="h-6 w-6 text-white">...</svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Modal Title</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Modal description</p>
                                </div>
                            </div>
                            <button wire:click="closeModal" type="button" class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600">
                                <svg class="h-6 w-6">...</svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form wire:submit="save" class="relative flex-1 overflow-y-auto">
                        <div class="space-y-6 p-6">
                            <!-- Form fields -->
                        </div>

                        <!-- Footer Actions -->
                        <div class="border-t border-gray-200/50 px-6 py-4 backdrop-blur-sm dark:border-gray-700/50">
                            <div class="flex items-center justify-end gap-3">
                                <flux:button type="button" wire:click="closeModal" variant="ghost">Cancel</flux:button>
                                <flux:button type="submit" variant="primary" icon="check">Save</flux:button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
```

**Features**:
- Full-height right-side panel (max-w-xl)
- Smooth slide-in/out animations (500ms)
- Click outside does NOT close modal
- Gradient background matching variant
- Decorative blur circles
- Icon badge header
- Footer with cancel and save buttons
- Dark mode support

**Opening Modal** (from parent component):
```blade
<div x-data="{
    openModal(itemId = null) {
        $wire.$dispatch('open-item-modal', { itemId: itemId })
    }
}">
    <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
        Add New Item
    </flux:button>
</div>
```

---

### 6. **Toast Notification Component** (`<x-toast-notification>`)

**Purpose**: Display success/error/info/warning messages

**Features**:
- Auto-dismisses after 3 seconds
- Manual close button
- Color-coded by type (success, error, info, warning)
- Positioned at bottom-right
- Slide-in animation

**Usage**:
```php
// In Livewire component
$this->dispatch('notify', message: 'Operation successful!', type: 'success');
```

**Include in Layout**:
```blade
<!-- Add before @fluxScripts -->
<x-toast-notification />
```

---

## 📐 Layout Structure

### **Standard Page Layout**

**CRITICAL SPACING RULE**: The container uses `gap-4` which automatically provides consistent 1.5rem (24px) spacing between all direct children. **NEVER** add extra empty lines or manual spacing (like `<div class="h-6"></div>`) between sections - the gap utility handles this automatically.

```blade
<div class="flex h-full w-full flex-1 flex-col gap-4 p-6" x-data="{
    openModal(itemId = null) {
        $wire.$dispatch('open-item-modal', { itemId: itemId })
    }
}">
    <!-- 1. Page Header -->
    <x-page-header variant="blue">
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                Add New Item
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- 2. Table Card -->
    <x-table-card variant="blue">
        <!-- Filters -->
        <div class="mb-4 flex gap-4">
            <div class="flex-1">
                <flux:input wire:model.live.debounce.300ms="search" />
            </div>
            <flux:select wire:model.live="filter" />
        </div>

        <!-- Table -->
        <div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            Column
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($items as $item)
                        <x-item-table-row :item="$item" />
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

### **Dashboard Layout**

```blade
<div class="flex h-full w-full flex-1 flex-col gap-4">
    <!-- 1. Welcome Header (Grid layout) -->
    <div class="grid gap-4 md:grid-cols-2">
        <!-- Welcome Card with Glassmorphism -->
        <!-- Date/Time Card -->
    </div>

    <!-- 2. Stats Cards -->
    <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
        <x-stats-card />
    </div>

    <!-- 3. Charts Section -->
    <div class="grid gap-4 md:grid-cols-2">
        <!-- Chart Cards -->
    </div>
</div>
```

### **API Documentation Layout**

```blade
<div class="flex h-full w-full flex-1 flex-col gap-4">
    <!-- Header with Base URL display -->
    <x-page-header variant="violet">
        <x-slot:actions>
            <div class="flex items-center gap-2 rounded-lg bg-gray-900/80 px-3 py-2 backdrop-blur-sm border border-white/30 shadow-lg">
                <span class="text-sm font-semibold text-white">Base URL:</span>
                <code class="rounded-md bg-gray-800 px-3 py-1.5 text-sm font-mono font-bold text-emerald-300 shadow-sm border border-emerald-500/30">{{ config('app.url') }}/api/v1</code>
            </div>
        </x-slot:actions>
    </x-page-header>

    <!-- Documentation Sections -->
    <x-table-card variant="violet">
        <!-- Section content -->
    </x-table-card>
</div>
```

---

## 🎨 API Documentation Patterns

### **Endpoint Card**

```blade
<div class="space-y-3 rounded-xl border border-blue-200 bg-white/50 p-6 dark:border-blue-900/50 dark:bg-gray-800/50">
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Endpoint Name</h4>
        <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>
    </div>
    <code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/endpoint/path</code>
    
    <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Request Body:</p>
        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "key": "value"
}</code></pre>
    </div>
</div>
```

### **HTTP Method Badges**

```blade
<!-- GET -->
<span class="rounded-lg bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">GET</span>

<!-- POST -->
<span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-400">POST</span>

<!-- PUT -->
<span class="rounded-lg bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">PUT</span>

<!-- DELETE -->
<span class="rounded-lg bg-red-100 px-3 py-1 text-xs font-bold text-red-800 dark:bg-red-900/30 dark:text-red-400">DELETE</span>
```

### **Code Blocks**

```blade
<!-- Inline Code -->
<code class="rounded bg-white/50 px-1 dark:bg-gray-800">inline code</code>

<!-- Block Code (URL/Endpoint) -->
<code class="block rounded-lg bg-gray-900 px-4 py-2 text-sm text-emerald-400 dark:bg-gray-950">/api/endpoint</code>

<!-- Block Code (JSON) -->
<pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"><code>{
    "key": "value",
    "nested": {
        "data": true
    }
}</code></pre>
```

### **Error Response Cards**

```blade
<div class="grid gap-4 md:grid-cols-2">
    <!-- 401 Unauthorized -->
    <div class="space-y-2 rounded-xl border border-red-200 bg-red-50/50 p-4 dark:border-red-900/50 dark:bg-red-900/10">
        <div class="flex items-center justify-between">
            <h4 class="font-semibold text-red-900 dark:text-red-400">Unauthenticated</h4>
            <span class="rounded bg-red-200 px-2 py-1 text-xs font-bold text-red-900 dark:bg-red-900/50 dark:text-red-400">401</span>
        </div>
        <pre class="overflow-x-auto rounded-lg bg-gray-900 p-3 text-xs text-gray-100"><code>{ "success": false, "message": "Unauthenticated." }</code></pre>
    </div>
    
    <!-- Add more error codes: 403, 404, 422 -->
</div>
```

### **Step-by-Step Guide Cards**

```blade
<div class="grid gap-4 md:grid-cols-3">
    <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 p-6 dark:from-emerald-900/20 dark:to-teal-900/20">
        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-500 text-white">
            <span class="text-xl font-bold">1</span>
        </div>
        <h4 class="mb-2 font-bold text-gray-900 dark:text-white">Step Title</h4>
        <p class="text-sm text-gray-700 dark:text-gray-300">Step description</p>
    </div>
</div>
```

---

## 🎯 Typography

### **Headings**
- Page Title: `text-2xl font-bold text-gray-900 dark:text-white`
- Section Title: `text-xl font-bold text-gray-900 dark:text-white`
- Card Title: `text-lg font-semibold text-gray-900 dark:text-white`
- Stat Title: `text-sm font-medium text-accent`
- Stat Count: `text-4xl font-bold text-accent`

### **Body Text**
- Primary: `text-sm text-gray-900 dark:text-white`
- Secondary: `text-sm text-gray-600 dark:text-gray-400`
- Muted: `text-xs text-gray-500 dark:text-gray-400`

### **Labels**
- Table Header: `text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300`
- Form Label: `text-sm font-medium text-gray-700 dark:text-gray-300`

### **Code Text**
- Inline: `text-xs font-mono`
- Block URL: `text-sm text-emerald-400`
- Block JSON: `text-xs text-gray-100`

---

## 🎨 Tables

### **Table Container**
```blade
<div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <!-- Content -->
    </table>
</div>
```

### **Table Header**
```blade
<thead>
    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
            Column Name
        </th>
    </tr>
</thead>
```

### **Table Body**
```blade
<tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
    <!-- Use component for each row -->
    <x-item-table-row :item="$item" />
</tbody>
```

### **Empty State**
```blade
<tr>
    <td colspan="9" class="px-6 py-12 text-center">
        <div class="flex flex-col items-center gap-3">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                <svg class="h-8 w-8 text-gray-400">...</svg>
            </div>
            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No items found') }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
        </div>
    </td>
</tr>
```

---

## 🎭 Icons

### **Icon Sources**
- **Heroicons**: Primary icon set (https://heroicons.com/)
- Always use `stroke` variants (outline style)
- Standard sizes: `h-4 w-4`, `h-5 w-5`, `h-6 w-6`, `h-7 w-7`, `h-8 w-8`, `h-12 w-12`

### **Icon Colors**
- Primary actions: `text-white`
- Secondary/Muted: `text-gray-400`
- In colored contexts: `text-{color}-600 dark:text-{color}-400`

### **Common Icon Paths**
```blade
<!-- Users -->
<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />

<!-- Tasks -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />

<!-- API/Code -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

<!-- Email -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

<!-- Phone -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />

<!-- Calendar -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

<!-- Lock/Security -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
```

---

## 🌈 Decorative Elements

### **Blur Circles** (Background decoration)
```blade
<!-- Large (cards/modals) -->
<div class="pointer-events-none absolute -right-8 -top-8 h-64 w-64 rounded-full bg-gradient-to-br from-{color}-400/20 to-{color2}-400/20 blur-3xl"></div>
<div class="pointer-events-none absolute -bottom-8 -left-8 h-64 w-64 rounded-full bg-gradient-to-br from-{color2}-400/20 to-{color}-400/20 blur-3xl"></div>

<!-- Small (stats cards) -->
<div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-blue-300 dark:bg-white/10 backdrop-blur-sm"></div>
<div class="absolute -bottom-4 -right-4 h-32 w-32 rounded-full bg-blue-400 dark:bg-white/5"></div>
```

### **Status Indicators**
```blade
<!-- Simple Online Badge -->
<div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white bg-green-500 dark:border-gray-900"></div>

<!-- With Animation -->
<div class="relative">
    <div class="h-4 w-4 animate-pulse rounded-full bg-green-500 shadow-lg shadow-green-500/50"></div>
    <div class="absolute inset-0 h-4 w-4 animate-ping rounded-full bg-green-400 opacity-75"></div>
</div>
```

### **Particle Background System** (Canvas-based animated background)
Modern animated particle background with connecting lines, perfect for documentation and special pages.

**Canvas Setup** (in layout):
```blade
<!-- Add to layout body (before main content) -->
<canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none" style="display: none;"></canvas>
```

**Particle Script** (in page):
```blade
@push('scripts')
    <script>
        (function() {
            const canvas = document.getElementById('particle-canvas');
            if (!canvas) return;
            
            // Show canvas for this page
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
```

**Key Features**:
- **Multi-color palette**: Uses 8 colors from design system (violet, blue, emerald, amber, purple, cyan, teal, orange)
- **Dark mode support**: Automatically switches color palette based on `dark` class
- **Dynamic particle count**: Calculated based on screen size (`width * height / 15000`)
- **Connection lines**: Particles within 120px distance are connected with gradient lines
- **Connection opacity**: Uses `0.3 * (1 - distance / 120)` for visible but subtle connections
- **Smooth animation**: Uses `requestAnimationFrame` for 60fps animation
- **Responsive**: Automatically resizes on window resize
- **Performance**: Cleans up animation on page unload

**Usage**:
- Add canvas to layout (hidden by default)
- Add particle script to specific pages that need it
- Show canvas with `canvas.style.display = 'block'` in script
- Perfect for documentation pages, landing pages, or special feature pages

**Customization Options**:
- **Particle count**: Adjust `/15000` divisor (lower = more particles)
- **Connection distance**: Change `120` in `if (distance < 120)`
- **Connection opacity**: Adjust `0.3` multiplier (higher = darker lines)
- **Particle size**: Adjust `Math.random() * 2 + 0.5` range
- **Particle speed**: Adjust `(Math.random() - 0.5) * 0.5` multiplier

**Current Usage**:
- Admin Manual page (`resources/views/admin-manual.blade.php`)
- API Documentation page (`resources/views/api-documentation.blade.php`)

---

## 🎬 Animations & Transitions

### **Hover Effects**
```blade
<!-- Cards -->
class="transition-all duration-300 hover:shadow-2xl"

<!-- Table Rows -->
class="transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-cyan-50/50"

<!-- Buttons -->
class="transition-opacity hover:opacity-100"
class="transition-all hover:scale-105"
```

### **Modal Transitions**
```blade
<!-- Backdrop -->
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"

<!-- Slide-in Panel -->
x-transition:enter="transform transition ease-in-out duration-500"
x-transition:enter-start="translate-x-full"
x-transition:enter-end="translate-x-0"
x-transition:leave="transform transition ease-in-out duration-500"
x-transition:leave-start="translate-x-0"
x-transition:leave-end="translate-x-full"
```

### **Loading States**
```blade
<div class="animate-pulse rounded-2xl bg-gray-200 dark:bg-gray-800">
    <!-- Content -->
</div>
```

### **Interactive Elements**
```blade
<div class="group">
    <button class="opacity-50 transition-opacity group-hover:opacity-100">
        Action
    </button>
</div>
```

---

## 🔘 Buttons & Actions

### **Primary Action** (Outline variant)
```blade
<flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
    {{ __('Add New Item') }}
</flux:button>
```

### **Secondary Action**
```blade
<flux:button size="sm" variant="ghost" icon="pencil" @click="openModal({{ $item->id }})">
    {{ __('Edit') }}
</flux:button>
```

### **Hover-Revealed Actions** (in table rows)
```blade
<flux:button 
    size="sm" 
    variant="ghost" 
    icon="pencil" 
    @click="openModal({{ $item->id }})" 
    class="opacity-50 transition-opacity group-hover:opacity-100">
    {{ __('Edit') }}
</flux:button>
```

### **Modal Actions**
```blade
<div class="flex items-center justify-end gap-3">
    <flux:button type="button" wire:click="closeModal" variant="ghost">
        {{ __('Cancel') }}
    </flux:button>
    <flux:button type="submit" variant="primary" icon="check">
        {{ __('Save') }}
    </flux:button>
</div>
```

---

## 📊 Charts (Using Chart.js)

### **Chart Container**
```blade
<div class="relative flex items-center justify-center rounded-xl bg-white/50 p-6 backdrop-blur-sm dark:bg-gray-800/50">
    <canvas id="chartId" class="max-h-64"></canvas>
</div>
```

### **Chart Colors**
```javascript
{
    pending: 'rgba(245, 158, 11, 0.8)',    // Amber
    running: 'rgba(59, 130, 246, 0.8)',     // Blue
    completed: 'rgba(16, 185, 129, 0.8)',   // Emerald
    cancelled: 'rgba(239, 68, 68, 0.8)',    // Red
    available: 'rgba(16, 185, 129, 0.8)',   // Emerald
    in_use: 'rgba(59, 130, 246, 0.8)',      // Blue
    maintenance: 'rgba(245, 158, 11, 0.8)', // Amber
}
```

### **Chart Initialization Pattern**
```javascript
function initializeCharts() {
    // Destroy existing charts
    if (window.taskChart && typeof window.taskChart.destroy === 'function') {
        window.taskChart.destroy();
    }
    
    // Create new chart
    const ctx = document.getElementById('taskChart');
    if (!ctx) return;
    
    window.taskChart = new Chart(ctx, {
        type: 'doughnut',
        data: { ... },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
                        padding: 15,
                        font: { size: 12 }
                    }
                }
            }
        }
    });
}

// Initialize on load and navigation
document.addEventListener('DOMContentLoaded', initializeCharts);
document.addEventListener('livewire:navigated', initializeCharts);
```

### **Chart Card with Embedded Table** (Dashboard Pattern)
For dashboard charts that need to display related data below the chart, embed a table directly inside the chart card. This pattern uses the empty space at the bottom of the chart canvas efficiently.

**Structure**:
```blade
<div class="group relative overflow-hidden rounded-2xl border border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 p-6 shadow-xl transition-all duration-300 hover:shadow-2xl dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20">
    <!-- Decorative Elements -->
    <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-400/20 blur-2xl"></div>
    <div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-teal-400/20 to-emerald-400/20 blur-2xl"></div>

    <div class="relative">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <div class="h-1 w-8 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Chart Title') }}</h3>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Chart description') }}
                </p>
            </div>
            <div class="animate-pulse rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 p-4 shadow-lg shadow-emerald-500/50">
                <svg class="h-6 w-6 text-white">...</svg>
            </div>
        </div>

        <!-- Chart and Status List: Vertical on md/small, Horizontal on lg+ -->
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start">
            <!-- Chart Canvas -->
            <div class="relative flex flex-1 items-center justify-center rounded-xl bg-white/50 p-6 backdrop-blur-sm dark:bg-gray-800/50">
                <canvas id="chartId" class="max-h-64"></canvas>
            </div>

            <!-- Status List -->
            <div class="flex-1 space-y-3">
                <!-- Status items -->
            </div>
        </div>

        <!-- Embedded Table Section -->
        @if($items->count() > 0)
            <div class="mt-6">
                <h4 class="mb-4 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Section Title') }}</h4>
                <div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                                <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                    {{ __('Column') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                            @foreach($items as $item)
                                <tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 dark:hover:from-emerald-900/10 dark:hover:to-teal-900/10">
                                    <td class="px-4 py-3">
                                        <!-- Table row content -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
```

**Key Features**:
- Chart card uses variant-specific gradient (emerald for tasks, violet for vehicles, etc.)
- Chart and status list are responsive: vertical on md/small, horizontal on lg+
- Embedded table appears below chart/status section using `mt-6` spacing
- Table uses compact padding (`px-4 py-3` instead of `px-6 py-5`) for dashboard context
- Table container has border and frosted glass effect (`bg-white/50 backdrop-blur-sm`)
- Hover effects on table rows match the chart card's variant color
- Only displays if items exist (`@if($items->count() > 0)`)

**Use Cases**:
- Dashboard charts showing summary data with related items
- Task status chart with upcoming tasks table
- Vehicle status chart with recent vehicles
- Any chart that needs to display related data in a compact format

---

## 🌓 Dark Mode

### **Always Include Dark Mode Variants**
```blade
bg-white dark:bg-gray-900
text-gray-900 dark:text-white
border-gray-200 dark:border-gray-700
text-gray-600 dark:text-gray-400
```

### **Gradient Backgrounds in Dark Mode**
```blade
class="bg-gradient-to-br from-white via-blue-50/30 to-cyan-50/30 
       dark:from-gray-900 dark:via-blue-900/20 dark:to-cyan-900/20"
```

### **Code Blocks in Dark Mode**
```blade
class="rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-gray-950"
```

---

## 📏 Spacing & Sizing

### **Padding**
- Page Container: `p-6` (standard) or `p-4` (compact like dashboard)
- Card: `p-6` or `p-8` (large cards)
- Table Cell: `px-6 py-5` (rows) or `px-6 py-4` (headers)
- Modal Content: `p-6`
- Modal Header/Footer: `px-6 py-4` or `px-6 py-6`

### **Gaps**
- Vertical Sections: `gap-4` (NEVER add manual spacing between cards - the container's gap-4 handles this automatically)
- Horizontal Items: `gap-4` or `gap-3` or `gap-2`
- Grid: `gap-4` or `gap-4`
- Authentication Forms: `gap-4` (for both main container and form elements)

### **Authentication Form Spacing**
Authentication pages (login, register, password reset) use consistent `gap-4` spacing:
- Main container: `<div class="flex flex-col gap-4">`
- Form elements: `<form class="flex flex-col gap-4">`
- This provides consistent 1.5rem (24px) spacing between all form fields and sections

**Example**:
```blade
<x-layouts.auth>
    <div class="flex flex-col gap-4">
        <x-auth-header />
        <form class="flex flex-col gap-4">
            <!-- Form fields with automatic gap-4 spacing -->
        </form>
    </div>
</x-layouts.auth>
```

### **Critical Spacing Rule**
**NEVER** add extra empty lines, divs, or manual margins between direct children of a `flex flex-col gap-4` container. The `gap-4` utility automatically provides consistent 1.5rem (24px) spacing. Adding manual spacing breaks the design system consistency.

### **Rounded Corners**
- Cards/Containers: `rounded-2xl`
- Tables/Modals: `rounded-xl`
- Avatars: `rounded-xl` or `rounded-full`
- Badges/Pills: `rounded-lg`
- Code inline: `rounded`
- Buttons: Use Flux defaults

### **Shadows**
- Default: `shadow-xl`
- Hover: `hover:shadow-2xl`
- Icon Badge: `shadow-lg`
- Small elements: `shadow-sm`
- Modals: `shadow-2xl`

### **Max Widths**
- Modal: `max-w-xl` (small forms) or `max-w-2xl` (large forms)
- Documentation content: `max-w-none` (with prose class)

---

## 🎯 Badge Colors

### **Role/Status Badges**
```blade
<flux:badge :color="match($status) {
    'admin', 'urgent', 'critical' => 'red',
    'manager', 'high', 'running' => 'blue',
    'employee', 'completed', 'available' => 'green',
    'medium', 'pending' => 'amber',
    'low', 'cancelled' => 'gray',
    default => 'gray',
}" size="sm" class="font-semibold">
    {{ ucfirst($status) }}
</flux:badge>
```

---

## ✅ Checklist for New Pages

When creating a new page, ensure:

- [ ] Use `<x-page-header>` with appropriate variant
- [ ] Choose consistent color variant (blue/emerald/violet/amber)
- [ ] Wrap tables in `<x-table-card>` component
- [ ] Create model-specific table row component
- [ ] Create modal component for CRUD operations
- [ ] Include Alpine.js `openModal()` function in page container
- [ ] Include search and filters in table card
- [ ] Add `border` class to table container
- [ ] Use frosted glass effect (`bg-white/50 backdrop-blur-sm`)
- [ ] Add gradient hover effects to table rows
- [ ] Include icons with data where appropriate
- [ ] Add empty state with icon and helpful text
- [ ] Include pagination at bottom
- [ ] Ensure all elements have dark mode variants
- [ ] Use heroicons for all icons
- [ ] Add decorative blur circles to cards and modals
- [ ] Test responsive design (md:, lg:, xl: breakpoints)
- [ ] Use `@click="openModal()"` instead of `wire:navigate` for modals
- [ ] Add `cursor-pointer` class to buttons that open modals
- [ ] Use `opacity-50` for edit buttons (becomes `opacity-100` on hover)
- [ ] Add `livewire:item-modal` component at end of page
- [ ] Test modal open/close functionality
- [ ] Add loading states where appropriate
- [ ] Include toast notifications for success/error messages

---

## 🎨 Color Mapping by Page/Feature

| Feature | Variant | Example Usage |
|---------|---------|---------------|
| Users | Blue | User management, profiles, authentication |
| Tasks | Emerald | Task management, assignments |
| Vehicles | Amber | Vehicle inventory, tracking |
| API Docs | Violet | Documentation, general data |
| Dashboard | Mixed | Use all variants as needed |
| Settings | Gray | Configuration pages |

---

## 📝 Notes

- Always use translation helpers `__()` for all user-facing text
- Use Livewire's `wire:navigate` for page navigation
- Use Alpine.js `@click="openModal()"` for modal triggers
- Debounce search inputs: `wire:model.live.debounce.300ms="search"`
- Use Flux UI components where available (buttons, inputs, badges, selects)
- Keep decorative elements consistent (blur circles, gradients)
- Test in both light and dark mode
- Ensure responsive design at all breakpoints
- Use semantic HTML
- Include proper accessibility attributes
- Always dispatch events for notifications: `$this->dispatch('notify', ...)`
- Use `@entangle` for Alpine.js ↔ Livewire state sync in modals
- Add `z-50` to modals to ensure they appear above other content
- Use `pointer-events-none` on decorative elements
- Test modal animations on slow connections

---

## 🚀 Recent Updates

### Particle Background System
- Added canvas-based animated particle background system
- Multi-color palette with automatic dark mode adaptation
- Gradient connection lines between particles (opacity: 0.3)
- Responsive particle count based on screen size
- Used in Admin Manual and API Documentation pages
- Performance optimized with cleanup on page unload

### Authentication Form Spacing
- Standardized authentication forms to use `gap-4` for consistent spacing
- Both main container and form elements use `gap-4` (1.5rem / 24px)
- Provides uniform spacing between form fields, headers, and sections
- Applied to login, register, and password reset pages

### Modal System
- Full-height right-side slide-in modals
- Smooth 500ms animations
- Gradient backgrounds matching page variants
- Click outside does NOT close modal
- Event-driven architecture (`open-{model}-modal`)

### API Documentation
- Professional code block styling
- HTTP method badges (GET, POST, PUT, DELETE)
- Error response cards with status codes
- Step-by-step guide cards
- Inline code snippets with proper backgrounds

### Toast Notifications
- Auto-dismiss after 3 seconds
- Color-coded by type
- Positioned bottom-right
- Manual close button

### Table Improvements
- Border on table containers
- Opacity-based edit button visibility (50% → 100%)
- Added Created At and Updated At columns
- Improved date formatting

### File Attachments
- Multiple file upload support
- 10MB max per file
- Preview for new uploads before saving
- Display existing attachments with download/delete actions
- Permission-based deletion (only uploader or admin/manager)
- Emerald-themed UI matching parent component

### Dashboard Chart Cards with Embedded Tables
- Chart cards can now include embedded tables below the chart/status section
- Responsive layout: chart and status list horizontal on lg+, vertical on md/small
- Tables use compact padding (`px-4 py-3`) for dashboard context
- Efficient use of empty space at bottom of chart canvas
- Hover effects on table rows match chart card variant colors
- Example: Task Status chart with upcoming tasks table

### Role Counts Section
- Role counts displayed above Members table in dashboard
- Grid layout: 2 columns on small screens, 4 columns on md+ screens
- Color-coded cards: Admin (red), Manager (blue), Employee (emerald), Client (gray)
- Each card shows role name, count, and icon with hover effects

### Upcoming Tasks Query Pattern
- Dashboard upcoming tasks show only future tasks (work_date >= today)
- Sorted by work_date (ASC) then work_time (ASC)
- Displays "Work Date & Time" instead of "Due Date"
- Date and time shown with icons in vertical stack layout

### Role Counts Section (Dashboard Pattern)
For dashboard cards displaying user/member data, show role counts above the main table. This provides a quick overview of team composition.

**Structure**:
```blade
<!-- Role Counts Section -->
<div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
    <!-- Admin Count -->
    <div class="group relative overflow-hidden rounded-xl border border-red-200 bg-gradient-to-br from-red-50 to-red-100/50 p-4 shadow-sm transition-all duration-200 hover:scale-105 hover:shadow-md dark:border-red-800/50 dark:from-red-900/20 dark:to-red-800/10">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-red-700 dark:text-red-400">{{ __('Admin') }}</p>
                <p class="mt-1 text-2xl font-bold text-red-900 dark:text-red-200">{{ $adminCount }}</p>
            </div>
            <div class="rounded-lg bg-red-200/50 p-2 dark:bg-red-900/30">
                <svg class="h-5 w-5 text-red-600 dark:text-red-400">...</svg>
            </div>
        </div>
    </div>
    <!-- Repeat for Manager, Employee, Client with appropriate colors -->
</div>
```

**Key Features**:
- Grid layout: 2 columns on small screens, 4 columns on md+ screens
- Color-coded by role: Admin (red), Manager (blue), Employee (emerald), Client (gray)
- Each card shows role name, count, and icon
- Hover effects: scale and shadow on hover
- Dark mode support
- Positioned above the main data table

**Use Cases**:
- Members card showing team composition
- User management pages
- Any dashboard section displaying role-based statistics

### Upcoming Tasks Query Pattern
For displaying upcoming tasks in dashboard tables, use this query pattern to show only future tasks sorted by work date and time.

**Query Pattern**:
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

**Key Features**:
- Filters out completed and cancelled tasks
- Only shows tasks with `work_date` set
- Only shows tasks with `work_date >= today` (future dates only)
- Sorted by `work_date` (ASC) then `work_time` (ASC)
- Eager loads relationships to prevent N+1 queries
- Limits results (typically 3-5 for dashboard display)

**Display Pattern**:
```blade
<td class="whitespace-nowrap px-4 py-3">
    @if($task->work_date)
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm text-gray-900 dark:text-white">{{ $task->work_date->format('M d, Y') }}</span>
            </div>
            @if($task->work_time)
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($task->work_time)->format('h:i A') }}</span>
                </div>
            @endif
        </div>
    @else
        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
    @endif
</td>
```

**Display Features**:
- Shows "Work Date & Time" instead of "Due Date"
- Date displayed with calendar icon on first line
- Time displayed with clock icon on second line (if available)
- Time formatted as "h:i A" (e.g., "02:30 PM")
- Vertical flex layout for date and time stacking

---

### Particle Background System
- Canvas-based animated particle background with connecting lines
- Multi-color palette (8 colors) with dark mode support
- Dynamic particle count based on screen size
- Gradient connection lines between nearby particles
- Used in Admin Manual and API Documentation pages

**Version**: 2.4  
**Last Updated**: November 12, 2025  
**Project**: Laravel Livewire Dashboard - Senda Snap

---

## 📚 Quick Reference

### Component Variants
- `<x-page-header>`: blue, emerald, violet, amber
- `<x-table-card>`: blue, emerald, violet, amber
- `<x-stats-card>`: Custom circle colors

### Common Classes
```
Container: flex h-full w-full flex-1 flex-col gap-4 p-6
Header: text-2xl font-bold text-gray-900 dark:text-white
Secondary: text-sm text-gray-600 dark:text-gray-400
Card: rounded-2xl shadow-xl transition-all hover:shadow-2xl
Table: overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm
```

### Event Names
```php
// Modals
$this->dispatch('open-user-modal', userId: $id);
$this->dispatch('open-task-modal', taskId: $id);
$this->dispatch('open-vehicle-modal', vehicleId: $id);

// Notifications
$this->dispatch('notify', message: 'Success!', type: 'success');

// List Refresh
$this->dispatch('user-saved');
$this->dispatch('task-saved');
$this->dispatch('vehicle-saved');
```

---

## 🧩 Livewire Tables & Filters Pattern (Authoritative)

Use this pattern for any new data table to ensure correct filtering, rendering, and UX.

### Livewire Component (Controller logic)

```php
declare(strict_types=1);

use App\Services\SomeService;
use Illuminate\View\View;
use Livewire\Component;

class ItemsIndex extends Component
{
    public ?string $search = null;
    public ?string $statusFilter = null; // e.g. pending|running|completed|cancelled
    public ?string $fromDate = null;     // Y-m-d
    public ?string $toDate = null;       // Y-m-d

    public function updatedSearch($value): void
    {
        $this->search = trim((string) $value) === '' ? null : trim((string) $value);
    }

    public function updatedStatusFilter($value): void
    {
        $this->statusFilter = ($value === '' || $value === null) ? null : $value;
    }

    public function updatedFromDate($value): void
    {
        $this->fromDate = ($value === '' || $value === null) ? null : $value;
    }

    public function updatedToDate($value): void
    {
        $this->toDate = ($value === '' || $value === null) ? null : $value;
    }

    public function clearFilters(): void
    {
        $this->search = $this->statusFilter = $this->fromDate = $this->toDate = null;
    }

    public function render(SomeService $service): View
    {
        $filters = [];
        if ($this->search !== null && $this->search !== '') { $filters['search'] = $this->search; }
        if ($this->statusFilter !== null && $this->statusFilter !== '') { $filters['status'] = $this->statusFilter; }
        if ($this->fromDate !== null && $this->fromDate !== '') { $filters['from_date'] = $this->fromDate; }
        if ($this->toDate !== null && $this->toDate !== '') { $filters['to_date'] = $this->toDate; }

        $items = $service->listAll($filters); // returns Collection (or paginator if needed)

        return view('livewire.items.index', compact('items'))
            ->layout('components.layouts.app', ['title' => __('Items')]);
    }
}
```

### Blade View (UI + rendering rules)

```blade
<x-table-card variant="emerald">
    <!-- Filters Row -->
    <div class="mb-4 flex flex-wrap gap-4">
        <div class="flex-1 min-w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="{{ __('Search...') }}"
                icon="magnifying-glass" />
        </div>
        <div class="w-44">
            <flux:input type="date" wire:model.live="fromDate" placeholder="{{ __('From Date') }}" />
        </div>
        <div class="w-44">
            <flux:input type="date" wire:model.live="toDate" placeholder="{{ __('To Date') }}" />
        </div>
        <div class="w-48">
            <flux:select wire:model.live="statusFilter" placeholder="{{ __('All Status') }}">
                <option value="">{{ __('All Status') }}</option>
                <option value="pending">{{ __('Pending') }}</option>
                <option value="running">{{ __('Running') }}</option>
                <option value="completed">{{ __('Completed') }}</option>
                <option value="cancelled">{{ __('Cancelled') }}</option>
            </flux:select>
        </div>

        @if($search || $statusFilter || $fromDate || $toDate)
            <div class="flex items-center">
                <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark">
                    {{ __('Clear Filters') }}
                </flux:button>
            </div>
        @endif
    </div>

    <!-- Active Filters Badges -->
    @if($search || $statusFilter || $fromDate || $toDate)
        <div class="mt-3 flex flex-wrap gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active Filters:') }}</span>
            @if($search)
                <flux:badge color="violet" size="sm">{{ __('Search:') }} "{{ $search }}"</flux:badge>
            @endif
            @if($statusFilter)
                <flux:badge color="blue" size="sm">{{ __('Status:') }} {{ ucfirst($statusFilter) }}</flux:badge>
            @endif
            @if($fromDate)
                <flux:badge color="gray" size="sm">{{ __('From:') }} {{ $fromDate }}</flux:badge>
            @endif
            @if($toDate)
                <flux:badge color="gray" size="sm">{{ __('To:') }} {{ $toDate }}</flux:badge>
            @endif
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50"
         wire:key="table-{{ md5(($search ?? '').'|'.($statusFilter ?? '').'|'.($fromDate ?? '').'|'.($toDate ?? '')) }}">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>...</thead>
            <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                @forelse($items as $item)
                    <x-item-row :item="$item" wire:key="item-{{ $item->id }}" />
                @empty
                    <!-- Empty state -->
                @endforelse
            </tbody>
        </table>
    </div>
</x-table-card>
```

### Service Method (Filtering semantics)

```php
public function listAll(array $filters = []): \Illuminate\Database\Eloquent\Collection
{
    $query = Model::with(['relations...']);

    if (isset($filters['search']) && $filters['search'] !== '') {
        $query->where(function ($q) use ($filters) {
            $q->where('title', 'like', "%{$filters['search']}%")
              ->orWhere('description', 'like', "%{$filters['search']}%");
        });
    }

    if (isset($filters['status']) && $filters['status'] !== '') {
        $query->where('status', $filters['status']);
    }

    if (isset($filters['from_date']) && $filters['from_date'] !== '') {
        $query->whereDate('work_date', '>=', $filters['from_date']);
    }

    if (isset($filters['to_date']) && $filters['to_date'] !== '') {
        $query->whereDate('work_date', '<=', $filters['to_date']);
    }

    return $query->latest('work_date')->latest('work_time')->get();
}
```

### Non-Negotiables (Always follow)

- Use nullable public properties (e.g., `?string $statusFilter = null`).
- Normalize empty inputs to `null` in `updatedXxx()` handlers.
- Build `$filters` explicitly; do not pass raw `$this` properties directly.
- Add `wire:key` to:
  - Each row: `wire:key="item-{{ $item->id }}"`
  - Table wrapper keyed by all active filters.
- Provide a Clear Filters button and Active Filters badges.
- Keep UI within `<x-table-card>` and follow spacing, borders, and dark mode rules above.

This is the canonical table pattern. Reuse as-is and adapt field names only.
