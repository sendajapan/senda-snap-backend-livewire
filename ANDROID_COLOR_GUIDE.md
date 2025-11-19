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

    <!-- Action Button Colors -->
    <!-- Cyan (Edit Actions - Universal) -->
    <color name="cyan_700">#0891B2</color>
    <color name="cyan_600">#0891B2</color>
    <color name="cyan_500_10">#1A06B6D4</color>
    <color name="cyan_500_20">#3306B6D4</color>
    <color name="cyan_700_30">#4D0891B2</color>
    
    <!-- Red (Delete Actions - Universal) -->
    <color name="red_700">#B91C1C</color>
    <color name="red_600">#DC2626</color>
    <color name="red_500_10">#1AEF4444</color>
    <color name="red_500_20">#33EF4444</color>
    <color name="red_700_30">#4DB91C1C</color>
    
    <!-- Status Colors -->
    <!-- Green (Completed, Available, Online Status) -->
    <color name="green_500">#22C55E</color>
    <color name="green_400">#4ADE80</color>
    
    <!-- Gray (Neutral, Cancelled, Client Role) -->
    <color name="gray_50">#F9FAFB</color>
    <color name="gray_100">#F3F4F6</color>
    <color name="gray_200">#E5E7EB</color>
    <color name="gray_300">#D1D5DB</color>
    <color name="gray_400">#9CA3AF</color>
    <color name="gray_500">#6B7280</color>
    <color name="gray_600">#4B5563</color>
    <color name="gray_700">#374151</color>
    <color name="gray_800">#1F2937</color>
    <color name="gray_900">#111827</color>
    <color name="gray_950">#030712</color>
    
    <!-- Gray with opacity -->
    <color name="gray_200_50">#80E5E7EB</color>
    <color name="gray_700_50">#80374151</color>
    <color name="gray_800_50">#801F2937</color>
    <color name="gray_900_50">#80111827</color>
    
    <!-- Text Colors -->
    <color name="text_primary">#111827</color>
    <color name="text_primary_dark">#F9FAFB</color>
    <color name="text_secondary">#4B5563</color>
    <color name="text_secondary_dark">#D1D5DB</color>
    <color name="text_muted">#6B7280</color>
    <color name="text_muted_dark">#9CA3AF</color>
    <color name="text_light_muted">#9CA3AF</color>
    <color name="text_light_muted_dark">#6B7280</color>
    
    <!-- Background Colors -->
    <color name="bg_white">#FFFFFF</color>
    <color name="bg_white_50">#80FFFFFF</color>
    <color name="bg_gray_800_50">#801F2937</color>
    <color name="bg_gray_900">#111827</color>
    <color name="bg_gray_900_80">#CC111827</color>
    <color name="bg_gray_950">#030712</color>
    
    <!-- Table Header Background -->
    <color name="bg_table_header">#F9FAFB</color>
    <color name="bg_table_header_dark">#1F2937</color>
</resources>
```

---

## 🎨 Table Border Colors

### Table Container Borders (res/values/colors.xml)
```xml
<!-- Table Borders -->
<color name="table_border">#E5E7EB</color>        <!-- gray-200 -->
<color name="table_border_dark">#374151</color>    <!-- gray-700 (dark mode) -->

<!-- Table Row Dividers -->
<color name="table_divider">#80E5E7EB</color>     <!-- gray-200/50 -->
<color name="table_divider_dark">#80374151</color>  <!-- gray-700/50 -->

<!-- Table Header Background Gradient -->
<color name="table_header_from">#F9FAFB</color>    <!-- gray-50 -->
<color name="table_header_to">#F3F4F6</color>     <!-- gray-100 -->
<color name="table_header_from_dark">#1F2937</color> <!-- gray-800 -->
<color name="table_header_to_dark">#111827</color>  <!-- gray-900 -->
```

---

## 💎 Frosted Glass Backdrop Effect

### XML Drawable (res/drawable/frosted_glass_background.xml)

```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <solid android:color="@color/bg_white_50" />
    <corners android:radius="12dp" />
    <stroke
        android:width="1dp"
        android:color="@color/gray_200" />
</shape>
```

### Dark Mode Variant (res/drawable-v21/frosted_glass_background.xml)

```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <solid android:color="@color/bg_gray_800_50" />
    <corners android:radius="12dp" />
    <stroke
        android:width="1dp"
        android:color="@color/gray_700" />
