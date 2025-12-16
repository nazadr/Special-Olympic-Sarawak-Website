# State Games Management System

## Overview
This system provides a complete CRUD (Create, Read, Update, Delete) interface for managing State Games events in the Special Olympics Sarawak website. It follows the same patterns as other admin sections like News and Sports management.

## Components Created

### 1. Database Structure
- **File**: `admin/db/state_games_table.sql`
- **Table**: `state_games`
- **Fields**: id, event_title, event_date, event_description, learn_more_link, image_path, display_order, created_at, updated_at

### 2. Admin Panel Integration
- **Modified**: `admin/admin_panel_soswk.php`
- Added State Games management section with modal form
- Added button styling and modal functionality
- Integrated with existing admin design patterns

### 3. Backend Handler
- **File**: `admin/handler/admin_state_games_handler.php`
- Handles CRUD operations (Create, Read, Update, Delete)
- Image upload functionality
- Drag-and-drop reordering support
- Error handling and validation

### 4. Frontend JavaScript
- **File**: `scripts/admin-components/state-games-management.js`
- Modal management functions
- AJAX form submissions
- Image preview functionality
- Sortable drag-and-drop interface
- Real-time updates

### 5. Dynamic PHP Page
- **File**: `src/state-games.php` (converted from state-games.html)
- Fetches events from database
- Displays events dynamically
- Fallback to static data if database unavailable
- Maintains original design and styling

### 6. CSS Styling
- **Modified**: `css/admin_style.css`
- Added `.state-games-item-admin` styles
- Consistent with existing admin interface patterns
- Responsive design support

## Database Setup

1. Execute the SQL file to create the table:
   ```sql
   -- Run the contents of admin/db/state_games_table.sql
   ```

2. Or use the PHP setup script:
   ```bash
   php admin/db/setup_state_games.php
   ```

## Features

### Admin Panel Features
- ✅ Add new events with image upload
- ✅ Edit existing events
- ✅ Delete events with confirmation
- ✅ Drag-and-drop reordering
- ✅ Image preview functionality
- ✅ Form validation
- ✅ Real-time updates
- ✅ Responsive design

### Public Page Features
- ✅ Dynamic content from database
- ✅ Fallback to static content
- ✅ Responsive design
- ✅ Image error handling
- ✅ Learn More links (optional)

## Usage

### Adding a New Event
1. Go to Admin Panel → State Games
2. Click "Add Event" button
3. Fill in the form fields:
   - Event Title (required)
   - Event Date (required)
   - Event Description (required)
   - Learn More Link (optional)
   - Upload Image (optional)
   - Display Order (optional)
4. Click "Add Event" to save

### Editing an Event
1. Find the event in the list
2. Click the edit (pencil) icon
3. Modify the fields as needed
4. Click "Update Event" to save changes

### Reordering Events
1. Drag events by the grip handle (⋮⋮)
2. Drop them in the desired position
3. Order is saved automatically

### Deleting an Event
1. Click the delete (trash) icon
2. Confirm the deletion
3. Event and associated image are removed

## File Structure
```
admin/
├── admin_panel_soswk.php (modified - added State Games section)
├── handler/
│   └── admin_state_games_handler.php (new)
├── db/
│   ├── state_games_table.sql (new)
│   └── setup_state_games.php (new)
└── test_state_games.html (new - for testing)

scripts/admin-components/
└── state-games-management.js (new)

src/
└── state-games.php (new - dynamic version)

css/
└── admin_style.css (modified - added State Games styles)
```

## Testing

Use the test file to verify everything is working:
- Open: `admin/test_state_games.html`
- Check database connection
- Verify API endpoints
- Confirm data retrieval

## Notes

- Images are uploaded to `assets/images/events/`
- The system supports JPEG, PNG, GIF, and WebP formats
- Maximum file size is 5MB
- Events are ordered by `display_order` then `created_at`
- The public page gracefully handles missing database connections