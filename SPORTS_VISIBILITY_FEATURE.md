# Sports Visibility Feature Implementation

## Overview
Added the ability for administrators to control which sports are visible on the public-facing sports page without deleting them from the database.

## Changes Made

### 1. Database Schema
**File:** `admin/handler/sports_visibility_migration.php` (NEW)
- Created migration script to add `is_visible` column to sports table
- Column type: TINYINT(1) with default value 1 (visible)
- Position: After `display_order` column

**How to run:** Access via browser at:
`http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/admin/handler/sports_visibility_migration.php`

### 2. Public Page Filtering
**File:** `src/sport.php`
- Updated database query to filter only visible sports
- Changed: `SELECT * FROM sports ORDER BY...`
- To: `SELECT * FROM sports WHERE is_visible = 1 ORDER BY...`

### 3. Admin Backend Handler
**File:** `admin/handler/toggle_sport_visibility.php` (NEW)
- Created endpoint to handle visibility toggle requests
- Accepts: `sport_id` and `is_visible` (0 or 1)
- Returns: JSON response with success/error status
- Includes authentication check (requires admin session)

### 4. Admin Frontend UI
**File:** `admin/admin_panel_soswk.php`
- Added CSS styles for visibility toggle switch (lines 3037-3124)
- Toggle switch design: Modern iOS-style slider
- Colors:
  - Unchecked (hidden): Gray (#cbd5e1)
  - Checked (visible): Green (#10b981)
- Added success/error message styling

### 5. JavaScript Functionality
**File:** `scripts/admin-components/sports-management.js`

**Changes:**
1. Added global `window.allSports` array for cross-function access
2. Updated `createSportCard()` function to include visibility toggle HTML
3. Added visibility toggle to both grid and list views
4. Added `toggleSportVisibility()` function to handle toggle interactions
5. Added `showVisibilityMessage()` function for user feedback
6. Updated `attachButtonListeners()` to include visibility checkbox listeners
7. Updated `loadSports()` to sync local and global allSports arrays

**Toggle Features:**
- Real-time status label update (Visible/Hidden)
- Optimistic UI updates (changes immediately, reverts on error)
- Error handling with automatic state revert
- Success/error toast messages
- Maintains sport in allSports array for persistence

### 6. Admin Sports Handler Update
**File:** `admin/handler/admin_sports_handler.php`
- Updated fetch query to include `is_visible` column
- Changed: `SELECT id, title, description, image_path, display_order, created_at FROM sports...`
- To: `SELECT id, title, description, image_path, display_order, is_visible, created_at FROM sports...`

## Usage

### For Administrators:
1. Navigate to Sports Management section in admin panel
2. Each sport card/item now shows a toggle switch with label
3. Click the toggle to hide/show the sport on the public page
4. Label updates immediately: "Visible" (green) or "Hidden" (gray)
5. Success message appears confirming the change

### For Users:
- Only sports marked as "Visible" appear on the sports page
- Hidden sports are completely filtered from public view
- No changes to the user-facing design or experience

## Technical Details

### Database Column
```sql
ALTER TABLE sports ADD COLUMN is_visible TINYINT(1) DEFAULT 1 AFTER display_order
```

### API Endpoint
**URL:** `admin/handler/toggle_sport_visibility.php`
**Method:** POST (JSON)
**Request Body:**
```json
{
  "sport_id": 123,
  "is_visible": 1
}
```
**Response:**
```json
{
  "success": true,
  "message": "Sport successfully set to visible",
  "is_visible": 1
}
```

### Toggle Switch HTML Structure
```html
<div class="sport-visibility-control">
  <label class="visibility-toggle">
    <input type="checkbox" class="visibility-checkbox" data-id="123" checked>
    <span class="visibility-slider"></span>
  </label>
  <span class="visibility-label">Visible</span>
</div>
```

## Benefits
1. **Non-Destructive:** Sports are hidden, not deleted
2. **Reversible:** Toggle back to visible anytime
3. **User-Friendly:** Visual toggle switch with clear labels
4. **Real-Time:** Immediate feedback and updates
5. **Safe:** Includes authentication checks and error handling

## Future Enhancements
Possible additions:
- Bulk visibility toggle (select multiple sports)
- Visibility scheduling (auto-show/hide at specific dates)
- Visibility history/audit log
- Filter by visibility status in admin view