</shape>
```

### Java Implementation with Backdrop Blur

**Note**: Android doesn't have native backdrop blur until API 31. For older versions, use a library like `BlurView` or `BlurKit`.

#### Using BlurView Library (Recommended)

**1. Add dependency to `build.gradle` (Module: app):**
```gradle
dependencies {
    implementation 'com.github.Dimezis:BlurView:2.0.3'
}
```

**2. XML Layout (layout/frosted_glass_card.xml):**
```xml
<?xml version="1.0" encoding="utf-8"?>
<FrameLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    android:padding="16dp">

    <!-- Background with blur -->
    <eightbitlab.com.blurview.BlurView
        android:id="@+id/blurView"
        android:layout_width="match_parent"
        android:layout_height="match_parent"
        android:background="@drawable/frosted_glass_background"
        app:blurRadius="8dp"
        app:overlayColor="@color/bg_white_50" />

    <!-- Content -->
    <LinearLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:orientation="vertical"
        android:padding="16dp">

        <!-- Your content here -->

    </LinearLayout>
</FrameLayout>
```

**3. Java Code (FrostedGlassCard.java):**
```java
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.PorterDuff;
import android.graphics.PorterDuffXfermode;
import android.graphics.Rect;
import android.graphics.RectF;
import android.view.View;
import android.view.ViewGroup;
import eightbitlab.com.blurview.BlurView;
import eightbitlab.com.blurview.RenderScriptBlur;

public class FrostedGlassCard extends FrameLayout {
    private BlurView blurView;
    
    public FrostedGlassCard(Context context) {
        super(context);
        init();
    }
    
    private void init() {
        inflate(getContext(), R.layout.frosted_glass_card, this);
        blurView = findViewById(R.id.blurView);
        
        // Setup blur
        float radius = 8f; // 8dp blur radius
        View decorView = ((Activity) getContext()).getWindow().getDecorView();
        ViewGroup rootView = decorView.findViewById(android.R.id.content);
        Drawable windowBackground = decorView.getBackground();
        
        blurView.setupWith(rootView)
            .setFrameClearDrawable(windowBackground)
            .setBlurAlgorithm(new RenderScriptBlur(getContext()))
            .setBlurRadius(radius)
            .setBlurAutoUpdate(true)
            .setHasFixedTransformationMatrix(false);
    }
}
```

#### Alternative: Using CardView with Semi-Transparent Background

**XML Layout (layout/simple_frosted_card.xml):**
```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.cardview.widget.CardView
    xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    android:layout_margin="16dp"
    app:cardCornerRadius="12dp"
    app:cardElevation="4dp"
    app:cardBackgroundColor="@color/bg_white_50">

    <LinearLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:orientation="vertical"
        android:padding="16dp">

        <!-- Your content here -->

    </LinearLayout>
</androidx.cardview.widget.CardView>
```

**Key Properties:**
- **Background Color**: `@color/bg_white_50` (white with 50% opacity) for light mode
- **Background Color Dark**: `@color/bg_gray_800_50` (gray-800 with 50% opacity) for dark mode
- **Blur Radius**: `8dp` (equivalent to `backdrop-blur-sm`)
- **Border Radius**: `12dp` (equivalent to `rounded-xl`)
- **Border**: `1dp` solid border with `@color/gray_200` for light mode

---

## 🎨 Gradient Card Prompt

### XML Drawable Resources

#### Blue Gradient Card (res/drawable/gradient_card_blue.xml)
```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <gradient
        android:type="linear"
        android:angle="135"
        android:startColor="#FFFFFF"
        android:centerColor="#4DEFF6FF"
        android:endColor="#4DECFEFF" />
    <corners android:radius="16dp" />
    <stroke
        android:width="1dp"
        android:color="@color/blue_200" />
</shape>
```

#### Emerald Gradient Card (res/drawable/gradient_card_emerald.xml)
```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <gradient
        android:type="linear"
        android:angle="135"
        android:startColor="#FFFFFF"
        android:centerColor="#4DECFDF5"
        android:endColor="#4DF0FDFA" />
    <corners android:radius="16dp" />
    <stroke
        android:width="1dp"
        android:color="@color/emerald_200" />
