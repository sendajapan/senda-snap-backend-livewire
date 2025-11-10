# Design System Documentation
## Laravel Livewire Project - Design Patterns & Guidelines

This document outlines the design patterns, components, and styling guidelines used throughout the application to ensure consistency across all pages.

---

## 🎨 Color Variants

The design system uses 4 primary color variants:

### **Blue** (Default for User-related pages)
- Primary: `blue-500` → `cyan-500`
- Light: `blue-50/30` → `cyan-50/30`
- Border: `blue-200`
- Decorative: `blue-400/20` → `cyan-400/20`

### **Emerald** (Default for Data Tables)
- Primary: `emerald-500` → `teal-500`
- Light: `emerald-50/30` → `teal-50/30`
- Border: `emerald-200`
- Decorative: `emerald-400/20` → `teal-400/20`

### **Violet** (For Vehicle-related pages)
- Primary: `violet-500` → `purple-500`
- Light: `violet-50/30` → `purple-50/30`
- Border: `violet-200`
- Decorative: `violet-400/20` → `purple-400/20`

### **Amber** (For Task/Alert-related pages)
- Primary: `amber-500` → `orange-500`
- Light: `amber-50/30` → `orange-50/30`
- Border: `amber-200`
- Decorative: `amber-400/20` → `orange-400/20`

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
- Hover shadow effect

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
    <div class="overflow-x-auto rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
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
- Colored decorative circles
- Text uses `text-accent` class
- Rounded 2xl corners
- Icon container with backdrop blur

### 4. **Table Row Components** (Model-specific)

**Purpose**: Consistent table row styling for each model

**Example**: `<x-user-table-row>`

**Pattern to Follow**:
```blade
<tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 dark:hover:from-emerald-900/10 dark:hover:to-teal-900/10">
    <td class="whitespace-nowrap px-6 py-5">
        <!-- Avatar/Image Column -->
        <div class="flex items-center">
            <div class="relative size-12 flex-shrink-0">
                @if($item->image)
                    <img src="{{ $item->image_url }}" class="size-12 rounded-xl object-cover ring-2 ring-emerald-200">
                @else
                    <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg ring-2 ring-emerald-200">
                        <span class="text-base font-bold text-white">{{ $item->initials() }}</span>
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
    
    <!-- Additional columns with icons -->
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex items-center gap-2">
            <svg class="h-4 w-4 text-gray-400">...</svg>
            <span class="text-sm text-gray-900 dark:text-white">{{ $item->field }}</span>
        </div>
    </td>
    
    <!-- Badge column -->
    <td class="whitespace-nowrap px-6 py-5">
        <flux:badge :color="$color" size="sm" class="font-semibold">
            {{ $item->status }}
        </flux:badge>
    </td>
    
    <!-- Actions column (hover-revealed) -->
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex items-center gap-2">
            <flux:button size="sm" variant="ghost" icon="pencil" wire:navigate 
                class="opacity-0 transition-opacity group-hover:opacity-100">
                {{ __('Edit') }}
            </flux:button>
        </div>
    </td>
</tr>
```

---

## 📐 Layout Structure

### **Standard Page Layout**

```blade
<div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
    <!-- 1. Page Header -->
    <x-page-header variant="blue">...</x-page-header>

    <!-- 2. Stats Cards (if applicable) -->
    <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-4">
        <x-stats-card>...</x-stats-card>
        <!-- Repeat for each stat -->
    </div>

    <!-- 3. Main Content (Table/Form/Charts) -->
    <x-table-card variant="emerald">
        <!-- Content -->
    </x-table-card>
    
    <!-- OR Multiple Cards -->
    <div class="grid gap-6 md:grid-cols-2">
        <x-table-card variant="emerald">...</x-table-card>
        <x-table-card variant="violet">...</x-table-card>
    </div>
</div>
```

### **Dashboard Layout**

```blade
<div class="flex h-full w-full flex-1 flex-col gap-6 p-4">
    <!-- 1. Welcome Header (Grid layout) -->
    <div class="grid gap-6 md:grid-cols-2">
        <!-- Welcome Card -->
        <!-- Date/Time Card -->
    </div>

    <!-- 2. Stats Cards -->
    <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-4">
        <!-- Stats -->
    </div>

    <!-- 3. Charts Section -->
    <div class="grid gap-6 md:grid-cols-2">
        <!-- Chart Cards -->
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

---

## 🎨 Tables

### **Table Container**
```blade
<div class="overflow-x-auto rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
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
    <!-- Rows -->
