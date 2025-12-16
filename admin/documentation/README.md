# 📚 Admin Panel Documentation Index

**Last Updated:** December 12, 2025

---

## 📖 Documentation Files

### Button Standardization
- **[BUTTON_STANDARDIZATION_SUMMARY.md](BUTTON_STANDARDIZATION_SUMMARY.md)** - Complete technical specification for admin panel button standardization
- **[BUTTON_STANDARDIZATION_VISUAL_REFERENCE.html](BUTTON_STANDARDIZATION_VISUAL_REFERENCE.html)** - Interactive visual reference for button styles

### Profile System
- **[PROFILE_DEBUG_REPORT.md](PROFILE_DEBUG_REPORT.md)** - Comprehensive debug guide for profile data loading
- **[PROFILE_DIAGNOSTIC_REPORT.md](PROFILE_DIAGNOSTIC_REPORT.md)** - System diagnostic and troubleshooting guide

### Change History
- **[CHANGES_SUMMARY.md](CHANGES_SUMMARY.md)** - Summary of all changes made to the admin panel

### Setup Guides
- **[PROFILE_SETUP_GUIDE.md](PROFILE_SETUP_GUIDE.md)** - Profile section setup and configuration guide
- **[STATE_GAMES_README.md](STATE_GAMES_README.md)** - State Games section documentation

---

## 🔧 Test Scripts

All test and utility scripts have been moved to the `../test-scripts/` folder for better organization.

### Available Test Scripts:
1. **test_profile_api.php** - API endpoint comprehensive testing
2. **test_profile_inspector.html** - Real-time profile data flow inspector
3. **test_login.php** - Login credentials verification
4. **clear_session.php** - Session cleanup utility
5. **fix_password.php** - Password hash repair tool
6. **verify_no_hardcoded.php** - Verify no hardcoded values remain
7. **PROFILE_DEBUG_TEST.html** - Profile section debug interface

---

## 📁 Folder Structure

```
admin/
├── documentation/          # All documentation files
│   ├── README.md          # This file
│   ├── *.md              # Markdown documentation
│   └── *.html            # HTML reference files
│
├── test-scripts/          # Test and utility scripts
│   ├── test_*.php        # PHP test files
│   ├── *.html            # HTML test interfaces
│   └── utility scripts
│
├── admin_panel_soswk.php  # Main admin panel
├── login_page_v1.php      # Login page
├── logout.php             # Logout handler
├── pw_hash.php            # Password hash generator
│
├── handler/               # Backend API handlers
│   └── admin_*_handler.php
│
├── assets/                # Images and resources
├── db/                    # Database files
└── scripts/               # JavaScript files
```

---

## 🚀 Quick Access

### Main Application
- **Admin Panel:** `../admin_panel_soswk.php`
- **Login Page:** `../login_page_v1.php`

### Testing
- **Test Scripts Index:** `../test-scripts/` (folder)
- **Quick Test:** `../test-scripts/verify_no_hardcoded.php`

### Documentation
- **This Index:** `README.md`
- **All Docs:** Current folder

---

## 📝 Notes

- All test files are preserved in `test-scripts/` folder
- Documentation is organized in this `documentation/` folder
- Main application files remain in the root admin folder
- Database files are in the `db/` folder

---

**For issues or questions, refer to the specific documentation file or test script.**