</shape>
```

#### Violet Gradient Card (res/drawable/gradient_card_violet.xml)
```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <gradient
        android:type="linear"
        android:angle="135"
        android:startColor="#FFFFFF"
        android:centerColor="#4DF5F3FF"
        android:endColor="#4DFAF5FF" />
    <corners android:radius="16dp" />
    <stroke
        android:width="1dp"
        android:color="@color/violet_200" />
</shape>
```

#### Amber Gradient Card (res/drawable/gradient_card_amber.xml)
```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <gradient
        android:type="linear"
        android:angle="135"
        android:startColor="#FFFFFF"
        android:centerColor="#4DFFFBF0"
        android:endColor="#4DFFF7ED" />
    <corners android:radius="16dp" />
    <stroke
        android:width="1dp"
        android:color="@color/amber_200" />
</shape>
```

### Dark Mode Variants (res/drawable-v21/)

#### Emerald Gradient Card Dark (res/drawable-v21/gradient_card_emerald.xml)
```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <gradient
        android:type="linear"
        android:angle="135"
        android:startColor="#111827"
        android:centerColor="#33064E3B"
        android:endColor="#33064748" />
    <corners android:radius="16dp" />
    <stroke
        android:width="1dp"
        android:color="@color/emerald_900_50" />
</shape>
```

### XML Layout (layout/gradient_card.xml)

```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.cardview.widget.CardView
    xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    android:layout_margin="16dp"
    app:cardCornerRadius="16dp"
    app:cardElevation="12dp"
    app:cardBackgroundColor="@android:color/transparent">

    <FrameLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:background="@drawable/gradient_card_emerald"
        android:padding="24dp">

        <!-- Decorative blur circle (optional) -->
        <View
            android:layout_width="128dp"
            android:layout_height="128dp"
            android:layout_gravity="top|end"
            android:layout_marginTop="-32dp"
            android:layout_marginEnd="-32dp"
            android:background="@drawable/decorative_blur_circle_emerald" />

        <!-- Content -->
        <LinearLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:orientation="vertical">

            <!-- Your card content here -->

        </LinearLayout>
    </FrameLayout>
</androidx.cardview.widget.CardView>
```

### Decorative Blur Circle (res/drawable/decorative_blur_circle_emerald.xml)

```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="oval">
    <gradient
        android:type="radial"
        android:centerX="0.5"
        android:centerY="0.5"
        android:gradientRadius="64dp"
        android:startColor="#3334D399"
        android:endColor="#0034D399" />
</shape>
```

### Java Helper Class (GradientCardHelper.java)

```java
import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import androidx.cardview.widget.CardView;

public class GradientCardHelper {
    
    public enum CardVariant {
        BLUE, EMERALD, VIOLET, AMBER
    }
    
    public static void applyGradientCard(CardView cardView, CardVariant variant) {
        Context context = cardView.getContext();
        int drawableRes;
        
        switch (variant) {
            case BLUE:
                drawableRes = R.drawable.gradient_card_blue;
                break;
            case EMERALD:
                drawableRes = R.drawable.gradient_card_emerald;
                break;
            case VIOLET:
                drawableRes = R.drawable.gradient_card_violet;
                break;
            case AMBER:
                drawableRes = R.drawable.gradient_card_amber;
                break;
            default:
                drawableRes = R.drawable.gradient_card_emerald;
        }
        
        ViewGroup parent = (ViewGroup) cardView.getChildAt(0);
        if (parent != null) {
            parent.setBackground(context.getDrawable(drawableRes));
        }
    }
}
```

**Key Properties:**
- **Gradient Direction**: Diagonal (135° angle) - `from-white via-{color}-50/30 to-{color2}-50/30`
- **Border**: `1dp` solid border with variant color (e.g., `blue-200`, `emerald-200`)
- **Border Radius**: `16dp` (equivalent to `rounded-2xl`)
- **Elevation**: `12dp` (equivalent to `shadow-xl`)
- **Padding**: `24dp` (equivalent to `p-6`)
- **Decorative Elements**: Optional radial gradient circles in corners with 20% opacity variant colors

---

## 📊 Table Design Prompt

### XML Drawable Resources

#### Table Container Background (res/drawable/table_container_background.xml)
```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <solid android:color="@color/bg_white_50" />
    <corners android:radius="12dp" />
    <stroke
        android:width="1dp"
        android:color="@color/table_border" />