</tbody>
```

### **Empty State**
```blade
<tr>
    <td colspan="5" class="px-6 py-12 text-center">
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
- **Heroicons**: Primary icon set
- Always use `stroke` variants (outline style)
- Standard sizes: `h-4 w-4`, `h-5 w-5`, `h-6 w-6`, `h-7 w-7`, `h-8 w-8`

### **Icon Colors**
- Primary actions: `text-white`
- Secondary/Muted: `text-gray-400`
- In colored badges: `text-{color}-600 dark:text-{color}-400`

### **Common Icons**
- Users: `M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z...`
- Tasks: `M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7...`
- Vehicles: `M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293...`
- Email: `M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7...`
- Phone: `M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493...`

---

## 🌈 Decorative Elements

### **Blur Circles** (Background decoration)
```blade
<!-- Top Right -->
<div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-{color}-400/20 to-{color2}-400/20 blur-2xl"></div>

<!-- Bottom Left -->
<div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-{color2}-400/20 to-{color}-400/20 blur-2xl"></div>
```

### **Gradient Accent Lines**
```blade
<div class="h-1 w-8 rounded-full bg-gradient-to-r from-{color}-500 to-{color2}-500"></div>
```

### **Status Indicators**
```blade
<!-- Online/Active -->
<div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white bg-green-500 dark:border-gray-900"></div>

<!-- With Animation -->
<div class="relative">
    <div class="h-4 w-4 animate-pulse rounded-full bg-{color}-500 shadow-lg shadow-{color}-500/50"></div>
    <div class="absolute inset-0 h-4 w-4 animate-ping rounded-full bg-{color}-400 opacity-75"></div>
</div>
```

---

## 🎬 Animations & Transitions

### **Hover Effects**
- Cards: `hover:shadow-2xl` with `transition-all duration-300`
- Table Rows: `hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50` with `transition-all duration-200`
- Buttons: `hover:scale-105` or `hover:opacity-100` with `transition-opacity`

### **Loading States**
```blade
<div class="animate-pulse rounded-2xl ...">
    <!-- Content -->
</div>
```

### **Interactive Elements**
```blade
<div class="group">
    <button class="opacity-0 transition-opacity group-hover:opacity-100">
        Action
    </button>
</div>
```

---

## 🔘 Buttons & Actions

### **Primary Action**
```blade
<flux:button icon="plus" wire:navigate variant="primary">
    {{ __('Add Item') }}
</flux:button>
```

### **Secondary Action**
```blade
<flux:button size="sm" variant="ghost" icon="pencil" wire:navigate>
    {{ __('Edit') }}
</flux:button>
```

### **Hover-Revealed Actions**
```blade
<flux:button 
    size="sm" 
    variant="ghost" 
    icon="pencil" 
    wire:navigate 
    class="opacity-0 transition-opacity group-hover:opacity-100">
    {{ __('Edit') }}
</flux:button>
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
- Pending: `rgba(245, 158, 11, 0.8)` (Amber)
- Running/Active: `rgba(59, 130, 246, 0.8)` (Blue)
- Completed/Success: `rgba(16, 185, 129, 0.8)` (Emerald)
- Warning: `rgba(245, 158, 11, 0.8)` (Amber)
- Info: `rgba(100, 116, 139, 0.8)` (Slate)

### **Chart Initialization**
```javascript
function initializeCharts() {
    // Destroy existing charts
    if (window.chartName && typeof window.chartName.destroy === 'function') {
        window.chartName.destroy();
    }
    
    // Create new chart
    window.chartName = new Chart(ctx, { options });
}

