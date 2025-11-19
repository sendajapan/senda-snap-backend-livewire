# Android App Color Guide & Design Prompts
## Senda Snap Backend - Design System Colors (Native Java/XML)

This document provides all colors, gradients, and design prompts for recreating the web design in native Android using Java and XML.

---

## 🎨 Complete Color Palette

### Color Resources (res/values/colors.xml)

```xml
<?xml version="1.0" encoding="utf-8"?>
<resources>
    <!-- Primary Color Variants -->
    
    <!-- Blue Variant (Users & Authentication) -->
    <color name="blue_500">#3B82F6</color>
    <color name="cyan_500">#06B6D4</color>
    
    <!-- Light Backgrounds (30% opacity) -->
    <color name="blue_50_30">#4DEFF6FF</color>
    <color name="cyan_50_30">#4DECFEFF</color>
    
    <!-- Borders -->
    <color name="blue_200">#BFDBFE</color>
    <color name="blue_300">#93C5FD</color>
    <color name="blue_800">#1E40AF</color>
    <color name="blue_900_50">#801E3A8A</color>
    
    <!-- Action Buttons -->
    <color name="blue_700">#1D4ED8</color>
    <color name="blue_600">#2563EB</color>
    <color name="blue_500_10">#1A3B82F6</color>
    <color name="blue_500_20">#333B82F6</color>
    <color name="blue_700_30">#4D1D4ED8</color>
    
    <!-- Decorative (20% opacity) -->
    <color name="blue_400_20">#3360A5FA</color>
    <color name="cyan_400_20">#3322D3EE</color>
    
    <!-- Dark Mode Backgrounds (20% opacity) -->
    <color name="blue_900_20">#331E3A8A</color>
    <color name="cyan_900_20">#33064748</color>

    <!-- Emerald Variant (Tasks) -->
    <color name="emerald_500">#10B981</color>
    <color name="teal_500">#14B8A6</color>
    
    <!-- Light Backgrounds (30% opacity) -->
    <color name="emerald_50_30">#4DECFDF5</color>
    <color name="teal_50_30">#4DF0FDFA</color>
    
    <!-- Borders -->
    <color name="emerald_200">#A7F3D0</color>
    <color name="emerald_300">#6EE7B7</color>
    <color name="emerald_800">#065F46</color>
    <color name="emerald_900_50">#80064E3B</color>
    
    <!-- Action Buttons -->
    <color name="emerald_700">#047857</color>
    <color name="emerald_600">#059669</color>
    <color name="emerald_500_10">#1A10B981</color>
    <color name="emerald_500_20">#3310B981</color>
    <color name="emerald_700_30">#4D047857</color>
    
    <!-- Decorative (20% opacity) -->
    <color name="emerald_400_20">#3334D399</color>
    <color name="teal_400_20">#332DD4BF</color>
    
    <!-- Dark Mode Backgrounds (20% opacity) -->
    <color name="emerald_900_20">#33064E3B</color>
    <color name="teal_900_20">#33064748</color>

    <!-- Violet Variant (General & API) -->
    <color name="violet_500">#8B5CF6</color>
    <color name="purple_500">#A855F7</color>
    
    <!-- Light Backgrounds (30% opacity) -->
    <color name="violet_50_30">#4DF5F3FF</color>
    <color name="purple_50_30">#4DFAF5FF</color>
    
    <!-- Borders -->
    <color name="violet_200">#DDD6FE</color>
    <color name="violet_900_50">#804C1D95</color>
    
    <!-- Decorative (20% opacity) -->
    <color name="violet_400_20">#33A78BFA</color>
    <color name="purple_400_20">#33C084FC</color>
    
    <!-- Dark Mode Backgrounds (20% opacity) -->
    <color name="violet_900_20">#334C1D95</color>
    <color name="purple_900_20">#335B21B6</color>

    <!-- Amber Variant (Vehicles) -->
    <color name="amber_500">#F59E0B</color>
    <color name="orange_500">#F97316</color>
    
    <!-- Light Backgrounds (30% opacity) -->
    <color name="amber_50_30">#4DFFFBF0</color>
    <color name="orange_50_30">#4DFFF7ED</color>
    
    <!-- Borders -->
    <color name="amber_200">#FDE68A</color>
    <color name="amber_900_50">#8078410F</color>
    
    <!-- Decorative (20% opacity) -->
    <color name="amber_400_20">#33FBBF24</color>
    <color name="orange_400_20">#33FB923C</color>
    
    <!-- Dark Mode Backgrounds (20% opacity) -->
    <color name="amber_900_20">#3378410F</color>
    <color name="orange_900_20">#337C2D12</color>

### Action Button Colors

#### **Cyan** (Edit Actions - Universal)
```kotlin
val cyan700 = Color(0xFF0891B2)      // cyan-700
val cyan600 = Color(0xFF0891B2)       // cyan-600 (hover)
val cyan500_10 = Color(0x1A06B6D4)    // cyan-500/10 (background)
val cyan500_20 = Color(0x3306B6D4)    // cyan-500/20 (hover background)
val cyan700_30 = Color(0x4D0891B2)    // cyan-700/30 (shadow)
```

#### **Red** (Delete Actions - Universal)
```kotlin
val red700 = Color(0xFFB91C1C)        // red-700
val red600 = Color(0xFFDC2626)        // red-600 (hover)
val red500_10 = Color(0x1AEF4444)     // red-500/10 (background)
val red500_20 = Color(0x33EF4444)     // red-500/20 (hover background)
val red700_30 = Color(0x4DB91C1C)     // red-700/30 (shadow)
```

### Status Colors

#### **Green** (Completed, Available, Online Status)
```kotlin
val green500 = Color(0xFF22C55E)      // green-500 (status indicator)
val green400 = Color(0xFF4ADE80)       // green-400
```

#### **Gray** (Neutral, Cancelled, Client Role)
```kotlin
val gray50 = Color(0xFFF9FAFB)        // gray-50
val gray100 = Color(0xFFF3F4F6)        // gray-100
val gray200 = Color(0xFFE5E7EB)        // gray-200
val gray300 = Color(0xFFD1D5DB)        // gray-300
val gray400 = Color(0xFF9CA3AF)        // gray-400
val gray500 = Color(0xFF6B7280)        // gray-500
val gray600 = Color(0xFF4B5563)         // gray-600
val gray700 = Color(0xFF374151)        // gray-700
val gray800 = Color(0xFF1F2937)        // gray-800
val gray900 = Color(0xFF111827)        // gray-900
val gray950 = Color(0xFF030712)         // gray-950