</shape>
```

#### Table Header Background (res/drawable/table_header_background.xml)
```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <gradient
        android:type="linear"
        android:angle="0"
        android:startColor="@color/table_header_from"
        android:endColor="@color/table_header_to" />
</shape>
```

#### Table Row Divider (res/drawable/table_row_divider.xml)
```xml
<?xml version="1.0" encoding="utf-8"?>
<shape xmlns:android="http://schemas.android.com/apk/res/android"
    android:shape="rectangle">
    <solid android:color="@color/table_divider" />
    <size android:height="0.5dp" />
</shape>
```

### XML Layout (layout/data_table.xml)

```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.cardview.widget.CardView
    xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    android:layout_margin="16dp"
    app:cardCornerRadius="12dp"
    app:cardElevation="0dp"
    app:cardBackgroundColor="@android:color/transparent">

    <LinearLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:background="@drawable/table_container_background"
        android:orientation="vertical">

        <!-- Table Header -->
        <LinearLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:background="@drawable/table_header_background"
            android:orientation="horizontal"
            android:paddingStart="24dp"
            android:paddingEnd="24dp"
            android:paddingTop="16dp"
            android:paddingBottom="16dp">

            <TextView
                android:id="@+id/header1"
                android:layout_width="0dp"
                android:layout_height="wrap_content"
                android:layout_weight="1"
                android:text="Name"
                android:textColor="@color/gray_700"
                android:textSize="12sp"
                android:textStyle="bold"
                android:textAllCaps="true"
                android:letterSpacing="0.05" />

            <TextView
                android:id="@+id/header2"
                android:layout_width="0dp"
                android:layout_height="wrap_content"
                android:layout_weight="1"
                android:text="Email"
                android:textColor="@color/gray_700"
                android:textSize="12sp"
                android:textStyle="bold"
                android:textAllCaps="true"
                android:letterSpacing="0.05" />

            <!-- Add more headers as needed -->

        </LinearLayout>

        <!-- Table Rows Container -->
        <LinearLayout
            android:id="@+id/tableRowsContainer"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:orientation="vertical">

            <!-- Rows will be added programmatically -->

        </LinearLayout>
    </LinearLayout>
</androidx.cardview.widget.CardView>
```

### Table Row Layout (layout/table_row.xml)

```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    android:orientation="horizontal"
    android:paddingStart="24dp"
    android:paddingEnd="24dp"
    android:paddingTop="20dp"
    android:paddingBottom="20dp"
    android:background="?android:attr/selectableItemBackground">

    <TextView
        android:id="@+id/cell1"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:layout_weight="1"
        android:text="Cell 1"
        android:textColor="@color/text_primary"
        android:textSize="12sp" />

    <View
        android:layout_width="0.5dp"
        android:layout_height="match_parent"
        android:background="@color/table_divider"
        android:layout_marginStart="8dp"
        android:layout_marginEnd="8dp" />

    <TextView
        android:id="@+id/cell2"
        android:layout_width="0dp"
        android:layout_height="wrap_content"
        android:layout_weight="1"
        android:text="Cell 2"
        android:textColor="@color/text_primary"
        android:textSize="12sp" />

    <!-- Add more cells as needed -->

</LinearLayout>
```

### Java Implementation (DataTable.java)

```java
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;
import androidx.cardview.widget.CardView;

public class DataTable {
    private Context context;
    private LinearLayout rowsContainer;
    private CardView cardView;
    
    public DataTable(Context context, CardView cardView) {
        this.context = context;
        this.cardView = cardView;
        this.rowsContainer = cardView.findViewById(R.id.tableRowsContainer);
    }
    
    public void addRow(String[] cells) {
        View rowView = LayoutInflater.from(context)
            .inflate(R.layout.table_row, rowsContainer, false);
        
        TextView cell1 = rowView.findViewById(R.id.cell1);
        TextView cell2 = rowView.findViewById(R.id.cell2);
        // ... get other cell views
        
        if (cells.length > 0) cell1.setText(cells[0]);
        if (cells.length > 1) cell2.setText(cells[1]);
        // ... set other cells
        
        // Add divider if not last row
        if (rowsContainer.getChildCount() > 0) {
            View divider = new View(context);
            divider.setLayoutParams(new LinearLayout.LayoutParams(
                ViewGroup.LayoutParams.MATCH_PARENT,
                (int) (0.5 * context.getResources().getDisplayMetrics().density)
            ));
            divider.setBackgroundColor(context.getColor(R.color.table_divider));
            rowsContainer.addView(divider);
        }
        
        rowsContainer.addView(rowView);
    }
    
