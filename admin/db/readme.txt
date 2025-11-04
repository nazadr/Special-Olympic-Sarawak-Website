*Require XAMPP Control Panel installed on a computer.
*Require Apache and MySQL started, leave the and Port(s) number as default.

[ Quick Fix ]

If MySQL is failed to initialised, open Task Manager and end task for the following background processes:
— mysqld.exe
— (other related SQL)



[ ----- Quick Set Up ----- ]

1. On phpMyAdmin, create a new database: so_sarawak_db
2. Click so_sarawak_db on the sidebar, go to Import tab and browse the file (so_sarawak_db.sql)
3. All set up!

---

Any changes made on phpMyAdmin does not affects the content of the file so_sarawak_db.sql in this folder but the data is stored on "C:\xampp\mysql\data" instead.

Before "drop" (delete) so_sarawak_db database in phpMyAdmin, do consider to download the SQL file in the Export tab by just simply click the "Export" button.
— Export method: Quick
— Format: SQL