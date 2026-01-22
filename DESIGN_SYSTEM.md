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

---

## 🌟 Shadow Standards

All cards and containers use a consistent shadow system with colored shadows for visual depth.

### **Standard Dashboard Card Shadow Pattern** ⭐ (Recommended)

All dashboard cards (Task Status Chart, Members Card, Stats Cards, Date/Time Card) use this standardized shadow pattern:

```blade
<!-- Base shadow with colored tint -->
shadow-xl shadow-{color}-200/40 dark:shadow-{color}-900/30

<!-- Hover state shadow -->
hover:shadow-2xl hover:shadow-{color}-300/50 dark:hover:shadow-{color}-800/40
```

### **Shadow by Variant**

| Variant | Default Shadow | Hover Shadow |
|---------|---------------|--------------|
| Blue | `shadow-xl shadow-blue-200/40` | `hover:shadow-2xl hover:shadow-blue-300/50` |
| Emerald | `shadow-xl shadow-emerald-200/40` | `hover:shadow-2xl hover:shadow-emerald-300/50` |
| Violet | `shadow-xl shadow-violet-200/40` | `hover:shadow-2xl hover:shadow-violet-300/50` |
| Amber | `shadow-xl shadow-amber-200/40` | `hover:shadow-2xl hover:shadow-amber-300/50` |
| Indigo | `shadow-xl shadow-indigo-200/40` | `hover:shadow-2xl hover:shadow-indigo-300/50` |
| Gray (neutral) | `shadow-xl shadow-gray-200/40` | `hover:shadow-2xl hover:shadow-gray-300/50` |

### **Dark Mode Shadows**

```blade
<!-- Dark mode default -->
dark:shadow-{color}-900/30

<!-- Dark mode hover -->
dark:hover:shadow-{color}-800/40
```

### **Standard Dashboard Card Structure**

All dashboard cards follow this consistent structure:

```blade
<div class="dashboard-card group relative overflow-hidden rounded-xl sm:rounded-2xl border border-{color}-300/50 bg-white/60 p-4 sm:p-5 lg:p-6 shadow-xl shadow-{color}-200/40 backdrop-blur-xl transition-all duration-300 hover:border-{color}-400/60 hover:shadow-2xl hover:shadow-{color}-300/50 dark:border-{color}-800/50 dark:bg-gray-800/60 dark:shadow-{color}-900/30 dark:hover:border-{color}-700 dark:hover:shadow-{color}-800/40">
    <!-- Decorative blur circles - larger and more spread -->
    <div class="pointer-events-none absolute -right-6 sm:-right-12 -top-6 sm:-top-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-{color}-400/30 to-{color2}-400/30 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-6 sm:-bottom-12 -left-6 sm:-left-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-{color2}-400/30 to-{color}-400/30 blur-3xl"></div>
    
    <div class="relative z-10">
        <!-- Card content -->
    </div>
</div>
```

**Key Features**:
- **Shadow**: `shadow-xl` (not `shadow-md`) with `/40` opacity for stronger depth
- **Hover Shadow**: `hover:shadow-2xl` (not `hover:shadow-lg`) with `/50` opacity
- **Decorative Blur Circles**: Larger (`h-24 sm:h-48 w-24 sm:w-48`) with `blur-3xl` (not `blur-2xl`)
- **Border Opacity**: `/50` for borders, `/60` on hover
- **Background**: `bg-white/60` with `backdrop-blur-xl` for glass morphism effect
- **Consistent Spacing**: All cards use same padding pattern `p-4 sm:p-5 lg:p-6`

### **Legacy Card Pattern** (Deprecated)

For non-dashboard cards, the lighter shadow pattern may still be used:

```blade
<!-- Base shadow with colored tint -->
shadow-md shadow-{color}-100/50 dark:shadow-{color}-900/20

<!-- Hover state shadow -->
hover:shadow-lg hover:shadow-{color}-200/50 dark:hover:shadow-{color}-800/30
```

**Note**: New dashboard cards should use the standard pattern above, not the legacy pattern.

### **Standardized Dashboard Cards**

All dashboard cards have been refactored to use the same shadow, border, and decorative blur circle patterns:

| Card | Status | Variant | Notes |
|------|--------|---------|-------|
| Task Status Donut Chart | ✅ Standardized | Emerald | Uses standard shadow pattern |
| Members Card | ✅ Standardized | Blue | Uses standard shadow pattern |
| Stats Cards (`<x-stats-card>`) | ✅ Standardized | Blue/Emerald/Amber/Violet | Component updated for all variants |
| Date & Time Card | ✅ Standardized | Indigo | Uses standard shadow pattern |
| Welcome Card | ✅ Standardized | Blue | Gradient background (special case) |

**All cards now share**:
- Same shadow: `shadow-xl shadow-{color}-200/40` → `hover:shadow-2xl hover:shadow-{color}-300/50`
- Same border opacity: `border-{color}-300/50` → `hover:border-{color}-400/60`
- Same decorative blur circles: `h-24 sm:h-48 w-24 sm:w-48` with `blur-3xl`
- Same dark mode shadows: `dark:shadow-{color}-900/30` → `dark:hover:shadow-{color}-800/40`
- Same background: `bg-white/60` with `backdrop-blur-xl` (except Welcome Card which uses gradient)

### **Small Element Shadows (Status indicators, badges)**

```blade
<!-- Glowing indicator dot -->
<div class="h-3 w-3 animate-pulse rounded-full bg-{color}-500 shadow-lg shadow-{color}-500/50"></div>

<!-- Small card/label shadow -->
shadow-sm transition-all duration-200 hover:shadow-md hover:shadow-{color}-200/50
```

---

## 🏷️ Status Label Design Variants

Five pre-built design variants for status labels, counters, and stat indicators. Each can be customized with different colors using the color combinations table below.

### **Design 1: Neon Glow Cards** (Recommended for Role Counters)

Best for: Role counters, category indicators, high-impact stats with subtitles

**Features:**
- Left-side blur glow effect that intensifies on hover
- Gradient icon box with colored shadow
- Gradient badge for count
- Status name with subtitle
- Scale effect on hover

```blade
<div class="group relative flex items-center justify-between overflow-hidden rounded-xl border border-{color}-400/50 bg-gradient-to-r from-{color}-500/10 via-{color}-400/5 to-transparent px-4 py-3 shadow-lg shadow-{color}-500/20 backdrop-blur-sm transition-all duration-300 hover:scale-[1.03] hover:border-{color}-400 hover:shadow-xl hover:shadow-{color}-500/30 dark:border-{color}-500/30 dark:from-{color}-500/20 dark:via-{color}-400/10 dark:to-transparent">
    <!-- Blur glow effect -->
    <div class="absolute -left-4 top-1/2 h-16 w-16 -translate-y-1/2 rounded-full bg-{color}-500/30 blur-2xl transition-all group-hover:bg-{color}-500/50"></div>
    <div class="relative flex items-center gap-3">
        <!-- Icon box (h-8 w-8) -->
        <div class="relative flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-{color}-400 to-{color2}-500 shadow-lg shadow-{color}-500/50">
            <svg class="h-4 w-4 text-white">...</svg>
        </div>
        <div>
            <span class="text-sm font-bold text-{color}-900 dark:text-{color}-200">Label</span>
            <p class="text-xs text-{color}-600/80 dark:text-{color}-400/70">Subtitle</p>
        </div>
    </div>
    <!-- Count badge -->
    <span class="relative rounded-full bg-gradient-to-r from-{color}-500 to-{color2}-500 px-3 py-1 text-sm font-bold text-white shadow-lg shadow-{color}-500/40">{{ $count }}</span>
</div>
```

---

### **Design 2: Compact Glass with Gradient Stroke** ⭐ (Recommended for Status Labels)

Best for: Task status labels, compact indicators, space-efficient displays

**Features:**
- Smaller, compact size
- Colored gradient stroke/border
- Glass morphism with gradient background
- Left-side blur glow
- Gradient icon box and badge
- Scale effect on hover

```blade
<div class="group relative flex items-center justify-between overflow-hidden rounded-xl border border-{color}-400/50 bg-gradient-to-r from-{color}-500/10 via-{color}-400/5 to-white/40 px-3 py-2 shadow-lg shadow-{color}-500/20 backdrop-blur-xl transition-all duration-300 hover:scale-[1.02] hover:border-{color}-400 hover:shadow-xl hover:shadow-{color}-500/30 dark:border-{color}-500/30 dark:from-{color}-500/20 dark:via-{color}-400/10 dark:to-gray-900/40">
    <!-- Blur glow effect -->
    <div class="absolute -left-3 top-1/2 h-12 w-12 -translate-y-1/2 rounded-full bg-{color}-500/20 blur-xl transition-all group-hover:bg-{color}-500/40"></div>
    <div class="relative flex items-center gap-2">
        <!-- Icon box (h-7 w-7) - smaller -->
        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-br from-{color}-400 to-{color2}-500 shadow-md shadow-{color}-500/50">
            <svg class="h-3.5 w-3.5 text-white">...</svg>
        </div>
        <span class="text-xs font-bold text-{color}-900 dark:text-{color}-200">Label</span>
    </div>
    <!-- Compact count badge -->
    <span class="relative rounded-full bg-gradient-to-r from-{color}-500 to-{color2}-500 px-2.5 py-0.5 text-xs font-bold text-white shadow-md shadow-{color}-500/40">{{ $count }}</span>
</div>
```

**Size Comparison:**
| Property | Design 1 (Neon Glow) | Design 2 (Compact) |
|----------|---------------------|-------------------|
| Padding | `px-4 py-3` | `px-3 py-2` |
| Icon Box | `h-8 w-8` | `h-7 w-7` |
| Icon | `h-4 w-4` | `h-3.5 w-3.5` |
| Text | `text-sm` | `text-xs` |
| Badge | `px-3 py-1 text-sm` | `px-2.5 py-0.5 text-xs` |
| Gap | `gap-3` | `gap-2` |
| Spacing | `space-y-2` | `space-y-1.5` |

---

### **Design 3: Glass Morphism Pills**

Best for: Large displays, progress tracking with visual indicators

**Features:**
- Frosted glass background (white border)
- Number displayed inside gradient box with ring effect
- Progress bar indicator
- Animated icons for running states
- Soft shadows

