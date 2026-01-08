# Participants Management System
## Athletes, Coaches & Volunteers Module

### Overview
This module provides a comprehensive system for managing athlete, coach, and volunteer registrations through Microsoft Forms Excel file uploads. The system automatically processes, stores, and displays participant data with full CRUD operations.

---

## Features

### 1. **Excel File Upload & Processing**
- Upload Microsoft Forms response Excel files (.xlsx, .xls, .csv)
- Automatic column mapping and data extraction
- Smart duplicate detection (matches by email or name+phone)
- Updates existing records or creates new ones
- Comprehensive error reporting and success metrics

### 2. **Data Management**
- View all participants in sortable, filterable tables
- Search by name, email, or phone
- Filter by status (pending, approved, rejected, archived)
- Chapter-based organization
- Pagination for large datasets

### 3. **Status Management**
- Approve/Reject pending registrations
- Archive old records
- Bulk status updates
- Real-time status indicators

### 4. **Statistics Dashboard**
- Total registrations count
- Approved vs pending breakdown
- Gender distribution
- Recent registrations (last 7 days)
- Chapter-wise distribution
- Average experience (coaches only)

### 5. **Export Functionality**
- Export all data to CSV format
- Complete with all fields
- Download for offline analysis

---

## Installation

### Step 1: Database Setup

1. Navigate to `admin/db/` folder
2. Open `participants-management-sql.txt`
3. Execute SQL commands in your MySQL database (phpMyAdmin or command line):

```sql
-- Create tables
CREATE TABLE athletes (...);
CREATE TABLE coaches (...);
CREATE TABLE volunteers (...);
CREATE TABLE participant_excel_uploads (...);
```

### Step 2: Install Dependencies

This system requires **PhpSpreadsheet** library for Excel processing.

**Option A: Using Composer (Recommended)**
```bash
cd c:\xampp\htdocs\Special-Olympic-Sarawak-Website-Staging-environment
composer require phpoffice/phpspreadsheet
```

**Option B: Manual Installation**
1. Download PhpSpreadsheet from: https://github.com/PHPOffice/PhpSpreadsheet/releases
2. Extract to `vendor/` folder
3. Ensure autoload.php is accessible

### Step 3: Create Upload Directories

Create the following directories with write permissions:
```
uploads/
  └─ participants/
      ├─ athletes/
      ├─ coaches/
      └─ volunteers/
```

**On Windows (XAMPP):**
```powershell
New-Item -ItemType Directory -Path "uploads\participants\athletes" -Force
New-Item -ItemType Directory -Path "uploads\participants\coaches" -Force
New-Item -ItemType Directory -Path "uploads\participants\volunteers" -Force
```

### Step 4: Verify File Structure

Ensure these files exist:
```
admin/
  ├─ handler/
  │   ├─ admin_athletes_handler.php
  │   ├─ admin_coaches_handler.php
  │   └─ admin_volunteers_handler.php
  ├─ db/
  │   └─ participants-management-sql.txt
  └─ admin_panel_soswk.php

scripts/
  └─ admin-components/
      ├─ participants-shared.js
      ├─ athletes-management.js
      ├─ coaches-management.js
      └─ volunteers-management.js
```

---

## Excel File Format

### Athletes Excel Template
| Column # | Field Name | Type | Required | Example |
|----------|-----------|------|----------|---------|
| 1 | Full Name | Text | Yes | John Doe |
| 2 | Email | Email | No | john@example.com |
| 3 | Phone | Text | No | 0123456789 |
| 4 | Date of Birth | Date | No | 1995-05-15 |
| 5 | Gender | Text | No | Male/Female |
| 6 | Chapter | Text | No | Kuching |
| 7 | Sports Interested | Text | No | Swimming, Athletics |
| 8 | Medical Conditions | Text | No | None |
| 9 | Emergency Contact Name | Text | No | Jane Doe |
| 10 | Emergency Contact Phone | Text | No | 0129876543 |
| 11 | Registration Date | DateTime | No | 2025-01-06 14:30:00 |

