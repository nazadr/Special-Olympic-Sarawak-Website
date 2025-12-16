# Admin Profile System - Setup Guide

## Overview
The Admin Profile System provides comprehensive profile management for administrators with the following features:

### Features Included:
1. **Personal Information Management**
   - Name, email, phone, position, department
   - Biography/description
   - Profile picture upload

2. **Security Settings**
   - Password change functionality
   - Two-factor authentication toggles
   - Active session management
   - Session revocation

3. **Preferences**
   - Theme selection (Light/Dark/Auto)
   - Language selection
   - Notification preferences
   - Dashboard settings

4. **Activity Log**
   - Track admin activities
   - Filter by action type and time period
   - View login history and system changes

## Setup Instructions

### 1. Database Setup
Run the SQL file to create necessary tables:
```sql
-- Execute the contents of: admin/db/admin_profile_tables.sql
```

### 2. Directory Structure
Ensure these directories exist:
```
assets/
  images/
    admin_avatars/     (create this directory for profile pictures)
    default-avatar.png (add a default avatar image)
```

### 3. File Permissions
Set appropriate permissions:
- `admin_avatars/` directory: 755 (writable)
- Profile handler: 644 (executable by web server)

### 4. Configuration
Update the database connection settings in:
- `admin/handler/admin_profile_handler.php`

### 5. Session Management
Ensure your login system sets the session variable:
```php
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_id'] = 1; // Set the actual admin ID
```

## Usage

### Accessing the Profile
1. Login to the admin panel
2. Navigate to Settings → Profile
3. Use the tabs to manage different aspects:
   - Personal Information
   - Security
   - Preferences  
   - Activity Log

### Profile Picture Upload
- Supported formats: JPG, PNG, GIF
- Maximum size: 2MB
- Automatically resized and optimized

### Password Requirements
- Minimum 8 characters
- Real-time strength indicator
- Confirmation required

### Activity Tracking
Activities are automatically logged when:
- Admin logs in/out
- Events are created/modified
- News articles are published
- User registrations are processed

## Security Features

### Session Management
- Multiple session tracking
- Individual session revocation
- Automatic session cleanup

### Two-Factor Authentication
- SMS authentication toggle
- Email authentication toggle
- Easy enable/disable controls

### Password Security
- Secure password hashing (PHP password_hash)
- Password strength validation
- Current password verification required

## Customization

### Adding New Activity Types
Edit `admin_activity_logs` table and handler to track additional actions.

### Custom Preferences
Add new preference fields to `admin_preferences` table and update the UI.

### Theme Integration
The theme preference can be used to dynamically load different CSS files.

## Troubleshooting

### Common Issues:
1. **Profile image upload fails**
   - Check directory permissions
   - Verify file size limits
   - Ensure correct file types

2. **Database connection errors**
   - Verify database credentials
   - Ensure tables are created
   - Check MySQL service status

3. **Session issues**
   - Verify session configuration
   - Check PHP session settings
   - Ensure proper login flow

### File Locations:
- Main profile page: `admin/admin_panel_soswk.php` (Profile section)
- Handler script: `admin/handler/admin_profile_handler.php`
- Database schema: `admin/db/admin_profile_tables.sql`
- CSS styles: `css/admin_style.css` (Profile page styles)

## Demo Data
The setup includes sample data for testing:
- Default admin user (username: admin, password: password)
- Sample profile information
- Mock activity log entries
- Default preferences

## Future Enhancements
Potential improvements:
- Email notifications system
- Advanced activity filtering
- Profile export functionality
- Multi-language support
- Advanced security options