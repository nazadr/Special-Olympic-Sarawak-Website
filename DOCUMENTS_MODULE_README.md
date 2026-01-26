# Participants Documents Management Module

## Overview
A Google Drive-inspired document explorer that tracks all Excel uploads for the Participants Management System. This module provides comprehensive version control, upload history, and metadata tracking for all athlete, coach, and volunteer data imports.

## Features

### 📊 Statistics Dashboard
- **Total Uploads**: Shows count of all Excel files uploaded
- **Athletes Files**: Number of athlete data uploads
- **Coaches Files**: Number of coach data uploads  
- **Volunteers Files**: Number of volunteer data uploads

### 🔍 Search & Filter
- **Search**: Find documents by filename or uploader name
- **Type Filter**: Filter by participant type (All/Athletes/Coaches/Volunteers)
- **Sort Options**:
  - Newest First (default)
  - Oldest First
  - Name (A-Z)
  - Name (Z-A)
  - Largest Files
  - Smallest Files

### 📁 Two View Modes
1. **List View** (default): Detailed table showing:
   - File name with Excel icon
   - Participant type (color-coded badge)
   - Upload date and time
   - Uploaded by (admin user)
   - Record count with breakdown (imported/updated/failed)
   - Status indicator (Success/Partial/Failed)
   - Action buttons (View/Download/Delete)

2. **Grid View**: Card-based layout showing:
   - Large Excel file icon
   - File name
   - Upload date and version
   - Record statistics in highlighted box
   - Quick action buttons

### 📄 Document Details
Click on any document to view:
- Complete file information
- Upload metadata (date, time, uploader)
- Import statistics:
  - Total records processed
  - New records imported (green)
  - Updated records (blue)
  - Failed records (red)
- Error log (if any failures occurred)

### ⚙️ Actions Available
- **View Details**: Opens modal with complete document information
- **Download**: Re-download the original Excel file
- **Delete**: Remove document record (does not delete imported data)

## Database Schema

### Table: `participant_excel_uploads`
```sql
CREATE TABLE participant_excel_uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participant_type ENUM('athlete', 'coach', 'volunteer') NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    rows_imported INT DEFAULT 0,
    rows_updated INT DEFAULT 0,
    rows_failed INT DEFAULT 0,
    upload_status ENUM('success', 'partial', 'failed') DEFAULT 'success',
    error_log TEXT,
    FOREIGN KEY (uploaded_by) REFERENCES so_admins(admin_id)
);
```

## File Structure

### Frontend Components
```
admin/admin_panel_soswk.php
├── Documents Section (lines 4488-4643)
│   ├── Stats Grid (4 stat cards)
│   ├── Explorer Controls (search, filter, sort, view toggle)
│   ├── Grid View Container
│   └── List View Table
└── CSS Styles (lines 2859-2987)
    ├── View toggle button styles
    ├── Grid card styles
    ├── List table styles
    └── Responsive design

scripts/admin-components/participants-documents.js
├── loadDocuments() - Fetch and display documents
├── loadDocumentStats() - Update stat counters
├── displayDocumentsList() - Render table rows
├── displayDocumentsGrid() - Render grid cards
├── toggleDocView() - Switch between views
├── viewDocumentDetails() - Show document modal
├── downloadDocument() - Initiate file download
└── deleteDocument() - Remove document with confirmation
```

### Backend Handler
```
admin/handler/admin_documents_handler.php
├── fetchDocuments() - Query with filters, search, sort
├── fetchDocumentStats() - Aggregate statistics
├── downloadDocument() - Stream file download
└── deleteDocument() - Remove record and file
```

## API Endpoints

### GET: Fetch Documents
```
handler/admin_documents_handler.php?action=fetch
Parameters:
  - search (optional): Search term for filename
  - type (optional): athlete|coach|volunteer|all
  - sortBy (optional): date-desc|date-asc|name-asc|name-desc|size-desc|size-asc
  - limit (optional, default: 100)
  - offset (optional, default: 0)

Response:
{
    "success": true,
    "data": [
        {
            "id": 1,
            "participant_type": "athlete",
            "original_filename": "athletes_data.xlsx",
            "file_path": "../uploads/excel/athletes_1234567890.xlsx",
            "created_at": "2024-01-15 14:30:00",
            "rows_imported": 50,
            "rows_updated": 10,
            "rows_failed": 2,
            "upload_status": "partial",
            "error_log": "Row 5: Missing email..."
        }
    ],
    "total": 15
}
```

### GET: Fetch Statistics
```
handler/admin_documents_handler.php?action=fetchStats

Response:
{
    "success": true,
    "stats": {
        "total": 42,
        "athletes": 18,
        "coaches": 14,
        "volunteers": 10,
        "recent": 5,
        "success_rate": 85.7
    }
}
```

### GET: Download Document
```
handler/admin_documents_handler.php?action=download&id=1

Response: File stream with headers
Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
Content-Disposition: attachment; filename="original_filename.xlsx"
```

### POST: Delete Document
```
handler/admin_documents_handler.php

POST Body:
action=delete&id=1

Response:
{
    "success": true,
    "message": "Document deleted successfully"
}
```

## Color Scheme

### Participant Type Badges
- **Athletes**: Pink/Purple gradient (`#f093fb`)
- **Coaches**: Blue (`#3b82f6`)
- **Volunteers**: Orange (`#f59e0b`)

### Status Indicators
- **Success**: Green (`#10b981`) - All records imported successfully
- **Partial**: Orange (`#f59e0b`) - Some records failed
- **Failed**: Red (`#ef4444`) - Upload completely failed