    public void clearRows() {
        rowsContainer.removeAllViews();
    }
}
```

**Key Properties:**
- **Container**: CardView with `12dp` corner radius, border, and frosted glass background
- **Header Background**: Horizontal gradient from `gray-50` to `gray-100`
- **Header Text**: `12sp`, bold, uppercase, `gray-700`, letter spacing `0.05`
- **Row Padding**: `24dp` horizontal, `20dp` vertical (`px-6 py-5`)
- **Row Dividers**: `0.5dp` border with `gray-200/50` between rows
- **Cell Text**: `12sp`, `gray-900`

---

## 🎯 Complete Color Reference Table

| Color Name | Light Mode | Dark Mode | XML Resource | Usage |
|------------|------------|-----------|--------------|-------|
| **Blue Variant** |
| Primary Start | `#3B82F6` | Same | `@color/blue_500` | Gradient start |
| Primary End | `#06B6D4` | Same | `@color/cyan_500` | Gradient end |
| Border | `#BFDBFE` | `#1E3A8A80` | `@color/blue_200` | Card borders |
| Background | `#FFFFFF80` | `#1F293780` | `@color/bg_white_50` | Frosted glass |
| **Emerald Variant** |
| Primary Start | `#10B981` | Same | `@color/emerald_500` | Gradient start |
| Primary End | `#14B8A6` | Same | `@color/teal_500` | Gradient end |
| Border | `#A7F3D0` | `#064E3B80` | `@color/emerald_200` | Card borders |
| Background | `#FFFFFF80` | `#1F293780` | `@color/bg_white_50` | Frosted glass |
| **Violet Variant** |
| Primary Start | `#8B5CF6` | Same | `@color/violet_500` | Gradient start |
| Primary End | `#A855F7` | Same | `@color/purple_500` | Gradient end |
| Border | `#DDD6FE` | `#4C1D9580` | `@color/violet_200` | Card borders |
| **Amber Variant** |
| Primary Start | `#F59E0B` | Same | `@color/amber_500` | Gradient start |
| Primary End | `#F97316` | Same | `@color/orange_500` | Gradient end |
| Border | `#FDE68A` | `#78410F80` | `@color/amber_200` | Card borders |
| **Action Buttons** |
| View (Blue) | `#1D4ED8` | Same | `@color/blue_700` | View button |
| Edit (Cyan) | `#0891B2` | Same | `@color/cyan_700` | Edit button |
| Delete (Red) | `#B91C1C` | Same | `@color/red_700` | Delete button |
| **Table** |
| Border | `#E5E7EB` | `#374151` | `@color/table_border` | Table container |
| Divider | `#E5E7EB80` | `#37415180` | `@color/table_divider` | Row dividers |
| Header BG | `#F9FAFB` → `#F3F4F6` | `#1F2937` → `#111827` | `@drawable/table_header_background` | Header gradient |

---

## 📱 Android Material 3 Color Scheme (res/values/themes.xml)

```xml
<?xml version="1.0" encoding="utf-8"?>
<resources>
    <!-- Light Theme -->
    <style name="Theme.SendaSnap" parent="Theme.Material3.Light">
        <item name="colorPrimary">@color/blue_500</item>
        <item name="colorSecondary">@color/emerald_500</item>
        <item name="colorTertiary">@color/violet_500</item>
        <item name="colorError">@color/red_700</item>
        <item name="colorSurface">@color/bg_white_50</item>
        <item name="colorOnSurface">@color/text_primary</item>
        <item name="colorSurfaceVariant">@color/gray_50</item>
        <item name="colorOnSurfaceVariant">@color/text_muted</item>
    </style>
    
    <!-- Dark Theme -->
    <style name="Theme.SendaSnap" parent="Theme.Material3.Dark">
        <item name="colorPrimary">@color/blue_500</item>
        <item name="colorSecondary">@color/emerald_500</item>
        <item name="colorTertiary">@color/violet_500</item>
        <item name="colorError">@color/red_700</item>
        <item name="colorSurface">@color/bg_gray_800_50</item>
        <item name="colorOnSurface">@color/text_primary_dark</item>
        <item name="colorSurfaceVariant">@color/gray_800</item>
        <item name="colorOnSurfaceVariant">@color/text_muted_dark</item>
    </style>
</resources>
```

