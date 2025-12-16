# State Games Modal Title Fix

## Problem
When clicking the **Edit** button on a State Games event, the modal opened but displayed "Add New State Games Event" instead of "Edit State Games Event".

## Root Cause
The issue was a race condition in the modal opening sequence:

1. `editStateGames()` would set the modal title to "Edit State Games Event"
2. Then call `openStateGamesModal()`
3. `openStateGamesModal()` would call `resetStateGamesModal()`
4. `resetStateGamesModal()` would overwrite the title back to "Add New State Games Event"

**Result:** The edit title was immediately overwritten by the reset function.

## Solution

### Step 1: Add Mode Parameter to openStateGamesModal()
**File:** `admin_panel_soswk.php` (Lines ~2460-2469)

**Before:**
```javascript
function openStateGamesModal() {
    const modal = document.getElementById('stateGamesModal');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        resetStateGamesModal();  // Always resets to "Add New"
    }
}
```

**After:**
```javascript
function openStateGamesModal(mode = 'add') {
    const modal = document.getElementById('stateGamesModal');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        // Only reset form to "Add New" state if we're adding (not editing)
        if (mode === 'add') {
            resetStateGamesModal();
        }
    }
}
```

**Explanation:**
- Added `mode = 'add'` parameter with default value
- Made `resetStateGamesModal()` conditional - only runs when `mode === 'add'`
- When editing, the modal opens WITHOUT resetting, preserving the title set by `editStateGames()`

### Step 2: Update Edit Function to Pass Mode
**File:** `scripts/admin-components/state-games-management.js` (Lines ~260-274)

**Before:**
```javascript
const title = document.querySelector('#stateGamesModal .modal-title');  // Wrong selector
const submitBtn = document.getElementById('submitStateGamesBtn');
const cancelBtn = document.getElementById('cancelEditStateGamesBtn');

if (title) title.textContent = 'Edit State Games Event';
if (submitBtn) {
    submitBtn.textContent = 'Update Event';
    submitBtn.className = 'state-games-submit-btn';
}
if (cancelBtn) cancelBtn.style.display = 'inline-block';

// Open modal
openStateGamesModal();  // No mode parameter
```

**After:**
```javascript
const title = document.querySelector('#stateGamesModal h3');  // Correct selector
const submitBtn = document.getElementById('submitStateGamesBtn');
const cancelBtn = document.getElementById('cancelEditStateGamesBtn');

// Open modal first in edit mode (this will NOT reset the form)
openStateGamesModal('edit');

// Then update the UI elements for edit mode
if (title) title.textContent = 'Edit State Games Event';
if (submitBtn) {
    submitBtn.textContent = 'Update Event';
    submitBtn.className = 'state-games-submit-btn';
}
if (cancelBtn) cancelBtn.style.display = 'inline-block';
```

**Explanation:**
- Fixed title selector from `.modal-title` to `h3` (matches actual HTML structure)
- Moved `openStateGamesModal('edit')` call BEFORE title updates
- Pass `'edit'` mode to prevent reset function from running
- Title and button changes now persist because reset doesn't overwrite them

## How It Works

### Add New Event Flow:
1. User clicks "Add State Games Event" button → `openStateGamesModal()` (no parameter, defaults to 'add')
2. Modal opens → `resetStateGamesModal()` runs
3. Form cleared, title set to "Add New State Games Event"
4. User fills form and submits

### Edit Event Flow:
1. User clicks Edit button on existing event → `editStateGames(id)` runs
2. Fetch event data from database
3. Call `openStateGamesModal('edit')` → modal opens but `resetStateGamesModal()` is skipped
4. Populate form fields with event data
5. Update title to "Edit State Games Event"
6. Update button to "Update Event"
7. User modifies data and submits

## Key Concepts

### Default Parameters
```javascript
function openStateGamesModal(mode = 'add') {
    // mode will be 'add' if not specified
}
```
This allows backward compatibility - existing calls without parameters still work.

### Conditional Execution
```javascript
if (mode === 'add') {
    resetStateGamesModal();
}
```
The reset only happens for new events, not edits.

### Race Condition Prevention
By moving the modal open BEFORE the title update and using the mode parameter, we ensure:
- Edit mode: Modal opens → No reset → Title stays "Edit..."
- Add mode: Modal opens → Reset runs → Title becomes "Add New..."

## Testing

To verify the fix works:

1. **Test Add:**
   - Click "Add State Games Event" button
   - Modal should open with title "Add New State Games Event"
   - Form should be empty
   - Button should say "Add Event"

2. **Test Edit:**
   - Click Edit button on any existing State Games event
   - Modal should open with title "Edit State Games Event"
   - Form should be populated with event data
   - Button should say "Update Event"

3. **Test Sequence:**
   - Add a new event → Close modal → Edit same event
   - Edit title should display correctly
   - Open Add modal → Edit title should reset properly

## Lessons Learned

1. **Function sequencing matters** - The order of operations affects the final result
2. **Race conditions** - One function can overwrite changes made by another
3. **Mode parameters** - Allow same function to behave differently in different contexts
4. **DOM selectors** - Must match actual HTML structure (`.modal-title` vs `h3`)
5. **Default parameters** - Enable backward compatibility when adding new features

## Future Improvements

Consider applying this pattern to other modal sections:
- Sports section edit modal
- ALP edit modal
- HAP edit modal
- YAP edit modal
- Gallery photo/video edit modals

All should use `openModal(mode = 'add')` pattern for consistency.
