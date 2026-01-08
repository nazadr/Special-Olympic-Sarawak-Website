# Excel Template Examples
## Sample Data for Testing

Use these templates to create test Excel files for each participant type.

---

## Athletes Template

Copy this into Excel or save as CSV:

```csv
Full Name,Email,Phone,Date of Birth,Gender,Chapter,Sports Interested,Medical Conditions,Emergency Contact Name,Emergency Contact Phone,Registration Date
John Doe,john.doe@example.com,0123456789,1995-05-15,Male,Kuching,"Swimming, Athletics",None,Jane Doe,0129876543,2025-01-06 10:30:00
Sarah Lee,sarah.lee@example.com,0134567890,1998-08-22,Female,Miri,"Basketball, Badminton",Asthma,Michael Lee,0145678901,2025-01-06 11:00:00
Ahmad Ibrahim,ahmad@example.com,0156789012,1992-03-10,Male,Sibu,"Football, Volleyball",,Siti Ibrahim,0167890123,2025-01-06 11:30:00
Melissa Wong,melissa.wong@example.com,0178901234,2000-11-05,Female,Bintulu,Table Tennis,,David Wong,0189012345,2025-01-06 12:00:00
Raj Kumar,raj.kumar@example.com,0190123456,1996-07-18,Male,Samarahan,"Cycling, Running",Diabetes,Priya Kumar,0101234567,2025-01-06 12:30:00
```

**Quick Tips:**
- First row is headers (required)
- Dates: YYYY-MM-DD format
- Medical Conditions: Leave empty or put "None"
- Sports: Comma-separated for multiple
- Chapter: Must match exactly (Kuching, Miri, Sibu, Bintulu, Samarahan)

---

## Coaches Template

```csv
Full Name,Email,Phone,Date of Birth,Gender,Chapter,Sports Expertise,Experience Years,Certifications,Availability,Emergency Contact Name,Emergency Contact Phone,Registration Date
Robert Chen,robert.chen@example.com,0111222333,1985-04-12,Male,Kuching,"Swimming, Athletics",10,"Level 2 Swimming Coach, Athletics Instructor",Weekends,Michelle Chen,0122333444,2025-01-06 09:00:00
Linda Tan,linda.tan@example.com,0133444555,1988-09-25,Female,Miri,Basketball,7,"Basketball Coach Certification",Mon-Fri Evenings,James Tan,0144555666,2025-01-06 09:30:00
Hassan Ali,hassan.ali@example.com,0155666777,1982-06-08,Male,Sibu,"Football, Futsal",15,"UEFA B License",Flexible,Aina Ali,0166777888,2025-01-06 10:00:00
Emily Lim,emily.lim@example.com,0177888999,1990-12-30,Female,Bintulu,Badminton,5,"Level 1 Badminton Coach",Weekends Only,Peter Lim,0188999000,2025-01-06 10:30:00
Kumar Selvan,kumar.s@example.com,0199000111,1987-02-14,Male,Samarahan,Cycling,8,"Cycling Instructor Cert",Mon/Wed/Fri,Devi Selvan,0100111222,2025-01-06 11:00:00
```

**Key Fields:**
- Experience Years: Number only (e.g., 5, 10, 15)
- Certifications: Text field, comma-separated if multiple
- Availability: Any text describing when they're available

---

## Volunteers Template

```csv
Full Name,Email,Phone,Date of Birth,Gender,Chapter,Volunteer Role,Skills,Availability,Previous Volunteer Experience,Emergency Contact Name,Emergency Contact Phone,Registration Date
Jessica Wong,jessica.w@example.com,0112223344,1995-03-20,Female,Kuching,"Event Coordinator, Photographer","Photography, Event Planning",Weekends,2 years at Red Cross,Richard Wong,0123334455,2025-01-06 08:00:00
Daniel Lee,daniel.lee@example.com,0134445566,1992-07-15,Male,Miri,"Transportation, Setup Crew","Driving, Manual Labor",Flexible,First time volunteering,Susan Lee,0145556677,2025-01-06 08:30:00
Fatimah Zahra,fatimah.z@example.com,0156667788,1998-11-02,Female,Sibu,"Medical Support, First Aid","Nursing, First Aid Certified",Mon-Fri Mornings,3 years at Hospital Volunteer,Ahmad Zahra,0167778899,2025-01-06 09:00:00
Kevin Tan,kevin.tan@example.com,0178889900,1990-05-28,Male,Bintulu,"IT Support, Registration Desk","IT, Computer Skills",Weekends,Volunteer at Tech Event,Mary Tan,0189990011,2025-01-06 09:30:00
Priya Nair,priya.nair@example.com,0190001122,1994-09-10,Female,Samarahan,"Coaching Assistant, Mentor","Teaching, Sports Knowledge",Tue/Thu Evenings,Coach volunteer 1 year,Raj Nair,0101112233,2025-01-06 10:00:00
```