// With opacity
val gray200_50 = Color(0x80E5E7EB)    // gray-200/50
val gray700_50 = Color(0x80374151)     // gray-700/50
val gray800_50 = Color(0x801F2937)     // gray-800/50
val gray900_50 = Color(0x80111827)     // gray-900/50
```

### Text Colors

```kotlin
// Primary Text
val textPrimary = Color(0xFF111827)        // gray-900
val textPrimaryDark = Color(0xFFF9FAFB)   // white

// Secondary Text
val textSecondary = Color(0xFF4B5563)      // gray-600
val textSecondaryDark = Color(0xFFD1D5DB) // gray-300

// Muted Text
val textMuted = Color(0xFF6B7280)          // gray-500
val textMutedDark = Color(0xFF9CA3AF)     // gray-400

// Light Muted (for date/time in cards)
val textLightMuted = Color(0xFF9CA3AF)    // gray-400
val textLightMutedDark = Color(0xFF6B7280) // gray-500
```

### Background Colors

```kotlin
// Base Backgrounds
val bgWhite = Color(0xFFFFFFFF)           // white
val bgWhite_50 = Color(0x80FFFFFF)       // white/50 (frosted glass)
val bgGray800_50 = Color(0x801F2937)      // gray-800/50 (dark mode frosted glass)
val bgGray900 = Color(0xFF111827)         // gray-900
val bgGray900_80 = Color(0xCC111827)       // gray-900/80
val bgGray950 = Color(0xFF030712)          // gray-950