### Coaches Excel Template
| Column # | Field Name | Type | Required |
|----------|-----------|------|----------|
| 1 | Full Name | Text | Yes |
| 2 | Email | Email | No |
| 3 | Phone | Text | No |
| 4 | Date of Birth | Date | No |
| 5 | Gender | Text | No |
| 6 | Chapter | Text | No |
| 7 | Sports Expertise | Text | No |
| 8 | Experience Years | Number | No |
| 9 | Certifications | Text | No |
| 10 | Availability | Text | No |
| 11 | Emergency Contact Name | Text | No |
| 12 | Emergency Contact Phone | Text | No |
| 13 | Registration Date | DateTime | No |

### Volunteers Excel Template
| Column # | Field Name | Type | Required |
|----------|-----------|------|----------|
| 1 | Full Name | Text | Yes |
| 2 | Email | Email | No |
| 3 | Phone | Text | No |
| 4 | Date of Birth | Date | No |
| 5 | Gender | Text | No |
| 6 | Chapter | Text | No |
| 7 | Volunteer Role | Text | No |
| 8 | Skills | Text | No |
| 9 | Availability | Text | No |
| 10 | Previous Volunteer Experience | Text | No |
| 11 | Emergency Contact Name | Text | No |
| 12 | Emergency Contact Phone | Text | No |
| 13 | Registration Date | DateTime | No |

### Important Notes:
- First row must be headers (will be skipped during import)
- Date format: YYYY-MM-DD or any Excel date format
- Chapter values: Kuching, Miri, Sibu, Bintulu, Samarahan
- Gender values: Male, Female, Other
- Empty cells are allowed (will be stored as NULL)
- System auto-detects duplicates by email or name+phone combination

---

## Usage Guide

### 1. Uploading Excel Files

**Step-by-step:**
1. Log in to admin panel
2. Navigate to Athletes/Coaches/Volunteers section
3. Click **"Upload Excel File"** button
4. Select your Microsoft Forms export file
5. Review the column mapping guide
6. Click **"Upload & Process"**
7. Review upload results:
   - Green: New records imported
   - Blue: Existing records updated
   - Red: Failed records (with error details)

### 2. Managing Participants

**Viewing Details:**
- Click the **eye icon** to view full participant details
- Modal shows all information including emergency contacts

**Approving/Rejecting:**
- For pending participants, use **checkmark** (approve) or **X** (reject) buttons
- Confirmation dialog prevents accidental actions

**Deleting:**
- Click **trash icon** to permanently delete
- Requires confirmation (action cannot be undone)

### 3. Searching & Filtering

**Search:**
- Type in search bar to filter by name, email, or phone
- Search is real-time with 500ms debounce

**Filters:**
- **All**: Show all participants
- **Approved**: Show only approved participants
- **Pending**: Show awaiting approval
- **Rejected**: Show rejected registrations

**Chapter Filter:**
- Use the chapter dropdown (if implemented) to filter by location

### 4. Exporting Data

- Click **"Export to CSV"** button
- All participant data downloads as CSV file
- Filename format: `athletes_export_20250106_143045.csv`
- Open with Excel for offline analysis

---

## Database Schema

### athletes table
```sql
- id: Primary key
- excel_row_id: Original row number from Excel
- full_name: VARCHAR(255) NOT NULL
- email: VARCHAR(255)
- phone: VARCHAR(50)
- date_of_birth: DATE
- gender: ENUM('Male','Female','Other')
- chapter: VARCHAR(100)
- sports_interested: TEXT
- medical_conditions: TEXT
- emergency_contact_name: VARCHAR(255)
- emergency_contact_phone: VARCHAR(50)
- registration_date: DATETIME
- status: ENUM('pending','approved','rejected','archived')
- notes: TEXT
- excel_filename: VARCHAR(255)
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
```

Similar structure for `coaches` and `volunteers` with role-specific fields.

### participant_excel_uploads table
Tracks all Excel uploads with import statistics and error logs.

---

## API Endpoints

### Athletes Handler: `handler/admin_athletes_handler.php`