// Initialize on load and navigation
document.addEventListener('DOMContentLoaded', initializeCharts);
document.addEventListener('livewire:navigated', initializeCharts);
```

---

## 🌓 Dark Mode

### **Always Include Dark Mode Variants**
- Background: `bg-white dark:bg-gray-900`
- Text: `text-gray-900 dark:text-white`
- Borders: `border-gray-200 dark:border-gray-700`
- Secondary Text: `text-gray-600 dark:text-gray-400`
- Hover: Match color scheme with dark variants

### **Gradient Backgrounds in Dark Mode**
```blade
class="bg-gradient-to-br from-white via-blue-50/30 to-cyan-50/30 
       dark:from-gray-900 dark:via-blue-900/20 dark:to-cyan-900/20"
```

---

## 📏 Spacing & Sizing

### **Padding**
- Page Container: `p-6` (standard) or `p-4` (compact like dashboard)
- Card: `p-6` or `p-8` (large cards)
- Table Cell: `px-6 py-5` (rows) or `px-6 py-4` (headers)

### **Gaps**
- Vertical Sections: `gap-6`
- Horizontal Items: `gap-4` or `gap-3`
- Grid: `gap-6`

### **Rounded Corners**
- Cards/Containers: `rounded-2xl`
- Tables: `rounded-xl`
- Avatars: `rounded-xl` or `rounded-full`
- Badges: `rounded-lg`
- Buttons: Use Flux defaults

### **Shadows**
- Default: `shadow-xl`
- Hover: `hover:shadow-2xl`
- Icon Badge: `shadow-lg`
- Small elements: `shadow-sm`

---

## 🎯 Badge Colors

### **Role/Status Badges**
```blade
<flux:badge :color="match($status) {
    'admin', 'critical' => 'red',
    'manager', 'active' => 'blue',
    'employee', 'completed' => 'green',
    'pending' => 'amber',
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
- [ ] Create model-specific table row component if needed
- [ ] Include search and filters in table card
- [ ] Use frosted glass effect for table container (`bg-white/50 backdrop-blur-sm`)
- [ ] Add gradient hover effects to table rows
- [ ] Include icons with data where appropriate
- [ ] Add empty state with icon and helpful text
- [ ] Include pagination at bottom
- [ ] Ensure all elements have dark mode variants
- [ ] Use heroicons for all icons
- [ ] Add decorative blur circles to cards
- [ ] Test responsive design (md:, lg:, xl: breakpoints)
- [ ] Use `wire:navigate` for internal links
- [ ] Add loading states where appropriate

---

## 📚 Example: Creating a Tasks Page

```blade
<div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
    <!-- Header -->
    <x-page-header 
        :title="__('Tasks Management')" 
        :description="__('Manage all tasks and assignments')"
        variant="amber">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button :href="route('tasks.create')" icon="plus" wire:navigate variant="primary">
                {{ __('Add Task') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Table -->
    <x-table-card variant="amber">
        <!-- Filters -->
        <div class="mb-4 flex gap-4">
            <div class="flex-1">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="{{ __('Search tasks...') }}" icon="magnifying-glass" />
            </div>
            <div class="w-48">
                <flux:select wire:model.live="statusFilter">
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="pending">{{ __('Pending') }}</option>
                    <option value="running">{{ __('Running') }}</option>
                    <option value="completed">{{ __('Completed') }}</option>
                </flux:select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Task') }}
                        </th>
                        <!-- More columns -->
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($tasks as $task)
                        <x-task-table-row :task="$task" />
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No tasks found') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </x-table-card>
</div>
```

---

## 🎨 Color Mapping by Page Type

| Page Type | Variant | Use Case |
|-----------|---------|----------|
| Users | Blue | User management, profiles |
| Tasks | Amber | Task management, assignments |
| Vehicles | Violet | Vehicle inventory, tracking |
| Reports | Emerald | Data tables, analytics |
| Settings | Gray | Configuration pages |
| Dashboard | Mixed | Use all variants as needed |

---

## 📝 Notes

- Always use translation helpers `__()` for all user-facing text
- Use Livewire's `wire:navigate` for internal navigation
- Debounce search inputs: `wire:model.live.debounce.300ms="search"`
- Use Flux UI components where available (buttons, inputs, badges, etc.)
- Keep decorative elements consistent (blur circles, gradients)
- Test in both light and dark mode
- Ensure responsive design at all breakpoints
- Use semantic HTML
- Include proper accessibility attributes

---

**Version**: 1.0  
**Last Updated**: {{ now()->format('F d, Y') }}  
**Project**: Laravel Livewire Dashboard