```blade
<div class="group flex items-center justify-between rounded-2xl border border-white/20 bg-white/40 px-4 py-3 shadow-xl shadow-{color}-200/30 backdrop-blur-xl transition-all duration-300 hover:bg-white/60 hover:shadow-2xl hover:shadow-{color}-300/40 dark:border-white/10 dark:bg-gray-900/40 dark:shadow-{color}-900/20">
    <div class="flex items-center gap-3">
        <!-- Number box with ring -->
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-{color}-400 via-{color}-500 to-{color2}-500 shadow-lg shadow-{color}-500/50 ring-4 ring-{color}-200/50 dark:ring-{color}-900/50">
            <span class="text-lg font-black text-white">{{ $count }}</span>
        </div>
        <div>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Label</span>
            <!-- Progress bar -->
            <div class="mt-0.5 h-1.5 w-16 overflow-hidden rounded-full bg-{color}-200/50 dark:bg-{color}-900/30">
                <div class="h-full w-3/4 rounded-full bg-gradient-to-r from-{color}-400 to-{color2}-500"></div>
            </div>
        </div>
    </div>
    <!-- Status icon (can be animated with animate-spin) -->
    <svg class="h-5 w-5 text-{color}-500">...</svg>
</div>
```

---

### **Design 4: Solid Color Blocks**

Best for: Dashboard highlights, key metrics, bold presentations

**Features:**
- Full gradient colored background
- White text for maximum contrast
- Large count number on right
- Decorative blur circles
- Bold and vibrant appearance

```blade
<div class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-{color}-500 to-{color2}-500 p-4 shadow-lg shadow-{color}-500/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-{color}-500/50">
    <!-- Decorative blurs -->
    <div class="absolute -right-4 -top-4 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>
    <div class="absolute -bottom-2 -left-2 h-16 w-16 rounded-full bg-white/10 blur-lg"></div>
    <div class="relative flex items-center justify-between">
        <div class="flex items-center gap-3">
            <!-- Icon box -->
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                <svg class="h-5 w-5 text-white">...</svg>
            </div>
            <div>
                <span class="text-sm font-bold text-white">Label</span>
                <p class="text-xs text-white/70">Subtitle</p>
            </div>
        </div>
        <!-- Large count -->
        <span class="text-3xl font-black text-white drop-shadow-lg">{{ $count }}</span>
    </div>
</div>
```

---

### **Design 5: Minimal Dark Cards**

Best for: Dark themes, dashboard widgets, subtle displays

**Features:**
- Dark background with colored borders
- Animated ping dot indicator
- Large colored count number
- Minimal and modern aesthetic
- Works great in dark mode

```blade
<div class="group flex items-center justify-between rounded-xl border border-{color}-500/30 bg-gray-900/90 px-4 py-3 shadow-lg shadow-{color}-500/10 backdrop-blur-sm transition-all duration-300 hover:border-{color}-500/60 hover:shadow-xl hover:shadow-{color}-500/20">
    <div class="flex items-center gap-3">
        <!-- Animated dot -->
        <div class="relative h-2 w-2">
            <div class="absolute inset-0 animate-ping rounded-full bg-{color}-500"></div>
            <div class="relative h-2 w-2 rounded-full bg-{color}-400 shadow-lg shadow-{color}-500"></div>
        </div>
        <span class="text-sm font-medium text-gray-300">Label</span>
    </div>
    <div class="flex items-center gap-2">
        <span class="text-2xl font-black text-{color}-400">{{ $count }}</span>
        <svg class="h-4 w-4 text-{color}-500/50">...</svg>
    </div>
</div>
```

---

### **Quick Reference: When to Use Which Design**

| Design | Use When | Example |
|--------|----------|---------|
| **1. Neon Glow** | Need subtitles, larger display, role counters | Members stats (Admin, Manager, etc.) |
| **2. Compact Glass** ⭐ | Space-efficient, status labels, lists | Task status (Pending, Running, etc.) |
| **3. Glass Pills** | Progress tracking, number-focused display | Progress indicators |
| **4. Solid Blocks** | Bold presentation, key metrics | Dashboard highlights |
| **5. Minimal Dark** | Dark themes, subtle indicators | Dark mode widgets |

---

### **Color Combinations**

| Status | Primary `{color}` | Secondary `{color2}` |
|--------|-------------------|---------------------|
| Pending | `amber` | `orange` |
| Running | `blue` | `indigo` |
| Completed | `emerald` | `green` |
| Cancelled | `red` | `rose` |
| Admin | `red` | `rose` |
| Manager | `blue` | `indigo` |
| Employee | `emerald` | `green` |
| Client | `violet` | `purple` |

### **Common Icons by Status**

```blade
<!-- Pending (clock) -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>

<!-- Running (refresh/spin) - add animate-spin -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>

<!-- Completed (check) -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>

<!-- Cancelled (x) -->
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
```

---

## 📍 Sidebar Active Item Styling

The sidebar uses Glass Morphism Pills effect for selected/current menu items.

### **Active Item CSS**

```css
/* Glass Morphism Pills for Selected Sidebar Items */
[data-current="true"],
[aria-current="page"] {
    background: linear-gradient(to right, 
        rgba(59, 130, 246, 0.15),    /* blue-500/15 */
        rgba(99, 102, 241, 0.08),    /* indigo-500/8 */
        rgba(255, 255, 255, 0.4)     /* white/40 */
    ) !important;
    border: 1px solid rgba(59, 130, 246, 0.5) !important;
    border-radius: 0.75rem !important;
    box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.25),
                0 4px 6px -4px rgba(59, 130, 246, 0.15) !important;
    backdrop-filter: blur(16px) !important;
    position: relative;
    overflow: hidden;
}

/* Left glow effect */
[data-current="true"]::before {
    content: '';
    position: absolute;
    left: -0.5rem;
    top: 50%;
    transform: translateY(-50%);
    width: 2.5rem;
    height: 2.5rem;
    background: rgba(59, 130, 246, 0.3);
    border-radius: 50%;
    filter: blur(0.75rem);
    pointer-events: none;
}

/* Hover state */
[data-current="true"]:hover {
    background: linear-gradient(to right, 
        rgba(59, 130, 246, 0.2),
        rgba(99, 102, 241, 0.12),
        rgba(255, 255, 255, 0.5)
    ) !important;
    border-color: rgba(59, 130, 246, 0.7) !important;
    box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.3),
                0 8px 10px -6px rgba(59, 130, 246, 0.2) !important;
    transform: scale(1.02);
}
```

### **Dark Mode**

```css
.dark [data-current="true"] {
    background: linear-gradient(to right, 
        rgba(59, 130, 246, 0.25),
        rgba(99, 102, 241, 0.15),
        rgba(17, 24, 39, 0.7)        /* gray-900/70 */
    ) !important;
    border-color: rgba(59, 130, 246, 0.4) !important;
}
```

### **Non-Active Hover**

```css
[data-flux-navlist-item]:not([data-current="true"]):hover {
    background: rgba(59, 130, 246, 0.05) !important;
    border-radius: 0.75rem;
}

.dark [data-flux-navlist-item]:not([data-current="true"]):hover {
    background: rgba(59, 130, 246, 0.1) !important;
}
```

### **Features**
- Glass morphism background with gradient
- Blue-indigo color scheme (matches primary accent)
- Left-side blur glow effect
- Scale transform on hover (1.02x)
- Smooth transitions (0.3s cubic-bezier)
- Dark mode support

---

## 🌫️ Card Blur Levels

Three levels of blur and shadow intensity for different visual hierarchy needs.

### **Level 1: Standard Cards** (Default)

```blade
<div class="... border-{color}-200 bg-white/50 shadow-md shadow-{color}-100/50 backdrop-blur-sm ...">
    <div class="... h-32 w-32 ... blur-2xl"></div>
</div>
```

### **Level 2: Enhanced Cards** ⭐ (Standard for Dashboard - REQUIRED)

**All dashboard cards must use this pattern** (Task Status Chart, Members Card, Stats Cards, Date/Time Card).

```blade
<div class="dashboard-card group relative overflow-hidden rounded-xl sm:rounded-2xl border border-{color}-300/50 bg-white/60 p-4 sm:p-5 lg:p-6 shadow-xl shadow-{color}-200/40 backdrop-blur-xl transition-all duration-300 hover:border-{color}-400/60 hover:shadow-2xl hover:shadow-{color}-300/50 dark:border-{color}-800/50 dark:bg-gray-800/60 dark:shadow-{color}-900/30 dark:hover:border-{color}-700 dark:hover:shadow-{color}-800/40">
    <!-- Decorative blur circles - larger and more spread -->
    <div class="pointer-events-none absolute -right-6 sm:-right-12 -top-6 sm:-top-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-{color}-400/30 to-{color2}-400/30 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-6 sm:-bottom-12 -left-6 sm:-left-12 h-24 sm:h-48 w-24 sm:w-48 rounded-full bg-gradient-to-br from-{color2}-400/30 to-{color}-400/30 blur-3xl"></div>
    <div class="relative z-10">
        <!-- Card content -->
    </div>
</div>
```

**Standardized Cards**:
- ✅ Task Status Donut Chart
- ✅ Members Card
- ✅ Stats Cards (`<x-stats-card>`)
- ✅ Date & Time Card

### **Level 3: Premium Cards** (Hero Sections)

```blade
<div class="... border-{color}-400/60 bg-white/70 shadow-2xl shadow-{color}-300/50 backdrop-blur-2xl hover:shadow-3xl ...">
    <div class="... h-64 w-64 ... blur-[40px]"></div>
</div>
```

### **Comparison Table**

| Property | Standard | Enhanced | Premium |
|----------|----------|----------|---------|
| Background | `bg-white/50` | `bg-white/60` | `bg-white/70` |
| Blur | `backdrop-blur-sm` | `backdrop-blur-xl` | `backdrop-blur-2xl` |
| Shadow | `shadow-md` | `shadow-xl` | `shadow-2xl` |
| Shadow Color | `{color}-100/50` | `{color}-200/40` | `{color}-300/50` |
| Hover Shadow | `shadow-lg` | `shadow-2xl` | `shadow-3xl` |
| Blur Circle Size | `h-32 w-32` | `h-48 w-48` | `h-64 w-64` |
| Blur Circle Blur | `blur-2xl` | `blur-3xl` | `blur-[40px]` |
| Border | `{color}-200` | `{color}-300/50` | `{color}-400/60` |

### **Full Enhanced Card Example**

```blade
<div class="group relative overflow-hidden rounded-2xl border border-{color}-300/50 bg-white/60 p-6 shadow-xl shadow-{color}-200/40 backdrop-blur-xl transition-all duration-300 hover:border-{color}-400/60 hover:shadow-2xl hover:shadow-{color}-300/50 dark:border-{color}-800/50 dark:bg-gray-800/60 dark:shadow-{color}-900/30 dark:hover:border-{color}-700 dark:hover:shadow-{color}-800/40">
    <!-- Decorative blur circles -->
    <div class="pointer-events-none absolute -right-12 -top-12 h-48 w-48 rounded-full bg-gradient-to-br from-{color}-400/30 to-{color2}-400/30 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-12 -left-12 h-48 w-48 rounded-full bg-gradient-to-br from-{color2}-400/30 to-{color}-400/30 blur-3xl"></div>
    <!-- Card content -->
</div>
```

