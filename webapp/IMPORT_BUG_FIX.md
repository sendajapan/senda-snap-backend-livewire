# Shipment Schedule Import - Bug Fix Summary

## Problem Description
When importing shipment schedules via `/shipment-schedule/public/import`, the system showed:
- **111 imported successfully**
- **5 failed imports**
- **No clear reason** for the failures

## Root Cause Analysis

### The Issue
The import was failing with this database error:
```
SQLSTATE[22007]: Invalid datetime format: 1292 Incorrect date value: '-0001-11-30 00:00:00' for column 'eta'
```

### Why This Happened

1. **Excel Import Processing** (`ShipmentScheduleImport.php` line 158):
   - When ETA values were "TBA" or invalid, they were converted to `'0000-00-00'`
   
2. **Initial Validation** (`PublicImport.php` lines 114-118):
   - The validation checked if dates matched the regex pattern `/^\d{4}-\d{2}-\d{2}$/`
   - The value `'0000-00-00'` **passed** this regex check ✅
   - But `strtotime('0000-00-00')` returned `false` ❌
   - However, the check was using `||` (OR), so if regex passed, it didn't matter that strtotime failed

3. **Database Insert** (`ScheduleService.php` line 390):
   - When trying to parse `'0000-00-00'` with `Carbon::parse()`, it created an invalid date like `-0001-11-30`
   - MySQL rejected this invalid datetime value
   - The import failed with no clear error message to the user

## The Fix

### 1. Enhanced Date Validation in `PublicImport.php`
**File**: `app/Livewire/ShipmentSchedule/PublicImport.php` (lines 113-137)

**What Changed**:
- Added explicit check for `'0000-00-00'` and dates starting with `'0000-'`
- Added Carbon parsing validation to ensure dates are actually valid
- Added check to ensure parsed year is not negative (year < 1)
- Better error handling with try-catch blocks

**Before**:
```php
if ($val && (!preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $val) || strtotime((string) $val) === false)) {
    $mapped[$dateField] = '';
}
```

**After**:
```php
if ($val) {
    // Check if date matches format
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $val)) {
        $mapped[$dateField] = '';
        continue;
    }
    // Check for invalid placeholder dates like 0000-00-00
    if ($val === '0000-00-00' || strpos((string) $val, '0000-') === 0) {
        $mapped[$dateField] = '';
        continue;
    }
    // Validate that the date can be parsed and is valid
    try {
        $parsed = \Carbon\Carbon::parse($val);
        // Check if the parsed date is reasonable (not negative year)
        if ($parsed->year < 1) {
            $mapped[$dateField] = '';
        }
    } catch (\Throwable) {
        $mapped[$dateField] = '';
    }
}
```

### 2. Better Error Handling in `ScheduleService.php`
**File**: `app/Services/ScheduleService.php` (lines 386-405)

**What Changed**:
- Added year range validation (1 to 2100)
- Added detailed logging for debugging
- Better error messages for invalid dates
- Prevents invalid dates from reaching the database

**Before**:
```php
$eta = null;
if ($lastEtaRaw !== '') {
    try {
        $eta = Carbon::parse($lastEtaRaw)->format('Y-m-d');
    } catch (\Throwable) {
        // Invalid date, keep null
    }
}
```

**After**:
```php
$eta = null;
if ($lastEtaRaw !== '') {
    try {
        $parsedEta = Carbon::parse($lastEtaRaw);
        // Validate the parsed date is reasonable
        if ($parsedEta->year < 1 || $parsedEta->year > 2100) {
            $errors['eta'] = [__('Invalid ETA date: :date', ['date' => $lastEtaRaw])];
        } else {
            $eta = $parsedEta->format('Y-m-d');
        }
    } catch (\Throwable $e) {
        // Invalid date format - log for debugging but don't fail the import
        \Log::warning('Failed to parse ETA during import', [
            'eta_raw' => $lastEtaRaw,
            'vessel' => $vesselName,
            'error' => $e->getMessage()
        ]);
        // Keep eta as null
    }
}
```

## Expected Behavior After Fix

### Before Fix:
- ❌ Invalid dates like `'0000-00-00'` would cause database errors
- ❌ No clear error message to users
- ❌ Imports would fail silently with generic "failed" count

### After Fix:
- ✅ Invalid dates are caught early and converted to empty strings
- ✅ Clear error messages in logs for debugging
- ✅ Imports with missing/invalid ETAs will either:
  - Skip the invalid date (set to NULL in database)
  - Show validation error if ETA is required
- ✅ Better visibility into why imports fail

## Testing Recommendations

1. **Test with TBA values**: Import a schedule with ETA = "TBA"
2. **Test with 0000-00-00**: Import a schedule with ETA = "0000-00-00"
3. **Test with invalid dates**: Import with dates like "2026-13-45" (invalid month/day)
4. **Test with empty dates**: Import with blank ETA fields
5. **Check Laravel logs**: Verify that failed imports now show clear error messages in `storage/logs/laravel.log`

## How to Check Logs

To see detailed error information for failed imports:

```powershell
# View last 100 lines of Laravel log
Get-Content storage\logs\laravel.log -Tail 100

# Search for import errors
Get-Content storage\logs\laravel.log | Select-String -Pattern "Import error" -Context 5
```

## Files Modified

1. `app/Livewire/ShipmentSchedule/PublicImport.php` - Enhanced date validation
2. `app/Services/ScheduleService.php` - Better error handling and logging