**Important Notes:**
- Volunteer Role: Can list multiple roles
- Skills: Comma-separated list
- Previous Experience: Any text, or "First time volunteering"
- Availability: Free text field

---

## Microsoft Forms Column Mapping

If your Microsoft Forms has different column orders, map them correctly:

### Common Microsoft Forms Layout:
1. Timestamp → Skip (system generates)
2. Name → Full Name
3. Email Address → Email
4. Contact Number → Phone
5. Date of Birth → Date of Birth
... and so on

### Adjusting Handlers:
If your form columns are different, edit the handler PHP files:

```php
// In admin_athletes_handler.php, line ~195
$data = [
    'excel_row_id' => $index + 2,
    'full_name' => $row[0] ?? '',  // ← Change index if needed
    'email' => $row[1] ?? null,     // ← Column 2
    'phone' => $row[2] ?? null,     // ← Column 3
    // ... etc
];
```

---

## Testing Your Upload

### Step 1: Create Test File
1. Open Excel or Google Sheets
2. Copy one of the templates above
3. Save as `.xlsx` or `.csv`

### Step 2: Test Upload
1. Login to admin panel
2. Go to Athletes/Coaches/Volunteers
3. Click "Upload Excel File"
4. Select your test file
5. Review results

### Expected Results:
```
✅ Upload Successful!
New Records: 5
Updated Records: 0
Failed Records: 0
```

### If Upload Fails:
- Check first row is headers
- Verify Full Name column exists
- Ensure date format is YYYY-MM-DD
- Remove any empty rows at bottom

---

## Live Microsoft Forms Integration

### Your Real Forms Should Include:

**Athletes Form Questions:**
1. Full Name* (Short answer)
2. Email address (Email)
3. Phone number (Short answer)
4. Date of Birth (Date)
5. Gender (Multiple choice: Male/Female/Other)
6. Chapter (Dropdown: Kuching/Miri/Sibu/Bintulu/Samarahan)
7. Sports you're interested in (Checkboxes or Long answer)
8. Medical conditions we should know (Long answer)
9. Emergency contact name (Short answer)
10. Emergency contact phone (Short answer)

**Export Process:**
1. Open your Microsoft Form
2. Go to "Responses" tab
3. Click "Open in Excel" button
4. File downloads automatically
5. Upload to admin panel

### Auto-Update Workflow:
1. Participants fill Microsoft Form
2. You download Excel responses
3. Upload to admin panel
4. System updates existing + adds new
5. Review and approve new entries
6. Repeat weekly or as needed

---

## Data Validation Tips

### Good Data:
```csv
John Doe,john@email.com,0123456789,1995-05-15,Male,Kuching,...
```

### Bad Data (will cause errors):
```csv
,missing_name@email.com,0123456789,invalid-date,Unknown,InvalidChapter,...
```

### System Handles:
✅ Empty optional fields
✅ Duplicate entries (updates instead)
✅ Mixed date formats (tries to parse)
✅ Extra columns (ignored)

### System Rejects:
❌ Missing Full Name (required)
❌ Completely empty rows
❌ Invalid file types (not Excel/CSV)

---

## Best Practices

1. **Regular Exports:**
   - Export from Microsoft Forms weekly
   - Keep dated copies (e.g., `athletes_2025-01-06.xlsx`)

2. **Clean Data:**
   - Remove test responses before uploading
   - Delete empty rows at end
   - Check for duplicate entries

3. **Backup:**
   - Keep original Forms exports
   - Export from admin panel monthly as CSV
   - Store in safe location

4. **Testing:**
   - Use sample data first
   - Upload small batches initially
   - Verify data appears correctly

---

## Need Help?

Common issues and solutions:

**"Invalid file type"**
→ Save as .xlsx, .xls, or .csv only

**"No file uploaded"**
→ File must be under 10MB, check file selection

**"Column X not found"**
→ Verify headers match template

**"Duplicate entry"**
→ Not an error! System updates existing records

**"Date parsing error"**
→ Use YYYY-MM-DD format or Excel date format

---

## Ready to Use!

You now have everything you need to:
1. Create test Excel files
2. Upload participant data
3. Integrate with Microsoft Forms
4. Manage participants effectively

Start with the sample templates, test the upload, then use your real Microsoft Forms data!