---

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
- Transparent frosted glass background (`bg-white/50 backdrop-blur-sm`)
- Decorative blur circles in corners
- Rounded 2xl corners
- Icon badge with gradient (14x14, h-14 w-14)
- Icon container uses `flex-shrink-0` to maintain 56x56px size on all screen sizes
- Title (text-2xl font-bold)
- Description (text-sm)
- Optional actions slot
- Colored shadow: `shadow-md shadow-{color}-100/50`
- Hover effects: `hover:shadow-lg hover:shadow-{color}-200/50 hover:border-{color}-300`
- Dark mode support

---

### 2. **Phone Mockup Component** (`<x-phone-mockup>`)

**Purpose**: Reusable phone mockup frame for displaying app screenshots with consistent styling

**Usage**:
```blade
<x-phone-mockup 
    image="assets/app-manual/screenshot.jpg"
    :alt="__('Screenshot Description')"
    zoomable="true" />
```

**Props**:
- `image` (string, optional): Path to the image file (relative to public directory). If not provided, shows a default "No Image" placeholder.
- `alt` (string, optional): Alt text for the image. Defaults to "Phone Screenshot" if not provided.
- `zoomable` (boolean, default: false): If true, enables image zoom functionality on click with modal display.

**Features**:
- White phone body with gradient background (`#ffffff` to `#f8f8f8`)
- Transparent frame with 2px border for visibility
- No bezel design matching landing page style
- Images maintain natural aspect ratio (`object-fit: contain`)
- Default placeholder with "No Image" text when no image provided
- Dark mode support for phone body and border
- Notch indicator at top of frame
- Responsive sizing (280px default, adjusts on smaller screens)

**Default State**:
When no `image` prop is provided, displays a white background with centered icon and "No Image" text.

**Styling**:
- Phone body: `border-radius: 40px`, white gradient background
- Frame: `border-radius: 32px`, transparent with border
- Screen: `border-radius: 32px`, black background
- Image: Maintains aspect ratio, centered with flexbox

**Current Usage**:
- Android App Manual (`resources/views/android-app-manual.blade.php`)
- Landing Page (`resources/views/welcome.blade.php`)

---

### 3. **Table Card Component** (`<x-table-card>`)

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
- Transparent frosted glass background (`bg-white/50 backdrop-blur-sm`)
- Decorative blur circles in corners
- Rounded 2xl corners
- Responsive padding
- Colored shadow: `shadow-md shadow-{color}-100/50`
- Hover effects: `hover:shadow-lg hover:shadow-{color}-200/50 hover:border-{color}-300`
- Dark mode support
- Border on table container

---

### 3. **Stats Card Component** (`<x-stats-card>`)

**Purpose**: Display statistics with gradient background, icon, and animated bubble particles

**Usage**:
```blade
<x-stats-card 
    :title="__('Total Items')" 
    :count="$totalCount" 
    :description="__('Description text')"
    variant="blue|emerald|amber|violet|red">
    <x-slot:icon>
        <svg class="h-6 w-6 text-white">...</svg>
    </x-slot:icon>
</x-stats-card>
```

**Props**:
- `title` (string, required): Card title text
- `count` (string|number, required): The statistic number to display
- `description` (string, required): Description text below the count
- `variant` (string, default: "blue"): Color variant - `blue`, `emerald`, `amber`, `violet`, or `red`
- `icon` (slot, required): SVG icon element (should be `h-6 w-6`)

**Features**:
- Transparent frosted glass background (`bg-white/60 backdrop-blur-xl`)
- **Animated bubble particles** with floating animation
  - Middle section: Proper visible bubbles (opacity 60-70%, size 10-16px)
  - Side areas: Faded bubbles (opacity 20%, size 8px)
- Colored decorative blur circles (top-right and bottom-right, opacity 30%)
- Variant-based color scheme (gradient, borders, shadows, text colors)
- Rounded 2xl corners
- Compact icon container with gradient background (`rounded-xl p-3`)
- Reduced shadows: `shadow-md shadow-{color}-200/20`
- Hover effects: `hover:shadow-lg hover:shadow-{color}-300/25`
- Dark mode support with adjusted colors and shadows

**Color Variants**:
- `blue`: Blue to cyan gradient (Users)
- `emerald`: Emerald to teal gradient (Tasks)
- `amber`: Amber to orange gradient (Vehicles)
- `violet`: Violet to purple gradient (Notifications)
- `red`: Red to rose gradient (Alerts)

**Bubble Particles Animation**:
```css
@keyframes bubble-float {
    0%, 100% { transform: translateY(0) translateX(0) scale(1); opacity: 0.6; }
    25% { transform: translateY(-15px) translateX(10px) scale(1.1); opacity: 0.8; }
    50% { transform: translateY(-25px) translateX(-5px) scale(0.9); opacity: 0.7; }
    75% { transform: translateY(-10px) translateX(15px) scale(1.05); opacity: 0.75; }
}
```

**Bubble Particles Structure**:
- **Middle bubbles** (4 particles): Positioned in center area, higher opacity (60-70%), larger size
- **Side bubbles** (4 particles): Positioned at edges, lower opacity (20%), smaller size
- Animation durations: 6-9 seconds with staggered delays for natural movement

**Full Example**:
```blade
<x-stats-card 
    :title="__('Total Users')" 
    :count="$totalUsers" 
    :description="__('All registered users')" 
    variant="blue">
    <x-slot:icon>
        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
        </svg>
    </x-slot:icon>
</x-stats-card>
```

---

### 4. **Table Row Components** (Model-specific)

**Purpose**: Consistent table row styling for each model

**Examples**: `<x-user-table-row>`, `<x-task-table-row>`, `<x-vehicle-table-row>`

**Responsive Behavior**: Tables are shown below `lg` (1024px), cards are shown at `lg+` (1024px+)

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

### 4a. **Card Components** (Model-specific, for intermediate screens)

**Purpose**: Card-based layout for intermediate screen sizes (below 1536px) providing better readability and visual hierarchy, while maintaining table efficiency on very large screens (2XL+)

**Examples**: `<x-user-card>`, `<x-task-card>`

**Usage Pattern**:
```blade
<!-- Table View (2xl and above) -->
<div class="hidden 2xl:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <!-- Table content -->
    </table>
</div>

<!-- Stacked View (below 2xl) -->
<div class="2xl:hidden border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50 p-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @forelse($items as $item)
            <x-item-card :item="$item" :rounded="true" />
        @empty
            <div class="col-span-full p-12 text-center">
                <!-- Empty state -->
            </div>
        @endforelse
    </div>
</div>
```

**Card Structure Pattern**:
```blade
<div class="group relative overflow-hidden rounded-xl border border-{color}-200 bg-white/50 p-4 backdrop-blur-sm transition-all duration-200 hover:border-{color}-300 hover:shadow-lg dark:border-{color}-900/50 dark:bg-gray-800/50 dark:hover:border-{color}-800">
    <div class="flex flex-col gap-4">
        <!-- Header: Main info + Actions -->
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <!-- Title/Name -->
                <h3 class="text-base font-bold text-gray-900 dark:text-white break-words">{{ $item->title }}</h3>
                <!-- Optional description/subtitle -->
            </div>
            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                <!-- Badges (Priority, Status, etc.) -->
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <!-- Detail items with icons -->
        </div>

        <!-- Actions Footer -->
        <div class="flex items-center justify-end border-t border-gray-200/50 pt-3 dark:border-gray-700/50">
            <flux:button size="sm" variant="ghost" @click="openModal({{ $item->id }})" icon="pencil" class="opacity-50 transition-opacity group-hover:opacity-100">
                {{ __('Edit') }}
            </flux:button>
        </div>
    </div>
</div>
```

**Key Features**:
- Card borders match variant color (blue, emerald, violet, amber)
- Hover effects: border color change and shadow
- Frosted glass effect (`bg-white/50 backdrop-blur-sm`)
- Dark mode support
- Consistent spacing with `gap-4`
- Details in responsive grid (1 column on small, 2 columns on sm+)
- Time badges use dark background (`bg-accent/90`) with white text for emphasis
- Cards displayed in responsive grid below `2xl` breakpoint
- `rounded` prop controls border radius (default: `true`, set to `false` for list layouts)
- All text elements use `whitespace-nowrap` to prevent wrapping
- Long text uses `truncate` for overflow handling

**Time Badge Pattern** (for tasks):
```blade
<div class="inline-flex items-center gap-1.5 rounded-sm bg-accent/90 px-2 py-1 shadow-sm">
    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="text-sm font-semibold text-white">{{ $time }}</span>
</div>
```

**Card Props**:
- `rounded` (boolean, default: `true`): Controls whether card has rounded corners
  - `true`: Rounded corners (`rounded-xl`) for grid layouts
  - `false`: No rounded corners for vertical list layouts

**Breakpoints**:
- Below `2xl` (below 1536px): Stacked card layout in responsive grid
  - 1 column below `lg` (below 1024px)
  - 2 columns at `lg` and above (1024px+)
- `2xl` (1536px+) and above: Table layout

---

### 5. **Preview Modal Component Pattern** (Livewire)

**Purpose**: Center dialog modal for displaying read-only item details with action buttons