### Record Breakdown Icons
- **↑ Imported**: Green - New records added
- **⟳ Updated**: Blue - Existing records modified
- **✕ Failed**: Red - Records that couldn't be processed

## Usage Workflow

### 1. Accessing Documents
- Click "Documents" in the sidebar under "Management" section
- Statistics load automatically showing upload overview

### 2. Finding Documents
- Use search bar to find specific files by name
- Filter by participant type (Athletes/Coaches/Volunteers)
- Sort by date, name, or file size

### 3. Viewing Details
- Click any document row/card to view full details
- Review import statistics and error logs
- Identify which records failed and why

### 4. Downloading Files
- Click Download button to get original Excel file
- File downloads with original filename
- Useful for re-processing or backup

### 5. Managing Documents
- Delete old or duplicate uploads
- Confirmation prompt prevents accidental deletion
- Note: Deleting document does NOT remove imported participant data

## Integration with Upload System

When Excel files are uploaded via the Participants Management:

1. **File Processing** (in upload handlers):
   ```php
   // athletes-management.js, coaches-management.js, volunteers-management.js
   processExcelUpload(file, type)
   └─> POST to handler/admin_athletes_handler.php (or coaches/volunteers)
       └─> uploadExcel() function
           ├─> Validate file format
           ├─> Process rows with PhpSpreadsheet
           ├─> Import/Update database records
           └─> INSERT INTO participant_excel_uploads
   ```

2. **Tracking Record** is created with:
   - Original filename
   - Stored file path
   - Admin ID who uploaded
   - Row counts (imported/updated/failed)
   - Upload status
   - Error log (if any failures)

3. **Auto-Refresh**: Documents section updates automatically when:
   - New Excel file is uploaded
   - User navigates to Documents section
   - User changes filter/sort/search

## Security Features

### Authentication
- All API endpoints check for valid admin session
- Redirects to login if session expired

### SQL Injection Prevention
- All queries use prepared statements with `bind_param()`
- User inputs are sanitized before database operations

### File Security
- Uploaded files stored outside public directory
- File paths validated before download
- Only allows downloading files tracked in database

### XSS Prevention
- All user-generated content escaped with `escapeHtml()` in JavaScript
- HTML special characters converted to entities

## Troubleshooting

### Documents Not Loading
**Problem**: List shows "No documents found" but uploads exist  
**Solution**:
1. Check browser console for JavaScript errors
2. Verify `admin_documents_handler.php` is in correct path
3. Check database connection in handler file
4. Confirm `participant_excel_uploads` table exists

### Download Not Working
**Problem**: Click download but nothing happens  
**Solution**:
1. Check file path in database matches actual file location
2. Verify file still exists (not manually deleted)
3. Check browser console for 404 or 500 errors
4. Ensure PHP `readfile()` function is enabled

### Stats Not Updating
**Problem**: Upload new file but stats don't change  
**Solution**:
1. Refresh the page or navigate away and back
2. Check if upload actually succeeded (check main participants list)
3. Verify `created_at` timestamp is being set in database
4. Clear browser cache

### Search Not Working
**Problem**: Search returns no results for known files  
**Solution**:
1. Wait 500ms after typing (debounce delay)
2. Search uses partial matches, not exact
3. Check if `original_filename` column has correct data
4. Try filtering by type first, then searching

## Future Enhancements

### Planned Features
- [ ] Bulk delete (select multiple documents)
- [ ] Export document list as CSV
- [ ] File preview (show Excel content without downloading)
- [ ] Version comparison (diff between uploads)
- [ ] Restore previous version (re-import old Excel file)
- [ ] Advanced filtering (date range, status, record count)
- [ ] Document tagging/categorization
- [ ] Upload notes/comments
- [ ] Activity timeline showing all uploads
- [ ] File size display and tracking

### Performance Optimization
- [ ] Pagination for large document lists
- [ ] Lazy loading for grid view
- [ ] Caching for statistics
- [ ] Compress old files automatically

## Best Practices

### For Administrators
1. **Regular Cleanup**: Delete old/duplicate uploads monthly
2. **Version Tracking**: Use descriptive filenames (e.g., `athletes_2024_Q1.xlsx`)
3. **Error Review**: Check documents with failed records weekly
4. **Backup Downloads**: Download important uploads before deleting
5. **Test Uploads**: Use small test files first before bulk imports

### For Developers
1. **Error Handling**: Always log errors to `error_log` field
2. **Transaction Safety**: Use database transactions for bulk operations
3. **File Storage**: Keep uploaded files in separate directory from code
4. **Naming Convention**: Use timestamps in stored filenames to prevent conflicts
5. **Validation**: Verify Excel structure before processing

## Related Documentation
- [Participants Module README](PARTICIPANTS_MODULE_README.md) - Main participants system
- [Quick Start Guide](QUICK_START_PARTICIPANTS.md) - Setup and usage
- [Excel Templates Guide](EXCEL_TEMPLATES_GUIDE.md) - Excel file format requirements
- [Implementation Summary](IMPLEMENTATION_SUMMARY.md) - Technical architecture

## Support
For issues or questions:
1. Check this documentation first
2. Review browser console for JavaScript errors
3. Check PHP error logs in XAMPP
4. Verify database schema matches documentation
5. Test with small sample Excel files first

---

**Last Updated**: 2024  
**Version**: 1.0  
**Author**: Special Olympics Sarawak Development Team
