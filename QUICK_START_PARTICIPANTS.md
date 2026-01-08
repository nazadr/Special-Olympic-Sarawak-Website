# Quick Start Guide: Participants Management
## Get Started in 5 Minutes

### Prerequisites Checklist
- [ ] XAMPP installed and running
- [ ] Admin panel login credentials
- [ ] Microsoft Forms with participant responses
- [ ] Excel export from Microsoft Forms

---

## Step 1: Install PhpSpreadsheet (2 minutes)

Open PowerShell in your project directory:
```powershell
cd c:\xampp\htdocs\Special-Olympic-Sarawak-Website-Staging-environment
composer require phpoffice/phpspreadsheet
```

If you don't have Composer, download from: https://getcomposer.org/download/

**Alternative (Manual):**
1. Download: https://github.com/PHPOffice/PhpSpreadsheet/releases
2. Extract to `vendor/phpoffice/phpspreadsheet/`
3. Ensure `vendor/autoload.php` exists

---

## Step 2: Setup Database (2 minutes)

1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Select your database (e.g., `so_sarawak_db`)
3. Go to SQL tab
4. Copy and paste SQL from: `admin/db/participants-management-sql.txt`
5. Click "Go" to execute

✅ You should see 4 new tables created:
- athletes
- coaches  
- volunteers
- participant_excel_uploads

---

## Step 3: Create Upload Folders (30 seconds)

Run in PowerShell:
```powershell
New-Item -ItemType Directory -Path "uploads\participants\athletes" -Force
New-Item -ItemType Directory -Path "uploads\participants\coaches" -Force
New-Item -ItemType Directory -Path "uploads\participants\volunteers" -Force
```

Or manually create these folders in your project:
```
uploads/
  └─ participants/
      ├─ athletes/
      ├─ coaches/
      └─ volunteers/
```

---

## Step 4: Test the System (1 minute)

1. Login to admin panel: http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/admin/login_page_v1.php
2. Click **"Athletes"** in sidebar
3. You should see:
   - ✅ Statistics cards showing 0
   - ✅ Empty table with "No athletes found"
   - ✅ "Upload Excel File" button

If you see errors, check:
- Database connection is working
- All JavaScript files loaded (check browser console)
- PHP errors (check `xampp/apache/logs/error.log`)

---

## Step 5: Upload Your First Excel File (30 seconds)

### Prepare Excel File from Microsoft Forms:

1. Go to your Microsoft Forms
2. Click **"Responses"** tab
3. Click **"Open in Excel"** or export to Excel
4. Save file to your computer

### Upload to System:

1. In admin panel, go to Athletes/Coaches/Volunteers section
2. Click **"Upload Excel File"** button
3. Select your Excel file
4. Review column mapping (ensure it matches)
5. Click **"Upload & Process"**

✅ Success looks like:
- Green box showing "Upload Successful!"
- Numbers: X new records, Y updated records
- Table now shows your data

❌ If upload fails:
- Check Excel has proper headers in row 1
- Verify required field (Full Name) is present
- Check error messages for specific issues

---

## Column Mapping Reference

### Athletes:
1. Full Name* (required)
2. Email
3. Phone  
4. Date of Birth
5. Gender
6. Chapter
7. Sports Interested
8. Medical Conditions
9. Emergency Contact Name
10. Emergency Contact Phone
11. Registration Date

### Coaches:
Same as athletes, but columns 7-9 are:
- Sports Expertise
- Experience Years (number)
- Certifications

### Volunteers:
Same as athletes, but columns 7-10 are:
- Volunteer Role
- Skills
- Availability
- Previous Volunteer Experience

---

## Common Quick Fixes

### "PhpSpreadsheet not found"
```powershell
composer require phpoffice/phpspreadsheet
```

### "Database connection failed"
Check `db_connection.php` has correct credentials.

### "Upload folder not writable"
```powershell
icacls uploads /grant Everyone:F /T
```

### "Table doesn't exist"
Re-run SQL from `admin/db/participants-management-sql.txt`

---

## Next Steps

✅ **You're all set!** Now you can:

1. **Approve Participants:**
   - View pending registrations
   - Click checkmark to approve
   - Click X to reject

2. **Search & Filter:**
   - Use search bar for quick lookup
   - Filter by status (All, Approved, Pending, Rejected)
   - Click on participant to view full details

3. **Export Data:**
   - Click "Export to CSV" anytime
   - Open in Excel for analysis
   - Keep backups of your data

4. **Update Records:**
   - Re-upload same Excel file to update existing records
   - System matches by email or name+phone
   - Existing records get updated, new ones added

---

## Tips for Success

💡 **Best Practices:**
- Upload small batches first (10-20 records) to test
- Always review upload results
- Keep original Microsoft Forms exports as backup
- Export to CSV weekly as backup
- Approve/reject participants within 3-5 days

💡 **Excel Tips:**
- Remove empty rows before uploading
- Use consistent date format (YYYY-MM-DD)
- Don't skip columns (leave empty if no data)
- First row must be headers

💡 **Performance:**
- System handles 1000+ participants easily
- Pagination shows 50 per page
- Search is real-time
- Statistics update automatically

---

## Getting Help

If something isn't working:

1. **Check Browser Console:**
   - Press F12 in browser
   - Look for red error messages

2. **Check PHP Errors:**
   - Location: `xampp/apache/logs/error.log`
   - Shows database and PHP issues

3. **Test Handlers Directly:**
   - Visit: `handler/admin_athletes_handler.php?action=fetchStats`
   - Should return JSON response

4. **Verify Files Exist:**
   - All handlers in `admin/handler/`
   - All JS files in `scripts/admin-components/`
   - Database tables created

---

## You're Ready! 🎉

Your participants management system is now fully operational. Start by uploading your first Excel file and watch the magic happen!

For detailed documentation, see: `PARTICIPANTS_MODULE_README.md`