**Structure**:
```blade
<div>
    <!-- Backdrop -->
    <div x-data="{ open: @entangle('open') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">

        <!-- Background overlay -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <!-- Modal Container -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative w-full max-w-4xl transform overflow-hidden rounded-2xl bg-gradient-to-br from-{color}-50 via-white to-{color2}-50 shadow-2xl dark:from-{color}-900/20 dark:via-gray-900 dark:to-{color2}-900/20"
                 @click.away="open = false">
                <!-- Decorative Elements (on parent) -->
                <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-{color}-400/20 to-{color2}-400/20 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-{color2}-400/20 to-{color}-400/20 blur-2xl"></div>

                <!-- Content -->
                <div class="relative max-h-[90vh] overflow-y-auto p-6 pb-20">
                    <!-- Item Preview Card (transparent to show parent gradient) -->
                    <div class="relative overflow-hidden rounded-xl border border-{color}-200/50 bg-white/50 p-6 mb-3 backdrop-blur-sm dark:border-{color}-800/50 dark:bg-gray-800/50">
                        <!-- Item details display -->
                    </div>
                </div>

                <!-- Action Buttons (Separated: Close on Left, Edit/Delete on Right) -->
                <div class="absolute bottom-0 left-0 right-0 flex items-center justify-between gap-3 border-t border-{color}-200/30 bg-white/60 px-4 py-3 backdrop-blur-md dark:border-{color}-800/30 dark:bg-gray-900/60">
                    <!-- Close Button (Left) -->
                    <button wire:click="closePreview" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-gray-500/60 bg-gray-600/20 backdrop-blur-sm px-3 py-2 transition-all duration-200 hover:border-gray-400 hover:bg-gray-500/30 hover:shadow-lg hover:shadow-gray-500/40">
                        <svg class="h-4 w-4 text-gray-700 dark:text-gray-200 transition-all duration-200 group-hover:text-gray-900 dark:group-hover:text-white group-hover:drop-shadow-[0_0_6px_rgba(156,163,175,0.9)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="ml-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 group-hover:text-gray-900 dark:group-hover:text-white">{{ __('Close') }}</span>
                    </button>

                    <!-- Edit and Delete Buttons (Right) -->
                    <div class="flex items-center gap-2">
                        <!-- Edit Button (cyan) -->
                        <button wire:click="editItem" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-500/70 bg-cyan-600/20 backdrop-blur-sm px-3 py-2 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/30 hover:shadow-lg hover:shadow-cyan-500/50">
                            <svg class="h-4 w-4 text-cyan-700 dark:text-cyan-200 transition-all duration-200 group-hover:text-cyan-900 dark:group-hover:text-cyan-100 group-hover:drop-shadow-[0_0_6px_rgba(6,182,212,0.9)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span class="ml-1.5 text-xs font-semibold text-cyan-700 dark:text-cyan-200 group-hover:text-cyan-900 dark:group-hover:text-cyan-100">{{ __('Edit') }}</span>
                        </button>

                        <!-- Delete Button (red, conditional) -->
                        @if($this->canDelete())
                            <button @click="window.confirmDelete(...).then(...)" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-500/70 bg-red-600/20 backdrop-blur-sm px-3 py-2 transition-all duration-200 hover:border-red-400 hover:bg-red-500/30 hover:shadow-lg hover:shadow-red-500/50">
                                <svg class="h-4 w-4 text-red-700 dark:text-red-200 transition-all duration-200 group-hover:text-red-900 dark:group-hover:text-red-100 group-hover:drop-shadow-[0_0_6px_rgba(239,68,68,0.9)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                <span class="ml-1.5 text-xs font-semibold text-red-700 dark:text-red-200 group-hover:text-red-900 dark:group-hover:text-red-100">{{ __('Delete') }}</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

**Features**:
- Center dialog modal (not side panel)
- Max width: `max-w-4xl`
- Scale animation on open/close
- **Gradient on parent container** (not on preview card) matching variant color
- **Transparent preview card** (`bg-white/50`) to show parent gradient through
- **No shadow on preview card** (removed for cleaner look)
- Decorative blur circles on parent container
- **Separated button layout**: Close button on left, Edit/Delete buttons on right
- **Smaller buttons**: `px-3 py-2` padding, `h-4 w-4` icons, `text-xs` text
- **High contrast button text**: `text-gray-700 dark:text-gray-200` for Close, `text-cyan-700 dark:text-cyan-200` for Edit, `text-red-700 dark:text-red-200` for Delete
- **Glowing borders and blurry backgrounds**: `backdrop-blur-sm` on buttons, enhanced shadows with glow effects
- **Preview card margin**: `mb-3` (half of top padding `p-6`)
- Action buttons at bottom: Edit (cyan), Close (gray), Delete (red, conditional)
- Delete button only shown if `canDelete()` returns true
- Integrated with SweetAlert2 for delete confirmation

**Color Variants**:
- **Users/Ports**: Blue/cyan gradient (`from-blue-50 via-white to-cyan-50`)
- **Tasks**: Emerald/teal gradient (`from-emerald-50 via-white to-teal-50`)
- **Shipping Companies**: Indigo/purple gradient (`from-indigo-50 via-white to-purple-50`)

**Key Design Principles**:
- **Parent has gradient, child is transparent**: Gradient applied to modal container, preview card uses `bg-white/50` to show gradient through
- **No shadows on preview card**: Clean, flat design that blends with parent
- **Button separation**: Close button separated from action buttons for better UX
- **Readable button text**: Darker text colors (`text-{color}-700`) for better contrast on blurry backgrounds

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

---

### 5a. **Modal Component Pattern** (Livewire)

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
                 class="w-screen max-w-xl bg-white/60 backdrop-blur-xl dark:bg-gray-800/60">

                <div class="flex h-full flex-col overflow-y-auto border-l border-emerald-300/50 bg-white/60 shadow-xl shadow-emerald-200/40 backdrop-blur-xl dark:border-emerald-800/50 dark:bg-gray-800/60 dark:shadow-emerald-900/30">
                    <!-- Decorative Elements -->
                    <div class="pointer-events-none absolute -right-8 -top-8 h-64 w-64 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-400/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-8 -left-8 h-64 w-64 rounded-full bg-gradient-to-br from-teal-400/20 to-emerald-400/20 blur-3xl"></div>

                    <!-- Header -->
                    <div class="relative border-b border-gray-200/50 bg-white/50 px-6 py-6 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
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
                        <div class="border-t border-gray-200/50 px-6 py-4 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
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

### 6. **Action Buttons with Permissions Pattern**

**Purpose**: View, Edit, and Delete buttons with role-based permission checks

**Button Colors by Module**:
- **Users**: View (blue-700), Edit (cyan-700), Delete (red-700)
- **Tasks**: View (emerald-700), Edit (cyan-700), Delete (red-700)

**Table Row Pattern**:
```blade
<td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
    <div class="flex items-center gap-1.5 md:gap-2">
        @php
            $currentUser = auth()->user();
            $canDelete = $currentUser && in_array($currentUser->role, ['admin', 'manager']) 
                && !($currentUser->role === 'manager' && ($currentUser->id === $item->id || $item->role === 'admin'));
        @endphp

        <!-- View Button -->
        <button @click="openPreview({{ $item->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-{color}-700/60 bg-{color}-500/10 p-1.5 transition-all duration-200 hover:border-{color}-700 hover:bg-{color}-500/20 hover:shadow-lg hover:shadow-{color}-700/30" title="{{ __('View') }}">
            <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-{color}-700 transition-all duration-200 group-hover:text-{color}-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>

        <!-- Edit Button -->
        <button @click="openModal({{ $item->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-700/60 bg-cyan-500/10 p-1.5 transition-all duration-200 hover:border-cyan-700 hover:bg-cyan-500/20 hover:shadow-lg hover:shadow-cyan-700/30" title="{{ __('Edit') }}">
            <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-cyan-700 transition-all duration-200 group-hover:text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
        </button>

        <!-- Delete Button (conditional) -->
        @if($canDelete)
            @php
                // Check for child records that will be cascade deleted OR have foreign keys set to null
                
                // Example 1: Cascade Delete (Schedule → Stopovers)
                // $stopoverCount = $item->stopovers()->count();
                // $warnings = [];
                // if ($stopoverCount > 0) {
                //     $warnings[] = __(':count stopover(s)', ['count' => $stopoverCount]);
                // }
                
                // Example 2: Null On Delete (Vendor → Users/Vehicles)
                // $userCount = $vendor->users()->count();
                // $vehicleCount = $vendor->vehicles()->count();
                // $warnings = [];
                // if ($userCount > 0) {
                //     $warnings[] = __(':count user(s) will have their vendor association removed', ['count' => $userCount]);
                // }
                // if ($vehicleCount > 0) {
                //     $warnings[] = __(':count vehicle(s) will have their vendor association removed', ['count' => $vehicleCount]);
                // }
                
                // Example 3: Multiple Column References (Shipping Company → Schedules)
                // $scheduleCount = \App\Models\Schedule::where('carrier_1_id', $shippingCompany->id)
                //     ->orWhere('carrier_2_id', $shippingCompany->id)
                //     ->orWhere('carrier_3_id', $shippingCompany->id)
                //     ->count();
                // $warnings = [];
                // if ($scheduleCount > 0) {
                //     $warnings[] = __(':count schedule(s) will have their carrier reference removed', ['count' => $scheduleCount]);
                // }
                
                $warnings = []; // Calculate warnings based on relationships
            @endphp
            <button @click="window.confirmDelete({{ $item->id }}, '{{ addslashes($item->name) }}', @js($warnings)).then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-item', { itemId: {{ $item->id }} }) } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 transition-all duration-200 hover:border-red-700 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-700/30" title="{{ __('Delete') }}">
                <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-red-700 transition-all duration-200 group-hover:text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
        @endif
    </div>
</td>
```

**Permission Rules**:
- **Delete Users**: Only `admin` or `manager` can delete
  - Manager cannot delete their own account
  - Manager cannot delete admin accounts
- **Delete Tasks**: Only `admin` or `manager` can delete
- **UI Visibility**: Delete buttons are hidden if user doesn't have permission

**Child Record Warnings**:
- Before deletion, check for child records that will be cascade deleted OR have foreign keys set to null
- Pass warnings array to `confirmDelete()` function using `@js()` helper
- Warnings are displayed in an amber-colored alert box within the SweetAlert2 confirmation dialog
- Example warning messages for cascade delete:
  - `__(':count stopover(s)', ['count' => $stopoverCount])`
  - `__(':count attachment(s)', ['count' => $attachmentCount])`
  - `__(':count schedule(s)', ['count' => $scheduleCount])`
- Example warning messages for nullOnDelete (data integrity):
  - `__(':count user(s) will have their vendor association removed', ['count' => $userCount])`
  - `__(':count vehicle(s) will have their vendor association removed', ['count' => $vehicleCount])`
  - `__(':count schedule(s) will have their carrier reference removed', ['count' => $scheduleCount])`
- Warnings are informational - deletion still proceeds if user confirms
- Warnings apply to both cascade delete relationships AND nullOnDelete relationships (for data integrity awareness)

**Entities with Delete Warnings**:
- **Schedule deletion**: Warns about stopovers (cascade delete)
- **Port deletion**: Warns about schedules and stopovers (cascade delete)
- **User deletion**: Warns about notices, schedules, stopovers (cascade delete)
- **Task deletion**: Warns about attachments (cascade delete)
- **Vehicle deletion**: Warns about photos and consignee details (cascade delete)
- **Vendor deletion**: Warns about users and vehicles that will have vendor_id set to null (nullOnDelete)
- **Shipping Company deletion**: Warns about schedules that reference the company as a carrier (nullOnDelete)

**Key Features**:
- Small icon-only buttons in table rows (`p-1.5`, `h-3.5 w-3.5 md:h-4 md:w-4`)
- Outline border style with semi-transparent background
- Hover effects: border color change, background opacity increase, shadow
- Integrated with SweetAlert2 for delete confirmation with child record warnings
- No opacity transitions (opacity-100 by default)
- No inner shadow effects on icons
- Integrated with SweetAlert2 for delete confirmation
- Permission checks in Blade using `@php` blocks

**Card View Pattern**:
Same button structure but with slightly larger padding (`p-2`) and icon size (`h-4 w-4`) for better touch targets.

**Delete Event Listener Pattern**:
When implementing delete functionality, use flexible parameter handling in Livewire event listeners to avoid dependency injection issues:

```php
#[On('delete-item')]
public function deleteItem($itemId = null, ?ItemService $itemService = null): void
{
    // Handle both direct itemId parameter and object/array with itemId property
    if (is_array($itemId)) {
        $itemId = $itemId['itemId'] ?? null;
    } elseif (is_object($itemId)) {
        $itemId = $itemId->itemId ?? null;
    }

    if (! $itemId) {
        return;
    }

    try {
        if (! $itemService) {
            $itemService = app(ItemService::class);
        }
        $item = $itemService->getById($itemId);
        $itemService->delete($item);
        $this->dispatch('notify', message: __('Item deleted successfully.'), type: 'success');
    } catch (\Exception $e) {
        \Log::error('Item delete error: '.$e->getMessage());
        $this->dispatch('notify', message: __('An error occurred while deleting the item.'), type: 'error');
    }
}
```

**Key Points**:
- ✅ Use flexible first parameter that accepts scalar, array, or object
- ✅ Extract ID from different formats
- ✅ Use optional nullable service parameter
- ✅ Resolve service manually if not provided
- ✅ Early return if ID is missing
- ✅ Wrap in try-catch for error handling
- ❌ Do NOT use strict `array $payload` type hint with dependency injection

**Applied To**:
- All delete event listeners in Livewire Index components
- See ARCHITECTURE.md for complete implementation details

---

### 7. **Toast Notification Component** (`<x-toast-notification>`)

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

### **Table Structure Standards**

All tables in the application follow these standards:

1. **S/N Column (Serial Number)**
   - Always the first column in every table
   - Width: `w-16` (fixed)
   - Alignment: `text-center`
   - Displays paginated index: `$items->firstItem() + $index`
   - Styling: `text-xs md:text-sm font-semibold text-gray-600 dark:text-gray-400`

2. **Actions Column**
   - Always the last column in every table
   - Width: `w-32` (fixed) - prevents excessive space usage
   - Alignment: `text-center`
   - Contains action buttons (View, Edit, Delete) with consistent spacing

### **S/N Column Implementation**

```blade
<!-- Table Header -->
<th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-16">
    {{ __('S/N') }}