// Table Header Background
val bgTableHeader = Color(0xFFF9FAFB)     // gray-50
val bgTableHeaderDark = Color(0xFF1F2937)  // gray-800
```

---

## 🎨 Table Border Colors

### Table Container Borders
```kotlin
// Standard table border (no specific color, uses default border)
val tableBorder = Color(0xFFE5E7EB)        // gray-200 (default)
val tableBorderDark = Color(0xFF374151)    // gray-700 (dark mode)
```

### Table Row Dividers
```kotlin
val tableDivider = Color(0x80E5E7EB)      // gray-200/50
val tableDividerDark = Color(0x80374151)   // gray-700/50
```

### Table Header Background Gradient
```kotlin
// Table header uses gradient background
val tableHeaderFrom = Color(0xFFF9FAFB)    // gray-50
val tableHeaderTo = Color(0xFFF3F4F6)      // gray-100
val tableHeaderFromDark = Color(0xFF1F2937) // gray-800
val tableHeaderToDark = Color(0xFF111827)  // gray-900
```

---

## 💎 Frosted Glass Backdrop Effect

### Android Implementation Prompt

**Create a Material 3 Card/Container with Frosted Glass (Backdrop Blur) Effect:**

```kotlin
// Kotlin/Compose Implementation
@Composable
fun FrostedGlassCard(
    modifier: Modifier = Modifier,
    content: @Composable () -> Unit
) {
    Card(
        modifier = modifier,
        shape = RoundedCornerShape(12.dp), // rounded-xl
        colors = CardDefaults.cardColors(
            containerColor = Color(0x80FFFFFF) // bg-white/50 (50% opacity white)
        )
    ) {
        Box(
            modifier = Modifier
                .background(
                    brush = Brush.verticalGradient(
                        colors = listOf(
                            Color(0x80FFFFFF), // white/50
                            Color(0x80FFFFFF)  // white/50
                        )
                    )
                )
                .blur(radius = 8.dp) // backdrop-blur-sm equivalent
        ) {
            content()
        }
    }
}