**Fetch All Athletes:**
```
GET ?action=fetch&limit=50&offset=0&status=pending&search=john
Response: { success: true, data: [...], total: 150 }
```

**Fetch Statistics:**
```
GET ?action=fetchStats
Response: { success: true, stats: {...}, chapters: [...] }
```

**Upload Excel:**
```
POST action=upload&excelFile=[file]
Response: { success: true, imported: 45, updated: 12, failed: 2 }
```

**Update Status:**
```
POST action=updateStatus&id=5&status=approved
Response: { success: true, message: "Status updated" }
```

**Delete:**
```
POST action=delete&id=5
Response: { success: true, message: "Athlete deleted" }
```

**Export:**
```
GET ?action=export
Response: CSV file download
```

Similar endpoints exist for coaches and volunteers handlers.

---

## Troubleshooting

### Excel Upload Fails

**Error: "No file uploaded"**
- Solution: Check file input name matches 'excelFile'
- Verify form enctype="multipart/form-data"

**Error: "Invalid file type"**
- Solution: Only .xlsx, .xls, .csv allowed
- Re-export from Microsoft Forms

**Error: "Failed to process Excel"**
- Solution: Check PhpSpreadsheet is installed
- Verify `vendor/autoload.php` exists

### Data Not Displaying

**Tables show "Loading..."**
- Check browser console for JavaScript errors
- Verify handler URLs are correct
- Check database connection in handlers

**Statistics show 0**
- Run SQL queries manually to verify data exists
- Check database table names match code

### Permission Issues

**Error: "Failed to upload file"**
- Solution: Check `uploads/participants/` has write permissions
- On Windows XAMPP: Right-click folder → Properties → Security → Edit

**Database Errors**
- Verify database credentials in `db_connection.php`
- Check tables exist in correct database
- Verify user has INSERT/UPDATE/DELETE permissions

---

## Best Practices

### Data Management
1. **Regular Backups**: Export data to CSV weekly
2. **Review Pending**: Approve/reject within 3-5 days
3. **Archive Old Data**: Move completed season participants to archived status
4. **Verify Uploads**: Always review upload results for errors

### Excel Preparation
1. **Clean Data**: Remove empty rows from Microsoft Forms export
2. **Consistent Formatting**: Use standard date formats
3. **Test First**: Upload small batch first to verify column mapping
4. **Keep Original**: Save original Microsoft Forms files as backup

### Security
1. **Session Validation**: System checks admin authentication
2. **SQL Injection Protection**: All queries use prepared statements
3. **File Validation**: Only allows Excel file types
4. **Input Sanitization**: HTML escaping prevents XSS attacks

---

## Advanced Customization

### Adding New Fields

1. **Update Database:**
```sql
ALTER TABLE athletes ADD COLUMN new_field VARCHAR(255);
```

2. **Update Handler** (admin_athletes_handler.php):
```php
$data['new_field'] = $row[12] ?? null; // Add to Excel mapping
// Add to INSERT and UPDATE queries
```

3. **Update Display** (athletes-management.js):
```javascript
// Add column to table display
<td>${athlete.new_field || '-'}</td>
```

### Customizing Status Values

Edit ENUM in database:
```sql
ALTER TABLE athletes MODIFY status ENUM('pending','approved','rejected','archived','active');
```

Update JavaScript status colors in CSS.

### Email Notifications

Add to `updateAthleteStatus()` function:
```php
if ($status === 'approved') {
    mail($email, "Registration Approved", "Your athlete registration has been approved!");
}
```

---

## Support

For issues or questions:
1. Check this README first
2. Review browser console for JavaScript errors
3. Check PHP error logs (xampp/apache/logs/)
4. Verify database structure matches schema
5. Test with sample data first

---

## Version History

**v1.0.0 (January 2026)**
- Initial release
- Athletes, Coaches, Volunteers management
- Excel upload with PhpSpreadsheet
- CRUD operations
- Statistics dashboard
- CSV export functionality

---

## Credits

Developed for Special Olympics Sarawak  
Admin Panel by: Senior Web Development Expert  
Date: January 2026