</th>

<!-- Table Row -->
<td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 text-center">
    <span class="text-xs md:text-sm font-semibold text-gray-600 dark:text-gray-400">{{ $items->firstItem() + $index }}</span>
</td>

<!-- In Blade Loop -->
@forelse($items as $index => $item)
    <x-item-table-row :item="$item" :index="$items->firstItem() + $index" wire:key="item-{{ $item->id }}" />
@empty
    <!-- Empty state -->
@endforelse
```

### **Actions Column Implementation**

```blade
<!-- Table Header -->
<th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-32">
    {{ __('Actions') }}
</th>

<!-- Table Row -->
<td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 w-32">
    <div class="flex justify-center items-center gap-1.5 md:gap-2">
        <!-- Action buttons -->
    </div>
</td>
```

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

## 📄 Pagination

### **Overview**
Pagination uses a **blue color scheme** throughout the application for consistency. The pagination views are published to `resources/views/vendor/livewire/` for Livewire components and `resources/views/vendor/pagination/` for standard Laravel pagination.

### **Selected/Active Page Styling**
The selected page index uses a solid blue background with white text:

```blade
<!-- Active page number -->
<span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-white bg-blue-600 border border-blue-600 leading-5 dark:bg-blue-600 dark:border-blue-600">
    {{ $page }}
</span>
```

### **Non-Selected Page Styling**
Non-active pages have white background with hover states:

```blade
<!-- Inactive page number -->
<button class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-300 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-blue-100 active:text-blue-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-blue-900/20 dark:hover:text-blue-300 dark:hover:border-blue-700 dark:active:bg-blue-900/30 dark:focus:border-blue-800">
    {{ $page }}
</button>
```

### **Previous/Next Button Styling**
Navigation buttons use blue text with matching hover states:

```blade
<!-- Active Previous/Next button -->
<button class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-300 rounded-l-md leading-5 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-300 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-blue-100 active:text-blue-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-blue-400 dark:hover:bg-blue-900/20 dark:active:bg-blue-900/30 dark:focus:border-blue-800">
    <!-- Arrow SVG -->
</button>

<!-- Disabled Previous/Next (on first/last page) -->
<span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600">
    <!-- Arrow SVG -->
</span>
```

### **Color Reference Table**

| Element | Light Mode | Dark Mode |
|---------|-----------|-----------|
| Active Page BG | `bg-blue-600` | `dark:bg-blue-600` |
| Active Page Border | `border-blue-600` | `dark:border-blue-600` |
| Active Page Text | `text-white font-bold` | `text-white` |
| Inactive Hover BG | `hover:bg-blue-50` | `dark:hover:bg-blue-900/20` |
| Inactive Hover Text | `hover:text-blue-700` | `dark:hover:text-blue-300` |
| Inactive Hover Border | `hover:border-blue-300` | `dark:hover:border-blue-700` |
| Focus Ring | `ring-blue-300` | `ring-blue-300` |
| Nav Button Text | `text-blue-600` | `dark:text-blue-400` |

### **Published View Files**
- **Livewire pagination**: `resources/views/vendor/livewire/tailwind.blade.php`
- **Livewire simple pagination**: `resources/views/vendor/livewire/simple-tailwind.blade.php`
- **Laravel pagination**: `resources/views/vendor/pagination/tailwind.blade.php`
- **Laravel simple pagination**: `resources/views/vendor/pagination/simple-tailwind.blade.php`

### **Usage in Blade Views**
```blade
<!-- Standard Livewire pagination (uses published views automatically) -->
<div class="mt-4">
    {{ $items->links() }}
</div>
```

### **Important Notes**
1. **Do NOT use emerald/green colors** for pagination - always use blue
2. All pagination buttons should have `cursor-pointer` for clickable states
3. Disabled states use `cursor-default` with muted gray colors
4. Always include dark mode variants for all states

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

### **Performance Optimization: Preventing Flashing During Navigation**

The application implements CSS optimizations to prevent visual flashing (FOUC - Flash of Unstyled Content) during Livewire navigation, especially in light mode. This ensures smooth page transitions without border, shadow, or background color flashing.

**Problem**: During Livewire navigation, elements with `transition-all` would animate border colors, shadows, and backgrounds, causing a visible flash as styles were applied.

**Solution**: CSS rules disable border and shadow transitions during initial page load and navigation, then re-enable them after the page is fully loaded using the `page-loaded` class.

**Implementation** (in `resources/css/app.css`):

```css
/* Light Mode: Disable border and shadow transitions during navigation */
html:not(.dark) .page-card,
html:not(.dark) .dashboard-card,
html:not(.dark) .welcome-card {
    transition-property: transform, opacity !important;
    /* border-color and box-shadow excluded during load */
}

/* Re-enable after page is loaded */
html:not(.dark) .page-loaded .page-card {
    transition-property: transform, opacity, box-shadow, border-color !important;
}

/* Dark Mode: Similar pattern but allows border/shadow transitions */
.dark .page-card {
    transition-property: transform, opacity, box-shadow, border-color !important;
}
```

**JavaScript Integration** (in `resources/views/components/layouts/app/sidebar.blade.php`):

```javascript
// Add page-loaded class after page loads
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => document.body.classList.add('page-loaded'), 100);
});

// Remove during Livewire navigation
document.addEventListener('livewire:navigating', function() {
    document.body.classList.remove('page-loaded');
});

