# Quick Database Migration Guide

## Execute This Command

Open phpMyAdmin and run this SQL command:

```sql
USE so_sarawak_db;
ALTER TABLE `sarawak_chapters` DROP COLUMN `treasurer`;
```

## Verification

After running the command, verify the change:

```sql
SHOW COLUMNS FROM sarawak_chapters;
```

## Expected Columns After Migration
- id
- chapter_name
- city
- chairman
- vice_chairman
- secretary
- logo_path
- status
- created_at
- updated_at

The `treasurer` column should NO LONGER appear in the list.

## Backup First!
Before running the migration, it's recommended to backup your database:
1. In phpMyAdmin, select `so_sarawak_db`
2. Click "Export" tab
3. Click "Go" to download the backup
4. Save the file with date (e.g., `so_sarawak_db_backup_2026-01-25.sql`)

## Done!
After migration, refresh your website and test the chapter editing functionality.
