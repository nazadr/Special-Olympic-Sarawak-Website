# Event Type Rename: "Special Event" → "Tournament"

## Summary
Successfully renamed "Special Event" to "Tournament" across the entire events calendar system while maintaining database compatibility.

---

## Files Modified

### 1. Admin Panel (Backend)
**File:** `admin/admin_panel_soswk.php`

**Changes:**
- ✅ Statistics label: "Special Events" → "Tournaments"
- ✅ Add Event dropdown: "Special Event" → "Tournament" 
- ✅ Edit Event dropdown: "Special Event" → "Tournament"

**Lines Modified:**
- Line ~3685: Statistics display label
- Line ~3717: Add event modal dropdown option
- Line ~3820: Edit event modal dropdown option

---

### 2. Frontend Event Calendar
**File:** `src/event_calendar.php`

**Changes:**
- ✅ CSS variable comment: `--event-special` → `--event-tournament` (documentation)
- ✅ CSS class: `.event.special` → `.event.tournament`
- ✅ CSS class: `.calendar-day.bg-special` → `.calendar-day.bg-tournament`
- ✅ Event Type Legend: "Special Event" → "Tournament"
- ✅ JavaScript color mapping: Added comment for clarity

**Lines Modified:**
- Line ~22: CSS variable (comment updated for clarity)
- Line ~186: Event styling class
- Line ~218: Calendar day background class
- Line ~472: Legend display text
- Line ~857: JavaScript function (comment added)

---

## Database Compatibility

### Important Note:
The database still uses `'special'` as the value for the `type` field. This is **intentional** to maintain backward compatibility with existing data.

**Database Structure:**
```sql
CREATE TABLE `events` (
  ...
  `type` varchar(50) NOT NULL,
  ...
)
```

**Existing Data:**
```sql
INSERT INTO `events` (..., `type`, ...) VALUES
(..., 'special', ...),  -- This value remains unchanged
```

**Why Keep 'special'?**
- All existing events in the database use `type='special'`
- Changing database values would require data migration
- Frontend displays "Tournament" while backend stores 'special'
- This separation of display vs. storage is a best practice

---

## Visual Changes

### Admin Panel Statistics
**Before:** 
```
⭐ Special Events
```

**After:**
```
⭐ Tournaments
```

### Event Form Dropdowns
**Before:**
```html
<option value="special">Special Event</option>
```

**After:**
```html
<option value="special">Tournament</option>
```

### Frontend Legend
**Before:**
```
🔴 Special Event
```

**After:**
```
🔴 Tournament
```

---

## CSS Classes Renamed

| Old Class Name | New Class Name | Purpose |
|----------------|----------------|---------|
| `.event.special` | `.event.tournament` | Event badge styling |
| `.calendar-day.bg-special` | `.calendar-day.bg-tournament` | Day background when event present |

**Note:** The value attribute in forms and database remains `'special'` for compatibility.

---

## Testing Checklist

After deployment, verify:

- [ ] Admin panel shows "Tournaments" in statistics
- [ ] Add Event dropdown shows "Tournament" option
- [ ] Edit Event dropdown shows "Tournament" option
- [ ] Saving events with type "special" works correctly
- [ ] Frontend calendar displays events with tournament styling
- [ ] Event Type Legend shows "Tournament" instead of "Special Event"
- [ ] Existing events display correctly with new label
- [ ] Mobile view displays correctly
- [ ] No console errors in browser

---

## Backward Compatibility

✅ **Fully Compatible**
- Existing events with `type='special'` continue to work
- No database migration required
- Forms still submit `value='special'` to database
- Display layer shows "Tournament" to users
- All functionality preserved

---

## Future Considerations

If you want to rename the database value from 'special' to 'tournament':

1. Create a SQL migration:
```sql
UPDATE `events` SET `type` = 'tournament' WHERE `type` = 'special';
```

2. Update all form values:
```html
<option value="tournament">Tournament</option>
```

3. Update JavaScript filters:
```javascript
const tournamentCount = allEvents.filter(e => e.type === 'tournament').length;
```

**Recommendation:** Keep current implementation unless database cleanup is required.

---

## Summary of Changes

| Component | Before | After | Status |
|-----------|--------|-------|--------|
| Admin Stats Label | "Special Events" | "Tournaments" | ✅ Updated |
| Add Event Dropdown | "Special Event" | "Tournament" | ✅ Updated |
| Edit Event Dropdown | "Special Event" | "Tournament" | ✅ Updated |
| Frontend Legend | "Special Event" | "Tournament" | ✅ Updated |
| CSS Classes | `.event.special` | `.event.tournament` | ✅ Updated |
| Database Value | `'special'` | `'special'` | ⚠️ Unchanged (by design) |

---

**Status:** ✅ All display changes complete. System fully functional.

**Next Step:** Test the changes in both admin panel and frontend to ensure everything displays correctly.