// Re-add after navigation completes
document.addEventListener('livewire:navigated', function() {
    setTimeout(() => document.body.classList.add('page-loaded'), 150);
});
```

**Affected Elements**:
- ✅ Cards (`.page-card`, `.dashboard-card`, `.welcome-card`)
- ✅ Table rows (`table tbody tr`)
- ✅ Headers (`flux-header`, `[data-flux-header]`)
- ✅ Sidebars (`flux-sidebar`, `[data-flux-sidebar]`)
- ✅ Table headers (`table thead tr`, `table thead th`)

**Key Points**:
- Light mode: Border and shadow transitions are disabled during navigation
- Dark mode: Border and shadow transitions are allowed (less visible flashing)
- All transitions re-enable after `page-loaded` class is added
- Hover effects work normally after page is loaded
- Works seamlessly with Livewire's `wire:navigate` directive

**When Adding New Components**:
If creating new components with borders/shadows that flash during navigation, apply the same pattern:
1. Disable `box-shadow` and `border-color` in transition properties during load
2. Re-enable them when `.page-loaded` class is present
3. Use `html:not(.dark)` selector for light mode specific rules

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

### Landing Page Pattern
- Added landing page pattern with hero section and side-by-side layout
- Microsoft Surface-style monitor mockup (white frame, minimal stand)
- Phone mockup without black bezel, transparent frame
- Vertical separator lines (|) between navigation menu items
- Mobile hamburger menu with dropdown for small screens (below 768px)
- Desktop horizontal menu for tablet and larger screens (768px+)
- Alpine.js-powered mobile menu toggle with smooth slide animations
- Particle background animation with increased density (divisor: 8000)
- Responsive design: features and screenshots side-by-side on desktop, stacked on mobile
- Logo component integration with hover effects

### Preview Modal & Permission System
- Added center dialog preview modals for Users and Tasks
- Implemented role-based permission system for delete actions
- Added View, Edit, Delete action buttons with permission checks
- Manager restrictions: cannot delete own account or admin accounts
- Delete buttons conditionally rendered based on user permissions
- Integrated SweetAlert2 for delete confirmations
- Color-coded buttons: View (module color), Edit (cyan), Delete (red)

### Particle Background System
- Added canvas-based animated particle background system
- Multi-color palette with automatic dark mode adaptation
- Gradient connection lines between particles (opacity: 0.3)
- Responsive particle count based on screen size
- Enabled only on Landing page, Dashboard, Admin Manual, Android Manual, and API Docs
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
- Added Created At and Updated At columns with date and time
- Improved date formatting: shows date on first line, time on second line
- All Tasks table: Title column is 25% width, all text uses `xs` size
- All Tasks table: Time shown below date in Work Date column
- User table: Created At and Updated At both show date and time
- User card: Created At and Updated At use responsive layout, light gray color, smaller font (`text-xs`)

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
- Chart canvas and status labels sit inside a flex container with `lg:justify-center lg:gap-16` to keep both elements centered with an even, generous gap on large screens
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

### Members Card Vendor Column (Dashboard)
The dashboard **Members** card now shows per-user vendor information alongside role and email.

- **Query**: Members are loaded with vendor using `User::with('vendor')->latest()->limit(5)->get()`.
- **Desktop table layout (lg+)**:
  - Columns: **Member**, **Role**, **Vendor**, **Email**
  - Member column shows avatar, name, and **Member since** in `text-xs text-gray-500`.
  - Role column uses the standard role badge pattern: `flux:badge` with `size="sm"` and `class="font-semibold text-xs w-20 justify-center"`.
  - Vendor column:
    - Shows vendor name in `text-xs text-gray-900 dark:text-white`.
    - Falls back to a muted dash (`-`) in `text-gray-400 dark:text-gray-500` when no vendor is assigned.
- **Mobile / stacked layout (below lg)**:
  - Header still shows name + “Member since”.
  - Detail row shows:
    - Email with envelope icon.
    - Role badge using the standard role badge pattern.
    - Vendor name (when present) with a small building icon and `text-xs text-gray-600 dark:text-gray-400`.

This pattern should be reused for any future dashboard cards that need to surface vendor context without losing the original “Member since” metadata.

### Responsive Card Layout Pattern
For data tables that need better readability on intermediate screen sizes, implement a three-tier layout system:
- **Below 2xl (below 1536px)**: Stacked card layout in responsive grid
  - 1 column below `lg` (below 1024px)
  - 2 columns at `lg` and above (1024px+)
- **2xl (1536px+) and above**: Traditional table layout

**Implementation**:
1. Create a card component (e.g., `<x-user-card>`, `<x-task-card>`) following the card structure pattern
2. Show table with `hidden 2xl:block` classes (hidden below 2xl, shown at 2xl+)
3. Show stacked cards with `2xl:hidden` classes (shown below 2xl, hidden at 2xl+)
4. Wrap cards in a grid container: `grid grid-cols-1 lg:grid-cols-2 gap-4`
5. Add padding to card container: `p-4`
6. Pass `rounded="true"` prop to cards in grid layout
7. Ensure both views have proper `wire:key` attributes for Livewire reactivity
8. Use `col-span-full` for empty states in grid layout

**Benefits**:
- Better readability on intermediate screen sizes (tablet landscape, XL monitors)
- More visual hierarchy with card-based design
- Maintains table efficiency on very large screens (2XL+)
- Responsive grid adapts to screen size (1 column on mobile, 2 columns on tablet+)
- Standard Tailwind breakpoints (no custom fixed sizes)

**Text Handling in Cards**:
- All text elements use `whitespace-nowrap` to prevent wrapping
- Long text (names, emails, titles) use `truncate` for overflow handling
- Date/time fields use `whitespace-nowrap` for consistent display

**Current Usage**:
- Users Management (`livewire.users.index`)
- All Tasks (`livewire.tasks.all-tasks`)
- Today's Tasks (`livewire.tasks.today-tasks`)

---

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
- Enabled only on Landing page, Dashboard, Admin Manual, Android Manual, and API Docs

### Responsive Card Layout System
- Three-tier layout system: stacked cards below 2xl (1536px), table at 2xl+
- Card-based layout optimized for intermediate screen sizes (tablet landscape, XL monitors)
- Cards displayed in responsive grid: 1 column below lg, 2 columns at lg+
- Time badges use dark background (`bg-accent/90`) with white text
- Applied to Users, All Tasks, and Today's Tasks modules
- Uses standard Tailwind breakpoints: `lg` (1024px) for grid columns, `2xl` (1536px) for table switch
- Cards have `rounded` prop: `true` for grid layouts, `false` for list layouts
- All text elements use `whitespace-nowrap` with `truncate` for long text

### Page Header Icon Responsive Fix
- Icon container in page-header component uses `flex-shrink-0` to prevent shrinking on responsive screens
- Maintains consistent 56x56px (h-14 w-14) icon background size on all screen sizes
- Prevents icon background from becoming 28x56px on smaller screens
- Applied to all pages using the page-header component (Android App Manual, Admin Manual, API Manual, etc.)

### Phone Mockup Component
- Created reusable `<x-phone-mockup>` component for displaying app screenshots
- Accepts `image`, `alt`, and `zoomable` props
- Shows default "No Image" placeholder when no image provided
- White phone body with transparent frame and no bezel design
- Images maintain natural aspect ratio with `object-fit: contain`
- Matches landing page phone-mockup styling
- All phone-mockup instances in Android App Manual replaced with component

### Preview Modal System
- Center dialog modals for read-only item previews
- **Gradient on parent container** (not on preview card) matching module variant colors
- **Transparent preview card** (`bg-white/50`) to show parent gradient through, matching table card pattern
- **No shadow on preview card** for cleaner appearance
- **Separated button layout**: Close button on left, Edit/Delete buttons grouped on right
- **Smaller, high-contrast buttons**: `px-3 py-2` padding, `h-4 w-4` icons, `text-xs` text with darker colors (`text-{color}-700`) for readability
- **Glowing borders and blurry backgrounds**: Enhanced visual effects with `backdrop-blur-sm` on buttons and glow shadows on hover
- **Preview card margin**: `mb-3` (half of top padding `p-6`) for balanced spacing
- Action buttons: Edit (cyan), Close (gray), Delete (red, conditional)
- Permission-based delete button visibility
- Integrated with SweetAlert2 for delete confirmations
- Applied to Users, Tasks, Ports, and Shipping Companies modules

### Preview Modal System Updates (v2.13)
- **Gradient moved to parent container**: Parent modal container now has gradient, preview card is transparent
- **Transparent preview cards**: Changed from `bg-white/80` to `bg-white/50` to match table card pattern and show parent gradient through
- **Removed shadows**: Preview cards no longer have `shadow-lg` for cleaner appearance
- **Separated button layout**: Close button positioned on left, Edit/Delete buttons grouped on right
- **Smaller, high-contrast buttons**: Reduced button size (`px-3 py-2`, `h-4 w-4` icons, `text-xs` text) with darker text colors for better readability
- **Enhanced button styling**: Added glowing borders (`border-{color}-500/70`), blurry backgrounds (`backdrop-blur-sm`), and glow shadows on hover
- **Balanced spacing**: Preview card bottom margin set to `mb-3` (half of top padding)
- Applied to all preview dialogs: Users, Tasks, Ports, Shipping Companies

### Permission-Based UI System
- Role-based permission checks for delete actions
- Only admin/manager can delete users and tasks
- Manager restrictions: cannot delete own account or admin accounts
- Delete buttons conditionally rendered based on permissions
- Permission checks implemented in both component methods and Blade templates

### "How It Works" Bullet Points Pattern
- Card-based design with rounded circular serial numbers matching section variant colors
- Color matching system: Emerald for Vehicle Search, Purple for Task Management, Blue for Team Communication
- Responsive 3-column grid layout (1 column mobile, 3 columns desktop)
- Dark mode support for all color variants
- Consistent spacing with `mt-8` margin before Keypoints sections
- Applied to Android App Manual "How It Works" sections

### Android App Manual Pattern
For documentation pages that display app features with instructions and screenshots, use an alternating side-by-side layout pattern.

**Structure**:
```blade
<div class="grid gap-6 lg:grid-cols-2 lg:items-center">
    @if($screenshotOnLeft)
        <!-- Screenshot on Left -->
        <div class="flex justify-center lg:justify-start order-2 lg:order-1">
            <x-phone-mockup 
                image="assets/app-manual/screenshot.jpg"
                :alt="__('Screenshot Description')"
                zoomable="true" />
        </div>
        <!-- Instructions on Right -->
        <div class="space-y-4 order-1 lg:order-2">
    @else
        <!-- Instructions on Left -->
        <div class="space-y-4">
    @endif
    
    <!-- Step-by-step instructions or content -->
    
    </div>
    
    @if(!$screenshotOnLeft)
        <!-- Screenshot on Right -->
        <div class="flex justify-center lg:justify-end order-2">
            <x-phone-mockup 
                image="assets/app-manual/screenshot.jpg"
                :alt="__('Screenshot Description')"
                zoomable="true" />
        </div>
    @endif
</div>
```

**Key Features**:
- **Alternating Layout**: Screenshots alternate between left and right sides for visual variety
- **Responsive Design**: Stacked on mobile (`order-2 lg:order-1`), side-by-side on desktop (`lg:grid-cols-2`)
- **Phone Mockup**: Screenshots wrapped in smartphone mockup frames (not for banner images like feature.png)
- **Section Index Tracking**: Use `$sectionIndex` to alternate positions: `$screenshotOnLeft = ($sectionIndex % 2 === 0)`
- **Instructions Format**: Step-by-step instructions displayed in cards with numbered badges
- **Feature Image**: Banner images (1024x512) displayed without phone mockup, side-by-side with feature list

**Introduction Section Pattern**:
```blade
<div class="grid gap-6 lg:grid-cols-2 lg:items-center">
    <!-- Features List -->
    <div class="space-y-4">
        <h3>{{ __('Key Features') }}</h3>
        @foreach($features as $feature)
            <div class="flex items-start gap-3 rounded-xl border p-4">
                <div class="icon-badge">{{ $feature['icon'] }}</div>
                <h4>{{ $feature['name'] }}</h4>
            </div>
        @endforeach
    </div>
    
    <!-- Feature Banner Image (No Phone Mockup) -->
    <div class="flex justify-center lg:justify-end">
        <div class="w-full max-w-lg rounded-xl border shadow-lg">
            <img src="feature.png" class="w-full h-auto" />
        </div>
    </div>
</div>
```

**Use Cases**:
- Android App Manual pages
- Feature documentation with screenshots
- Step-by-step guides with visual aids
- Any documentation requiring alternating content layout

**Current Usage**:
- Android App Manual (`resources/views/android-app-manual.blade.php`)

### "How It Works" Bullet Points Pattern
For step-by-step instructions in documentation pages, use a card-based design with rounded circular serial numbers that match the section's variant color.

**Structure**:
```blade
<div class="grid grid-cols-1 gap-6 md:grid-cols-3">
    <div class="space-y-3 flex flex-col items-center">
        <x-phone-mockup 
            image="assets/app-manual/screenshot.jpg"
            :alt="__('Screenshot Description')"
            zoomable="true" />
        <div class="w-full space-y-2">
            <div class="flex gap-3 rounded-lg bg-{color}-50 p-3 dark:bg-{color}-900/20">
                <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-{color}-500 bg-{color}-100 text-sm font-bold text-{color}-600 dark:border-{color}-400 dark:bg-{color}-900/40 dark:text-{color}-400">1</div>
                <p class="flex-1 text-sm text-gray-700 dark:text-gray-300">
                    {{ __('Step description text') }}
                </p>
            </div>
            <!-- Repeat for steps 2, 3, etc. -->
        </div>
    </div>
    <!-- Repeat for additional columns -->