// Dark Mode Variant
@Composable
fun FrostedGlassCardDark(
    modifier: Modifier = Modifier,
    content: @Composable () -> Unit
) {
    Card(
        modifier = modifier,
        shape = RoundedCornerShape(12.dp),
        colors = CardDefaults.cardColors(
            containerColor = Color(0x801F2937) // gray-800/50
        )
    ) {
        Box(
            modifier = Modifier
                .background(
                    brush = Brush.verticalGradient(
                        colors = listOf(
                            Color(0x801F2937), // gray-800/50
                            Color(0x801F2937)  // gray-800/50
                        )
                    )
                )
                .blur(radius = 8.dp)
        ) {
            content()
        }
    }
}
```

**Key Properties:**
- **Background Color**: `Color(0x80FFFFFF)` (white with 50% opacity) for light mode
- **Background Color Dark**: `Color(0x801F2937)` (gray-800 with 50% opacity) for dark mode
- **Blur Radius**: `8.dp` (equivalent to `backdrop-blur-sm`)
- **Border Radius**: `12.dp` (equivalent to `rounded-xl`)
- **Border**: Optional, can add `1.dp` border with `Color(0xFFE5E7EB)` for light mode

**Alternative (Using Material 3 Surface with Blur):**
```kotlin
Surface(
    modifier = Modifier
        .blur(radius = 8.dp)
        .background(
            brush = Brush.verticalGradient(
                colors = listOf(
                    Color(0x80FFFFFF),
                    Color(0x80FFFFFF)
                )
            )
        ),
    shape = RoundedCornerShape(12.dp),
    color = Color.Transparent,
    tonalElevation = 0.dp
) {
    content()
}
```

---

## 🎨 Gradient Card Prompt

### Android Implementation Prompt

**Create a Gradient Card matching the project's design system:**

```kotlin
// Example: Emerald Variant (Tasks)
@Composable
fun GradientCard(
    variant: CardVariant = CardVariant.EMERALD,
    modifier: Modifier = Modifier,
    content: @Composable () -> Unit
) {
    val colors = when (variant) {
        CardVariant.BLUE -> listOf(
            Color(0xFFFFFFFF),      // white
            Color(0x4DEFF6FF),      // blue-50/30
            Color(0x4DECFEFF)       // cyan-50/30
        )
        CardVariant.EMERALD -> listOf(
            Color(0xFFFFFFFF),      // white
            Color(0x4DECFDF5),      // emerald-50/30
            Color(0x4DF0FDFA)       // teal-50/30
        )
        CardVariant.VIOLET -> listOf(
            Color(0xFFFFFFFF),      // white
            Color(0x4DF5F3FF),      // violet-50/30
            Color(0x4DFAF5FF)       // purple-50/30
        )
        CardVariant.AMBER -> listOf(
            Color(0xFFFFFFFF),      // white
            Color(0x4DFFFBF0),      // amber-50/30
            Color(0x4DFFF7ED)       // orange-50/30
        )
    }
    
    val borderColor = when (variant) {
        CardVariant.BLUE -> Color(0xFFBFDBFE)      // blue-200
        CardVariant.EMERALD -> Color(0xFFA7F3D0)    // emerald-200
        CardVariant.VIOLET -> Color(0xFFDDD6FE)      // violet-200
        CardVariant.AMBER -> Color(0xFFFDE68A)      // amber-200
    }
    
    Card(
        modifier = modifier,
        shape = RoundedCornerShape(16.dp), // rounded-2xl
        border = BorderStroke(1.dp, borderColor),
        elevation = CardDefaults.cardElevation(defaultElevation = 12.dp) // shadow-xl
    ) {
        Box(
            modifier = Modifier
                .fillMaxSize()
                .background(
                    brush = Brush.linearGradient(
                        colors = colors,
                        start = Offset(0f, 0f),
                        end = Offset(1000f, 1000f) // diagonal gradient
                    )
                )
                .padding(24.dp) // p-6
        ) {
            // Decorative blur circles (optional)
            Box(
                modifier = Modifier
                    .align(Alignment.TopEnd)
                    .offset(x = (-32).dp, y = (-32).dp)
                    .size(128.dp)
                    .background(
                        brush = Brush.radialGradient(
                            colors = listOf(
                                when (variant) {
                                    CardVariant.EMERALD -> Color(0x3334D399), // emerald-400/20
                                    CardVariant.BLUE -> Color(0x3360A5FA),   // blue-400/20
                                    CardVariant.VIOLET -> Color(0x33A78BFA), // violet-400/20
                                    CardVariant.AMBER -> Color(0x33FBBF24)   // amber-400/20
                                },
                                Color.Transparent
                            )
                        ),
                        shape = CircleShape
                    )
                    .blur(radius = 64.dp) // blur-2xl
            )
            
            content()
        }
    }
}