---

## 🎨 Gradient Examples

### Blue Gradient Card (Users)
**XML Drawable**: `res/drawable/gradient_card_blue.xml`
```
Direction: Diagonal (135° angle)
Colors:
  1. #FFFFFF (white) - startColor
  2. #4DEFF6FF (blue-50/30) - centerColor
  3. #4DECFEFF (cyan-50/30) - endColor
Border: #BFDBFE (blue-200) - 1dp
Corner Radius: 16dp
```

### Emerald Gradient Card (Tasks)
**XML Drawable**: `res/drawable/gradient_card_emerald.xml`
```
Direction: Diagonal (135° angle)
Colors:
  1. #FFFFFF (white) - startColor
  2. #4DECFDF5 (emerald-50/30) - centerColor
  3. #4DF0FDFA (teal-50/30) - endColor
Border: #A7F3D0 (emerald-200) - 1dp
Corner Radius: 16dp
```

### Violet Gradient Card (API/General)
**XML Drawable**: `res/drawable/gradient_card_violet.xml`
```
Direction: Diagonal (135° angle)
Colors:
  1. #FFFFFF (white) - startColor
  2. #4DF5F3FF (violet-50/30) - centerColor
  3. #4DFAF5FF (purple-50/30) - endColor
Border: #DDD6FE (violet-200) - 1dp
Corner Radius: 16dp
```

### Amber Gradient Card (Vehicles)
**XML Drawable**: `res/drawable/gradient_card_amber.xml`
```
Direction: Diagonal (135° angle)
Colors:
  1. #FFFFFF (white) - startColor
  2. #4DFFFBF0 (amber-50/30) - centerColor
  3. #4DFFF7ED (orange-50/30) - endColor
Border: #FDE68A (amber-200) - 1dp
Corner Radius: 16dp
```

---

## 🔍 Additional Notes

1. **Opacity Values**: 
   - `/30` = 30% opacity (0x4D in hex, e.g., `#4DFFFFFF`)
   - `/50` = 50% opacity (0x80 in hex, e.g., `#80FFFFFF`)
   - `/20` = 20% opacity (0x33 in hex, e.g., `#33FFFFFF`)
   - `/10` = 10% opacity (0x1A in hex, e.g., `#1AFFFFFF`)

2. **Border Radius (XML)**:
   - `rounded-xl` = `12dp` in `android:radius`
   - `rounded-2xl` = `16dp` in `android:radius`
   - `rounded-lg` = `8dp` in `android:radius`

3. **Elevation/Shadows (CardView)**:
   - `shadow-xl` = `12dp` in `app:cardElevation`
   - `shadow-2xl` = `16dp` in `app:cardElevation`
   - `shadow-lg` = `8dp` in `app:cardElevation`
   - `shadow-sm` = `2dp` in `app:cardElevation`

4. **Spacing (XML)**:
   - `gap-4` = `16dp` in `android:layout_margin` or padding
   - `p-4` = `16dp` in `android:padding`
   - `p-6` = `24dp` in `android:padding`
   - `px-6 py-5` = `24dp` horizontal (`paddingStart`/`paddingEnd`), `20dp` vertical (`paddingTop`/`paddingBottom`)

5. **Gradient Angle**:
   - Diagonal (135°) = `android:angle="135"` in gradient drawable
   - Horizontal (0°) = `android:angle="0"`
   - Vertical (90°) = `android:angle="90"`

6. **Backdrop Blur Libraries**:
   - **BlurView**: `com.github.Dimezis:BlurView:2.0.3` (Recommended)
   - **BlurKit**: `io.alterac.blurkit:blurkit:1.1.1`
   - **Native**: Android 12+ (API 31+) has native backdrop blur support

---

**Version**: 1.0  
**Last Updated**: November 12, 2025  
**Project**: Senda Snap Backend - Android Color Guide