</div>
```

**Color Variants by Section**:
- **Emerald** (`emerald-50`, `emerald-500`, `emerald-600`): Vehicle Search & Photo Upload sections
- **Purple** (`purple-50`, `purple-500`, `purple-600`): Task & Schedule Management sections
- **Blue** (`blue-50`, `blue-500`, `blue-600`): Team Communication sections

**Key Features**:
- **Card-based Design**: Each step is in a rounded card with background color matching section variant
- **Rounded Circular Badges**: Numbered badges (1, 2, 3) with border and background matching card color
- **Color Matching**: Bullet point colors automatically match the section's `<x-table-card variant="">` color
- **Responsive Grid**: 1 column on mobile, 3 columns on desktop (`md:grid-cols-3`)
- **Dark Mode Support**: All colors have dark mode variants
- **Consistent Spacing**: `space-y-2` between cards, `gap-3` between badge and text
- **Flex Layout**: Badge and text use flexbox for proper alignment

**Color Class Mapping**:
```blade
<!-- Emerald (Vehicle Search) -->
bg-emerald-50 dark:bg-emerald-900/20
border-emerald-500 dark:border-emerald-400
bg-emerald-100 dark:bg-emerald-900/40
text-emerald-600 dark:text-emerald-400

<!-- Purple (Task Management) -->
bg-purple-50 dark:bg-purple-900/20
border-purple-500 dark:border-purple-400
bg-purple-100 dark:bg-purple-900/40
text-purple-600 dark:text-purple-400

<!-- Blue (Team Communication) -->
bg-blue-50 dark:bg-blue-900/20
border-blue-500 dark:border-blue-400
bg-blue-100 dark:bg-blue-900/40
text-blue-600 dark:text-blue-400
```

**Keypoints Section Spacing**:
Add `mt-8` margin-top to the Keypoints container for proper spacing before the "Key Features" section:
```blade
<!-- Keypoints -->
<div class="mt-8 space-y-4 w-full max-w-md">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Key Features') }}</h3>
    <!-- Feature list -->