enum class CardVariant {
    BLUE, EMERALD, VIOLET, AMBER
}
```

**Key Properties:**
- **Gradient Direction**: Diagonal (`from-white via-{color}-50/30 to-{color2}-50/30`)
- **Border**: `1.dp` solid border with variant color (e.g., `blue-200`, `emerald-200`)
- **Border Radius**: `16.dp` (equivalent to `rounded-2xl`)
- **Elevation**: `12.dp` (equivalent to `shadow-xl`)
- **Padding**: `24.dp` (equivalent to `p-6`)
- **Decorative Elements**: Optional blur circles in corners with 20% opacity variant colors

**Dark Mode Variant:**
```kotlin
val darkColors = when (variant) {
    CardVariant.EMERALD -> listOf(
        Color(0xFF111827),      // gray-900
        Color(0x33064E3B),      // emerald-900/20
        Color(0x33064748)        // teal-900/20
    )
    // ... other variants
}
```

---

## 📊 Table Design Prompt

### Android Table Implementation

**Create a Material 3 Table matching the project's design:**

```kotlin
@Composable
fun DataTable(
    headers: List<String>,
    rows: List<List<String>>,
    modifier: Modifier = Modifier
) {
    Card(
        modifier = modifier,
        shape = RoundedCornerShape(12.dp), // rounded-xl
        border = BorderStroke(1.dp, Color(0xFFE5E7EB)), // border gray-200
        colors = CardDefaults.cardColors(
            containerColor = Color(0x80FFFFFF) // bg-white/50
        )
    ) {
        Column {
            // Table Header
            Row(
                modifier = Modifier
                    .fillMaxWidth()
                    .background(
                        brush = Brush.horizontalGradient(
                            colors = listOf(
                                Color(0xFFF9FAFB), // gray-50
                                Color(0xFFF3F4F6)  // gray-100
                            )
                        )
                    )
                    .padding(horizontal = 24.dp, vertical = 16.dp) // px-6 py-4
            ) {
                headers.forEach { header ->
                    Text(
                        text = header,
                        style = TextStyle(
                            fontSize = 12.sp,      // text-xs
                            fontWeight = FontWeight.Bold,
                            letterSpacing = 0.05.em, // tracking-wider
                            color = Color(0xFF374151) // gray-700
                        ),
                        modifier = Modifier.weight(1f)
                    )
                }
            }
            
            // Table Rows
            rows.forEachIndexed { index, row ->
                Row(
                    modifier = Modifier
                        .fillMaxWidth()
                        .background(
                            if (index % 2 == 0) Color.Transparent
                            else Color(0x0DE5E7EB) // subtle alternating (optional)
                        )
                        .padding(horizontal = 24.dp, vertical = 20.dp) // px-6 py-5
                        .then(
                            if (index < rows.size - 1) {
                                Modifier.border(
                                    width = 0.5.dp,
                                    color = Color(0x80E5E7EB), // gray-200/50
                                    shape = RoundedCornerShape(0.dp)
                                )
                            } else Modifier
                        )
                ) {
                    row.forEach { cell ->
                        Text(
                            text = cell,
                            style = TextStyle(
                                fontSize = 12.sp, // text-xs
                                color = Color(0xFF111827) // gray-900
                            ),
                            modifier = Modifier.weight(1f)
                        )
                    }
                }
            }
        }
    }
}
```

**Key Properties:**
- **Container**: Card with `rounded-xl` (12.dp), border, and frosted glass background
- **Header Background**: Horizontal gradient from `gray-50` to `gray-100`
- **Header Text**: `12.sp`, bold, uppercase, `gray-700`
- **Row Padding**: `24.dp` horizontal, `20.dp` vertical (`px-6 py-5`)
- **Row Dividers**: `0.5.dp` border with `gray-200/50` between rows
- **Cell Text**: `12.sp`, `gray-900`

---

## 🎯 Complete Color Reference Table

| Color Name | Light Mode | Dark Mode | Usage |
|------------|------------|-----------|-------|
| **Blue Variant** |
| Primary Start | `#3B82F6` (blue-500) | Same | Gradient start |
| Primary End | `#06B6D4` (cyan-500) | Same | Gradient end |
| Border | `#BFDBFE` (blue-200) | `#1E3A8A80` (blue-900/50) | Card borders |
| Background | `#FFFFFF80` (white/50) | `#1F293780` (gray-800/50) | Frosted glass |
| **Emerald Variant** |
| Primary Start | `#10B981` (emerald-500) | Same | Gradient start |
| Primary End | `#14B8A6` (teal-500) | Same | Gradient end |
| Border | `#A7F3D0` (emerald-200) | `#064E3B80` (emerald-900/50) | Card borders |
| Background | `#FFFFFF80` (white/50) | `#1F293780` (gray-800/50) | Frosted glass |
| **Violet Variant** |
| Primary Start | `#8B5CF6` (violet-500) | Same | Gradient start |
| Primary End | `#A855F7` (purple-500) | Same | Gradient end |
| Border | `#DDD6FE` (violet-200) | `#4C1D9580` (violet-900/50) | Card borders |
| **Amber Variant** |
| Primary Start | `#F59E0B` (amber-500) | Same | Gradient start |
| Primary End | `#F97316` (orange-500) | Same | Gradient end |
| Border | `#FDE68A` (amber-200) | `#78410F80` (amber-900/50) | Card borders |
| **Action Buttons** |
| View (Blue) | `#1D4ED8` (blue-700) | Same | View button |
| Edit (Cyan) | `#0891B2` (cyan-700) | Same | Edit button |
| Delete (Red) | `#B91C1C` (red-700) | Same | Delete button |
| **Table** |
| Border | `#E5E7EB` (gray-200) | `#374151` (gray-700) | Table container |
| Divider | `#E5E7EB80` (gray-200/50) | `#37415180` (gray-700/50) | Row dividers |
| Header BG | `#F9FAFB` → `#F3F4F6` | `#1F2937` → `#111827` | Header gradient |