</div>
```

**Use Cases**:
- Step-by-step instructions in app manuals
- Feature documentation with numbered steps
- How-to guides with visual instructions
- Any documentation requiring sequential numbered steps

**Current Usage**:
- Android App Manual (`resources/views/android-app-manual.blade.php`)

### Landing Page Pattern
For the main landing/welcome page, use a hero section with side-by-side features and device screenshots, featuring animated particle background and modern navigation.

**Structure**:
```blade
<!-- Top Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 border-b border-gray-200/50 bg-white/95 backdrop-blur-md dark:border-gray-800/50 dark:bg-gray-900/95 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="mx-auto max-w-7xl px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-8">
                <!-- Logo (using app-logo component) -->
                <a href="{{ route('home') }}" class="flex items-center group">
                    <div class="transition-transform group-hover:scale-105">
                        <x-app-logo />
                    </div>
                </a>
                
                <!-- Desktop Menu Items with Vertical Separators -->
                <div class="hidden items-center gap-0 md:flex">
                    <a href="{{ route('admin.manual') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-all">
                        {{ __('Admin Manual') }}
                    </a>
                    <span class="h-4 w-px bg-gray-300/50 dark:bg-gray-700/50"></span>
                    <a href="{{ route('android.app.manual') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-all">
                        {{ __('Android Manual') }}
                    </a>
                    <span class="h-4 w-px bg-gray-300/50 dark:bg-gray-700/50"></span>
                    <a href="{{ route('api.docs') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-all">
                        {{ __('API Docs') }}
                    </a>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="rounded-lg p-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 md:hidden" aria-label="Toggle menu">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-gradient-to-r from-violet-600 to-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition-all hover:from-violet-700 hover:to-purple-700 hover:shadow-lg hover:shadow-violet-500/50">
                            {{ __('Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg border-2 border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 transition-all hover:bg-gray-50 hover:border-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:hover:border-gray-600">
                            {{ __('Log in') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mt-4 space-y-2 border-t border-gray-200/50 pt-4 dark:border-gray-700/50 md:hidden"
             style="display: none;">
            <a href="{{ route('admin.manual') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                {{ __('Admin Manual') }}
            </a>
            <a href="{{ route('android.app.manual') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                {{ __('Android Manual') }}
            </a>
            <a href="{{ route('api.docs') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                {{ __('API Docs') }}
            </a>
            <div class="pt-2 border-t border-gray-200/50 dark:border-gray-700/50">
                @auth
                    <a href="{{ route('dashboard') }}" class="block rounded-lg bg-gradient-to-r from-violet-600 to-purple-600 px-4 py-2.5 text-sm font-semibold text-white text-center transition-all hover:from-violet-700 hover:to-purple-700">
                        {{ __('Dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block rounded-lg border-2 border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 text-center transition-all hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                        {{ __('Log in') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section with Particle Background -->
<div class="relative min-h-screen pt-40 pb-20">
    <!-- Particle Canvas -->
    <canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none"></canvas>
    
    <div class="mx-auto max-w-7xl px-6">
        <!-- Hero Title -->
        <div class="text-center mb-12">
            <h1 class="mb-6 text-5xl font-bold text-gray-900 dark:text-white md:text-6xl lg:text-7xl">
                {{ __('Manage Vehicles & Tasks') }}
                <span class="block bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                    {{ __('Seamlessly') }}
                </span>
            </h1>
            <p class="mx-auto max-w-2xl text-xl text-gray-600 dark:text-gray-400">
                {{ __('Description text') }}
            </p>
        </div>
        
        <!-- Features and Screenshots Side by Side -->
        <div class="grid gap-12 lg:grid-cols-2 lg:gap-16 items-center mb-20">
            <!-- Features Section (Left) -->
            <div class="space-y-6">
                <!-- Feature Cards -->
            </div>
            
            <!-- Screenshots Section (Right) -->
            <div class="relative flex items-center justify-center">
                <!-- Monitor Mockup (Microsoft Surface style) -->
                <div class="relative z-10 -mr-16 hidden lg:block">
                    <div class="monitor-mockup">
                        <div class="monitor-frame">
                            <div class="monitor-screen">
                                <img src="..." class="monitor-image">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Mockup (No black bezel) -->
                <div class="relative z-20">
                    <div class="phone-mockup">
                        <div class="phone-frame">
                            <div class="phone-screen">
                                <img src="..." class="phone-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

**Key Features**:
- **Fixed Navigation**: Top navigation bar with backdrop blur and shadow
- **Logo Component**: Uses `<x-app-logo />` for automatic light/dark mode switching
- **Vertical Separators**: Transparent vertical lines (`|`) between menu items using `<span class="h-4 w-px bg-gray-300/50">`
- **Particle Background**: Animated canvas particles with connecting lines (see Particle Background System section)
- **Side-by-Side Layout**: Features on left, device screenshots on right (`lg:grid-cols-2`)
- **Microsoft Surface Monitor**: White frame with minimal stand, matches screenshot aspect ratio
- **Phone Mockup**: No black bezel, transparent frame, matches screenshot aspect ratio
- **Responsive Design**: Stacks vertically on mobile, side-by-side on desktop
- **Gradient Hero Title**: Large title with gradient accent text

**Monitor Mockup CSS**:
```css
.monitor-mockup {
    display: inline-block;
    padding: 0;
    background: transparent;
    border-radius: 0;
}

.monitor-frame {
    width: 600px;
    max-width: 100%;
    background: #ffffff;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(0, 0, 0, 0.05),
        inset 0 0 0 1px rgba(0, 0, 0, 0.05);
    position: relative;
}

.dark .monitor-frame {
    background: #f5f5f5;
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.3),
        0 0 0 1px rgba(255, 255, 255, 0.1),
        inset 0 0 0 1px rgba(255, 255, 255, 0.05);
}

.monitor-frame::before {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 8px;
    background: #ffffff;
    border-radius: 0 0 4px 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.monitor-frame::after {
    content: '';
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    height: 4px;
    background: #e0e0e0;
    border-radius: 2px;
}

.monitor-screen {
    width: 100%;
    background: #000;
    border-radius: 4px;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.monitor-image {
    width: 100%;
    height: auto;
    object-fit: contain;
    display: block;
}
```

**Phone Mockup CSS** (No Black Bezel):
```css
.phone-mockup {
    display: inline-block;
    padding: 12px;
    background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
    border-radius: 40px;
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.2),
        0 0 0 8px rgba(255, 255, 255, 0.1),
        inset 0 0 20px rgba(0, 0, 0, 0.1);
}

.dark .phone-mockup {
    background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.5),
        0 0 0 8px rgba(255, 255, 255, 0.05),
        inset 0 0 20px rgba(0, 0, 0, 0.3);
}

.phone-frame {
    width: 280px;
    max-width: 100%;
    background: transparent;
    border-radius: 32px;
    padding: 0;
    box-shadow: none;
    position: relative;
}

.phone-frame::before {
    content: '';
    position: absolute;
    top: 12px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 6px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
    z-index: 10;
}

.phone-screen {
    width: 100%;
    background: #000;
    border-radius: 32px;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.phone-image {
    width: 100%;
    height: auto;
    object-fit: contain;
    display: block;
}
```

**Navigation Features**:
- **Backdrop Blur**: `backdrop-blur-md` for modern glass effect
- **Menu Item Hover**: Background color change on hover
- **Vertical Separators**: Transparent lines between menu items (`bg-gray-300/50`)
- **Desktop Menu**: Horizontal menu bar visible on `md` screens and above (768px+)
- **Mobile Menu**: Hamburger button with dropdown menu for screens below `md` (below 768px)
- **Alpine.js Integration**: Uses `x-data="{ mobileMenuOpen: false }"` for toggle functionality
- **Smooth Transitions**: Mobile menu slides down with fade animation
- **Logo Hover**: Scale effect on logo hover (`group-hover:scale-105`)

**Mobile Menu Pattern**:
- **Hamburger Button**: Visible on screens below `md` breakpoint (`md:hidden`)
- **Toggle Icons**: Hamburger icon (☰) when closed, X icon (✕) when open
- **Dropdown Menu**: Slides down below navigation bar with fade and slide animation
- **Menu Items**: All navigation links displayed vertically in mobile menu
- **Auth Buttons**: Login/Dashboard button included at bottom of mobile menu with separator
- **Responsive Breakpoint**: Desktop menu at `md:flex`, mobile menu at `md:hidden`

**Spacing**:
- Top padding: `pt-40` (to account for fixed navigation)
- Hero title margin: `mb-12`
- Features/Screenshots gap: `gap-12 lg:gap-16`
- Feature cards gap: `space-y-6`

**Current Usage**:
- Landing Page (`resources/views/welcome.blade.php`)

### "How It Works" Bullet Points Pattern
- Card-based design with rounded circular serial numbers
- Color matching system: bullet points automatically match section variant colors
- Emerald for Vehicle Search, Purple for Task Management, Blue for Team Communication
- Responsive 3-column grid layout
- Dark mode support for all color variants
- Consistent spacing with `mt-8` margin before Keypoints sections

### Navigation Menu Naming Conventions
- Added standard for menu item naming: plural forms without "Manage" suffix
- Main menu items: Users, Tasks, Shipments, Vehicles
- Submenu items: Descriptive names (Today's Tasks, Shipping Companies, Ports)
- Consistent with industry best practices

**Version**: 2.15  
**Last Updated**: January 22, 2026  
**Project**: Laravel Livewire Dashboard - Senda Snap

---

## 🧭 Navigation Menu Naming Conventions

### Menu Item Naming Standard

All navigation menu items in the sidebar follow a consistent naming convention:

**Rule**: Use **plural form** without "Manage" suffix for all menu items.

**Examples**:
- ✅ `Users` (not "User Manage" or "User Management")
- ✅ `Tasks` (not "Task Manage" or "Task Management")
- ✅ `Shipments` (not "Shipment Manage" or "Shipment Management")
- ✅ `Vehicles` (not "Vehicle Manage" or "Vehicle Management")

**Rationale**:
- Plural forms are standard for resource lists in modern UIs
- Shorter, cleaner labels improve readability
- Consistent with industry best practices (GitHub, GitLab, etc.)
- Avoids redundancy (the "Management" section heading already implies management)

**Submenu Items**:
- Submenu items can be more descriptive (e.g., "Today's Tasks", "All Tasks", "Shipping Companies", "Ports")
- Submenu items use specific names that describe the content or action

**Implementation Pattern**:
```blade
<flux:navlist.group :heading="__('Management')" class="grid">
    <!-- Main menu items: plural form, no "Manage" suffix -->
    <flux:navlist.item icon="users" :href="route('users.index')">
        {{ __('Users') }}
    </flux:navlist.item>

    <!-- Menu items with submenus -->
    <div x-data="{ open: {{ request()->routeIs('tasks.*') ? 'true' : 'false' }} }">
        <flux:navlist.item icon="clipboard" @click="open = !open">
            <span>{{ __('Tasks') }}</span>
        </flux:navlist.item>
        
        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
            <!-- Submenu items: descriptive names -->
            <flux:navlist.item :href="route('tasks.today')">
                {{ __("Today's Tasks") }}
            </flux:navlist.item>
            <flux:navlist.item :href="route('tasks.all')">
                {{ __('All Tasks') }}
            </flux:navlist.item>
        </div>
    </div>

    <!-- Shipments with submenu -->
    <div x-data="{ open: {{ request()->routeIs('shipping-companies.*') || request()->routeIs('ports.*') ? 'true' : 'false' }} }">
        <flux:navlist.item icon="layout-grid" @click="open = !open">
            <span>{{ __('Shipments') }}</span>
        </flux:navlist.item>
        
        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
            <flux:navlist.item :href="route('shipping-companies.index')">
                {{ __('Shipping Companies') }}
            </flux:navlist.item>
            <flux:navlist.item :href="route('ports.index')">
                {{ __('Ports') }}
            </flux:navlist.item>
        </div>
    </div>
</flux:navlist.group>
```

**Key Points**:
- Main menu items: Always plural, no "Manage" suffix
- Submenu items: Can be descriptive and specific
- Consistency: All menu items follow the same pattern
- Translation: Always use `__()` helper for internationalization

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

// Previews
$this->dispatch('open-user-preview', userId: $id);
$this->dispatch('open-task-preview', taskId: $id);

// Delete Actions
$this->dispatch('delete-user', userId: $id);
$this->dispatch('delete-task', taskId: $id);

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

---

## 📋 Kanban Board Pattern

### Purpose
Display tasks in a drag-and-drop Kanban board layout with status-based columns (Pending, Running, Completed, Cancelled).

### Structure

**Livewire Component**:
```php
<?php

namespace App\Livewire\Tasks;

use App\Services\TaskService;
use Livewire\Component;

class KanbanBoard extends Component
{
    public ?string $search = null;
    public ?string $priorityFilter = null;
    public ?string $assignedToFilter = null;
    public ?string $fromDate = null;
    public ?string $toDate = null;
    public int $refreshKey = 0; // Critical for filter refresh

    public function mount(): void
    {
        // Set default date range: 1 month back to today
        $this->fromDate = now()->subMonth()->format('Y-m-d');
        $this->toDate = now()->format('Y-m-d');
    }

    public function updatedPriorityFilter($value): void
    {
        $this->priorityFilter = ($value === '' || $value === null) ? null : trim($value);
        $this->refreshKey++; // Force refresh
    }

    public function render(TaskService $taskService): View
    {
        $filters = [];
        // Build filters array...
        
        $tasksByStatus = $taskService->getTasksGroupedByStatus($filters);
        
        return view('livewire.tasks.kanban-board', [
            'tasksByStatus' => $tasksByStatus,
        ]);
    }
}
```

**Blade Template Structure**:
```blade
<div class="flex h-full w-full flex-1 flex-col gap-4 min-w-[1280px]" x-data="{...}">
    <!-- Page Header -->
    <x-page-header variant="emerald" ... />

    <!-- Filters Card with Kanban Board -->
    <x-table-card variant="emerald" class="flex flex-col flex-1 min-h-0 min-w-[1280px]">
        <!-- Filters Section -->
        <div class="mb-4 flex-shrink-0">
            <h3>Filters</h3>
            <div class="flex flex-col md:flex-row flex-wrap gap-3 md:gap-4">
                <flux:input wire:model.live.debounce.300ms="search" ... />
                <flux:select wire:model.live="priorityFilter" ... />
                <flux:select wire:model.live="assignedToFilter" ... />
                <flux:input type="date" wire:model.live="fromDate" ... />
                <flux:input type="date" wire:model.live="toDate" ... />
            </div>
        </div>

        <flux:separator class="my-4" />

        <!-- Kanban Board -->
        <div class="flex-1 overflow-x-auto overflow-y-hidden min-h-0" 
             wire:key="kanban-board-{{ $refreshKey }}-{{ md5(($priorityFilter ?? '') . '|' . ($assignedToFilter ?? '')) }}">
            <div class="h-full w-full">
                <div class="grid grid-cols-4 gap-0 h-full">
                    <!-- Pending Column -->
                    <div class="flex flex-col border-r border-gray-200 dark:border-gray-700 pr-3 h-full overflow-hidden"
                         @dragover.prevent="handleDragOver($event, 'pending')"
                         @drop.prevent="handleDrop($event, 'pending')">
                        <div class="flex-shrink-0 mb-3 rounded-lg border border-emerald-200 bg-emerald-50 p-3 shadow-md dark:border-emerald-900/50 dark:bg-emerald-900/20">
                            <h3>Pending</h3>
                        </div>
                        <div class="flex flex-col gap-2 flex-1 overflow-y-auto">
                            @forelse($tasksByStatus['pending'] as $task)
                                <div draggable="true" @dragstart="handleDragStart($event, {{ $task->id }}, 'pending')">
                                    <x-task-card-kanban :task="$task" status="pending" />
                                </div>
                            @empty
                                <div>No tasks</div>
                            @endforelse
                        </div>
                    </div>
                    <!-- Repeat for Running, Completed, Cancelled -->
                </div>
            </div>
        </div>
    </x-table-card>
</div>
```

### Key Features

1. **Column Headers**: Solid background colors matching status
   - Pending: `bg-emerald-50 dark:bg-emerald-900/20`
   - Running: `bg-blue-50 dark:bg-blue-900/20`
   - Completed: `bg-green-50 dark:bg-green-900/20`
   - Cancelled: `bg-red-50 dark:bg-red-900/20`

2. **Task Cards**: Gradient backgrounds with 50% opacity
   - Use `<x-task-card-kanban>` component
   - Colors match column status
   - Display: title, description, priority badge, assigned users, created time, preview button

3. **Drag and Drop**: Alpine.js implementation
   - `handleDragStart()`: Store task ID and source status
   - `handleDragOver()`: Visual feedback on drop zones
   - `handleDrop()`: Call Livewire method to update status
   - Force refresh after drop: `$wire.$refresh()` or increment `refreshKey`

4. **Filtering**: 
   - Search (title/description)
   - Priority (low, medium, high, urgent)
   - Assigned user
   - Date range (from/to)
   - Default: 1 month back to today

5. **Responsive Design**:
   - Minimum width: `min-w-[1280px]` (xl breakpoint)
   - Fixed 4-column grid: `grid-cols-4`
   - Horizontal scroll on smaller screens
   - Fixed height with vertical scroll per column

6. **Refresh Pattern**:
   - Use `refreshKey` property in component
   - Increment in all `updatedXxx()` filter methods
   - Include in `wire:key` for main container
   - Ensures view updates when filters change

### Task Card Component (`<x-task-card-kanban>`)

**Props**:
- `task`: Task model instance
- `status`: Status for color theming (pending, running, completed, cancelled)

**Features**:
- Gradient background with 50% opacity matching status color
- Compact layout with title, description, priority badge
- Assigned users avatars (max 2 visible + count)
- Attachment count indicator
- Created time in 12-hour format (highlighted)
- Preview button at bottom end
- Drag-and-drop enabled

**Color Mapping**:
- Each status has its own color scheme (border, background, text, icons)
- Colors are defined in PHP array and applied dynamically
- Dark mode support for all color variants

### Service Method Pattern

```php
public function getTasksGroupedByStatus(array $filters = []): array
{
    $query = Task::with(['assignedUsers', 'creator', 'attachments']);

    // Apply filters
    if (isset($filters['search']) && $filters['search'] !== '' && $filters['search'] !== null) {
        $query->where(function ($q) use ($filters) {
            $q->where('title', 'like', "%{$filters['search']}%")
                ->orWhere('description', 'like', "%{$filters['search']}%");
        });
    }

    if (isset($filters['priority']) && $filters['priority'] !== '' && $filters['priority'] !== null) {
        $query->where('priority', $filters['priority']);
    }

    // ... other filters

    $tasks = $query->orderBy('created_at', 'desc')->get();

    // Group by status
    return [
        'pending' => $tasks->where('status', 'pending')->values(),
        'running' => $tasks->where('status', 'running')->values(),
        'completed' => $tasks->where('status', 'completed')->values(),
        'cancelled' => $tasks->where('status', 'cancelled')->values(),
    ];
}
```

### Critical Requirements

- ✅ Always use `refreshKey` pattern for filter updates
- ✅ Minimum width: `min-w-[1280px]` for main container and table-card
- ✅ Fixed 4-column grid (no responsive breakpoints)
- ✅ Column headers use solid colors (not gradients)
- ✅ Task cards use gradients with 50% opacity
- ✅ Time display in 12-hour format with AM/PM
- ✅ Preview button at bottom end of each card
- ✅ Force refresh after drag-and-drop operations
- ✅ Shadow should not be cropped (no `overflow-hidden` on table-card)
- ✅ Each column has independent vertical scrolling