---

## 📱 Android Material 3 Color Scheme

```kotlin
val LightColorScheme = lightColorScheme(
    primary = Color(0xFF3B82F6),        // blue-500
    secondary = Color(0xFF10B981),      // emerald-500
    tertiary = Color(0xFF8B5CF6),      // violet-500
    error = Color(0xFFB91C1C),         // red-700
    surface = Color(0x80FFFFFF),        // white/50 (frosted glass)
    onSurface = Color(0xFF111827),      // gray-900
    surfaceVariant = Color(0xFFF9FAFB), // gray-50
    onSurfaceVariant = Color(0xFF6B7280) // gray-500
)

val DarkColorScheme = darkColorScheme(
    primary = Color(0xFF3B82F6),        // blue-500
    secondary = Color(0xFF10B981),      // emerald-500
    tertiary = Color(0xFF8B5CF6),      // violet-500
    error = Color(0xFFB91C1C),         // red-700
    surface = Color(0x801F2937),        // gray-800/50 (frosted glass)
    onSurface = Color(0xFFF9FAFB),     // white
    surfaceVariant = Color(0xFF1F2937), // gray-800
    onSurfaceVariant = Color(0xFF9CA3AF) // gray-400
)
```

---

## 🎨 Gradient Examples

### Blue Gradient Card (Users)
```
Direction: Diagonal (top-left to bottom-right)
Colors:
  1. #FFFFFF (white) - 0%
  2. #EFF6FF4D (blue-50/30) - 50%
  3. #ECFEFF4D (cyan-50/30) - 100%
Border: #BFDBFE (blue-200)
```

### Emerald Gradient Card (Tasks)
```
Direction: Diagonal (top-left to bottom-right)
Colors:
  1. #FFFFFF (white) - 0%
  2. #ECFDF54D (emerald-50/30) - 50%
  3. #F0FDFA4D (teal-50/30) - 100%
Border: #A7F3D0 (emerald-200)
```

### Violet Gradient Card (API/General)
```
Direction: Diagonal (top-left to bottom-right)
Colors:
  1. #FFFFFF (white) - 0%
  2. #F5F3FF4D (violet-50/30) - 50%
  3. #FAF5FF4D (purple-50/30) - 100%
Border: #DDD6FE (violet-200)
```

### Amber Gradient Card (Vehicles)
```
Direction: Diagonal (top-left to bottom-right)
Colors:
  1. #FFFFFF (white) - 0%
  2. #FFFBEF4D (amber-50/30) - 50%
  3. #FFF7ED4D (orange-50/30) - 100%
Border: #FDE68A (amber-200)
```

---

## 🔍 Additional Notes

1. **Opacity Values**: 
   - `/30` = 30% opacity (0x4D in hex)
   - `/50` = 50% opacity (0x80 in hex)
   - `/20` = 20% opacity (0x33 in hex)
   - `/10` = 10% opacity (0x1A in hex)

2. **Border Radius**:
   - `rounded-xl` = 12.dp
   - `rounded-2xl` = 16.dp
   - `rounded-lg` = 8.dp

3. **Shadows**:
   - `shadow-xl` = 12.dp elevation
   - `shadow-2xl` = 16.dp elevation
   - `shadow-lg` = 8.dp elevation
   - `shadow-sm` = 2.dp elevation

4. **Spacing**:
   - `gap-4` = 16.dp
   - `p-4` = 16.dp
   - `p-6` = 24.dp
   - `px-6 py-5` = 24.dp horizontal, 20.dp vertical

---

**Version**: 1.0  
**Last Updated**: November 12, 2025  
**Project**: Senda Snap Backend - Android Color Guide

